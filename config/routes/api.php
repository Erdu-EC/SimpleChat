<?php

namespace HS\config\routes;

use HS\libs\core\Route;

#Users


#Contacts
Route::Get('/action/users/all', 'UserController#GetAll', [], true);