<?php

namespace HS\libs\database;

use PDOException;
use PDOStatement;

class DB
{
    private $PDO;

    public function __construct(array $account)
    {
        $this->PDO = SDB::Connect($account);
    }

    public function Execute(string $sentence, array $param = null): ?PDOStatement
    {
        return SDB::Execute($this->PDO, $sentence, $param);
    }

    public function ExecuteTransaction(callable $actions): bool
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

