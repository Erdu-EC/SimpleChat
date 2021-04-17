<?php


namespace HS\libs\io;

use const HS\APP_PATH;

class Path
{
    public static function GetFileName(string $path): ?string
    {
        $basename = pathinfo($path, PATHINFO_BASENAME);
        return empty($basename) ? null : $basename;
    }

    public static function GetFileNameWithoutExtension(string $path): ?string
    {
        $name = pathinfo($path, PATHINFO_FILENAME);
        return empty($name) ? null : $name;
    }

    public static function GetExtension(string $path): ?string
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        return empty($extension) ? null : ".{$extension}";
    }

    public static function GetDirName(string $path): ?string
    {
        $dirname = pathinfo($path, PATHINFO_DIRNAME);
        return empty($dirname) ? null : self::Fix($dirname);
    }

    public static function Fix(string $path): string
    {
        $path = preg_replace("#[\\\|/]+#", DIRECTORY_SEPARATOR, trim($path));
        if (strpos($path, DIRECTORY_SEPARATOR, ($path_pos = strlen($path) - 1)) === $path_pos)
            $path = substr($path, 0, $path_pos);
        return $path;
    }

    public static function Combine(string $path1, string $path2): ?string
    {
        if (empty($path1) && empty($path2)) return null;
        else if (empty($path1)) return self::Fix($path2);
        else if (empty($path2)) return self::Fix($path1);
        else {
            $path1 = self::Fix($path1);
            $path2 = self::Fix($path2);

            //Si path2 no inicia con separador.
            if (strpos($path2, DIRECTORY_SEPARATOR) !== 0)
                return $path1 . DIRECTORY_SEPARATOR . $path2;
            else
                return $path1 . $path2;
        }
    }

    public static function ToAbsolute(string $path): string
    {
        $path = self::Fix($path);

        if (strpos($path, "." . DIRECTORY_SEPARATOR) === 0 || strpos($path, "~" . DIRECTORY_SEPARATOR) === 0)
            $path = substr($path, 2);
        else if (strpos($path, ".." . DIRECTORY_SEPARATOR) === 0)
            $path = substr($path, 3);

        return Path::Combine(APP_PATH, $path);
    }
}