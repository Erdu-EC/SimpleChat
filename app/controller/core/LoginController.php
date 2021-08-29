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
//Env[io de true El registro del nuevo usuario fue correcto
    //envio de false y codigo
        //Codigo 0: Hay una sesión iniciada
        //Codigo 1: Uno de los parámetros recibido esta vacío
        //Codigo 2: El nombre que se ha recibido no es válido
        //Codigo 3: El apellido que se ha recibido no es válido
        //Codigo 4: La opción de género recibida no es válida
        //Codigo 5: La fecha de nacimiento recibida no es válida
        //Codigo 6: El número de teléfono recibido no es válido
        //Codigo 7: El correo electronico recibido no es válido
        //Codigo 8: El usuario no es válido
        //Codigo 9: La contraseña no es válido
        //Codigo 10: El nombre de usuario ya está siendo utilizado
        //Codigo 11, ...: No se ha podido efectuar el registro

        public function Register()
        {
            //Estableciendo tipo de respuesta.
            HttpResponse::SetContentType(MimeType::Json);

            //Obteniendo parámetros post.
            array_filter($_POST, function ($val) {
                return trim($val);
            });

            $first_name = empty($_POST['fn']) ? null : (string)$_POST['fn'];
            $last_name = empty($_POST['ln']) ? null : (string)$_POST['ln'];

            $gender = empty($_POST['gen'])?null: (string) $_POST['gen'];

            $birthday = empty($_POST['birth']) ? null : (string) $_POST['birth'];

            $phone = empty($_POST['phone'])?null: (string) $_POST['phone'];

            $email = empty($_POST['email'])?null: (string) $_POST['email'];

            $user = empty($_POST['u']) ? null : (string)$_POST['u'];

            $pass = empty($_POST['p']) ? null : (string)$_POST['p'];

            $pass_rep = empty($_POST['p_rep']) ? null : (string)$_POST['p_rep'];

            //Comprobaciones.
            if (Session::IsLogin()){
                file_put_contents('../archivo_25_08_21.txt', "\nYa se ha registrado un usuario", FILE_APPEND);
                die(json_encode([false, 0]));
            }
            else if(!$this->Iniciar()){
                file_put_contents('../archivo_25_08_21.txt', "\nUn campos vacio", FILE_APPEND);
                die(json_encode([false, 1]));
            }
            else if(!$this->ValidarNombreApellido($first_name)){
                file_put_contents('../archivo_25_08_21.txt', "\nNOmbre Invalido", FILE_APPEND);
                die(json_encode([false, 2]));
            }
            else if(!$this->ValidarNombreApellido($last_name)){
                file_put_contents('../archivo_25_08_21.txt', "\nApellido Invalido", FILE_APPEND);
                die(json_encode([false, 3]));
            }
            else if(!$this->ValidarGenero($gender)){
                file_put_contents('../archivo_25_08_21.txt', "\nGenero no valido", FILE_APPEND);
                die(json_encode([false, 4]));
            }
            else if(!$this->ValidarFechanacimiento($birthday)){
                file_put_contents('../archivo_25_08_21.txt', "\nFecha no valida", FILE_APPEND);
                die(json_encode([false, 5]));
            }
            else if(!$this->ValidarTelefono($phone)){
                file_put_contents('../archivo_25_08_21.txt', "\nTelefono no valido", FILE_APPEND);
                die(json_encode([false, 6]));
            }
            else if(!$this->ValidarCorreo($email)){
                file_put_contents('../archivo_25_08_21.txt', "\nCorreo no valido", FILE_APPEND);
                die(json_encode([false, 7]));
            }
            else if (!UserModel::IsValidUserName($user)){
                file_put_contents('../archivo_25_08_21.txt', "\nNombre de usuario no valido", FILE_APPEND);
                die(json_encode([false, 8]));
            }
            else if (!$this->ValidarContrasena($pass, $pass_rep) ){
                file_put_contents('../archivo_25_08_21.txt', "\nContrasena no valida", FILE_APPEND);
                die(json_encode([false, 9]));
            }
            file_put_contents('../archivo_25_08_21.txt', "Todo ha sido valido", FILE_APPEND);

           try {
                //Estableciendo conexión con BD.
                $db = new DB(DBAccount::Root);

                //Verificando que el nombre de usuario no exista.
                $row = $db->SelectOnly('SELECT id FROM users WHERE user_name = ?', [1 => $user]);

                //Realizando registro.
                if (is_null($row)) {
                    //Generando clave hash.
                    if (($pass = Crypt::Hash($pass)) === false)
                        die(json_encode([false, 11]));

                    //Insertando registro.
                    $img = $this->AsignarImagenPorDefecto($gender);
                    $db->Execute('INSERT INTO users(user_name, pass, first_name, last_name,birth_date, gender,create_at, profile_img, phone,email ) VALUES (:user, :pass, :first, :last, :birth, :gender, NOW(), :profile_img, :phone, :email)', [
                        'user' => $user,
                        'pass' => $pass,
                        'first' => $first_name,
                        'last' => $last_name,
                        'birth' => $birthday,
                        'gender' => $gender,
                        'profile_img'=> $img,
                        'phone' => $phone,
                        'email' => $email,
                    ]);

                    //Desconectando base de datos.
                    unset($db);

                    //Devolviendo respuesta.
                    die(json_encode([true]));
                } else
                    die(json_encode([false, 10]));
            } catch (PDOException $ex) {
                die(json_encode([false, 12]));
            }
        }
        //Código 1: Uno de los parámetros recibido no es válido o esta vacio
        //Código 2: Nombre no válido
        //Código 3: Apellido no valido
        //Código 4: La fecha de nacimiento no es valida
        //Código 5: Opcion de genero no valida
        //Código 6: Formato de telefono no valido
        //Código 7: Formato de Email no valido
        //Código 8: No se ha podido guardar los cambio en la Base de datos

        public function Setting(){
            array_filter($_POST, function ($val) {
                return trim($val);
            });

            //Estableciendo tipo de respuesta.
            HttpResponse::SetContentType(MimeType::Json);

            //Se verifica que los parámetros recibidos no esten vacíos a excepción de email
            if(!$this->Iniciar()){
                die(json_encode([false, 1]));
            }

            $session = new Session();
            $user_id = $session->user_id;
            $first_name = empty($_POST['fn']) ? null : (string)$_POST['fn'];
            $last_name = empty($_POST['ln']) ? null : (string)$_POST['ln'];
            $birthday = empty($_POST['bt']) ? null : (string)$_POST['bt'];
            $gender = empty($_POST['gn']) ? null : (string)$_POST['gn'];
            $phone = empty($_POST['tf']) ? null : (string)$_POST['tf'];
            $email= empty($_POST['em']) ? null : (string)$_POST['em'];
//Validacion de cada uno de los parametros recibidos por POST
            if(!$this->ValidarNombreApellido($first_name)){
                die(json_encode([false, 2]));
            }
            if(!$this->ValidarNombreApellido($last_name)){
                die(json_encode([false, 3]));
            }
            if(!$this->ValidarFechanacimiento($birthday)){
                die(json_encode([false, 4]));
            }
            if(!$this->ValidarGenero($gender)){
                die(json_encode([false, 5]));
            }
            if(!$this->ValidarTelefono($phone)){
                die(json_encode([false, 6]));
            }
            if(!$this->ValidarCorreo($email)){
                die(json_encode([false, 7]));
            }
            file_put_contents('../archivo_25_08_21.txt', "La validacion ha sido correcta", FILE_APPEND);

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
                die(json_encode([false, 8]));
            }


        }

///
/// Cambio de clave
        //codigo 1 Una de las tres claves no es valida
        //codigo 2 Las claves recibidas no coinciden
        //codigo 3 La contraseña es incorrecta
        //Codigo 4 La contraseña nueva es igual a la anterior
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
        
        //Funciones de validacion
        function Iniciar()
        {
            foreach ($_POST as $campo => $valor) {
                if (($campo!="phone") && empty($valor)) {
                   return false;
                }
            }
            return true;
        }
  private function AsignarImagenPorDefecto($genero){
            $nombre_imagen="";
            if($genero=='M'){
                $nombre_imagen = "photo-profile-ma-".rand(1,3).".png";
            }
            else if($genero=='F'){
                $nombre_imagen = "photo-profile-fem-".rand(1,3).".png";
            }
            else{
                $nombre_imagen = "undefined-photo.png";
            }
return $nombre_imagen;
  }
        function ValidarNombreApellido(&$cadena){
            $cadena= filter_var ( $cadena, FILTER_SANITIZE_STRING);
            if(strlen($cadena)< 2){
                return false;
            }
            if(strlen($cadena) > 100){
                $cadena= substr($cadena,100);
            }

            return true;
        }
        function ValidarFechanacimiento($date)
        {
            if (!(date('Y-m-d', strtotime($date)) == $date)) { //si el valor no coincide se devuelve un false
                return false;
            }
            //si es una fecha se procede a verificar que se encuentre entre 01-01-1900 y la fecha actual
            $fecha_max = new \DateTime();
            $fecha_min = new \DateTime("01-01-1900");
            $fecha_recibida = new \DateTime($date);

            if ($fecha_recibida > $fecha_max) {
                return false;
            }
            if($fecha_recibida < $fecha_min){
                return false;
            }

            return true;
        }
        function ValidarGenero($valor){
            $resp = true;
            switch ($valor){
                case'M':
                case  'F':
                case'D':
                case 'O':
                    $resp = true;
                    break;
                default:
                    $resp= false;
                    break;
            }
            return $resp;
        }
        function ValidarTelefono($tel){
            $long= strlen($tel);
            if($long == 0){
                return true;
            }
            if(!ctype_digit($tel)){
                return false;
            }
            if(($long > 0 && $long<8) || $long >15 ){
                return false;
            }
            return true;
        }

        function ValidarCorreo($correo_recibido)
        {
            $correo_recibido = filter_var($correo_recibido, FILTER_SANITIZE_EMAIL);
            return (filter_var($correo_recibido, FILTER_VALIDATE_EMAIL));
        }
        function ValidarContrasena($clave, $clave_rep){
            if(strcmp($clave, $clave_rep)!==0){
                return  false;
            }
            if(!UserModel::IsValidPass($clave)){
                return false;
            }
            return true;
        }
    }