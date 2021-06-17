DROP DATABASE IF EXISTS simplechat;
CREATE DATABASE simplechat;
USE simplechat;

#SET GLOBAL log_bin_trust_function_creators = 1;

CREATE TABLE users
(
    id              int auto_increment,
    user_name       varchar(30)  not null unique,
    pass            varchar(120) not null,
    first_name      varchar(250) not null,
    last_name       varchar(250) not null,
    birth_date      date,
    gender          enum ('M', 'F', 'O'),
    email           varchar(255),

    /*City, Country, Occupation*/

    state           ENUM ('A', 'O', 'I'),
    create_at       datetime,
    last_connection datetime,

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
    invitation_id INT,
    PRIMARY KEY (user_id, contact_id),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (contact_id) REFERENCES users (id),
    FOREIGN KEY (invitation_id) REFERENCES invitations (id)
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


#Funciones Y procedimientos.
CREATE FUNCTION user_set_login(name varchar(30), device_desc TEXT) RETURNS INT
    MODIFIES SQL DATA
BEGIN
    DECLARE USER_ID int DEFAULT (select id from users WHERE user_name = name);

    UPDATE users SET state = 'A', last_connection = NOW() WHERE id = USER_ID;
    INSERT INTO connections(id_user, device, login_date) VALUES (USER_ID, device_desc, NOW());

    RETURN LAST_INSERT_ID();
END;

CREATE PROCEDURE user_set_logout(in USER_ID int, in CONNECTION_ID int)
BEGIN
    UPDATE connections SET logout_date = NOW() WHERE id = CONNECTION_ID and id_user = USER_ID;
    UPDATE users SET last_connection = NOW() WHERE id = USER_ID;

    IF NOT EXISTS(SELECT id FROM connections WHERE logout_date IS NULL) THEN
        UPDATE users SET state = 'I' WHERE id = USER_ID;
    END IF;
END;

CREATE FUNCTION user_is_contact(USERID int, CONTACTID int) RETURNS BOOLEAN
    READS SQL DATA
BEGIN
    RETURN if(CONTACTID IN (SELECT contact_id FROM contacts WHERE user_id = USERID), true, false);
END;

#Procedimientos para contactos.
CREATE FUNCTION user_AddContact(own int, contact int) RETURNS INT
    MODIFIES SQL DATA
BEGIN
    insert into contacts(user_id, contact_id) values (own, contact);

    RETURN LAST_INSERT_ID();
END;

#Procedimientos para mensajes.
CREATE FUNCTION user_SendMessage(source int, dest int, msg text) RETURNS INT
    MODIFIES SQL DATA
BEGIN
    IF NOT EXISTS(SELECT * FROM contacts WHERE user_id = source and contact_id = dest)
        AND NOT EXISTS(SELECT accepted FROM invitations WHERE id_source = source and id_dest = dest) THEN
        INSERT INTO invitations(id_source, id_dest, send_date) VALUES (source, dest, NOW());
    END IF;

    INSERT INTO message(id_source, id_dest, send_date, content) VALUES (source, dest, NOW(), msg);

    RETURN LAST_INSERT_ID();
END;

#Obtener las conversaciones.
CREATE PROCEDURE user_GetConversations(IN USER_ID int)
BEGIN
    SELECT if(id_source != USER_ID, su.user_name, du.user_name)   as contact_id,
           if(id_source != USER_ID, su.first_name, du.first_name) as first_name,
           if(id_source != USER_ID, su.last_name, du.last_name)   as last_name,
           id_source = USER_ID as isMyMessage,
           message.id,
           message.content
    FROM message
             inner join users su on id_source = su.id
             inner join users du on id_dest = du.id
    WHERE USER_ID IN (su.id, du.id)
      and message.id = (select id
                        from message
                        where id_source in (su.id, du.id)
                          and id_dest in (su.id, du.id)
                        order by id desc
                        limit 1);
END;

#Datos de prueba.
INSERT INTO users
VALUES (1, 'erdu', '$2y$10$P3DtjrJE7JU6Sbm8Vb4ISuE44j/0phdXSPXFD/QFmnS/qmf3fW.Qa', 'E', 'C', NOW(), 'M', NULL, 'A',
        NOW(), NOW()), #12345678
       (2, 'test', '$2y$10$S/qP2dbOjk3f3NMUWXrm4u0rgP8/oQECx.lNdBKsx9j6oT5a9qtXS', 'Prueba', 'TEST', null, null, null,
        null, '2021-05-18 11:09:55', null),
       (3, 'test2', '$2y$10$S/qP2dbOjk3f3NMUWXrm4u0rgP8/oQECx.lNdBKsx9j6oT5a9qtXS', 'Prueba', 'TEST', null, null, null,
        null, '2021-05-18 11:09:55', null);

INSERT INTO contacts
VALUES (1, 3, null);