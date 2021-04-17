<?php


namespace HS\libs\helper;


use const HS\APP_NAMESPACE;
use const HS\APP_PATH;

class FQN
{
    public static function Resolve(string $class): string
    {
        if (strpos($class, '\\') === 0)
            return $class;
        else {
            foreach (get_required_files() as $file) {
                if (pathinfo($file)['filename'] == $class) {
                    $namespace = substr_replace($file, APP_NAMESPACE, 0, strlen(APP_PATH));
                    $namespace = substr($namespace, 0, strlen($namespace) - 4);
                    return $namespace;
                }
            }

            return $class;
        }
    }
}