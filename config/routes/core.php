<?php

	namespace HS\config\routes;

	use HS\config\APP_DIR;
	use HS\libs\core\Route;
	use HS\libs\graphic\Image;
	use HS\libs\helper\Regex;

	#SCSS Routes
	Route::Get('/files/css/{filename}.css', 'SCSSController#Get');
	Route::Get('/files/css/{filename}.css.map', 'SCSSController#GetMap');
	Route::Get('/files/scss/{filename}.scss', 'SCSSController#GetSCSS');

	#Image Routes
	$cond_image = [
		'type' => call_user_func_array([Regex::class, 'InList'], array_keys(APP_DIR::IMAGE)),
		'filename' => call_user_func_array([Regex::class, 'EndWith'], Image::SUPPORTED_FORMATS),
		'get' => '#^(?:[wht]=\d+(?:\.\d+)?)(?:&[wht]=\d+(?:\.\d+)?)?(?:&[wht]=\d+(?:\.\d+)?)?$#'
	];
	Route::Get('/files/{type*}/{filename}', 'ImageController#Get', $cond_image);
	Route::Get('/files/{type*}/{filename}?{get}', 'ImageController#Get', $cond_image);
	Route::Get('/files/{type*}/{filename}', 'ImageController#GetOriginal', [
		'type' => call_user_func_array([Regex::class, 'InList'], array_keys(APP_DIR::IMAGE)),
		'filename' => Regex::EndWith('.svg')
	]);
	unset($cond_image);

	#Audio Routes.
	Route::Get('/files/audio/{filename}', 'FileAccessController#GetAudio', [
		'filename' => Regex::EndWith('.webm')
	]);

	#Preprocessed JS Routes
	Route::Get('/files/js/{filename*}.js', 'JSController#Get');

	#Login and Register Routes
	Route::Get("/Login", 'Login.php');
	Route::Get("/Register", 'Register.php');
	Route::Get("/Privacy", 'Privacy.php');
	Route::Get("/About", 'About.php');
	Route::Get("/Contact", 'ContactUs.php');

	Route::Post('/action/user/Login', 'LoginController#Login');
	Route::Post('/action/user/Register', 'LoginController#Register');
	Route::Post('/action/user/Setting', 'LoginController#Setting');
	Route::Post('/action/user/NewPassword', 'LoginController#NewPassword');
	Route::Get("/Logout", 'LoginController#Logout');

	#Redirección a Login.
	Route::All('{all*}', 'LoginController#IfNotLoginRedirect', [], false);

	#rutas temporales
	Route::Get("/500", '/error/500.php');
	Route::Get("/400", '/error/400.php');
	Route::Get("/401", '/error/401.php');
	Route::Get("/404", '/error/404.php');