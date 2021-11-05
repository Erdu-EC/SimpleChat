<?php

	namespace HS\app\controller\core;

	use HS\app\model\UserModel;
	use HS\config\APP_DIR;
	use HS\config\APP_URL;
	use HS\config\DBAccount;
	use HS\libs\core\http\HttpResponse;
	use HS\libs\core\Session;
	use HS\libs\helper\MimeType;
	use HS\libs\io\Path;
	use const HS\APP_PATH;

	class AudioController
	{
		public function Upload() {
			HttpResponse::SetContentType(MimeType::Json);

			$contact_id = !empty($_POST['contact']) ? $_POST['contact'] : die(json_encode([false, 0]));
			$file = $_FILES['audio'];

			//Error al subir archivo.
			if ($file['error'] !== 0)
				die(json_encode([false, 1]));

			//Comprobando el tipo de archivo.
			else if (MimeType::OfFile($file['tmp_name']) == "audio/webm")
				die(json_encode([false, 2]));

			//Nombre de usuario.
			$session = new Session();
			$user_id = $session->user_id;
			unset($session);

			//Obteniendo nombre de imagen.
			$file_name = dechex($user_id) . md5(uniqid('', true)) . Path::GetExtension($file['name']);
			$fakeId = md5(uniqid(dechex($user_id), true));

			//Insertando en base de datos el mensaje que contendra el fichero.
			if (($user = new UserModel(DBAccount::Root))->SendMessageAudio($user_id, $contact_id, $fakeId, $file_name,
				fn() => move_uploaded_file($file['tmp_name'], Path::CombineAll(APP_PATH, APP_DIR::AUDIO, $file_name)) !== false)) {
				//Desconectando base de datos.
				unset($user);

				//Añadiendo metadatos.
				$output = [];
				$code = null;
				$program = Path::Combine(APP_PATH, '/vendor/ffmpeg/ffmpeg.exe');
				$audio = Path::CombineAll(APP_PATH, APP_DIR::AUDIO, $file_name);
				$audio_output = Path::CombineAll(APP_PATH, APP_DIR::AUDIO, Path::GetFileName($file_name) . "-2.webm");

				//Ejecutando comando.
				exec(escapeshellcmd("$program -i $audio -acodec copy $audio_output"), $output, $code);

				if ($code !== 0)
					die(json_encode([false, 10]));

				//Devolviendo respuesta.
				die(json_encode([true, /*APP_URL::OfChatAudio($file_name)*/ $file_name, $fakeId]));
			} else {
				//Devolviendo respuesta negativa.
				die(json_encode([false, 9]));
			}


		}
	}