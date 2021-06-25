<?php

namespace HS\libs\helper;


class Text
{
    #Información de cadenas.
    public static function Length(string $text): int
    {
        return strlen($text);
    }

    public static function IsEmpty(string $text): bool
    {
        return empty($text);
    }

    #Buscar cadenas.
    public static function IndexOf(string $text, string $find, bool $ignoreCase = false, int $offset = 0)
    { /*Devuelve: int | false */
        return ($ignoreCase) ? stripos($text, $find, $offset) : strpos($text, $find, $offset);
    }

    public static function Contains(string $text, string $find, bool $ignoreCase = false): bool
    {
        return self::IndexOf($text, $find, $ignoreCase) !== false;
    }

    public static function StartWith(string $text, string $find, bool $ignoreCase = false): bool
    {
        return self::IndexOf($text, $find, $ignoreCase) === 0;
    }

    public static function EndsWith(string $text, string $find, bool $ignoreCase = false): bool
    {
        return self::IndexOf($text, $find, $ignoreCase, strlen($text) - strlen($find)) === (strlen($text) - strlen($find));
    }

    #Modificar cadenas
    public static function Trim(string $text, string $charlist = null)
    {
        if (empty($charlist))
            return trim($text);
        else
            return trim($text, $charlist);
    }

    public static function TrimLeft(string $text, string $charlist = null)
    {
        if (empty($charlist))
            return ltrim($text);
        else
            return ltrim($text, $charlist);
    }

    public static function TrimRight(string $text, string $charlist = null)
    {
        if (empty($charlist))
            return rtrim($text);
        else
            return rtrim($text, $charlist);
    }

    public static function SubString(string $text, int $start, int $lenght = NULL)
    {
        return substr($text, $start, $lenght ?? strlen($text));
    }

    public static function Replace(string $text, string $find, string $replace, bool $ignoreCase = false)
    {
        return ($ignoreCase) ? str_ireplace($find, $replace, $text) : str_replace($find, $replace, $text);
    }
}