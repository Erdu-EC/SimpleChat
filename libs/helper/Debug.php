<?php


namespace HS\libs\helper;


class Debug
{
    static function GetCallingFunctionArgs() : string{
        //Obtiendo datos del metodo que hizo la llamada.
        $methodData = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1];

        //Obteniendo mas datos del metodo de la llamada.
        if (isset($methodData['class']))
            $method = new \ReflectionMethod($methodData['class'], $methodData['function']);
        else
            $method = new \ReflectionFunction($methodData['function']);

        //Recorriendo los nombres de los parametros del metodo o función.
        $print = '';
        foreach ($method->getParameters() as $param){
            $print .= $param->getName() . ':
        ' . print_r($methodData['args'][$param->getPosition()], true) . '
        ';
        }

        return $print;
    }
}