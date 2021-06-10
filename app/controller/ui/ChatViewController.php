<?php
    namespace HS\app\controller\ui;

    use HS\app\model\UserModel;
    use HS\config\DBAccount;
    use HS\libs\collection\Collection;
    use HS\libs\core\Controller;
    use PDOException;

    class ChatViewController extends Controller
    {
        public function Index(string $user_name)
        {
            try {
                $user = new UserModel(DBAccount::Root);
                $user_data = $user->GetOne($user_name, [
                    UserModel::C_ID,
                    UserModel::C_NICK,
                    UserModel::C_FNAME,
                    UserModel::C_LNAME,
                    UserModel::C_STATE
                ]);
                unset($user);
            } catch (PDOException $ex) {
                //TODO: Devolver una vista que muestre un error.
                return;
            }

            //Tratando datos.
            $data = new Collection();
            $user = new Collection($user_data);

            //Determinando nombre completo.
            $data->full_name = $user_data->first_name . $user_data->last_name;

            //Determinando estado del contacto.
            switch ($user_data->state){
                case UserModel::V_STATE_ACTIVE:
                    $data->state = 'Activo';
                    break;
                case UserModel::V_STATE_BUSY:
                    $data->state = 'Ocupado';
                    break;
                case UserModel::V_STATE_INACTIVE:
                    $data->state = 'Inactivo';
                    break;
                default:
                    $data->state = 'Desconocido';
            }

            //Destruyendo variables.
            unset($user_data);

            //Llamando vista.
            $this->View('partial\chat.php', $data);
        }
    }