<?php


namespace HS\app\controller\api;


use HS\app\model\UserModel;
use HS\config\DBAccount;
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
            UserModel::C_NICK
        ]);

        //Devolviendo.
        echo json_encode($data);
    }
}