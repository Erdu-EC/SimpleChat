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
        <link rel="stylesheet" href="files/login.css">
        <title><?= APP_NAME ?>: Inicio de sesión</title>

        <style>
            main {
                height: 100vh;
            }

            main .row {
                height: 100%
            }
        </style>

        <script type="text/javascript" src="/files/js/LoginPage.js"></script>
    </head>
    <body>
    <main class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-primary" id="navbar-login-home">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="container-fluid">
                <a class="navbar-brand" href="#">SimpleChat</a>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/chat">Chat</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
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
        <footer class="blockquote-footer">
            <div class="card-footer text-muted">
                <?= "Copyright 2021, Todos los derechos reservados" ?>
            </div>
        </footer>
    </main>
    </body>
    </html>


<?php