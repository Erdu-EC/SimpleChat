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
    </head>
    <body>
    <main class="container-fluid" style="background-image: url("")">
    <img alt="" class="imagen-contenedor">

    <section class="row" id="poster-login">

           <div class="col-sm-7 col-md-7">
                <img src="/files/img/img-01.jpg" alt="" class="img-fluid">
            </div>
            <div class="col-md-4">
                <main class="d-flex align-items-center">
                    <div class="card shadow-lg text-center flex-grow-1">
                        <div class="card-header bg-primary text-white">
                            <h4 class="m-0"><?= 'Bienvenido a ' . APP_NAME ?></h4>
                        </div>
                        <form id="user_form" class="card-body p-0 pb-3">
                            <div id="action_alert" class="alert p-1" style="border-radius: 0">
                            </div>

                            <div class="input-group mb-3 ps-5 pe-5">
                                <div class="input-group-prepend">
                                    <label class="input-group-text text-secondary material-icons" for="user_name">
                                        person
                                    </label>
                                </div>
                                <input id="user_name" type="text" class="form-control" placeholder="Nombre de usuario" minlength="4" maxlength="30" required>
                            </div>

                            <div class="input-group mb-3 ps-5 pe-5">
                                <div class="input-group-prepend">
                                    <label class="input-group-text text-secondary material-icons"
                                           for="user_pass">lock</label>
                                </div>
                                <input id="user_pass" type="password" class="form-control" placeholder="Contraseña" minlength="8" maxlength="60" required>
                            </div>

                            <button type="submit" class="btn btn-primary d-inline-flex">
                                <span class="material-icons me-2">person</span>
                                Acceder
                            </button>
                        </form>

                    </div>
                </main>
            </div>
            <div class="col-md-1"></div>
        </section>
    </main>
    <script type="text/javascript" src="/files/js/LoginPage.js"></script>
    </body>
    </html>


<?php