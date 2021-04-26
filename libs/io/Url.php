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

    public static function Combine(string $url1, string $url2): ?string
    {
        if (empty($url1) && empty($url2)) return null;
        else if (empty($url1)) return self::Fix($url2);
        else if (empty($url2)) return self::Fix($url1);
        else {
            $url1 = self::Fix($url1);
            $url2 = self::Fix($url2);

            //Si path2 no inicia con separador.
            if (strpos($url2, self::SEPARATOR) !== 0)
                return $url1 . self::SEPARATOR . $url2;
            else
                return $url1 . $url2;
        }
    }
}