<?php


namespace HS\libs\core;


use const HS\config\APP_SESSION_NAME;

class Session extends \ArrayObject
{
    public function __construct()
    {
        if (!$this->IsStart()){
            session_name(APP_SESSION_NAME);
            session_start();
        }
        parent::__construct($_SESSION, self::STD_PROP_LIST || self::ARRAY_AS_PROPS);
    }

    public function __destruct(){
        if ($this->IsStart())
            session_write_close();
    }

    public function IsStart(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function Regenerate() : bool{
        return session_regenerate_id();
    }

    public function Kill() : void{
        //Eliminando variables de sesion
        $_SESSION = array();

        //Eliminando Cookies de sesion
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        //Destruyendo la sesion
        session_destroy();
    }
}