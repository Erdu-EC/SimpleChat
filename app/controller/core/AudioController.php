<?php

namespace HS\app\controller\core;

use Exception;
use HS\app\model\UserModel;
use HS\config\APP_DIR;
use HS\config\APP_URL;
use HS\config\DBAccount;
use HS\libs\core\http\HttpResponse;
use HS\libs\core\Session;
use HS\libs\helper\IOUtil;
use HS\libs\helper\MimeType;
use HS\libs\helper\System;
use HS\libs\io\Path;
use const HS\APP_PATH;

class AudioController
{
    public function Upload()
    {
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
            function () use ($file_name, $file) {
				try{
					//Obteniendo ruta de directorio de audio.
					$path = Path::Combine(APP_PATH, APP_DIR::AUDIO);

					//Creando directorio si no existe.
					IOUtil::CreateDir($path, true);
				}catch (Exception $ex){
					//Error al crear el directorio para almacenar audios.
					die(json_encode([false, 3]));
				}

                //Ejecutando comando.
                $audio = $file['tmp_name'];
                $audio_output = Path::CombineAll($path, $file_name);
                if (System::GetOS() == System::OS_WIN)
                    $program = Path::Combine(APP_PATH, '/vendor/ffmpeg/ffmpeg.exe');
                else
                    $program = 'ffmpeg';
                exec(escapeshellcmd("$program -i $audio -acodec copy $audio_output"), $output, $code);

                //Devolviendo resultado.
                return $code === 0;
            })) {
            //Desconectando base de datos.
            unset($user);

            //Devolviendo respuesta.
            die(json_encode([true, $file_name, $fakeId]));
        } else {
            //Devolviendo respuesta negativa.
            die(json_encode([false, 4]));
        }


    }
}