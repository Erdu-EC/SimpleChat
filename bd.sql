DROP DATABASE IF EXISTS simplechat;
CREATE DATABASE simplechat;
USE simplechat;

CREATE TABLE users
(
    id        int primary key,
    user_name varchar(30)  not null unique,
    pass      varchar(120) not null
);

INSERT INTO users VALUES (0, 'erdu', '$2y$10$P3DtjrJE7JU6Sbm8Vb4ISuE44j/0phdXSPXFD/QFmnS/qmf3fW.Qa'); #12345678