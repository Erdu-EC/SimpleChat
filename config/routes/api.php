<?php

namespace HS\config\routes;

use HS\libs\core\Route;

#Users


#Contacts
Route::Get('/action/users/all', 'UserController#GetAll', [], true);
Route::Get('/action/users/search', 'UserController#SearchUserOrContact', [], true);
Route::Get('/action/users/contacts', 'ContactController#GetAll', [], true);