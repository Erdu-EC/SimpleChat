<?php


namespace HS\app\controller\core;


use HS\libs\core\http\HttpResponse;
use HS\libs\helper\MimeType;

class LoginController
{
    public function Login() : void{
        //Obteniendo parametros post.
        $user = empty($_POST['u']) ? null : $_POST['u'];
        $pass = empty($_POST['p']) ? null : $_POST['p'];

        //Verificando inicio de sesion.

        //Devolviendo respuesta.
        HttpResponse::SetContentType(MimeType::Json);
        die(json_encode(false));
    }

    private function IsLogin(){

    }
}