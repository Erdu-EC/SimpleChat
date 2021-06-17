<?php

namespace HS\app\view;

use HS\libs\core\http\HttpResponse;
use HS\libs\core\Session;
use const HS\config\APP_NAME;

//Si la sesion ya esta iniciada redireccionar a pantalla de inicio.
if (Session::IsLogin())
    HttpResponse::Redirect('/');

?>

    <!doctype html>
    <html lang="es">
    <head>
        <?php require 'template/Head.php' ?>
        <link rel="stylesheet" href="/files/scss/login.scss">
        <title><?= APP_NAME ?>: Inicio de sesión</title>
        <?php
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
        ?>
    </head>
    <body>
    <header class="">
        <nav class="menu-navegacion">
            <button class="navbar-toggler" id="btn-navbar-toggler">
    <span class="material-icons">menu</span>
            </button>
            <ul class="nav-lista inactivo">
                <li class="nav-list-item">

                    <a href="/Login" class="nav-link activo"> <span class="material-icons">login</span>Acceder</a>
                </li>
                <li class="nav-list-item">
                    <a href="/" class="nav-link"><span class="material-icons">
add
</span>Resgistrarse</a>
                </li>
                <li class="nav-list-item">
                    <a href="#" class="nav-link">
                        <span class="material-icons">gavel</span>Términos y condiciones</a>
                </li>
                <li class="nav-list-item">
                    <a href="#" class="nav-link"><span class="material-icons">
people_outline
</span>Sobre Nosotros</a>
                </li>
                <li class="nav-list-item">
                    <a href="#" class="nav-link">
                        <span class="material-icons"><span class="material-icons-outlined">
support_agent</span>
</span>Contacto</a>
                </li>


            </ul>

        </nav>
    </header>
     <div class="container-fluid">
         <div class="row">
<div class="col-sm-12 col-md-6 col-lg-7">

</div>
             <div class="col-sm-12 col-md-6 col-lg-5 contenedor-login" >
                 <div class="card">
                     <div class="card-header">
                         <img src="/files/icon/logo.png" alt="">
                         <?= 'Bienvenido a ' . APP_NAME ?>
                     </div>
                     <form id="user_form">
<div class="input-group">
    <label for="usuario"><span class="material-icons">person</span></label>
    <input type="text" id="user_name" minlength="4" maxlength="30" required placeholder="Introduzca su nombre de usuario">
</div>
                         <div class="input-group separar">
                             <label for="clave-usuario"><span class="material-icons">lock</span></label>
                             <input type="password" id="user_pass"  placeholder="Introduzca su contraseña" minlength="8" maxlength="60" required>
                         </div>
                         <div class="recuperar-clave">
                             <a href="">¿Ha olvidado su contraseña?</a>
                         </div>
<div class="input-group">
        <input type="submit" value="Acceder" id="acceder">
</div>

                     </form>
                 </div>
             </div>
         </div>




     </div>
    <script type="text/javascript" src="/files/js/LoginPage.js"></script>
    </body>
    </html>


<?php