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
		'chat' => '/upload/message'
    ];
	const AUDIO = '/upload/audio';

    const F_PREPROCESSED_JS = '/files/js';
}

class APP_URL {
    const IMG_PROFILE = '/files/profile';
	const IMG_CHAT = '/files/chat/';
	const AUDIO_CHAT = '/files/audio';

    public static function OfImageProfile(?string $file_img): string
    {
        return !is_null($file_img) ? Path::Combine(self::IMG_PROFILE, $file_img) : '';
    }

	public static function OfChatImage(?string $file_img): string
	{
		return !is_null($file_img) ? Path::Combine(self::IMG_CHAT, $file_img) : '';
	}

	public static function OfChatAudio(?string $file_audio): string
	{
		return !is_null($file_audio) ? Path::Combine(self::AUDIO_CHAT, $file_audio) : '';
	}
}