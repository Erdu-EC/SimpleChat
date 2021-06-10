<?php
namespace HS\app\controller\api;


use HS\app\model\ContactModel;
use HS\app\model\UserModel;
use HS\config\DBAccount;
use HS\libs\collection\ArrayUtils;
use HS\libs\core\http\HttpResponse;
use HS\libs\helper\MimeType;

class ContactController
{
    public function GetAll(){
        //TODO: Aplicar restriccion con permisos de usuario en la app.
        //Estableciendo tipo de respuesta.
        HttpResponse::SetContentType(MimeType::Json);

        //Obteniendo datos.
        $data = (new ContactModel(DBAccount::Root))->GetAll([
            UserModel::C_ID,
            UserModel::C_FNAME,
            UserModel::C_LNAME,
            UserModel::C_LAST_CONN
        ]);

        //Devolviendo.
        echo json_encode(ArrayUtils::GetIndexedValues($data));
    }
}