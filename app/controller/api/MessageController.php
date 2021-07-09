<?php

    namespace HS\app\controller\api;

    use HS\app\model\MessageModel;
    use HS\app\model\UserModel;
    use HS\config\APP_URL;
    use HS\config\DBAccount;
    use HS\libs\collection\ArrayUtils;
    use HS\libs\core\Controller;
    use HS\libs\core\http\HttpResponse;
    use HS\libs\core\Session;
    use HS\libs\helper\MimeType;

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

        //TODO: Aplicar seguridad para que no se puedan leer mensajes que no son tuyos.
        public function GetMyMessages()
        {

        }

        public function Receive()
        {

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
    }