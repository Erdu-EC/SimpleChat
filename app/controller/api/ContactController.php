<?php
namespace HS\app\controller\api;


use HS\app\model\ContactModel;
use HS\app\model\UserModel;
use HS\config\APP_URL;
use HS\config\DBAccount;
use HS\libs\collection\ArrayUtils;
use HS\libs\core\Controller;
use HS\libs\core\http\HttpResponse;
use HS\libs\core\Session;
use HS\libs\helper\MimeType;
use http\Client\Curl\User;

class ContactController extends Controller
{
    public function GetAll(){
        //TODO: Aplicar restriccion con permisos de usuario en la app.
        //Estableciendo tipo de respuesta.
        HttpResponse::SetContentType(MimeType::Json);

        //Obteniendo datos.
        $data = (new ContactModel(DBAccount::Root))->GetAll([
            UserModel::C_NICK,
            UserModel::C_FNAME,
            UserModel::C_LNAME,
			UserModel::C_STATE,
            UserModel::C_LAST_CONN,
            UserModel::C_PROFILE_IMG
        ]);

        //Modificando datos.
        for($i = 0; $i < count($data); $i++)
            $data[$i]->profile_img = APP_URL::OfImageProfile($data[$i]->profile_img);

        //Devolviendo.
        echo json_encode(ArrayUtils::GetIndexedValues($data->GetInnerArray()));
    }

    public function AddContact(){
        //Estableciendo tipo de respuesta.
        HttpResponse::SetContentType(MimeType::Json);

        //Obteniendo parametros post.
        $_POST = ArrayUtils::Trim($_POST, false);
        $contact_id = !empty($_POST['contact']) ? (int)$_POST['contact'] : die(json_encode(null));

        //Realizando acción.
        if ((new ContactModel(DBAccount::Root))->AddContact((new Session())->user_id, $contact_id))
            die(json_encode(true));
        else
            die(json_encode(false));
    }
}