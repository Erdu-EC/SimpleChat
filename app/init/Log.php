<?php

namespace HS\app\init;

use HS\config\APP_DIR;
use HS\libs\helper\IOUtil;
use HS\libs\io\Path;

//Habilitando log de errores.
ini_set('log_errors', 1);
$filename = Path::Combine(APP_DIR::LOG, "core.log");

//Creando fichero de log.
if (file_exists($filename) || IOUtil::CreateFile($filename))
    ini_set('error_log', $filename);