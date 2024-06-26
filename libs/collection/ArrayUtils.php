<?php


namespace HS\libs\collection;


class ArrayUtils
{
    public static function Trim(array $data, bool $recursive){
        $data = array_filter($data, function ($val) {
            return trim($val);
        });

        if ($recursive){
            foreach ($data as &$row)
                $row = self::Trim($row, true);
        }

        return $data;
    }

    public static function GetIndexedValues(array $data, bool $recursive = true){
        $data = array_values($data);

        if ($recursive){
            foreach ($data as &$row){
            	if (Collection::IsCollection($row) || is_array($row))
                	$row = array_values(Collection::IsCollection($row) ? $row->GetInnerArray() : $row);
            }
        }

        return $data;
    }
}