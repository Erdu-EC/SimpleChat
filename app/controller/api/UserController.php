<?php


namespace HS\app\controller\api;


use HS\app\model\UserModel;
use HS\config\DBAccount;
use HS\libs\collection\ArrayUtils;
use HS\libs\core\Controller;
use HS\libs\core\http\HttpResponse;
use HS\libs\helper\MimeType;

class UserController extends Controller
{
    public function GetAll(){
        //TODO: Aplicar restriccion con permisos de usuario en la app.
        //Estableciendo tipo de respuesta.
        HttpResponse::SetContentType(MimeType::Json);

        //Obteniendo datos.
        $data = (new UserModel(DBAccount::Root))->GetAll([
            UserModel::C_ID,
            UserModel::C_NICK
        ]);

        //Devolviendo.
        return json_encode(ArrayUtils::GetIndexedValues($data));;
    }

    public function SearchUserOrContact(){
        //Obteniendo parametros post.
        $_POST = ArrayUtils::Trim($_POST, false);
        $text = !empty($_POST['text']) ? (string)$_POST['text'] : die(json_encode(null));

        //Estableciendo tipo de respuesta.
        HttpResponse::SetContentType(MimeType::Json);

        //Obteniendo datos.
        $data = (new UserModel(DBAccount::Root))->SearchUserOrContact($text, [
            UserModel::C_ID,
            UserModel::C_NICK,
            UserModel::C_FNAME,
            UserModel::C_LNAME
        ]);

        //Devolviendo.
        return json_encode(ArrayUtils::GetIndexedValues($data));
    }
}