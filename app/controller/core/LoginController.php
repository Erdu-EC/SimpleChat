<?php

namespace HS\app\controller\core;

use HS\config\DBAccount;
use HS\libs\core\http\HttpResponse;
use HS\libs\core\Session;
use HS\libs\database\DB;
use HS\libs\helper\MimeType;
use HS\libs\security\Crypt;
use PDOException;

class LoginController
{
    const USER_NAME_LENGTH = ['min' => 4, 'max' => 30];
    const PASS_LENGTH = ['min' => 8, 'max' => 60];

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
        if (strlen($user) < self::USER_NAME_LENGTH['min'] || strlen($user) > self::USER_NAME_LENGTH['max'] ||
            strlen($pass) < self::PASS_LENGTH['min'] || strlen($pass) > self::PASS_LENGTH['max'])
            die(json_encode(false));

        //Obteniendo contraseña almacenada en BD para el usuario especificado.
        try {
            $db = new DB(DBAccount::Root);
            $row = $db->SelectOnly('SELECT id, pass, first_name, last_name FROM users WHERE user_name = ?', [1 => $user]);
            $user_id = $row['id'] ?? null;
            $user_first = $row['first_name'] ?? null;
            $user_last = $row['last_name'] ?? null;
            $hashed_pass = $row['pass'] ?? null;
            unset($row);
        } catch (PDOException $ex) {
            die(json_encode(false));
        }

        //Verificando inicio de sesion.
        if (!empty($hashed_pass) && Crypt::IsEquals($pass, $hashed_pass)) {
            //Regenerando contraseña si es necesario (No importa si falla).
            if (is_string($hashed_pass = Crypt::ReHash($pass, $hashed_pass))) {
                try {
                    $db->Execute('UPDATE users SET pass = ? WHERE user_name = ?', [1 => $hashed_pass, 2 => $user]);
                } catch (PDOException $ex) {
                }
            }

            //Estableciendo datos de sesion.
            Session::SetLogin(
                $user_id,
                $user,
                preg_split('# +#', $user_first)[0] . " " . preg_split('# +#', $user_last)[0]
            );

            //Devolviendo respuesta.
            die(json_encode(true));
        }

        //Desconectando base de datos.
        unset($db);

        //Devolviendo respuesta.
        die(json_encode(false));
    }

    public function Logout(): void
    {
        //Eliminando sesion.
        (new Session())->Kill();

        //Redireccionando.
        $this->IfNotLoginRedirect();
    }

    public function IfNotLoginRedirect(): void
    {
        if (!Session::IsLogin()) {
            //Redireccionando.
            HttpResponse::Redirect('/Login');
            die;
        }
    }

    public function Register()
    {
        //Obteniendo parametros post.
        array_filter($_POST, function ($val) {
            return trim($val);
        });
        $user = empty($_POST['u']) ? null : (string)$_POST['u'];
        $pass = empty($_POST['p']) ? null : (string)$_POST['p'];
        $first_name = empty($_POST['fn']) ? null : (string)$_POST['fn'];
        $last_name = empty($_POST['ln']) ? null : (string)$_POST['ln'];

        //Estableciendo tipo de respuesta.
        HttpResponse::SetContentType(MimeType::Json);

        //Comprobaciones.
        if (Session::IsLogin())
            die(json_encode([false, 0])); //Sesion iniciada, no realizar registro.
        else if (strlen($user) < self::USER_NAME_LENGTH['min'] || strlen($user) > self::USER_NAME_LENGTH['max'])
            die(json_encode([false, 1])); //Nombre de usuario, no valido.
        else if (strlen($pass) < self::PASS_LENGTH['min'] || strlen($pass) > self::PASS_LENGTH['max'])
            die(json_encode([false, 2])); //Contraseña no valida.

        try {
            //Estableciendo conexión con BD.
            $db = new DB(DBAccount::Root);

            //Verificando que el nombre de usuario no exista.
            $row = $db->SelectOnly('SELECT id FROM users WHERE user_name = ?', [1 => $user]);

            //Realizando registro.
            if (is_null($row)) {
                //Generando clave hash.
                if (($pass = Crypt::Hash($pass)) === false)
                    die(json_encode([false, 3]));

                //Insertando registro.
                $db->Execute('INSERT INTO users(user_name, pass, first_name, last_name) VALUES (:user, :pass, :first, :last)', [
                    'user' => $user,
                    'pass' => $pass,
                    'first' => $first_name,
                    'last' => $last_name
                ]);

                //Desconectando base de datos.
                unset($db);

                //Devolviendo respuesta.
                die(json_encode([true]));
            } else
                die(json_encode([false, 4]));
        } catch (PDOException $ex) {
            die(json_encode([false, 5]));
        }
    }
}