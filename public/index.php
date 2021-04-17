<?php

namespace HS {
    #Depuración.
    const APP_DEBUG = true;

    #Aplicación.
    /**Espacio de nombres base de la aplicación.*/
    const APP_NAMESPACE = __NAMESPACE__;

    /**Ruta del directorio raiz de la aplicación.*/
    define(__NAMESPACE__ . '\APP_PATH', realpath(__DIR__ . "/.."));

    /**Url raiz de la aplicación.*/
    define(__NAMESPACE__ . '\APP_URL', pathinfo($_SERVER['PHP_SELF'], PATHINFO_DIRNAME));

    /**Permiso a nivel de usuario para archivos y carpetas que crea la aplicación.*/
    const APP_FILE_MODE = '0007';
}

namespace {

    use const HS\APP_DEBUG;
    use const HS\APP_PATH;

    #Advertencias y reportes de errores.
    error_reporting(APP_DEBUG ? E_ALL : 0);
    ini_set('display_errors', APP_DEBUG ? 1 : 0);

    #Limitando acceso a ficheros del servidor.
    ini_set('open_basedir', APP_PATH);

    #Iniciando aplicación.
    require '../app/init.php';

    #Si no se encontro una ruta valida.
    header('HTTP/1.0 404 Not Found');
}
