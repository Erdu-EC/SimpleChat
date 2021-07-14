<?php

namespace HS\libs\database;

use InvalidArgumentException;
use PDO;
use PDOException;
use PDOStatement;
use const HS\config\APP_DB_HOST;
use const HS\config\APP_DB_NAME;

class SDB
{
    public static function Connect(array $account): PDO
    {
        if (empty($account['user']) || is_null($account['pass'])/*|| empty($account['pass'])*/)
            throw new InvalidArgumentException("Nombre de usuario ó contraseña invalidos.");

        //Cadena de conexion.
        $dsn = sprintf("mysql: host=%s;dbname=%s;charset=utf8", APP_DB_HOST, APP_DB_NAME);

        //Devolviendo objeto de la conexión.
        return new PDO($dsn, $account['user'], $account['pass'], [
            PDO::ATTR_EMULATE_PREPARES => false, //Desactivar virtualizacion de consultas preparadas.
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //Activar las excepciones.
        ]);
    }

    public static function Execute(PDO $PDO, string $sentence, array $param = null): ?PDOStatement
    {
        //Preparando consulta.
        $sentence = $PDO->prepare($sentence);

        //Vinculando parametros de la consulta
        if (!is_null($param)) {
            foreach ($param as $key => $value)
                $sentence->bindValue($key, $value, self::GetPDOType($value));
        }

        //Ejecutando y devolviendo resultados.
        if ($sentence->execute())
            return $sentence; //Devuelve PDOStatement.
        else
            return null;

        /*if (stripos($sentence->queryString, "SELECT") === 0)

        else
            return $sentence->rowCount(); //Devuelve filas afectadas.*/
    }

    public static function ExecuteTransaction(PDO $PDO, callable $actions): bool
    {
        $PDO->beginTransaction();

        try {
            if (is_callable($actions))
                $actions();
            else
                throw new \InvalidArgumentException();

            $PDO->commit();
            return true;
        } catch (PDOException $ex) {
            $PDO->rollBack();
            return false;
        }
    }

    public static function SelectAll(PDO $PDO, string $sentence, array $param = null) : ?array
    {
        //Preparando y ejecutando consulta
        $sentence = self::Execute($PDO, $sentence, $param);

        //Obteniendo y devolviendo resultados
        if (is_object($sentence)) {
            if (($result = $sentence->fetchAll(PDO::FETCH_ASSOC)) !== false)
                return $result;
            else
                return [];
        } else
            return null;
    }

    public static function SelectOnly(PDO $PDO, string $sentence, array $param = null){
        $result = self::SelectAll($PDO, $sentence, $param);

        if (count($result) === 1)
            if (count($result[0]) === 1)
                return array_values($result[0])[0];
            else
                return $result[0];
        else
            return null;
    }

    private static function GetPDOType($var): int
    {
        if (is_bool($var)) return PDO::PARAM_BOOL;
        else if (is_null($var)) return PDO::PARAM_NULL;
        else if (is_int($var)) return PDO::PARAM_INT;
        else /*if (is_string($var))*/ return PDO::PARAM_STR;
    }
}