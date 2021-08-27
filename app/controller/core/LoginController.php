<?php

    namespace HS\app\controller\core;

    use HS\app\model\UserModel;
    use HS\config\APP_URL;
    use HS\config\DBAccount;
    use HS\libs\collection\ArrayUtils;
    use HS\libs\core\http\HttpResponse;
    use HS\libs\core\Session;
    use HS\libs\database\DB;
    use HS\libs\helper\MimeType;
    use HS\libs\security\Crypt;
    use PDOException;

    class LoginController
    {
        public function Login(): void
        {
            //Estableciendo tipo de respuesta.
            HttpResponse::SetContentType(MimeType::Json);

            //Obteniendo parametros post.
            $_POST = ArrayUtils::Trim($_POST, false);
            $user = !empty($_POST['u']) ? (string)$_POST['u'] : die(json_encode(false));
            $pass = !empty($_POST['p']) ? (string)$_POST['p'] : die(json_encode(false));

            //Si la sesion ya estaba iniciada.
            if (Session::IsLogin()) die(json_encode(true));

            //Comprobando largo.
            if (!UserModel::IsValidUserName($user) || !UserModel::IsValidPass($pass))
                die(json_encode(false));

            //Obteniendo contraseña almacenada en BD para el usuario especificado.
            try {
                //TODO: Asignar un usuario con permisos restringidos en BD.
                $db = new DB(DBAccount::Root);
                $row = $db->SelectOnly('SELECT id, pass, first_name, last_name, profile_img FROM users WHERE user_name = ?', [1 => $user]);
                $user_id = $row['id'] ?? null;
                $user_first = $row['first_name'] ?? null;
                $user_last = $row['last_name'] ?? null;
                $user_profile_img = $row['profile_img'] ?? null;
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
                        $db->Execute('UPDATE users SET pass = :pass WHERE user_name = :user', [
                            'pass' => $hashed_pass,
                            'user' => $user
                        ]);
                    } catch (PDOException $ex) {
                    }
                }

                //Estableciendo datos de sesion en BD.
                if ($db->ExecuteTransaction(function () use ($db, $user, &$conn_id) {
                        $conn_id = $db->SelectOnly('SELECT user_set_login(:user, :device)', [
                            'user' => $user, 'device' => $_SERVER['HTTP_USER_AGENT']
                        ]);
                    }) === false) die(json_encode(false));

                //Estableciendo datos de sesion.
                Session::SetLogin(
                    $user_id,
                    $conn_id,
                    $user,
                    preg_split('# +#', $user_first)[0] . " " . preg_split('# +#', $user_last)[0],
                    !is_null($user_profile_img) ? APP_URL::OfImageProfile($user_profile_img) : ''
                );

                //Devolviendo respuesta.
                die(json_encode(true));
            }

            //Desconectando base de datos.
            unset($db);

            //Timeout, si la contraseña era incorrecta.
            sleep(2);

            //Devolviendo respuesta.
            die(json_encode(false));
        }

        public function Logout(): void
        {
            //Abriendo sesion.
            $session = new Session();

            //Estableciendo datos de cierre de sesion en BD.
            try {
                //TODO: Establecer cuenta con permisos restringidos en BD.
                $db = new DB(DBAccount::Root);
                $db->ExecuteTransaction(function () use ($db, $session) {
                    $db->Execute('CALL user_set_logout(:user_id, :conn_id)', ['user_id' => $session->user_id, 'conn_id' => $session->user_cid]);
                });
            } catch (PDOException $ex) {
                die(json_encode(false));
            }

            //Eliminando sesion.
            $session->Kill();
            unset($session);

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
// Recepcion de valores faltantes
            $gender = empty($_POST['gen'])?null: (string) $_POST['gen'];
            $birthday = empty($_POST['birth']) ? null : (string) $_POST['birth'];
            //Estableciendo tipo de respuesta.
            HttpResponse::SetContentType(MimeType::Json);

            //Comprobaciones.
            if (Session::IsLogin())
                die(json_encode([false, 0])); //Sesion iniciada, no realizar registro.
            else if (!UserModel::IsValidUserName($user))
                die(json_encode([false, 1])); //Nombre de usuario, no valido.
            else if (!UserModel::IsValidPass($pass))
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
                    $db->Execute('INSERT INTO users(user_name, pass, first_name, last_name,birth_date, gender,create_at) VALUES (:user, :pass, :first, :last, :birth, :gender, NOW())', [
                        'user' => $user,
                        'pass' => $pass,
                        'first' => $first_name,
                        'last' => $last_name,
                        'birth' => $birthday,
                        'gender' => $gender
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
        //Codigo 1 Uno de los parametros recibido no es valido

        public function Setting(){
            array_filter($_POST, function ($val) {
                return trim($val);
            });

            //Estableciendo tipo de respuesta.
            HttpResponse::SetContentType(MimeType::Json);

            $session = new Session();
            $user_id = $session->user_id;
            $first_name = empty($_POST['fn']) ? null : (string)$_POST['fn'];
            $last_name = empty($_POST['ln']) ? null : (string)$_POST['ln'];
            $birthday = empty($_POST['bt']) ? null : (string)$_POST['bt'];
            $gender = empty($_POST['gn']) ? null : (string)$_POST['gn'];
            $phone = empty($_POST['tf']) ? null : (string)$_POST['tf'];
            $email= empty($_POST['em']) ? null : (string)$_POST['em'];

            //validacion de correo electronico
           /* if(!$this->ValidarCorreo($email)){
                die(json_encode([false, 1]));
            }*/
            //file_put_contents('../archivo_25_08_21.txt', $this->ValidarFechaNacimiento($birthday)->format('Y-m-d'));

/* Codigo Correcto*/
            try {
                //Estableciendo conexión con BD.
                $db = new DB(DBAccount::Root);

                //Modificando los valores del registro.
                    $db->Execute('UPDATE users SET first_name= :first, last_name= :last, birth_date= :birth, gender = :gender, phone = :phone, email = :email where id = :user_id', [
                        'first' => $first_name,
                        'last' => $last_name,
                        'birth'=> $birthday,
                        'gender' => $gender,
                        'phone' => $phone,
                        'email' => $email,

                        'user_id' => $user_id
                    ]);

                    //Desconectando base de datos.
                    unset($db);

                    //Devolviendo respuesta.
                    die(json_encode([true],0));
            } catch (PDOException $ex) {
                die(json_encode([false, 5]));
            }


        }


        //Cambio de clave
        //codigo 1 una de las tres claves no es valida
        //codigo 2 las claves recibidas no coinciden
        //codigo 3 las contrasena es incorrecta
        //Codigo 4 La contrasena nueva es igual a la anterior
        //Codigo 5 No se ha podido asegurar la clave
        //Codigo 6 No se ha podido guardar el registro en la BBDD

        public function NewPassword(){
            //Estableciendo tipo de respuesta.
            HttpResponse::SetContentType(MimeType::Json);

            //Obteniendo parametros post.
            $_POST = ArrayUtils::Trim($_POST, false);

            $session = new Session();
            $user_id = $session->user_id;
            $user = $session->user_name;

            $act_pass= empty($_POST['ca']) ? null : (string)$_POST['ca'];
            $new_pass= empty($_POST['cn']) ? null : (string)$_POST['cn'];
            $new_pass_rep= empty($_POST['cnr']) ? null : (string)$_POST['cnr'];

            //una de las tres claves es invalida
            if(!(UserModel::IsValidPass($act_pass) & UserModel::IsValidPass($new_pass) & UserModel::IsValidPass($new_pass_rep))){

                die(json_encode([false, 1]));
               }
            //las claves nuevas y clave nueva_rep no son la misma
            if( strcmp($new_pass, $new_pass_rep)!=0){
                die(json_encode([false, 2]));
            }

            try {
                //Estableciendo conexión con BD.
                $db = new DB(DBAccount::Root);

                //Obteniendo el hash de la contrasena actual del usuario
                $row = $db->SelectOnly('SELECT pass FROM users WHERE id= ? and user_name = ?', [1=> $user_id,2 => $user]);

//En esta parte verifico que la contrasena actual corresponde al hash registrado
                if(!(Crypt::IsEquals($act_pass, $row))){
                    die(json_encode([false, 3]));
                }

                if(strcmp($new_pass, $act_pass)==0){
                    die(json_encode([false, 4]));
                }

                    //Generando clave hash.
                    if (($pass = Crypt::Hash($new_pass)) === false){
                        die(json_encode([false, 5]));
                    }

                    //Actualizando la clave
                    $db->Execute('UPDATE users SET pass= :pass WHERE id= :user_id and user_name= :user_name', [
                        'pass' => $pass,
                        'user_id' => $user_id,
                        'user_name' => $user
                    ]);
                   //Desconectando base de datos.
                    unset($db);

                    //Devolviendo respuesta.
                    die(json_encode([true]));

            } catch (PDOException $ex) {
                die(json_encode([false, 6]));
            }
        }
private function ValidarCorreo($correo_recibido){
      $correo_recibido = filter_var($correo_recibido, FILTER_SANITIZE_EMAIL);

    return (filter_var($correo_recibido, FILTER_VALIDATE_EMAIL));
    }
    public function ValidarFechaNacimiento($fecha){
        $dt = new DateTime($fecha);

     return $dt;
    }
    }