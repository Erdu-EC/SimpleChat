<?php

    use HS\app\model\UserModel;
    use HS\config\DBAccount;
    use HS\libs\collection\Collection;
    use HS\libs\collection\CollectionException;
    use HS\libs\core\Controller;
    use HS\libs\database\DB;

    class ChatViewController extends Controller
    {
        public function Index(string $user_name)
        {
            try {
                $user = new UserModel(DBAccount::Root);
                $user_data = $user->GetOne($user_name, [
                    UserModel::C_ID, UserModel::C_NICK,
                    UserModel::C_FNAME, UserModel::C_LNAME
                ]);
                unset($user);
            } catch (PDOException $ex) {
                //TODO: Devolver una vista que muestre un error.
            }

            $this->View('partial\chat.php', new Collection($user_data));
        }
    }