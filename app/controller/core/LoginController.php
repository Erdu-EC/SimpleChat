<?php

namespace HS\app\controller\core;


use HS\config\DBAccount;
use HS\libs\core\http\HttpResponse;
use HS\libs\database\DB;
use HS\libs\database\SDB;
use HS\libs\helper\MimeType;

class LoginController
{
    public function Login(): void
    {
        //Obteniendo parametros post.
        array_filter($_POST, function ($val) {
            return trim($val);
        });
        $user = empty($_POST['u']) ? null : (string)$_POST['u'];
        $pass = empty($_POST['p']) ? null : (string)$_POST['p'];

        //Estableciendo tipo de respuesta.
        HttpResponse::SetContentType(MimeType::Json);

        //Comprobando largo.
        if (strlen($user) > 30 || strlen($user) < 4 || strlen($pass) > 60 || strlen($pass) < 8)
            die(json_encode(false));

        //Verificando inicio de sesion.
        $hashed_pass = '';
        try{
            $db = new DB(DBAccount::Root);
            $hashed_pass = $db->SelectOnly('select pass from users where user_name = ?', [1 => $user]);
            unset($db);
        }catch (\PDOException $ex){
            die(json_encode(false));
        }

        //Devolviendo respuesta.
        die(json_encode(false));
    }

    private function IsLogin()
    {

    }
}