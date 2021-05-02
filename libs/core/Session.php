<?php


namespace HS\libs\core;


use HS\libs\collection\Collection;
use const HS\config\APP_SESSION_NAME;

class Session extends Collection
{
    public function __construct()
    {
        if (!$this->IsStart()){
            session_name(APP_SESSION_NAME);
            session_start();
        }
        parent::__construct($_SESSION);
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

    //Login.
    public static function SetLogin(int $id, string $user_name, string $shortname){
        $session = new Session();
        $session->user_id = $id;
        $session->user_name = $user_name;
        $session->user_shortname = $shortname;
        unset($session);
    }

    public static function IsLogin(){
        $session = new Session();
        return isset($session->user_id) && isset($session->user_name);
    }
}