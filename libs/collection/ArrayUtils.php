<?php


namespace HS\libs\collection;


class ArrayUtils
{
    public static function GetIndexedValues(array $data, bool $recursive){
        $data = array_values($data);

        if ($recursive){
            foreach ($data as &$row){
                $row = array_values($row);
            }
        }

        return $data;
    }
}