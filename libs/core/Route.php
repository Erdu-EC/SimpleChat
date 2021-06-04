<?php

namespace HS\libs\core;

use Error;
use HS\config\APP_DIR;
use HS\libs\helper\FQN;
use HS\libs\helper\Regex;
use HS\libs\helper\Text;
use HS\libs\io\Path;
use HS\libs\io\Url;
use http\Exception\InvalidArgumentException;
use const HS\APP_URL;

class Route
{
    public static function All(string $route_url, $url_or_call, array $conditions = [], bool $exitAfterMatch = true)
    {
        self::Run($route_url, $url_or_call, ['GET', 'POST'], $conditions, $exitAfterMatch);
    }

    public static function Get(string $route_url, $url_or_call, array $conditions = [], bool $exitAfterMatch = true){
        self::Run($route_url, $url_or_call, ['GET'], $conditions, $exitAfterMatch);
    }

    public static function Post(string $route_url, $url_or_call, array $conditions = [], bool $exitAfterMatch = true){
        self::Run($route_url, $url_or_call, ['POST'], $conditions, $exitAfterMatch);
    }

    private static function Run(string $route_url, $url_or_call, array $request_methods, array $conditions, bool $exitAfter){
        //Verificando si no es un tipo de petición permitido.
        if (array_search($_SERVER['REQUEST_METHOD'], $request_methods, true) === false)
            return;

        //Arreglando urls.
        $request_url = Url::Fix(urldecode($_SERVER['REQUEST_URI']));
        $route_url = URL::Fix($route_url);

        //Eliminando la parte raiz de la RequestUrl.
        if (Text::StartWith($request_url, APP_URL))
            $request_url = substr($request_url, strlen(APP_URL));

        //Extrayendo nombres de variables de la ruta. Ej: {Var1} ó {Var1*}
        preg_match_all('#\{(\w+|\w+\*)}#', $route_url, $varsName);
        $varsName = $varsName[1]; //0: Nombres con llaves | 1: Nombres sin llaves.

        //Si no habia variable en la ruta, llamar la vista.
        if (empty($varsName) && $request_url == $route_url) self::CallView($url_or_call, [], $exitAfter);

        //Establecer regex generico para obtener luego los valores de las variable.
        $route_url = preg_replace(["#\{\w+}#", '#\{\w+\\\\\+}#', '#\{\w+\\\\\*}#'], ["([^/]+)", "(.+)", "(.*)"], Regex::Escape($route_url, ['{', '}'])); //Palabras o numeros

        //Comprobar si la URL actual tiene la misma estructura que la ruta y obteniendo valores de variables.
        if (preg_match("#^$route_url$#", $request_url, $varsValue)) {
            //Eliminando url completa del match.
            unset($varsValue[0]);

            //Comprobando condiciónes para cada variable de la url, si las hubiera.
            for ($i = 0; $i < count($varsValue); $i++) {
                //Si existe una condición que comprobar...
                if (!empty($conditions[$name = $varsName[$i]])) {
                    if (!is_array($conditions[$name])) $conditions[$name] = [$conditions[$name]];

                    foreach ($conditions[$name] as $cond) {
                        //$cond es una expresion regular.
                        if (is_string($cond)){
                            if (preg_match($cond, $varsValue[$i + 1])) continue;
                            else return;
                        }
                        //$cond es una función.
                        else if (is_callable($cond)) {
                            if ($cond($varsValue[$i + 1])) continue;
                            else return;
                        }
                        //$cond es un array de valores.
                        else if (is_array($cond)){
                            if (array_search($varsValue[$i + 1], $cond, true) !== false)
                                continue;
                            else
                                return;
                        }
                        //$cond es de un tipo no valido.
                        else
                            throw new \InvalidArgumentException("Una de las condiciones para la url es de un tipo no valido.");
                    }

                    //Eliminando condiciones comprobadas
                    unset($conditions[$name]);
                }
            }

            //Una vez que la url haya sido verificada.
            //Crear un arreglo con el nombre y el contenido de las variables de la ruta.
            $VARS = array();
            for ($i = 0; $i < count($varsName); $i++) $VARS[$varsName[$i]] = $varsValue[$i + 1];

            //Agregando valores de las variables sobrantes en $VarsCond.
            if (!empty($conditions)) {
                foreach ($conditions as $key => $value) $VARS[$key] = $value;
            }

            //Llamando a callback, y pasándole un objeto con las variables de la URL.
            self::CallView($url_or_call, $VARS, $exitAfter);
        }
    }

    private static function CallView($callback, array $args, bool $exitAfter)
    {
        if (is_callable($callback))
            call_user_func_array($callback, $args);
        else if (is_string($callback)) {
            if (!preg_match("/^(.+)#(.+)$/", $callback, $parts)) {
                define(__NAMESPACE__ . "\URL_VARS", $args);
                /** @noinspection PhpIncludeInspection */
                require Path::Combine(APP_DIR::VIEW, $callback); //Ruta de un archivo.
            } else {
                try {
                    //Instanciando clase de forma normal.
                    $class = new $parts[1]();
                } catch (Error $ex) {
                    //Si no se encontro la clase, buscarla en los archivos incluidos,
                    //y instanciarla con su nombre completamente cualificado.
                    $class = FQN::Resolve($parts[1]);
                    $class = new $class();

                    //Si no se encontro aun asi, pues... ya valimos.
                }

                //Llamando metodo de la clase encontrada.
                $result = call_user_func_array([$class, $parts[2]], $args);
                if (is_string($result))
                    echo $result;
                //$class->{$parts[2]}($args);
            }
        }else
            throw new InvalidArgumentException("El callback especificado es de un tipo no valido.");

        //Si se requiere terminar la ejecución despues de mostrar la vista o ejecutar la funcion $callback.
        if ($exitAfter) exit(0);
    }
}