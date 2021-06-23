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

        <style>
            main {
                height: 100vh;
            }

            main .row {
                height: 100%
            }
        </style>

        <script type="text/javascript" src="/files/js/LoginRegisterPage.js"></script>
    </head>
    <body>
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
    </main>
    </body>
    </html>