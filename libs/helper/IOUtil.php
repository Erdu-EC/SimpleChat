<?php


namespace HS\libs\helper;

use HS\libs\io\Path;
use const HS\APP_FILE_MODE;

class IOUtil
{
    public static function CreateFile(string $filename){
        //Verificando si el fichero ya existe
        if (is_file($filename)) return true;

        //Si no, creando directorio y el fichero.
        if (IOUtil::CreateDir(Path::GetDirName($filename), true))
            return file_put_contents($filename, '', FILE_APPEND) !== false;

        return false;
    }

    public static function CreateDir($path, $recursive): bool
    {
        //Verificando que el directorio del fichero exista.
        if (!($exist = is_dir($path))) $exist = mkdir($path, APP_FILE_MODE, $recursive);

        //Devolviendo.
        return $exist;
    }
}