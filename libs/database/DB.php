<?php

namespace HS\libs\database;

use PDO;
use PDOException;
use PDOStatement;

class DB
{
    private $PDO;

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

    public function SelectAll(string $sentence, array $param = NULL) : ?array
    {
       return SDB::SelectAll($this->PDO, $sentence, $param);
    }

    public function SelectOnly(string $sentence, array $param = NULL){
        return SDB::SelectOnly($this->PDO, $sentence, $param);
    }

    public function __destruct()
    {
        unset($this->PDO);
    }
}

