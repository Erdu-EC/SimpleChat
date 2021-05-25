<?php


namespace HS\app\model;


use HS\libs\database\DB;

class UserModel extends DB
{
    const C_ID = 'id';
    const C_NICK = 'user_name';
    const C_FNAME = 'first_name';
    const C_LNAME = 'last_name';
    const C_LAST_CONN = 'last_connection';

    public const ALLOW_READ_VALUES = [self::C_ID, self::C_NICK, self::C_FNAME, self::C_LNAME, self::C_LAST_CONN];

    public function __construct(array $account) {
        parent::__construct($account);
    }

    public function GetAll(array $fields = null){
        try{
            $fields = is_null($fields) ? '*' : implode(',', array_intersect($fields, self::ALLOW_READ_VALUES));
            return self::SelectAll("select $fields from users");
        }catch (\PDOException $ex){
            return null;
        }
    }
}