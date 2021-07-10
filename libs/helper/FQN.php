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
                    $namespace = str_replace('/', '\\', $file);
                    $namespace = substr_replace($namespace, APP_NAMESPACE, 0, strlen(APP_PATH));

                    return substr($namespace, 0, strlen($namespace) - 4);
                }
            }

            return $class;
        }
    }
}