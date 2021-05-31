<?php


namespace HS\app\model;


use HS\libs\collection\ArrayUtils;
use HS\libs\core\Session;
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
            return ArrayUtils::GetIndexedValues(self::SelectAll("select $fields from users"));
        }catch (\PDOException $ex){
            return null;
        }
    }

    public function SearchUserOrContact(string $text, array $fields){
        try{
            $fields = is_null($fields) ? '*' : implode(',', array_intersect($fields, self::ALLOW_READ_VALUES));
            return ArrayUtils::GetIndexedValues(self::SelectAll("select $fields, user_is_contact(:uid, id) as isContact from users where id != :uid2 and (MATCH (user_name, first_name, last_name) AGAINST(:text IN BOOLEAN MODE)) order by isContact desc, first_name, last_name", [
                'uid' => (new Session())->user_id,
                'uid2' => (new Session())->user_id,
                'text' => "$text*"
            ]));
        }catch (\PDOException $ex){
            return null;
        }
    }
}