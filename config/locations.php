<?php

namespace HS\config;

use const HS\APP_PATH;

class APP_DIR
{
    const VIEW = APP_PATH . "/app/view";
    const TEMP = APP_PATH . "/.temp";
    const LOG = self::TEMP . "/logs";
    const CACHE = self::TEMP . "/cache";
    const IMAGE_CACHE = self::CACHE . '/img';
    const IMAGE = [
        'icon' => '/files/icon',
        'bg' => '/files/bg',
        'profile' => '/upload/profile'
    ];

}