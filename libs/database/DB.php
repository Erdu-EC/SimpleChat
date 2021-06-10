<?php

namespace HS\libs\database;

use HS\libs\collection\Collection;
use PDO;
use PDOException;
use PDOStatement;

class DB
{
    protected $PDO;

    public function __construct($account)
    {
        if (is_array($account))
            $this->PDO = SDB::Connect($account);
        elseif (is_a($account, PDO::class))
            $this->PDO = $account;
        else
            throw new \InvalidArgumentException("Parametro no valido para establecer una conexión.");
    }

    public function Execute(string $sentence, array $param = null): ?PDOStatement
    {
        return SDB::Execute($this->PDO, $sentence, $param);
    }

    /**
     * @param callable|array $actions
     * @return bool
     */
    public function ExecuteTransaction($actions): bool
    {
        return SDB::ExecuteTransaction($this->PDO, $actions);
    }

    public function SelectAll(string $sentence, array $param = NULL) : ?Collection
    {
        $items = SDB::SelectAll($this->PDO, $sentence, $param);
        return is_null($items) ? null : new Collection($items);
    }

    public function SelectOnly(string $sentence, array $param = NULL){
        $items = SDB::SelectOnly($this->PDO, $sentence, $param);
        return is_null($items) ? null : (is_array($items) ? new Collection($items) : $items);
    }

    public function __destruct()
    {
        unset($this->PDO);
    }
}

