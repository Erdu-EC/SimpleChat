<?php

namespace HS\config\routes;

use HS\libs\core\http\HttpResponse;
use HS\libs\core\Route;

#Login Routes
Route::Get("/Login", '/app/view/Login.php', [], true);
Route::Post('/Login.json', 'LoginController#Login', [], true);
Route::Get("/Logout", 'LoginController#Logout', [], true);
Route::Get("/chat", '/app/view/chats.php', [], true);
Route::Get("/contactos", '/app/view/contactos.php', [], true);
Route::Get("/temp", '/app/view/chat.php', [], true);
Route::Get("/conversacion", '/app/view/conversacion.php', [], true);
#Redirección a Login.
Route::All('{all*}', 'LoginController#IfNotLoginRedirect', [], false);

#Pagina de inicio.
Route::Get("/", "/app/view/index.php", [], true);
