<?php

namespace HS\config;

use HS\libs\core\ClassLoader;
use const HS\APP_PATH;

ClassLoader::Register(
    APP_PATH . "/app/controller",
    APP_PATH . "/app/model",
    APP_PATH . "/libs"
);