<?php

namespace HS\app\controller\core;


use HS\config\DBAccount;
use HS\libs\core\http\HttpResponse;
use HS\libs\core\Session;
use HS\libs\database\DB;
use HS\libs\database\SDB;
use HS\libs\helper\MimeType;
use HS\libs\security\Crypt;

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

        //Si la sesion ya estaba iniciada.
        if (Session::IsLogin())
            //Devolviendo respuesta.
            die(json_encode(true));

        //Comprobando largo.
        if (strlen($user) > 30 || strlen($user) < 4 || strlen($pass) > 60 || strlen($pass) < 8)
            die(json_encode(false));

        //Obteniendo contraseña almacenada en BD para el usuario especificado.
        try{
            $db = new DB(DBAccount::Root);
            $row = $db->SelectOnly('SELECT id, pass FROM users WHERE user_name = ?', [1 => $user]);
            $user_id = $row['id'] ?? null;
            $hashed_pass = $row['pass'] ?? null;
            unset($row);
        }catch (\PDOException $ex){
            die(json_encode(false));
        }

        //Verificando inicio de sesion.
        if (!empty($hashed_pass) && Crypt::IsEquals($pass, $hashed_pass)){
            //Regenerando contraseña si es necesario (No importa si falla).
            if (is_string($hashed_pass = Crypt::ReHash($pass, $hashed_pass))){
                try{
                    $db->Execute('UPDATE users SET pass = ? WHERE user_name = ?', [1 => $hashed_pass, 2 => $user]);
                }catch (\PDOException $ex){
                }
            }

            //Estableciendo datos de sesion.
            Session::SetLogin($user_id, $user);

            //Devolviendo respuesta.
            die(json_encode(true));
        }

        //Desconectando base de datos.
        unset($db);

        //Devolviendo respuesta.
        die(json_encode(false));
    }

    public function Logout() : void{
        //Eliminando sesion.
        (new Session())->Kill();

        //Redireccionando.
        HttpResponse::Redirect('/Login');
    }

    public function IfNotLoginRedirect() : void{
        if (!Session::IsLogin())
            //Redireccionando.
            HttpResponse::Redirect('/Login');
    }
}