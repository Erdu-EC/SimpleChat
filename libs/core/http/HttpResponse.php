<?php


namespace HS\libs\core\http;


use HS\libs\io\Url;
use const HS\APP_URL;

class HttpResponse
{
    const _404_NOTFOUND = 'HTTP/1.0 404 Not Found';
    const _500_INTERNAL_SERVER_ERROR = 'HTTP/1.0 500 Internal Server Error';

    public static function SetContentType(string $MimeType) {
        header("content-type: $MimeType");
    }

    public static function Set($value){
        header($value);
    }

    public static function Redirect(string $url){
        if (strpos($url, '/', 0) === 0)
            $url = Url::Combine(APP_URL, $url);

        header("Location: $url");
    }
}