<?php


namespace HS\libs\helper;


class Regex
{
    /**
     * Escapa una cadena de forma que pueda ser interpretada literalmente en una expresion regex.<br>
     * @param string $text
     * @param array $excepto [OPCIONAL]<br>
     * Array de caracteres que no deberian ser escapados en la cadena objetivo.
     * @return string
     * Devuelve una cadena con los caracteres utilizados en una regex escapados, excepto por los
     * especificados en <var>$excepto</var>.
     */
    static function Escape(string $text, array $excepto = []): string {
        $chars = ['\\', '^', '$', '.', '[', ']', '|', '(', ')', '?', '*', '+', '{', '}'];
        $chars_replace = [];

        $chars = array_diff($chars, $excepto);
        foreach ($chars as $char) $chars_replace[] = "\\$char";

        return (string)str_replace($chars, $chars_replace, $text);
    }

    /**
     * Recibe una lista de valores y la convierte en una expresion regex que se cumple si hay una
     * coincidencia con algun elemento de la lista.<br><br>
     * Ej: [Opcion1 | Opcion2]<br><br>
     *
     * @return string
     */
    static function InList() {
        $result = "";
        foreach (func_get_args() as $valor) $result .= self::escape($valor) . "|";
        $result = substr($result, 0, strlen($result) - 1);

        return "#^(?:$result)$#";
    }

    /**
     * Devuelve una expresion regex que coincide si una cadena termina con uno de las cadenas pasadas.
     * @return string
     */
    public static function EndWith(): string
    {
            $result = '';
            foreach (func_get_args() as $val) $result .= self::Escape($val) . '|';
            $result = substr($result, 0, strlen($result) - 1);

            return "#(?:$result)$#";
    }
}