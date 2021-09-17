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
    <link rel="stylesheet" href="/files/scss/register.scss">
</head>
<body>

<header class="">

    <nav class="menu-navegacion">
        <button class="navbar-toggler" id="btn-navbar-toggler">
            <span class="material-icons">menu</span>
        </button>

        <ul class="nav-lista inactivo">
            <li class="nav-list-item">

                <a href="/Login" class="nav-link "> <span class="material-icons">login</span>Acceder</a>
            </li>
            <li class="nav-list-item">
                <a href="/Register" class="nav-link activo"><span class="material-icons">add</span>Registrarse</a>
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
<section class="container-fluid">
    <main class="main">
        <div class="row">
            <div class="d-sm-none d-md-block col-md-3 col-lg-4"></div>
            <div class="col-sm-12 col-md-7 col-lg-5 col-xl-5">
                <div class="card">
                    <div class="card-header">
                        <img src="/files/icon/logo-wh.png?h=70" alt="">
                        <?= 'Bienvenido al formulario de registro de ' . APP_NAME ?>
                    </div>
                    <form id="register_form" method="post">
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="item-form">
                                    <span class="etiqueta-input">Nombres</span>
                                    <div class="input-group">
                                        <label for="first_name"><span class="material-icons">face</span></label>
                                        <input id="first_name" type="text" class="form-control" >

                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="item-form">
                                    <span class="etiqueta-input">Apellidos</span>
                                    <div class="input-group">
                                        <input id="last_name" type="text" class="form-control">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="item-form">
                                    <span class="etiqueta-input">Género</span>
                                    <div class="input-group">
                                        <label class="" for="gender">
                                            <span class="material-icons">wc</span>
                                        </label>
                                        <select class="form-select" id="gender">
                                            <option selected disabled value=""></option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                            <option value="O">Otro</option>
                                            <option value="D">Sin especificar</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="item-form">
                                    <span class="etiqueta-input" id="etiquetaCumple">Fecha de nacimiento</span>
                                    <div class="input-group">
                                        <label class="" for="birth_date">
                                            <span class="material-icons">cake</span>
                                        </label>
                                        <input id="birth_date" type="date" class="" <?php echo 'max="',date('Y-m-d'),'"'; ?>  min="1900-01-01" >
                                    </div>

                                </div>
                            </div>
                            <div class="item-form">
                                <span class="etiqueta-input">Teléfono</span>
                                <div class="input-group">

                                    <label class="" for="user_phone">
                                        <span class="material-icons">phone</span>
                                    </label>
                                    <input id="user_phone" type="text" class="form-control">

                                </div>
                            </div>
                            <div class="item-form">
                                <span class="etiqueta-input">E-mail</span>
                                <div class="input-group">

                                    <label class="" for="user_name">
                                        <span class="material-icons">email</span>
                                    </label>
                                    <input id="user_email" type="email" class="form-control" autocomplete="username">

                                </div>
                            </div>
                            <div class="item-form">
                                <span class="etiqueta-input">Usuario</span>
                                <div class="input-group">

                                    <label class="" for="user_name">
                                        <span class="material-icons">person</span>
                                    </label>
                                    <input id="user_name" type="text" class="form-control" autocomplete="username" maxlength="30" >

                                </div>
                            </div>
                            <div class="item-form">
                                <span class="etiqueta-input">Escriba su contraseña</span>
                                <div class="input-group">
                                    <label class="" for="user_pass"><span class="material-icons">lock</span></label>
                                    <input id="user_pass" type="password" class="form-control" autocomplete="new-password" maxlength="60" >
                                </div>
                                <div class="info-clave-usuario">
                                    <div class="indicador-minimo">
                                        8 caracteres mín.
                                    </div>
                                    <div id="indicador-nivel-seguridad">
                                        <i class="fas fa-info-circle"></i> <span>Débil</span>
                                    </div>

                                </div>
                                <div class="desplegable-recomendaciones-clave">
<p> <i class="fas fa-info-circle"></i> Una contraseña fuerte debe ser única, contener como mínimo 8 caracteres, con una combinación de:</p>
                                    <ul>
                                        <li>- 8 caracteres min.</li>
                                        <li>- Números</li>
                                        <li>- Letras mayúsculas</li>
                                        <li>- Letras minúsculas</li>
                                        <li>- Caracteres especiales</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="item-form">
                                <span class="etiqueta-input">Repita la contraseña</span>
                                <div class="input-group">
                                    <label for="user_pass_repeat" ><span class="material-icons">lock</span></label>
                                    <input id="user_pass_repeat" type="password" class="form-control"   autocomplete="new-password" maxlength="60" >
                                </div>
                            </div>
                            <div id="contenedor-mensajes">

                            </div>
                            <div class="item-form">

                                <div class="input-group " id="contenedor-registrar">
                                    <button type="submit" class="" id="registrar">
                                        Registrarse
                                    </button>
                                </div>

                            </div>
                        </div>
                        <div class="notifiacion-privacidad">
                            Al dar click en "Registrarse", acepta los condiciones generales de uso disponibles en <a href="/Privacy">Términos y condiciones</a>
                        </div>
                            <div class="acceder-cuenta">
                                ¿Ya tienes una cuenta? <a class="" href="/Login">Inicia Sesión</a>
                            </div>

                    </form>
                </div>

            </div>

            <div class="d-sm-none d-md-block col-md-2 col-lg-3"></div>
        </div>
    </main>
</section>

<script type="text/javascript" src="/files/js/RegisterPage.js"></script>
<script type="text/javascript" src="/files/sweetalert/sweetalert.min.js"></script>
</body>
</html>
