<?php
    namespace HS\app\controller\ui;

    use HS\app\model\UserModel;
    use HS\config\DBAccount;
    use HS\libs\collection\Collection;
    use HS\libs\core\Controller;
    use HS\libs\core\Session;
    use PDOException;

    class ChatViewController extends Controller
    {
        public function Index(string $user_name)
        {
            try {
                //Obteniendo datos de usuario consultado.
                $user = new UserModel(DBAccount::Root);
                $user_data = $user->GetOne($user_name, [
                    UserModel::C_ID,
                    UserModel::C_NICK,
                    UserModel::C_FNAME,
                    UserModel::C_LNAME,
                    UserModel::C_STATE
                ]);

                //Verificando si es un contacto del usuario actual.
                $user_data->is_contact = $user->HasContact((new Session())->user_id, $user_data->id);

                //Cerrando conexión BD.
                unset($user);
            } catch (PDOException $ex) {
                //TODO: Devolver una vista que muestre un error.
                return;
            }

            //Tratando datos.
            $data = new Collection();
            $data->id = $user_data->id;
            $data->full_name = $user_data->first_name . $user_data->last_name;
            $data->state = UserModel::GetStringUserState($user_data->state ?? '');
            $data->is_contact = $user_data->is_contact;

            //Destruyendo variables.
            unset($user_data);

            //Llamando vista.
            $this->View('partial\chat.php', $data);
        }
    }