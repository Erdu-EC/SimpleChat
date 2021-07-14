<?php


    namespace HS\app\controller\api;


    use HS\app\model\InvitationModel;
    use HS\app\model\MessageModel;
    use HS\config\DBAccount;
    use HS\libs\core\http\HttpResponse;
    use HS\libs\helper\MimeType;

    class Instant
    {
        public function GetUnreceivedMessagesAndInvitations(){
            while(true){
                $message_model = new MessageModel(DBAccount::Root);
                $invitation_model = new InvitationModel($message_model->GetPDO());



                sleep(2);
            }
            //Estableciendo tipo de respuesta.
            //HttpResponse::SetContentType(MimeType::Json);


        }
    }