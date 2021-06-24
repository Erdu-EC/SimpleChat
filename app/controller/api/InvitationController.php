<?php


    namespace HS\app\controller\api;


    use HS\app\model\InvitationModel;
    use HS\config\DBAccount;
    use HS\libs\collection\ArrayUtils;
    use HS\libs\core\http\HttpResponse;
    use HS\libs\core\Session;
    use HS\libs\helper\MimeType;

    class InvitationController extends \HS\libs\core\Controller
    {
        public function ChangeStateOfLast()
        {
            //Estableciendo tipo de respuesta.
            HttpResponse::SetContentType(MimeType::Json);

            //Obteniendo parametros post.
            $_POST = ArrayUtils::Trim($_POST, false);
            $contact_id = !empty($_POST['contact']) ? (int)$_POST['contact'] : die(json_encode(null));
            $state = !empty($_POST['accept']) ? trim($_POST['accept']) : die(json_encode(null));

            //Aceptando invitacion.
            $result = (new InvitationModel(DBAccount::Root))->ChangeStateOfLastInvitation((new Session())->user_id, $contact_id, $state);

            //Devolviendo resultado.
            die(json_encode($result));
        }
    }