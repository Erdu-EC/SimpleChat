<?php

namespace HS\config\routes;

use HS\libs\core\Route;

#Login and Register Routes
Route::Get("/Login", '/app/view/Login.php', [], true);
Route::Get("/Register", '/app/view/Register.php', [], true);

Route::Post('/action/user/Login', 'LoginController#Login', [], true);
Route::Post('/action/user/Register', 'LoginController#Register', [], true);
Route::Get("/Logout", 'LoginController#Logout', [], true);

#Redirección a Login.
Route::All('{all*}', 'LoginController#IfNotLoginRedirect', [], false);

#Pagina de inicio.
Route::Get("/", "/app/view/index.php", [], true);

