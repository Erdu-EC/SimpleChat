<?php

namespace HS\app\view;

use HS\libs\core\Session;
use HS\libs\core\http\HttpResponse;
use const HS\config\APP_NAME;

if (Session::IsLogin()) HttpResponse::Redirect('/');
?>

<!doctype html>
<html lang="es">
<head>
    <?php require 'template/Head.php' ?>

    <title><?= APP_NAME ?>: Registro</title>

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
        <div class="col-sm-2"></div>
        <div class="col-md-8">
            <main class="d-flex align-items-center">
                <div class="card shadow-lg text-center flex-grow-1">
                    <div class="card-header bg-primary text-white">
                        <h4 class="m-0"><?= APP_NAME ?>: Nuevo usuario</h4>
                    </div>
                    <form id="register_form" class="card-body p-0 pb-3">
                        <div id="action_alert" class="alert p-1" style="border-radius: 0">
                        </div>

                        <div class="row ps-5 pe-5 mb-3">
                            <div class="col-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text text-secondary" for="first_name">
                                            Nombres
                                        </label>
                                    </div>
                                    <input id="first_name" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text text-secondary" for="last_name">
                                            Apellidos
                                        </label>
                                    </div>
                                    <input id="last_name" type="text" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="row ps-5 pe-5 mb-3">
                            <div class="col-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text text-secondary" for="gender">
                                            Genero
                                        </label>
                                    </div>
                                    <select class="form-select" id="gender">
                                        <option selected>Seleccione...</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                        <option value="O">Otros</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text text-secondary" for="birth_date">
                                            Fecha de nacimiento
                                        </label>
                                    </div>
                                    <input id="birth_date" type="date" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="row ps-5 pe-5 mb-3">
                            <div class="col">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text text-secondary" for="user_name">
                                            Usuario
                                        </label>
                                    </div>
                                    <input id="user_name" type="text" class="form-control" autocomplete="username"
                                           minlength="4" maxlength="30" required>
                                </div>
                            </div>
                        </div>

                        <div class="row ps-5 pe-5 mb-3">
                            <div class="col">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text text-secondary"
                                               for="user_pass">Contraseña</label>
                                    </div>
                                    <input id="user_pass" type="password" class="form-control"
                                           autocomplete="new-password"
                                           placeholder="Ingrese su contraseña" minlength="8" maxlength="60" required>
                                    <label for="user_pass_repeat" class="d-none"></label>
                                    <input id="user_pass_repeat" type="password" class="form-control"
                                           autocomplete="new-password"
                                           placeholder="Repita la contraseña" minlength="8" maxlength="60" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary d-inline-flex">
                            <span class="material-icons me-2">add_circle</span>
                            Registrarse
                        </button>

                        <a class="d-block text-primary mt-3" href="/Login">¿Ya tienes una cuenta? Inicia Sesión</a>
                    </form>
                    <div class="card-footer text-muted">
                        <?= "Copyright 2021, Todos los derechos reservados" ?>
                    </div>
                </div>
            </main>
        </div>
        <div class="col-sm-2"></div>
    </div>
</main>
</body>
</html>
