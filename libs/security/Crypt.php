<?php


namespace HS\libs\security;


class Crypt
{
    private const cost = 10;

    /**
     * Genera un hash a partir del texto especificado.
     *
     * @param string $text Texto del cual se generara el hash.
     * @return string|false|null
     * Retorna un hash string generado a partir de <var>$text</var> ó FALSE si hubo un error.
     */
    public static function Hash(string $text){
        return password_hash($text, PASSWORD_DEFAULT /*Blowfish*/, ['cost' => self::cost]);
    }

    /**
     * Verifica si es necesario regenerar un hash, y si es asi genera uno nuevo.
     * @param string $text Texto a partir del cual se generara el nuevo hash, si es necesario hacerlo.
     * @param string $source_hash Hash que se verificara.
     * @return |stringfalse|null
     * Devuelve un nuevo hash si se ha determinado que <var>$source_hash</var> ya no es valido, si no, devuelve <var>$source_hash</var>.
     */
    public static function ReHash(string $text, string $source_hash){
        if (password_needs_rehash($source_hash, PASSWORD_DEFAULT, ['cost' => self::cost])) {
            return self::Hash($text);
        } else
            return $source_hash;
    }

    /**
     * Verifica si el hash corresponde con el texto especificado.
     *
     * @param string $text Texto plano
     * @param string $source_hash Hash.
     * @return bool
     * Devuelve <var>true</var> si el <var>$source_hash</var> fue originado a partir de <var>$text</var>, de otra manera <var>false</var>.
     */
    public static function IsEquals(string $text, string $source_hash) : bool{
        return password_verify($text, $source_hash);
    }
}