<?php
    namespace HS\libs\core;


    trait TModel
    {
        public static $ALLOW_READ_VALUES;

        protected function FilterAllowedFields(array $fields, string $default_field, array $allowed_fields = null): string
        {
            return is_null($fields) ? $default_field : implode(',', array_intersect($fields, $allowed_fields ?? self::$ALLOW_READ_VALUES));
        }
    }