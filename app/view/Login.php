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


<?php
/*
/*
 * AUTOR: Eduardo Castillo - Ingeniero en Telematica
 *

session_start();
if (isset($_SESSION['usuario'])) {
    header('location: dinasystem/inicio.php');
}

require_once "html/WebPage.php";
require_once "html/WebIcon.php";
require_once('dinasystem/permisos/master.php');

$master = new Master();

$Databases = $master->Get();
$master->Close_Conexion();
?>

<!--
<!DOCTYPE html>
<html lang="es">
<head>
    <?=
    WebPage::Title(null);
    WebPage::Head();
    ?>

    <script type="text/javascript">
        $(document).on("change", "#user_company", function () {
            const empresa = $.trim($(this).val());

            $.ajax({
                datatype: 'html',
                type: 'POST',
                url: "dinasystem/permisos/obtenerOcupacion.php",
                data: {empresa: empresa},
                error: () => alert('Error en la peticion AJAX'),
                success: function (datos) {
                    $(".opDinamico").remove();
                    const obj = JSON.parse(datos);
                    let bodegas = "";
                    for (let i = 0; i < obj.length; i++) {
                        bodegas += '<option class="opDinamico" value="' + obj[i][1] + '">' + obj[i][1] + '</option>';
                    }
                    $("#user_job").append(bodegas);
                }
            });
        })

        function launchFullScreen() {
            if (document.documentElement.requestFullScreen) {
                document.documentElement.requestFullScreen();
            } else if (document.documentElement.mozRequestFullScreen) {
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullScreen) {
                document.documentElement.webkitRequestFullScreen();
            }
        }

        $(document).on("click", "#bt_submit", function () {
            const empresa = $.trim($("#user_company").val());
            const user = $.trim($("#user_name").val());
            const pass = $.trim($("#user_pass").val());
            const ocupacion = $.trim($("#user_job").val());

            $.ajax({
                datatype: 'html',
                type: 'POST',
                url: "dinasystem/permisos/login.php",
                data: {empresa: empresa, Username: user, Password: pass, ocupacion: ocupacion},
                error: () => alert('Error en la peticion AJAX'),
                success: function (datos) {
                    if (parseInt(datos, 10) === 1) {
                        launchFullScreen();
                        //sandbox="allow-same-origin allow-scripts"
                        localStorage.timetoken = 0;
                        localStorage.original_timeout = <?= Config::TIMEOUT_TO_CLOSE_SESSION ?>;
                        localStorage.timeout = <?= Config::TIMEOUT_TO_CLOSE_SESSION ?>;
                        document.body.innerHTML = '<iframe id="ifr"  frameborder="0" width="100%" height="100%" src="dinasystem/inicio.php"></iframe>'

                        //window.location = 'dinasystem/inicio.php';
                    } else
                        $("#action_alert").text("Usuario, contraseña, empresa o cargo incorrecto");
                }
            });
        });
    </script>
</head>
<body>
<div class="container-fluid"
     style="height: 100vh; background: url(<?= Web::Url('/files/img/banner.jpg') ?>); background-size: cover ">
    <div class="row" style="height: 100%">
        <div class="col-sm-3"></div>
        <div class="col-md-6 align-self-center">
            <main>
                <div class="card text-center shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h4 class="m-0"><?= 'Bienvenido a ' . Config::APP_NAME ?></h4>
                    </div>
                    <div class="card-body p-0 pb-3">
                        <div id="action_alert" class="alert alert-danger p-1" style="border-radius: 0">

                        </div>

                        <div class="input-group mb-3 pr-5 pl-5">
                            <div class="input-group-prepend">
                                <label class="input-group-text text-secondary" for="user_name">
                                    <?= WebIcon::Get(WebIcon::PERSON, '', '', '') ?>
                                </label>
                            </div>
                            <input id="user_name" type="text" placeholder="Nombre de usuario" class="form-control">
                        </div>

                        <div class="input-group mb-3 pr-5 pl-5">
                            <div class="input-group-prepend">
                                <label class="input-group-text text-secondary"
                                       for="user_pass"><?= WebIcon::Get(WebIcon::LOCK_FILL, '', '', '') ?></label>
                            </div>
                            <input id="user_pass" type="password" placeholder="Contraseña" class="form-control">
                        </div>

                        <div class="input-group mb-3 pr-5 pl-5">
                            <div class="input-group-prepend">
                                <label class="input-group-text text-secondary"
                                       for="user_job"><?= WebIcon::Get(WebIcon::BUILDING, '', '', '') ?></label>
                            </div>
                            <select class="custom-select" id="user_company">
                                <option selected>Seleccione empresa. . .</option>
                                <?php
                                foreach ($Databases as $db)
                                    echo "<option value='{$db[0]}'>{$db[1]}</option>";
                                ?>
                            </select>
                        </div>

                        <div class="input-group mb-3 pr-5 pl-5">
                            <div class="input-group-prepend">
                                <label class="input-group-text text-secondary"
                                       for="user_job"><?= WebIcon::Get(WebIcon::BRIEFCASE_FILL, '', '', '') ?></label>
                            </div>
                            <select class="custom-select" id="user_job">
                                <option selected>Seleccione ocupación. . .</option>
                            </select>
                        </div>

                        <a id="bt_submit" href="#" class="btn btn-primary">
                            <?= WebIcon::Get(WebIcon::DOOR_OPEN_FILL, "1.2em", "1.2em", '') ?>
                            <span style="vertical-align: middle">Acceder</span>
                        </a>
                    </div>
                    <div class="card-footer text-muted">
                        <?= "Copyright 2020, Todos los derechos reservados" ?>
                    </div>
                </div>
            </main>
        </div>
        <div class="col-sm-3"></div>
    </div>
</div>
</body>
</html>-->
*/
