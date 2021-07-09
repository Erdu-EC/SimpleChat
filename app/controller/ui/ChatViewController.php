<?php
    namespace HS\app\controller\ui;

    use HS\app\model\InvitationModel;
    use HS\app\model\MessageModel;
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
                //Obteniendo ID de usuario actual.
                $user_id = (new Session())->user_id;

                //Obteniendo datos de usuario consultado.
                $user = new UserModel(DBAccount::Root);
                $user_data = $user->GetOne($user_name, [
                    UserModel::C_ID,
                    UserModel::C_FNAME,
                    UserModel::C_LNAME,
                    UserModel::C_STATE,
                    UserModel::C_PROFILE_IMG
                ]);

                //Verificando si es un contacto del usuario actual.
                $user_data->is_contact = $user->HasContact($user_id, $user_data->id);

                //Verificando si existe invitación.
                $user_data->has_invitation = (new InvitationModel(DBAccount::Root))->HasInvitation($user_id, $user_data->id);

                //Obteniendo todos los mensajes.
                $user_data->messages = (new MessageModel(DBAccount::Root))->GetMessages($user_id, $user_data->id);

                //Cerrando conexión BD.
                unset($user);
            } catch (PDOException $ex) {
                //TODO: Devolver una vista que muestre un error.
                return;
            }

            //Tratando datos.
            $data = new Collection();
            $data->id = $user_data->id;
            $data->full_name = $user_data->first_name . ' ' . $user_data->last_name;
            $data->state = UserModel::GetStringUserState($user_data->state ?? '');
            $data->is_contact = $user_data->is_contact;
            $data->has_invitation = $user_data->has_invitation;
            $data->messages = $user_data->messages;
            $data->profile_img = $user_data->profile_img;

            //Destruyendo variables.
            unset($user_data);

            //Llamando vista.
            $this->View('partial/chat.php', $data);
        }
    }