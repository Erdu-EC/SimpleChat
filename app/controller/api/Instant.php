<?php


	namespace HS\app\controller\api;


	use HS\app\model\InvitationModel;
	use HS\app\model\MessageModel;
	use HS\config\APP_URL;
	use HS\config\DBAccount;
	use HS\libs\core\http\HttpResponse;
	use HS\libs\core\Session;
	use HS\libs\helper\MimeType;
	use const HS\APP_DEBUG;

	class Instant
	{
		public function GetUnreceivedMessagesAndInvitations() {
			//Deshabilitando siempre log de errores.
			ini_set('display_errors', 0);

			//Obteniendo id del usuario actual.
			$session = new Session();
			$user_id = $session->user_id;
			unset($session);

			while (true) {
				//Consultando a la base de datos.
				$message_model = new MessageModel(DBAccount::Root);
				$invitation_model = new InvitationModel($message_model->GetPDO());

				$msg_data = $message_model->GetUnreceivedMessages($user_id);
				$inv_data = $invitation_model->GetUnreceive($user_id);
				$state_data = $message_model->GetUnreceivedStatesChanged($user_id);

				unset($invitation_model);
				unset($message_model);

				if ((!empty($msg_data) && $msg_data->count() > 0) || (!empty($inv_data) && $inv_data->count() > 0) ||
					(!empty($state_data) && $state_data->count() > 0)) {
					//Habilitando buffer de salida.
					ob_start();

					//Desactivando cache del navegador.
					HttpResponse::Set('Cache-Control: no-store');

					//Estableciendo tipo de respuesta.
					HttpResponse::SetContentType(MimeType::Json);

					//Modificando datos.
					for ($i = 0; $i < count($msg_data); $i++) {
						$msg_data[$i]->profile = APP_URL::OfImageProfile($msg_data[$i]->profile);
						$msg_data[$i]->content_img = !empty($msg_data[$i]->content_img) ? APP_URL::OfChatImage($msg_data[$i]->content_img) : null;
					}

					//Modificando valores.
					for ($i = 0; $i < count($inv_data); $i++)
						$inv_data[$i]->profile = APP_URL::OfImageProfile($inv_data[$i]->profile);

					//Regresando datos.
					echo json_encode([
						'messages' => !empty($msg_data) ? $msg_data->GetInnerArray(true) : [],
						'invitations' => !empty($inv_data) ? $inv_data->GetInnerArray(true) : [],
						'msg_states' => !empty($state_data) ? $state_data->GetInnerArray(true) : []
					]);

					//Enviando buffer de salida.
					ob_flush();
					break;
				}

				sleep(2);
			}
		}
	}