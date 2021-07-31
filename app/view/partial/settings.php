<?php
/*TODO: APLICAR PERMISOS PARA LA SEGURIDAD DE LA INFORMACION MOSTRADA.*/

namespace HS\app\view;
use HS\libs\core\Session;
use const HS\config\APP_NAME;
$SESSION = new Session();
?>
<div class="contenedor-info-cuenta">
    <div class="row">
        <div class="col-6">
            <div class="foto-perfil">
                <img id="profile-img" src="/files/profile/mikeross?w=100&h=100" class="online" alt="" />
            </div>

        </div>
        <div class="col-6">
            <div class="item-perfil"></div>
            <div class="item-perfil"></div>
        </div>



    </div>
    <div class="row">
        <div class="col-12">
            <div class="item-perfil"></div>
            <div class="item-perfil"></div></div>
    </div>
</div>
