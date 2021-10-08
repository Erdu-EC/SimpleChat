<?php

    namespace HS\app\controller\api;

    use HS\app\model\InvitationModel;
	use HS\app\model\MessageModel;
    use HS\app\model\UserModel;
    use HS\config\APP_URL;
    use HS\config\DBAccount;
    use HS\libs\collection\ArrayUtils;
	use HS\libs\collection\Collection;
	use HS\libs\core\Controller;
    use HS\libs\core\http\HttpResponse;
    use HS\libs\core\Session;
    use HS\libs\helper\MimeType;
	use PDOException;

	class MessageController extends Controller
    {
        public function Send()
        {
            //Estableciendo tipo de respuesta.
            HttpResponse::SetContentType(MimeType::Json);

            //Obteniendo parametros post.
            $_POST = ArrayUtils::Trim($_POST, false);
            $contact_id = !empty($_POST['contact']) ? (int)$_POST['contact'] : die(json_encode(null));
            $msg = !empty($_POST['text']) ? trim($_POST['text']) : die(json_encode(null));

            //Insertando mensaje en BD.
            if ((new UserModel(DBAccount::Root))->SendMessage((new Session())->user_id, $contact_id, $msg))
                die(json_encode(true));
            else
                die(json_encode(false));
        }

        public function GetConversations()
        {
            //Estableciendo tipo de respuesta.
            HttpResponse::SetContentType(MimeType::Json);

            //Obteniendo conversaciónes desde BD.
            $data = (new MessageModel(DBAccount::Root))->GetConversations((new Session())->user_id);

            //Modificando valores.
            for($i = 0; $i < count($data); $i++)
                $data[$i]->profile_img = APP_URL::OfImageProfile($data[$i]->profile_img);

            //Devolviendo datos.
            return json_encode(ArrayUtils::GetIndexedValues($data->GetInnerArray()));
        }

		public function GetConversationsWithContact(string $user_name){
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
				$user_data->messages = (new MessageModel(DBAccount::Root))->GetMessagesWithContact($user_id, $user_data->id);

				//Cerrando conexión BD.
				unset($user);
			} catch (PDOException $ex) {
				//TODO: Devolver una vista que muestre un error.
				die(json_encode(false));
			}

			//Tratando datos.
			$data = new Collection();
			$data->id = $user_data->id;
			$data->full_name = $user_data->first_name . ' ' . $user_data->last_name;
			$data->state = UserModel::GetStringUserState($user_data->state ?? '');
			$data->is_contact = $user_data->is_contact;
			$data->has_invitation = $user_data->has_invitation;
			$data->messages = ArrayUtils::GetIndexedValues($user_data->messages->GetInnerArray());
			$data->profile_img = APP_URL::OfImageProfile($user_data->profile_img);

			//Tratando mensajes con imagenes.
			for($i = 0; $i < count($data->messages); $i++){
				$url_img = $data->messages[$i][7];
				$data->messages[$i][7] = !empty($url_img) ? APP_URL::OfChatImage($data->messages[$i][7]) : null;
			}

			//Destruyendo variables.
			unset($user_data);

			//Devolviendo respuesta.
			die(json_encode($data->GetInnerArray(true)));
		}

		public function MarkAsRead(int $idMsg){
			//Estableciendo tipo de respuesta.
			HttpResponse::SetContentType(MimeType::Json);

			//Obteniendo parametros post.
			$_POST = ArrayUtils::Trim($_POST, false);
			$idMsg = !empty($_POST['id']) ? (int)$_POST['id'] : die(json_encode(false));

			//Obteniendo ID de usuario actual.
			$user_id = (new Session())->user_id;

			//Devolviendo respuesta.
			return json_encode((new MessageModel(DBAccount::Root))->SetReadStateInMsg($user_id, $idMsg));
		}
    }