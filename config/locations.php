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
        'profile' => '/upload/profile',
        'photos' => '/files/photos',
		'msg' => '/upload/message'
    ];

    const F_PREPROCESSED_JS = '/files/js';
}

class APP_URL {
    const IMG_PROFILE = '/files/profile';

    public static function OfImageProfile(?string $file_img): string
    {
        return !is_null($file_img) ? Path::Combine(self::IMG_PROFILE, $file_img) : '';
    }
}