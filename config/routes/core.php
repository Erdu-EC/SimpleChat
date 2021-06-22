<?php

    namespace HS\config\routes;

    use HS\config\APP_DIR;
    use HS\libs\core\Route;
    use HS\libs\helper\Regex;

    #SCSS Routes
    Route::Get('/files/css/{filename}.css', 'SCSSController#Get', [], true);
    Route::Get('/files/css/{filename}.css.map', 'SCSSController#GetMap', [], true);
    Route::Get('/files/scss/{filename}.scss', 'SCSSController#GetSCSS', [], true);

    #Image Routes
    $cond_image = [
        'type' => call_user_func_array([Regex::class, 'InList'], array_keys(APP_DIR::IMAGE)),
        'filename' => Regex::EndWith('.png', '.bmp', '.gif', '.jpg', '.jpeg'),
        'get' => '#^(?:[w|h]=\d+(?:\.\d+)?)(?:&[w|h]=\d+(?:\.\d+)?)?$#'
    ];
    Route::Get('/files/{type*}/{filename}', 'ImageController#Get', $cond_image, true);
    Route::Get('/files/{type*}/{filename}?{get}', 'ImageController#Get', $cond_image, true);
    Route::Get('/files/{type*}/{filename}', 'ImageController#GetOriginal', [
        'filename' => Regex::EndWith('.svg')
    ]);
    unset($cond_image);

    #Login and Register Routes
    Route::Get("/Login", 'Login.php', [], true);
    Route::Get("/Register", 'Register.php', [], true);

    Route::Post('/action/user/Login', 'LoginController#Login', [], true);
    Route::Post('/action/user/Register', 'LoginController#Register', [], true);
    Route::Get("/Logout", 'LoginController#Logout', [], true);

    #Redirección a Login.
    Route::All('{all*}', 'LoginController#IfNotLoginRedirect', [], false);
