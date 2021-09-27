<?php

	namespace HS\config\routes;

	use HS\app\model\UserModel;
	use HS\libs\core\Route;
	use HS\libs\helper\Regex;

	#Users and Contacts
	Route::Get('/action/users/all', 'UserController#GetAll');
	Route::Post('/action/users/search', 'UserController#SearchUserOrContact');
	Route::Get('/action/users/contacts', 'ContactController#GetAll');
	Route::Post('/action/contacts/add', 'ContactController#AddContact');
	Route::Post('/action/contacts/info', 'UserController#GetOneById');

	#Users Settings
	Route::Post('/action/profile/i/update', 'SettingController#UpdateInfo');
	Route::Post('/action/profile/p/update', 'SettingController#UpdatePassword');

	#Conversations and Messages.
	Route::Post('/action/messages/send', 'MessageController#Send');
	Route::Post('/action/messages/send_img', 'ImageController#Upload');
	Route::Get('/action/conversations', 'MessageController#GetConversations');

	Route::Get('/Chats/{contact_name}/', 'MessageController#GetConversationsWithContact', [
		'contact_name' => fn(string $user): bool => UserModel::IsValidUserName($user)
	]);

	#Invitations.
	Route::Post('/action/invitation/accept', 'InvitationController#ChangeStateOfLast');

	#Messages and Invitations Instants.
	Route::Get('/action/users/MIInstant', 'Instant#GetUnreceivedMessagesAndInvitations');

	#Upload Image Route
	Route::Post('/action/users/{type}/upload_img', 'ImageController#Upload', [
		'type' => Regex::InList('profile')
	]);

	///action/users/profile/upload_img