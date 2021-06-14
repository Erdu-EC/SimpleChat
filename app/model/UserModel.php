<?php

    namespace HS\app\model;

    use HS\libs\collection\Collection;
    use HS\libs\core\Model;
    use HS\libs\core\Session;
    use HS\libs\core\TModel;

    class UserModel extends Model
    {
        use TModel;

        const USER_NAME_LENGTH = ['min' => 4, 'max' => 30];
        const PASS_LENGTH = ['min' => 8, 'max' => 60];

        const C_ID = 'id';
        const C_NICK = 'user_name';
        const C_FNAME = 'first_name';
        const C_LNAME = 'last_name';
        const C_LAST_CONN = 'last_connection';
        const C_STATE = 'state';

        const V_STATE_ACTIVE = 'A';
        const V_STATE_BUSY = 'O';
        const V_STATE_INACTIVE = 'I';

        public static function _st_init()
        {
            self::$ALLOW_READ_VALUES = [self::C_ID, self::C_NICK, self::C_FNAME, self::C_LNAME, self::C_LAST_CONN, self::C_STATE];
        }

        //Metodos para obtener datos.
        public function GetOne(string $user_name, array $fields = null): ?Collection
        {
            try {
                $fields = self::FilterAllowedFields($fields, '*');
                return self::SelectOnly("select $fields from users where user_name = :name", [
                    'name' => $user_name
                ]);
            } catch (\PDOException $ex) {
                return null;
            }
        }

        public function GetAll(array $fields = null): ?Collection
        {
            try {
                $fields = self::FilterAllowedFields($fields, '*');
                return self::SelectAll("select $fields from users");
            } catch (\PDOException $ex) {
                return null;
            }
        }

        public function SearchUserOrContact(int $current_user, string $text, array $fields): ?Collection
        {
            try {
                //Filtrando campos validos en la consulta.
                $fields = self::FilterAllowedFields($fields, '*');

                //Ejecutando consulta y devolviendo valores.
                return self::SelectAll("select $fields, user_is_contact(:uid, id) as isContact from users where id != :uid2 and (MATCH (user_name, first_name, last_name) AGAINST(:text IN BOOLEAN MODE)) order by isContact desc, first_name, last_name", [
                    'uid' => $current_user,
                    'uid2' => $current_user,
                    'text' => "$text*"
                ]);
            } catch (\PDOException $ex) {
                return null;
            }
        }

        //Metodos para obtener determinados datos.
        public function HasContact(int $user, int $contact){
            return (new ContactModel($this->PDO))->IsContactOfUser($user, $contact);
        }

        //Metodos estaticos publicos
        public static function GetStringUserState(string $user_state): string{
            switch ($user_state){
                case UserModel::V_STATE_ACTIVE:
                    return 'Activo';
                case UserModel::V_STATE_BUSY:
                    return  'Ocupado';
                case UserModel::V_STATE_INACTIVE:
                    return  'Inactivo';
                default:
                    return  '';
            }
        }

        public static function IsValidUserName(string $user): bool
        {
            return strlen($user) >= self::USER_NAME_LENGTH['min'] && strlen($user) <= self::USER_NAME_LENGTH['max'];
        }

        public static function IsValidPass(string $pass): bool
        {
            return strlen($pass) >= UserModel::PASS_LENGTH['min'] && strlen($pass) <= UserModel::PASS_LENGTH['max'];
        }
    }