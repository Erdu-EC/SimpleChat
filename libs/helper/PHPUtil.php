<?php
namespace HS\libs\helper;

use HS\libs\io\Path;
use InvalidArgumentException;

class PHPUtil
{
    public static function Require(string $path, array $files){
        if (!is_null($files) && is_array($files)){
            foreach ($files as $file)
                /** @noinspection PhpIncludeInspection */
                require Path::Combine($path, $file);
        }else
            throw new InvalidArgumentException('Se esperaba un arreglo: ' . var_export($files));
    }
}