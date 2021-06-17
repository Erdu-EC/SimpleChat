<?php

namespace HS\config\routes;

use HS\libs\core\Route;

#Users


#Contacts
Route::Get('/action/users/all', 'UserController#GetAll');
Route::Post('/action/users/search', 'UserController#SearchUserOrContact');
Route::Get('/action/users/contacts', 'ContactController#GetAll');
Route::Post('/action/contacts/add', 'ContactController#AddContact');
Route::Post('/action/messages/send', 'MessageController#Send');
Route::Get('/action/conversations', 'MessageController#GetConversations');