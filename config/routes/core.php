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