<?php
namespace HS\config;

use const HS\APP_PATH;

/** Determina si los ficheros .css resultantes estaran comprimidos. <br/><br/>
 * <b>Nota:</b> Es necesario limpiar la cache para observar los cambios.</i> */
const SCSS_COMPRESS = true;

/** Nombre del fichero en donde se escribira la información sobre errores, etc.<br/><br/>
 * Nota: la constante HS_PATH_LOG determina el directorio de los logs.*/
const SCSS_LOG_FILE = 'scss';

/** Ruta al directorio que contiene los ficheros .scss. <br/>
 * Ejemplo: /<<PATH_ROOT>>/files/scss */
const SCSS_PATH_ROOT = APP_PATH . '/files/scss';

/** Ruta al directorio donde se guardara la cache de los ficheros .scss ya procesados. <br/>
Ejemplo: /<<PATH_ROOT>>/.temp/cache/scss */
const SCSS_PATH_CACHE = APP_DIR::CACHE . '/scss';

/** Pseudo-ruta en la que el navegador ubicara los ficheros .scss obtenidos mediante el SourceMap.*/
const SCSS_PATH_SOURCE = '../scss/';