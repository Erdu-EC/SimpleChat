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

        <link rel="stylesheet" href="/files/scss/login.scss">

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
                    <a href="/Register" class="nav-link"><span class="material-icons">
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
                        <div class="crear-cuenta">
                            ¿Todavía no tienes una cuenta Deezer? <a href="/Register">Regístrate</a>
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






    <!--
    <main class="container-fluid">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-md-6">
                <main class="d-flex align-items-center">
                    <div class="card shadow-lg text-center flex-grow-1">
                        <div class="card-header bg-primary text-white">
                            <h4 class="m-0"><?= 'Bienvenido a ' . APP_NAME ?></h4>
                        </div>
                        <form id="user_form" class="card-body p-0 pb-3">
                            <div id="action_alert" class="alert p-1" style="border-radius: 0">
                                HOLA
                            </div>

                            <div class="input-group mb-3 ps-5 pe-5">
                                <div class="input-group-prepend">
                                    <label class="input-group-text text-secondary material-icons" for="user_name">
                                        person
                                    </label>
                                </div>
                                <input id="user_name" type="text" class="form-control" autocomplete="username"
                                       placeholder="Nombre de usuario" minlength="4" maxlength="30" required>
                            </div>

                            <div class="input-group mb-3 ps-5 pe-5">
                                <div class="input-group-prepend">
                                    <label class="input-group-text text-secondary material-icons"
                                           for="user_pass">lock</label>
                                </div>
                                <input id="user_pass" type="password" class="form-control" autocomplete="current-password"
                                       placeholder="Contraseña" minlength="8" maxlength="60" required>
                            </div>

                            <button type="submit" class="btn btn-primary d-inline-flex">
                                <span class="material-icons me-2">vpn_key</span>
                                Acceder
                            </button>

                            <a class="d-block text-primary mt-3" href="/Register">¿No tienes una cuenta? Registrate</a>
                        </form>
                        <div class="card-footer text-muted">
                            <?= "Copyright 2021, Todos los derechos reservados" ?>
                        </div>
                    </div>
                </main>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </main> -->
    <script type="text/javascript" src="/files/js/Login.js"></script>
    </body>
    </html>


<?php
