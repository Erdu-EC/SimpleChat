<?php


namespace HS\app\model;


use HS\libs\collection\ArrayUtils;
use HS\libs\core\Model;
use HS\libs\core\Session;
use HS\libs\database\DB;

class ContactModel extends Model
{
    const C_UID = 'user_id';
    const C_CID = 'contact_id';
    const C_IID = 'invitation_id';

    public function __construct(array $account) {
        parent::__construct($account);

        ContactModel::$ALLOW_READ_VALUES = [self::C_UID, self::C_CID, self::C_IID];
    }

    public function GetAll($user_contact_fields = null){
        try{
            $allow_values = array_merge(UserModel::$ALLOW_READ_VALUES, ContactModel::$ALLOW_READ_VALUES);
            $user_contact_fields = is_null($user_contact_fields) ? '*' : implode(',', array_intersect($user_contact_fields, $allow_values));
            return ArrayUtils::GetIndexedValues(self::SelectAll("select $user_contact_fields from contacts c inner join users u on c.contact_id = u.id where c.user_id = ?", [
                1 => (new Session())->user_id
            ]));
        }catch (\PDOException $ex){
            return null;
        }
    }
}