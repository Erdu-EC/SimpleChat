<?php

    namespace HS\config\routes;

    use HS\app\model\UserModel;
    use HS\libs\core\Route;

    #Pagina de inicio.
    Route::Get("/", "index.php");

    #Paginas de usuario.
    Route::Get('/Contacts', 'Contacts.php');

    #Paginas parciales.
    Route::Get('/Chats/{contact_name}/', 'ChatViewController#Index', [
        'contact_name' => function (string $user): bool {
            return UserModel::IsValidUserName($user);
        }
    ]);
    Route::Get('/Settings', '/partial/settings.php');
