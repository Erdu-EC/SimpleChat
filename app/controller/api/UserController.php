<?php


namespace HS\app\controller\api;


use HS\app\model\UserModel;
use HS\config\APP_URL;
use HS\config\DBAccount;
use HS\libs\collection\ArrayUtils;
use HS\libs\core\Controller;
use HS\libs\core\http\HttpResponse;
use HS\libs\core\Session;
use HS\libs\database\DB;
use HS\libs\helper\MimeType;

class UserController extends Controller
{
	public function GetOneById(){
		//TODO: Aplicar restriccion con permisos de usuario en la app.
		//Estableciendo tipo de respuesta.
		HttpResponse::SetContentType(MimeType::Json);

		//Obteniendo parametros post.
		$_POST = ArrayUtils::Trim($_POST, false);
		$contact = !empty($_POST['c']) ? (string)$_POST['c'] : die(json_encode(null));

		//Obteniendo datos.
		$data = (new UserModel(DBAccount::Root))->GetOneById($contact, [
			UserModel::C_FNAME,
			UserModel::C_LNAME,
			UserModel::C_NICK,
			UserModel::C_STATE,
			UserModel::C_LAST_CONN,
			UserModel::C_EMAIL,
			UserModel::C_BIRTH,
			UserModel::C_GENDER,
			UserModel::C_PHONE
		]);

		//Devolviendo.
		return json_encode(ArrayUtils::GetIndexedValues($data->GetInnerArray(), false));
	}

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
        return json_encode(ArrayUtils::GetIndexedValues($data->GetInnerArray()));
    }

    public function SearchUserOrContact(){
        //Obteniendo parametros post.
        $_POST = ArrayUtils::Trim($_POST, false);
        $text = !empty($_POST['text']) ? (string)$_POST['text'] : die(json_encode(null));

        //Estableciendo tipo de respuesta.
        HttpResponse::SetContentType(MimeType::Json);

        //Obteniendo id del usuario actual.
        $user_id = (new Session())->user_id;

        //Obteniendo datos.
        $data = (new UserModel(DBAccount::Root))->SearchUserOrContact($user_id, $text, [
            UserModel::C_NICK,
            UserModel::C_FNAME,
            UserModel::C_LNAME,
            UserModel::C_PROFILE_IMG,
			UserModel::C_STATE
        ]);

        //Modificando datos.
        for($i = 0; $i < count($data); $i++)
            $data[$i]->profile_img = APP_URL::OfImageProfile($data[$i]->profile_img);

        //Devolviendo.
        return json_encode(ArrayUtils::GetIndexedValues($data->GetInnerArray()));
    }
}