<?php

namespace HS\config\routes;

use HS\libs\core\Route;

#Users


#Contacts
Route::Get('/api/users/all', 'UserController#GetAll', [], true);