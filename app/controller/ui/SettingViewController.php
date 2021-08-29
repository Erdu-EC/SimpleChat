<?php

namespace HS\app\controller\ui;

use HS\app\model\InvitationModel;
use HS\app\model\MessageModel;
use HS\app\model\UserModel;
use HS\config\DBAccount;
use HS\libs\core\Controller;
use HS\libs\core\Session;
use PDOException;

class SettingViewController extends Controller
{
    public function Index(){
        try {
            //Obteniendo ID de usuario actual.
            $user_id = (new Session())->user_id;

            //Obteniendo datos de usuario consultado.
            $user = new UserModel(DBAccount::Root);
            $user_data = $user->GetOneById($user_id, [
                UserModel::C_FNAME
            ]);

            //Cerrando conexión BD.
            unset($user);
        } catch (PDOException $ex) {
            //TODO: Devolver una vista que muestre un error.
            return;
        }

        //Llamando vista.
        $this->View('partial/settings.php', $user_data);
    }
}