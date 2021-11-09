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

        <title><?= APP_NAME ?>: Inició de sesión</title>

        <link rel="stylesheet" href="/files/scss/login.css">

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
                    <a href="/Register" class="nav-link"><span class="material-icons">add</span>Registrarse</a>
                </li>
                <li class="nav-list-item">
                    <a href="/Privacy" class="nav-link">
                        <span class="material-icons">gavel</span>Términos y condiciones</a>
                </li>
                <li class="nav-list-item">
                    <a href="/About" class="nav-link">
                        <span class="material-icons">people_outline</span>Sobre Nosotros
                    </a>
                </li>
                <li class="nav-list-item">
                    <a href="/Contact" class="nav-link">
                        <span class="material-icons">support_agent</span>Contacto
                    </a>
                </li>


            </ul>
            <div class="logo-simplechat-bk">
                <img src="/files/icon/logo-bk.png?h=40" alt="">
            </div>
            <div class="logo-simplechat-wh">
                <img src="/files/icon/logo-wh.png?h=36" alt="" >
            </div>
        </nav>
    </header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-7">

            </div>
            <div class="col-sm-12 col-md-6 col-lg-5 contenedor-login" >
                <div class="card">
                    <div class="card-header">
                        <img src="/files/icon/logo-wh.png?h=70" alt="">
                        <?= 'Bienvenido a ' . APP_NAME ?>
                    </div>


                    <form id="user_form">
                        <div class="input-group">
                            <label for="usuario"><span class="material-icons">person</span></label>
                            <input type="text" id="user_name"  maxlength="30" required placeholder="Introduzca su nombre de usuario">
                        </div>
                        <div class="input-group separar">
                            <label for="clave-usuario"><span class="material-icons">lock</span></label>
                            <input type="password" id="user_pass"  placeholder="Introduzca su contraseña" maxlength="60" required>
                        </div>
                        <div class="recuperar-clave">
                            <a href="">¿Has olvidado tu contraseña?</a>
                        </div>
                        <div class="crear-cuenta">
                            <a href="/Register">Regístrate en SimpleChat</a>
                        </div>
                        <div class="input-group" id="contenedor-acceder">
                            <input type="submit" value="Acceder" id="acceder">
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript" src="/files/js/Login.js"></script>
    </body>
    </html>

<?php

