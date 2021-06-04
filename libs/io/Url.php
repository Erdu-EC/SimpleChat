<?php


namespace HS\libs\io;


class Url
{
    private const SEPARATOR = '/';

    public static function Fix(string $url){
        $url = preg_replace("#[\\\|/]+#", self::SEPARATOR, trim($url));
        if (strpos($url, self::SEPARATOR, ($url_pos = strlen($url) - 1)) === $url_pos)
            $url = substr($url, 0, $url_pos);
        return $url;
    }
}