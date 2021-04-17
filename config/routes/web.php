<?php

namespace HS\config\routes;

use HS\libs\core\Route;

Route::Get("/", "/phpinfo.php", [], true);

Route::Get("/Login", '/app/view/Login.php', [], true);