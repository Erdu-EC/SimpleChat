<?php


    namespace HS\app\model;


    use HS\libs\collection\ArrayUtils;
    use HS\libs\core\Model;
    use HS\libs\core\Session;

    class UserModel extends Model
    {
        const USER_NAME_LENGTH = ['min' => 4, 'max' => 30];
        const PASS_LENGTH = ['min' => 8, 'max' => 60];

        const C_ID = 'id';
        const C_NICK = 'user_name';
        const C_FNAME = 'first_name';
        const C_LNAME = 'last_name';
        const C_LAST_CONN = 'last_connection';

        //Especificando que campos son de lectura y escritura.
        protected function GetAllowedReadFields(): array
        {
            return [self::C_ID, self::C_NICK, self::C_FNAME, self::C_LNAME, self::C_LAST_CONN];
        }

        protected function GetAllowedWriteFields(): array
        {
            // TODO: Implement GetAllowedWriteFields() method.
            throw new \BadFunctionCallException();
        }

        //Metodos para obtener datos.
        public function GetOne(string $user_name, array $fields = null): ?array
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

        public function GetAll(array $fields = null): ?array
        {
            try {
                $fields = self::FilterAllowedFields($fields, '*');
                return self::SelectAll("select $fields from users");
            } catch (\PDOException $ex) {
                return null;
            }
        }

        public function SearchUserOrContact(string $text, array $fields)
        {
            try {
                //Obteniendo id del usuario actual.
                $user_id = (new Session())->user_id;

                //Filtrando campos validos en la consulta.
                $fields = self::FilterAllowedFields($fields, '*');

                //Ejecutando consulta y devolviendo valores.
                return self::SelectAll("select $fields, user_is_contact(:uid, id) as isContact from users where id != :uid2 and (MATCH (user_name, first_name, last_name) AGAINST(:text IN BOOLEAN MODE)) order by isContact desc, first_name, last_name", [
                    'uid' => $user_id,
                    'uid2' => $user_id,
                    'text' => "$text*"
                ]);
            } catch (\PDOException $ex) {
                return null;
            }
        }

        //Metodos estaticos publicos
        public static function IsValidUserName(string $user): bool
        {
            return strlen($user) >= self::USER_NAME_LENGTH['min'] && strlen($user) <= self::USER_NAME_LENGTH['max'];
        }

        public static function IsValidPass(string $pass)
        {
            return strlen($pass) >= UserModel::PASS_LENGTH['min'] && strlen($pass) <= UserModel::PASS_LENGTH['max'];
        }
    }