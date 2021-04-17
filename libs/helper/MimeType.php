<?php


namespace HS\libs\helper;


use finfo;

class MimeType
{
    const Text = 'text/plain';
    const HTML = 'text/html';
    const CSS = 'text/css';
    const Json = 'application/json';

    public static function OfFile(string $path) : string{
        if (!file_exists($path)) return self::Text;
        $info = (new finfo(FILEINFO_MIME_TYPE))->file($path);
        if ($info === false) return self::Text;
        return $info;
    }
}