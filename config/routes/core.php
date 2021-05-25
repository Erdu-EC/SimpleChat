<?php

namespace HS\config\routes;

use HS\libs\core\Route;
use HS\libs\helper\Regex;

#SCSS Routes
Route::Get('/files/css/{filename}.css', 'SCSSController#Get', [], true);
Route::Get('/files/css/{filename}.css.map', 'SCSSController#GetMap', [], true);
Route::Get('/files/scss/{filename}.scss', 'SCSSController#GetSCSS', [], true);

#Image Routes
$cond_image = [/*'type' => [['icon']], */'filename' => Regex::EndWith('.png', '.bmp', '.gif', '.jpg', '.jpeg'),
    'get' => '#^(?:[w|h]=\d+(?:\.\d+)?)(?:&[w|h]=\d+(?:\.\d+)?)?$#'
];
Route::Get('/files/{type*}/{filename}', 'ImageController#Get', $cond_image , true);
Route::Get('/files/{type*}/{filename}?{get}', 'ImageController#Get', $cond_image, true);
unset($cond_image);

#Login and Register Routes
Route::Get("/Login", '/app/view/Login.php', [], true);
Route::Get("/Register", '/app/view/Register.php', [], true);

Route::Post('/action/user/Login', 'LoginController#Login', [], true);
Route::Post('/action/user/Register', 'LoginController#Register', [], true);
Route::Get("/Logout", 'LoginController#Logout', [], true);

#Redirección a Login.
Route::All('{all*}', 'LoginController#IfNotLoginRedirect', [], false);
