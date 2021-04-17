<?php

namespace HS\libs\core;

use DirectoryIterator;
use HS\libs\io\Path;
use InvalidArgumentException;
use const HS\APP_NAMESPACE;
use const HS\APP_PATH;

require_once APP_PATH . "\libs\io\Path.php";

#Registrando como función para autoincludes.
spl_autoload_register(function (string $class) {
    ClassLoader::Import($class);
});

class ClassLoader
{
    private static $List = [];

    public static function Register()
    {
        foreach (func_get_args() as $path) {
            if (!is_string($path))
                throw new InvalidArgumentException("Se esperaba una cadena especificando un directorio para buscar clases.");
            else if (strpos($path, APP_PATH, 0) !== 0)
                throw new InvalidArgumentException('No se permite directorios ubicados fuera de la aplicación.');
            else if (!is_dir($path))
                throw new InvalidArgumentException('La ruta especificada no existe o no es un directorio.');

            self::$List[] = Path::Fix($path);
        }
    }

    public static function Import(string $class)
    {
        //Si la clase pertenece al espacio de nombres principal,
        //tratar de incluir resolviendo directamente su ruta.
        if (strpos($class, APP_NAMESPACE . "\\", 0) === 0){
            $fileClass = substr_replace($class, APP_PATH, 0, strlen(APP_NAMESPACE));
            $fileClass = Path::Fix("$fileClass.php");

            //Si el directorio de la clase esta en la lista y existe el archivo de la clase.
            foreach (self::$List as $directory){
                if (strpos($fileClass, $directory, 0) === 0){
                    if (file_exists($fileClass)) {
                        /** @noinspection PhpIncludeInspection */
                        require_once $fileClass;

                        if (class_exists($class)) return;
                        else break;
                    }
                }
            }
        }

        //Si no pertenece al principal, o no posee un nombre cualificado,
        //se busca en cada directorio y subdirectorio de la lista,
        //incluyendo todas las clases del mismo nombre.
        foreach (self::$List as $directory)
            self::Search($class, $directory);
    }

    private static function Search(string $class, string $dir)
    {
        $file = pathinfo("$class.php", PATHINFO_BASENAME);

        foreach (new DirectoryIterator($dir) as $fileinfo) {
            if (!$fileinfo->isDot()) {
                if ($fileinfo->isDir())
                    self::Search($class, "$dir\\{$fileinfo->getFilename()}");
                else if ($fileinfo->getFilename() == $file) {
                    /** @noinspection PhpIncludeInspection */
                    require_once $fileinfo->getPathname();
                }
            }
        }
    }
}