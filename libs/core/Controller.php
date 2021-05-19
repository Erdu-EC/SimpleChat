<?php


namespace HS\libs\core;


class Controller
{
    protected function View(string $path, bool $die = true){
        /** @noinspection PhpIncludeInspection */
        require $path;
        if ($die) die();

        return null;
    }
}