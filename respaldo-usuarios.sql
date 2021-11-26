USE simplechat;
insert into users (id, user_name, pass, first_name, last_name, birth_date, gender, email, state, create_at,
                   last_connection, profile_img)
values (1, 'erdu', '$2y$10$P3DtjrJE7JU6Sbm8Vb4ISuE44j/0phdXSPXFD/QFmnS/qmf3fW.Qa', 'E', 'C', now(), 'M', null, 'I',
        now(), null, 'erdu.png'),
       (2, 'test', '$2y$10$S/qP2dbOjk3f3NMUWXrm4u0rgP8/oQECx.lNdBKsx9j6oT5a9qtXS', 'Prueba', 'TEST', now(), 'M', null,
        'I', now(), null, 'test.png'),
       (3, 'test2', '$2y$10$S/qP2dbOjk3f3NMUWXrm4u0rgP8/oQECx.lNdBKsx9j6oT5a9qtXS', 'Prueba', 'TEST', now(), 'M', null,
        'I', now(), null, 'test2.png'),
       (4, 'louislitt', '$2y$10$S/qP2dbOjk3f3NMUWXrm4u0rgP8/oQECx.lNdBKsx9j6oT5a9qtXS', 'Louis', 'Marlowe Litt',
        '1970-05-20', 'M', 'louislitt@email.com', 'I', now(), null, 'louislitt.png'),
       (5, 'rachelzane', '$2y$10$S/qP2dbOjk3f3NMUWXrm4u0rgP8/oQECx.lNdBKsx9j6oT5a9qtXS', 'Rachel Elizabeth', 'Zane',
        '1985-04-30', 'F', 'rachelzane@email.com', 'I', now(), null, 'rachelzane.png'),
       (6, 'mikeross', '$2y$10$S/qP2dbOjk3f3NMUWXrm4u0rgP8/oQECx.lNdBKsx9j6oT5a9qtXS', 'Michael James', 'Ross',
        '1981-04-04', 'M', 'mikeross@email.com', 'I', now(), null, 'mikeross.jpg'),
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

INSERT INTO message(id_source, id_dest, send_date, rcv_date, read_date, content, content_img)
VALUES (4, 6, now(3), now(), now(), 'Acabas de levantar a LITT, Mike.', null),
       (5, 6, now(3), now(), now(), 'Estaba pensando que podríamos comer pollo esta noche, ¿suena bien?', null),
       (6, 7, now(3), now(), now(),
        '¡¿Cómo diablos se supone que voy a hacer que un jurado te crea cuando ni siquiera estoy seguro de que lo crea ?!',
        null),
       (7, 6, now(3), now(), now(),
        'Cuando estés contra la pared, derriba esa maldita cosa.', null),
       (7, 6, now(3), now(), now(),
        'Las excusas no ganan campeonatos.', null),
       (6, 7, now(3), now(), now(),
        'Oh, sí, ¿Michael Jordan te dijo eso?', null),
       (7, 6, now(3), now(), now(),
        'No, le dije eso.', null),
       (7, 6, now(3), now(), now(),
        '¿Cuáles son sus opciones cuando alguien le apunta con un arma a la cabeza?', null),
       (6, 7, now(3), now(), now(),
        '¿De qué estás hablando? Haz lo que te dicen o te disparan.', null),
       (7, 6, now(3), now(), now(),
        'Equivocado. Coges el arma o sacas una más grande. O llama a su farol. O haces una de las ciento cuarenta y seis cosas más.',
        null);


INSERT INTO `users` VALUES
(8,'marcus','$2y$10$ZwvjHEV01gs6o/SXMimTF.1JAcDtjqlo9F9a3gwLL4FUeUxH1oGCq','Marcos ','López','1996-08-18','M','lopezm.fran1824@gmail.com','88151137','I','2021-10-04 18:12:01',NULL,'marcus.png'),
(9,'matias_hernandez','$2y$10$4s6S4PvL0ilT9KDo4xyInuptNXE/V3V1bPjRg8KL5ZCUrGvYoB06y','Matías Gabriel','Hernández González','1999-02-10','M','matiasgabrielhernandezgonzalez@gmail.com','81066134','I','2021-10-04 18:47:23','2021-10-11 12:01:20','matias_hernandez.png'),
(10,'Osman','$2y$10$vkLEYiYUKrmQ4QhLlFx1iucnPeFI3japWC59w9R3G2fTtR1xjUwKy','Osman Rodolfo','Blandon Altamirano ','1998-11-20','M','osman.A201198@gmail.com','85023721','I','2021-10-04 19:03:44','2021-10-05 21:40:34','Osman.jpg'),
(11,'admin','$2y$10$AeFaSX1.vN8mhJtWD7eTYORFTpph4iqU5AiwLrXfCPlS41z20CWiS','ariel','campos','2006-02-16','D','dfsfsdfds@gmail.com','12355489','I','2021-10-04 19:11:31','2021-10-04 19:51:59','admin.png'),
(12,'Ernesto ','$2y$10$uv6vYN1ICoF9oGeLDx4.FO5W67wX7OJYHpJIWOBs3HQYYYnlEyfv2','Pelon','Espinoza','2021-10-14','M','1994netoespinoza@gmail.com','86134832','I','2021-10-19 23:12:11','2021-10-19 23:12:29','Ernesto .png'),
(13,'ToroChingon','$2y$10$MqMrVJ1c6kNTjr05ozaJguzvWNSwMX3van927D/jpXos.gmPZqKhi','toro','chingon','1900-12-24','O','maluma@gmail.com','88888888','I','2021-10-24 12:14:39','2021-10-24 12:14:49','ToroChingon.jpg'),
(14,'AlexDM26','$2y$10$JSdQF2OsFlCI39sbP6Q3ounqyHGkDL9dy4zyrmApOTk/js1fhm7Uu','Alexander','Delgado','1999-02-26','M','alexander.delgado123@gmail.com','22456665','I','2021-10-24 14:04:05','2021-10-24 14:06:57','AlexDM26.png');

