<?php

namespace HS\config;

use HS\libs\io\Path;
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

class APP_URL {
    const IMG_PROFILE = '/files/profile';

    public static function OfImageProfile(string $file_img){
        return Path::Combine(self::IMG_PROFILE, $file_img);
    }
}