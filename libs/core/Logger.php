<?php

namespace HS\libs\core;

use HS\config\APP_DIR;
use HS\libs\helper\IOUtil;
use HS\libs\io\Path;
use const HS\APP_PATH;

class Logger
{
    public static function Log(string $filename, string $title, string $message){
        //Obteniendo ruta completa del fichero log.
        $filename = Path::Combine(APP_DIR::LOG, "$filename.log");

        //Obtener codigo de respuesta.
        $message = http_response_code() . " | $title - $message\n";

        //Creando archivo de log.
        if (IOUtil::CreateFile($filename)){
            if (error_log($message, 3, $filename))
                return;
        }

        //Si no se pudo escribir los logs en el archivo especificado...
        error_log($message);
    }
}