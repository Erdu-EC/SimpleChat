<?php

    namespace HS\config\routes;

    use HS\app\model\UserModel;
    use HS\libs\core\Route;

    #Pagina de inicio.
    Route::Get("/", "index.php");

    #Paginas de usuario.
    Route::Get('/Contacts', 'Contacts.php');

    #Paginas parciales.
    Route::Get('/Settings', 'SettingViewController#Index');
