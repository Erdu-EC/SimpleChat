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
		public function Send() {
			//Estableciendo tipo de respuesta.
			HttpResponse::SetContentType(MimeType::Json);

			//Obteniendo parametros post.
			$_POST = ArrayUtils::Trim($_POST, false);
			$contact_id = !empty($_POST['contact']) ? (int)$_POST['contact'] : die(json_encode(null));
			$msg = !empty($_POST['text']) ? trim($_POST['text']) : die(json_encode(null));

			//Insertando mensaje en BD.
			$user_id = (new Session())->user_id;
			$idFake = md5(uniqid(dechex($user_id), true));
			if ((new UserModel(DBAccount::Root))->SendMessage($user_id, $contact_id, $idFake, $msg))
				die(json_encode([true, $idFake]));
			else
				die(json_encode([false]));
		}

		public function GetConversations() {
			//Estableciendo tipo de respuesta.
			HttpResponse::SetContentType(MimeType::Json);

			//Obteniendo conversaciónes desde BD.
			$data = (new MessageModel(DBAccount::Root))->GetConversations((new Session())->user_id);

			//Modificando valores.
			for ($i = 0; $i < count($data); $i++)
				$data[$i]->profile = APP_URL::OfImageProfile($data[$i]->profile);

			//Devolviendo datos.
			return json_encode($data->GetInnerArray(true));
		}

		public function GetConversationsWithContact(string $user_name) {
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
                header("Location: /500");
				die(json_encode(false));
			}

			//Tratando datos.
			$data = new Collection();
			$data->id = $user_data->id;
			$data->full_name = $user_data->first_name . ' ' . $user_data->last_name;
			$data->state = UserModel::GetStringUserState($user_data->state ?? '');
			$data->is_contact = $user_data->is_contact;
			$data->has_invitation = $user_data->has_invitation;
			$data->messages = $user_data->messages->GetInnerArray();
			$data->profile_img = APP_URL::OfImageProfile($user_data->profile_img);

			//Tratando mensajes con imagenes.
			for ($i = 0; $i < count($data->messages); $i++) {
				$url_img = $data->messages[$i]->img;
				$url_audio = $data->messages[$i]->audio;
				$data->messages[$i]->img = !empty($url_img) ? APP_URL::OfChatImage($url_img) : null;
				$data->messages[$i]->audio = !empty($url_audio) ? APP_URL::OfChatAudio($url_audio) : null;
			}

			//Destruyendo variables.
			unset($user_data);

			//Devolviendo respuesta.
			die(json_encode($data->GetInnerArray(true)));
		}

		public function MarkState() {
			//Estableciendo tipo de respuesta.
			HttpResponse::SetContentType(MimeType::Json);

			//Obteniendo parametros post.
			$_POST = ArrayUtils::Trim($_POST, false);
			$idMsg = !empty($_POST['id']) ? $_POST['id'] : die(json_encode(false));
			$markRcv = !empty($_POST['rcv']) && $_POST['rcv'];
			$markRead = !empty($_POST['read']) && (bool)$_POST['read'];

			//Obteniendo ID de usuario actual.
			$user_id = (new Session())->user_id;

			//Marcando estados.
			$model = new MessageModel(DBAccount::Root);

			if (!$markRcv && !$markRead)
				die(json_encode(false));
			if ($markRcv && $markRead)
				$result = $model->SetBothStateInMsg($user_id, $idMsg);
			else if ($markRead)
				$result = $model->SetReadStateInMsg($user_id, $idMsg);
			else
				$result = $model->SetReceivedStateInMsg($user_id, $idMsg);

			//Devolviendo respuesta.
			return json_encode($result);
		}
	}