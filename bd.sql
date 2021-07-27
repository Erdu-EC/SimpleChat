DROP DATABASE IF EXISTS simplechat;
CREATE DATABASE simplechat CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;;
USE simplechat;

SET GLOBAL log_bin_trust_function_creators = 1;

CREATE TABLE users
(
    id              int auto_increment,
    user_name       varchar(30)  not null unique,
    pass            varchar(120) not null,
    first_name      varchar(250) not null,
    last_name       varchar(250) not null,
    birth_date      date,
    gender          enum ('M', 'F', 'O', 'D'), #M - Masculino, F - Femenino, O - Otro, D - Sin especificar
    email           varchar(255),

    /*City, Country, Occupation*/

    state           ENUM ('A', 'O', 'I'),      #A - Activo, O - Ocupado, I - Inactivo
    create_at       datetime,
    last_connection datetime,

    profile_img     text,

    PRIMARY KEY (id),
    KEY idx_user_name (user_name),
    FULLTEXT idx_user_search (user_name, first_name, last_name)
) engine = InnoDB;

CREATE TABLE connections
(
    id          INT AUTO_INCREMENT,
    id_user     INT,
    device      TEXT,
    login_date  datetime,
    logout_date datetime DEFAULT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_user) REFERENCES users (id)
);

CREATE TABLE invitations
(
    id          INT AUTO_INCREMENT,
    id_source   INT,
    id_dest     INT,
    send_date   datetime,
    rcv_date    datetime,
    accepted    boolean,
    action_date datetime,

    PRIMARY KEY (id),
    FOREIGN KEY (id_source) REFERENCES users (id),
    FOREIGN KEY (id_dest) REFERENCES users (id)
);

CREATE TABLE contacts
(
    user_id       INT,
    contact_id    INT,
    blocked       boolean default false,
    register_date datetime,
    PRIMARY KEY (user_id, contact_id),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (contact_id) REFERENCES users (id)
);

CREATE TABLE message
(
    id        INT AUTO_INCREMENT,
    id_source INT  NOT NULL,
    id_dest   INT  NOT NULL,
    send_date datetime,
    rcv_date  datetime,
    read_date datetime,
    content   TEXT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_source) REFERENCES users (id),
    FOREIGN KEY (id_dest) REFERENCES users (id)
);

create table permissions
(
    id    INT,
    type  varchar(100) NOT NULL,
    value ENUM ('P', 'C', 'O'), #Public, Only Contacts, Oculto
    FOREIGN KEY (id) REFERENCES users (id)
);

CREATE VIEW conversations AS
SELECT id_source,
       su.user_name      as s_nick,
       su.first_name     as s_first_name,
       su.last_name      as s_last_name,
       su.profile_img    as s_profile_img,
       id_dest,
       du.user_name      as d_nick,
       du.first_name     as d_first_name,
       du.last_name      as d_last_name,
       du.profile_img    as d_profile_img,
       message.id        as msg_id,
       message.content   as msg_content,
       message.rcv_date  as msg_received,
       message.read_date as msg_readed,
       message.send_date as msg_send_date
FROM message
         inner join users su on id_source = su.id
         inner join users du on id_dest = du.id
WHERE message.id = (select id
                    from message
                    where id_source in (su.id, du.id)
                      and id_dest in (su.id, du.id)
                    order by id desc
                    limit 1);


CREATE VIEW message_readable AS
select m.*
from message m
         inner join users su on m.id_source = su.id
         inner join users du on m.id_dest = du.id
         left join invitations i on i.id_source = su.id and i.id_dest = du.id and accepted
         left join contacts c on c.user_id = su.id and c.contact_id = du.id
where m.send_date >= i.send_date
   or m.send_date >= c.register_date;


DELIMITER $

#Funciones Y procedimientos.
CREATE FUNCTION user_set_login(name varchar(30), device_desc TEXT) RETURNS INT
    MODIFIES SQL DATA
BEGIN
    DECLARE USER_ID int DEFAULT (select id from users WHERE user_name = name);

    UPDATE users SET state = 'A', last_connection = NOW() WHERE id = USER_ID;
    INSERT INTO connections(id_user, device, login_date) VALUES (USER_ID, device_desc, NOW());

    RETURN LAST_INSERT_ID();
END $

CREATE PROCEDURE user_set_logout(in USER_ID int, in CONNECTION_ID int)
BEGIN
    UPDATE connections SET logout_date = NOW() WHERE id = CONNECTION_ID and id_user = USER_ID;
    UPDATE users SET last_connection = NOW() WHERE id = USER_ID;

    IF NOT EXISTS(SELECT id FROM connections WHERE logout_date IS NULL) THEN
        UPDATE users SET state = 'I' WHERE id = USER_ID;
    END IF;
END $

CREATE FUNCTION user_is_contact(USERID int, CONTACTID int) RETURNS BOOLEAN
    READS SQL DATA
BEGIN
    RETURN EXISTS(SELECT * FROM contacts WHERE user_id = USERID and contact_id = CONTACTID);
END $

#Procedimientos para contactos.
CREATE FUNCTION user_AddContact(own int, contact int) RETURNS INT
    MODIFIES SQL DATA
BEGIN
    #Insertar nuevo contacto.
    insert into contacts(user_id, contact_id, register_date) values (own, contact, NOW());

    #Si existen invitaciones de mensajes pendientes, aceptarlas.
    CALL user_ChangeInvitationState(own, contact, true);

    RETURN LAST_INSERT_ID();
END $

#Procedimientos para invitaciones.
CREATE FUNCTION user_HasInvitation(USER_ID int, CONTACT_ID int) RETURNS BOOLEAN
BEGIN
    RETURN EXISTS(SELECT * FROM invitations where id_dest = USER_ID AND id_source = CONTACT_ID and accepted IS NULL);
END $

CREATE PROCEDURE user_GetLastInvitationSend(in USER_ID int, in CONTACT_ID int)
BEGIN
    SELECT * FROM invitations WHERE id_dest = CONTACT_ID AND id_source = USER_ID order by id desc limit 1;
END $

CREATE FUNCTION user_GetIdOfLastInvitationReceived(USER_ID int, CONTACT_ID int) RETURNS INT
    READS SQL DATA
BEGIN
    RETURN (SELECT max(id) FROM invitations WHERE id_dest = USER_ID AND id_source = CONTACT_ID);
END $

CREATE PROCEDURE user_ChangeInvitationState(in USER_ID int, in CONTACT_ID int, in accept boolean)
BEGIN
    #Cambiar estado de la ultima invitacion recibida por el usuario proveniente de ese contacto.
    UPDATE invitations
    SET accepted    = accept,
        action_date = NOW(),
        rcv_date    = IF(rcv_date IS NULL, action_date, rcv_date)
    WHERE id = (SELECT user_GetIdOfLastInvitationReceived(USER_ID, CONTACT_ID))
      AND accepted is NULL;
END $

#Procedimientos para mensajes.
CREATE FUNCTION user_SendMessage(source int, dest int, msg text) RETURNS INT
    MODIFIES SQL DATA
BEGIN
    #Si usuario no pertenece a los contactos del destinario
    #Y no existe ninguna solicitud aceptada o pendiente.
    IF NOT user_is_contact(dest, source)
        AND NOT EXISTS(SELECT *
                       FROM invitations
                       WHERE id_source = source
                         and id_dest = dest
                         and (accepted = true or accepted IS NULL)) THEN
        #Insertar invitacion.
        INSERT INTO invitations(id_source, id_dest, send_date) VALUES (source, dest, NOW());
    END IF;

    #Insertar mensaje en cualquier caso.
    INSERT INTO message(id_source, id_dest, send_date, content) VALUES (source, dest, NOW(), msg);

    #Devolver ID del mensaje.
    RETURN LAST_INSERT_ID();
END $

#Obtener las conversaciones.
CREATE PROCEDURE user_GetConversations(IN USER_ID int, IN CONTACT_ID int)
BEGIN
    SELECT if(c.id_source != USER_ID, s_nick, d_nick)                                      as contact_id,
           if(c.id_source != USER_ID, s_first_name, d_first_name)                          as first_name,
           if(c.id_source != USER_ID, s_last_name, d_last_name)                            as last_name,
           if(c.id_source != USER_ID, s_profile_img, d_profile_img)                        as profile_img,
           c.id_source = USER_ID                                                           as isMyMessage,
           user_HasInvitation(USER_ID, if(c.id_source != USER_ID, c.id_source, c.id_dest)) as hasInvitation,
           if(c.id_source = USER_ID, m.id, mr.id)                                          as msg_id,
           if(c.id_source = USER_ID, m.content, mr.content)                                as msg_content,
           if(c.id_source = USER_ID, m.send_date, mr.send_date)                            as msg_send,
           if(c.id_source = USER_ID, m.rcv_date, mr.rcv_date)                              as msg_rcv,
           if(c.id_source = USER_ID, m.read_date, mr.read_date)                            as msg_read
    FROM conversations c
             left outer join message_readable mr on mr.id = msg_id
             left outer join message m on m.id = msg_id and c.id_source = USER_ID
    WHERE USER_ID IN (c.id_source, c.id_dest)
      AND (if(CONTACT_ID IS NULL, TRUE, CONTACT_ID IN (c.id_source, c.id_dest)))
    order by msg_send_date desc, msg_id desc;
END $

#Obtener una conversación completa.
CREATE PROCEDURE user_GetConversationWithContact(in USER_ID int, in CONTACT_ID int)
BEGIN
    select *
    from (
             select *
             from message
             where id_source = USER_ID
               AND id_dest = CONTACT_ID

             UNION

             select *
             from message_readable
             where id_source = CONTACT_ID
               AND id_dest = USER_ID
         ) as A
    order by send_date, id;
END $

CREATE OR REPLACE PROCEDURE user_GetUnreceiveMessages(in USER_ID int)
BEGIN
    CREATE TEMPORARY TABLE unrcv_messages
    (
        id int
    ) ENGINE = MEMORY;

    INSERT INTO unrcv_messages
    SELECT id
    from message_readable
    where id_dest = USER_ID
      and rcv_date is null;

    UPDATE message
    set rcv_date = NOW()
    where id in (select id from unrcv_messages);

    select u.id, u.first_name, u.last_name, mr.content, mr.send_date
    from message_readable mr
             inner join users u on id_source = u.id
    where id_dest = USER_ID
      and mr.id in (select id from unrcv_messages);

    /*
    DECLARE STARTTIME DATETIME DEFAULT NOW();

    UPDATE message
    set rcv_date = STARTTIME
    where id in (select id
                 from message_readable
                 where id_dest = USER_ID
                   and rcv_date is null);

    select u.id, u.first_name, u.last_name, mr.content, mr.send_date
    from message_readable mr
             inner join users u on id_source = u.id
    where id_dest = USER_ID
      and rcv_date = STARTTIME;*/
END $

DELIMITER ;

#Datos de prueba.
insert into users (id, user_name, pass, first_name, last_name, birth_date, gender, email, state, create_at,
                   last_connection, profile_img)
values (1, 'erdu', '$2y$10$P3DtjrJE7JU6Sbm8Vb4ISuE44j/0phdXSPXFD/QFmnS/qmf3fW.Qa', 'E', 'C', now(), 'M', null, null,
        now(), null, '0_erdu.png'),
       (2, 'test', '$2y$10$S/qP2dbOjk3f3NMUWXrm4u0rgP8/oQECx.lNdBKsx9j6oT5a9qtXS', 'Prueba', 'TEST', now(), 'M', null,
        null, now(), null, null),
       (3, 'test2', '$2y$10$S/qP2dbOjk3f3NMUWXrm4u0rgP8/oQECx.lNdBKsx9j6oT5a9qtXS', 'Prueba', 'TEST', now(), 'M', null,
        null, now(), null, null),
       (4, 'louislitt', '$2y$10$S/qP2dbOjk3f3NMUWXrm4u0rgP8/oQECx.lNdBKsx9j6oT5a9qtXS', 'Louis', 'Marlowe Litt',
        '1970-05-20', 'M', 'louislitt@email.com', null, now(), null, 'louislitt.png'),
       (5, 'rachelzane', '$2y$10$S/qP2dbOjk3f3NMUWXrm4u0rgP8/oQECx.lNdBKsx9j6oT5a9qtXS', 'Rachel Elizabeth', 'Zane',
        '1985-04-30', 'F', 'rachelzane@email.com', null, now(), null, 'rachelzane.png'),
       (6, 'mikeross', '$2y$10$S/qP2dbOjk3f3NMUWXrm4u0rgP8/oQECx.lNdBKsx9j6oT5a9qtXS', 'Michael James', 'Ross',
        '1981-04-04', 'M', 'mikeross@email.com', null, now(), null, 'mikeross.png'),
       (7, 'harveyspecter', '$2y$10$S/qP2dbOjk3f3NMUWXrm4u0rgP8/oQECx.lNdBKsx9j6oT5a9qtXS', 'Harvey Reginald',
        'Specter', '1970-06-12', 'M', 'harveyspecter@email.com', 'I', now(), null, 'harveyspecter.png');

INSERT INTO contacts(user_id, contact_id, register_date)
VALUES (6, 4, now()),
       (4, 6, now()),
       (6, 5, now()),
       (5, 6, now());

INSERT INTO invitations(ID_SOURCE, ID_DEST, SEND_DATE, RCV_DATE, ACCEPTED, ACTION_DATE)
VALUES (7, 6, now(), now(), true, now()),
       (6, 7, now(), now(), true, now());

INSERT INTO message(id_source, id_dest, send_date, rcv_date, read_date, content)
VALUES (4, 6, now(), now(), now(), 'Acabas de levantar a LITT, Mike.'),
       (5, 6, now(), now(), now(), 'Estaba pensando que podríamos comer pollo esta noche, ¿suena bien?'),
       (6, 7, now(), now(), now(),
        '¡¿Cómo diablos se supone que voy a hacer que un jurado te crea cuando ni siquiera estoy seguro de que lo crea ?!'),
       (7, 6, now(), now(), now(),
        'Cuando estés contra la pared, derriba esa maldita cosa.'),
       (7, 6, now(), now(), now(),
        'Las excusas no ganan campeonatos.'),
       (6, 7, now(), now(), now(),
        'Oh, sí, ¿Michael Jordan te dijo eso?'),
       (7, 6, now(), now(), now(),
        'No, le dije eso.'),
       (7, 6, now(), now(), now(),
        '¿Cuáles son sus opciones cuando alguien le apunta con un arma a la cabeza?'),
       (6, 7, now(), now(), now(),
        '¿De qué estás hablando? Haz lo que te dicen o te disparan.'),
       (7, 6, now(), now(), now(),
        'Equivocado. Coges el arma o sacas una más grande. O llama a su farol. O haces una de las ciento cuarenta y seis cosas más.');