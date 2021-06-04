<?php


namespace HS\libs\core;


use HS\config\APP_DIR;
use HS\libs\io\Path;

class Controller
{
    protected function View(string $path, $data = null, bool $die = true){
        define('HS\app\view\_VIEW', $data);

        /** @noinspection PhpIncludeInspection */
        require Path::Combine(APP_DIR::VIEW, $path);

        if ($die) die();

        return null;
    }
}