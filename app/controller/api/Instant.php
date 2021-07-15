<?php


    namespace HS\app\controller\api;


    use HS\app\model\InvitationModel;
    use HS\app\model\MessageModel;
    use HS\config\DBAccount;
    use HS\libs\core\http\HttpResponse;
    use HS\libs\core\Session;
    use HS\libs\helper\MimeType;
    use const HS\APP_DEBUG;

    class Instant
    {
        public function GetUnreceivedMessagesAndInvitations()
        {
            ob_implicit_flush(false);

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

                unset($invitation_model);
                unset($message_model);

                if (!is_null($msg_data) && $msg_data->count() > 0) {
                    //Estableciendo tipo de respuesta.
                    HttpResponse::SetContentType(MimeType::Json);

                    //Regresando datos.
                    die(json_encode(['messages' => $msg_data->GetInnerArray()]));
                }

                sleep(2);
            }
        }
    }