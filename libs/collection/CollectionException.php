<?php


namespace HS\libs\collection;


use Throwable;

class CollectionException extends \Exception
{
    const INVALID_COLLECTION = 0;
    const INVALID_ITEM = 1;
    const UNDEFINED_OFFSET = 2;

    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}