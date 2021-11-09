<?php

	namespace HS\app\controller\api;

	use DateInterval;
	use DateTime;
	use HS\app\model\ContactModel;
	use HS\app\model\InvitationModel;
	use HS\app\model\MessageModel;
	use HS\config\APP_URL;
	use HS\config\DBAccount;
	use HS\libs\core\http\HttpResponse;
	use HS\libs\core\Logger;
	use HS\libs\core\Session;
	use HS\libs\helper\MimeType;

	class Instant
	{
		public function GetUnreceivedMessagesAndInvitations() {
			//Deshabilitando siempre log de errores.
			ini_set('display_errors', 0);

			//Desactivando cache del navegador.
			HttpResponse::Set('Cache-Control: no-store');

			//Estableciendo tipo de respuesta.
			HttpResponse::SetContentType(MimeType::Json);

			//Obteniendo id del usuario actual.
			$session = new Session();
			$user_id = $session->user_id;

			if (empty($session->last_contact_active_data))
				$session->last_contact_active_data = (new DateTime())->format('Y-m-d H:i:s');

			$last_send_ca = new DateTime($session->last_contact_active_data);
			$last_send_ca->Add(new DateInterval('PT2M'));

			unset($session);

			while (true) {
				//Consultando a la base de datos.
				$message_model = new MessageModel(DBAccount::Root);
				$invitation_model = new InvitationModel($message_model->GetPDO());

				$msg_data = $message_model->GetUnreceivedMessages($user_id);
				$inv_data = $invitation_model->GetUnreceive($user_id);
				$state_data = $message_model->GetUnreceivedStatesChanged($user_id);

				//Revisando si es necesario enviar información sobre los contactos activos.
				if ($last_send_ca < new DateTime()) {
					$contacts_model = new ContactModel($message_model->GetPDO());
					$contact_data = $contacts_model->GetActiveContacts($user_id);

					//Logger::Log('instant', 'data++', ($last_send_ca)->format('Y-m-d H:i:s') . " < " . (new DateTime())->format('Y-m-d H:i:s'));

					if (!empty($contact_data) && $contact_data->count() > 0) {
						$session = new Session();
						$session->last_contact_active_data = (new DateTime())->format('Y-m-d H:i:s');
						unset($session);
					}
				}

				unset($invitation_model);
				unset($message_model);

				if ((!empty($msg_data) & $msg_data->count() > 0) || (!empty($inv_data) && $inv_data->count() > 0) ||
					(!empty($state_data) && $state_data->count() > 0) || (!empty($contact_data) && $contact_data->count() > 0)) {
					//Desactivando limpiado del buffer implicito.
					ob_implicit_flush(false);

					//Habilitando buffer de salida.
					ob_start();

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
						'msg_states' => !empty($state_data) ? $state_data->GetInnerArray(true) : [],
						'contact_active' => !empty($contact_data) ? $contact_data->GetInnerArray(true) : []
					]);

					//Enviando buffer de salida.
					ob_flush();
					flush();

					break;
				}

				sleep(2);
			}
		}
	}