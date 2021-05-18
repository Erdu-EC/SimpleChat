DROP DATABASE IF EXISTS simplechat;
CREATE DATABASE simplechat;
USE simplechat;

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
    KEY idx_user_name (user_name)
) engine = InnoDB;

CREATE TABLE connections(
                            id INT AUTO_INCREMENT,
                            id_user INT,
                            device TEXT,
                            login_date datetime,
                            logout_date datetime DEFAULT NULL,
                            PRIMARY KEY (id),
                            FOREIGN KEY (id_user) REFERENCES users(id)
);

CREATE TABLE invitations
(
    id                   INT AUTO_INCREMENT,
    id_source            INT,
    id_dest              INT,
    send_date            datetime,
    rcv_date             datetime,
    accepted             boolean,
    accepted_reject_date datetime,

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

#Datos de prueba.
INSERT INTO users
VALUES (0, 'erdu', '$2y$10$P3DtjrJE7JU6Sbm8Vb4ISuE44j/0phdXSPXFD/QFmnS/qmf3fW.Qa', 'E', 'C', NOW(), 'M', NULL, 'A',
        NOW(), NOW()); #12345678


#Funciones Y procedimientos.
CREATE FUNCTION user_set_login(name varchar(30), device_desc TEXT) RETURNS INT
BEGIN
    DECLARE USER_ID int DEFAULT (select id from users WHERE user_name = name);

    UPDATE users SET state = 'A', last_connection = NOW() WHERE id = USER_ID;
    INSERT INTO connections(id_user, device, login_date) VALUES(USER_ID, device_desc, NOW());

    RETURN LAST_INSERT_ID();
END;

CREATE PROCEDURE user_set_logout(in USER_ID int, in CONNECTION_ID int)
BEGIN
    UPDATE connections SET logout_date = NOW() WHERE id = CONNECTION_ID and id_user = USER_ID;
    UPDATE users SET last_connection = NOW() WHERE id = USER_ID;

    IF NOT EXISTS (SELECT id FROM connections WHERE logout_date IS NULL) THEN
        UPDATE users SET state = 'I' WHERE id = USER_ID;
    END IF;
END;