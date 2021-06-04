<?php

    namespace HS\libs\core;

    use HS\libs\database\DB;

    abstract class Model extends DB
    {
        protected abstract function GetAllowedReadFields() : array;
        protected abstract function GetAllowedWriteFields() : array;

        protected function FilterAllowedFields(array $fields, string $default_field, array $allowed_fields = null): string
        {
            get_class()
            return is_null($fields) ? $default_field : implode(',', array_intersect($fields, $allowed_fields ?? self::GetAllowedReadFields()));
        }
    }