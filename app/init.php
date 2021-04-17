<?php

namespace HS;

use HS\libs\helper\PHPUtil;

#Directorios de la aplicación.
require APP_PATH . "/config/locations.php";

#Autocarga de clases.
require APP_PATH . "/libs/core/ClassLoader.php";
require APP_PATH . "/config/autoload.php";

#Sistema de logs.
require APP_PATH . "/app/init/Log.php";

#Configuración.
PHPUtil::Require(APP_PATH . "/config", [
    'general.php',
    'scss.php',
    'session.php'
]);

#Rutas.
PHPUtil::Require(APP_PATH . "/config/routes", [
    'core.php',
    'web.php'
]);


