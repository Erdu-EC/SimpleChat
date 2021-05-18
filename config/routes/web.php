<?php

namespace HS\config\routes;

use HS\libs\core\Route;

#Pagina de inicio.
Route::Get("/", "/app/view/index.php", [], true);

#Paginas de usuario.
Route::Get('/Contacts', '/app/view/Contacts.php', [], true);
