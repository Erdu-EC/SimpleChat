<?php


namespace HS\app\model;


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
            return self::SelectAll("select $fields from users");
        }catch (\PDOException $ex){
            return null;
        }
    }

    public function SearchUserOrContact(string $text, array $fields){
        try{
            $fields = is_null($fields) ? '*' : implode(',', array_intersect($fields, self::ALLOW_READ_VALUES));
            return self::SelectAll("select $fields, if(id in (select contact_id from contacts where user_id = :uid), true, false) as isContact from users where id != :uid2 and (user_name like :text or CONCAT(first_name, ' ', last_name) like :text1)", [
                'uid' => (new Session())->user_id,
                'uid2' => (new Session())->user_id,
                'text' => "$text%",
                'text1' => "$text%"
            ]);
        }catch (\PDOException $ex){
            return null;
        }
    }
}