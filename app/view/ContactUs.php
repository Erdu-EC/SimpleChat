<?php
namespace HS\app\view;

use HS\libs\core\http\HttpResponse;
use HS\libs\core\Session;
use const HS\config\APP_NAME;
?>
<!doctype html>
<html lang="es">
<head>
    <?php require 'template/Head.php' ?>

    <title><?= APP_NAME ?>: Acerca de nosotros</title>
    <link rel="stylesheet" href="/files/scss/contact.scss">
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
                <a href="/Register" class="nav-link"><span class="material-icons">add</span>Resgistrarse</a>
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
                <a href="/Contact" class="nav-link activo">
                    <span class="material-icons"><span class="material-icons-outlined">support_agent</span></span>Contacto
                </a>
            </li>


        </ul>

    </nav>
</header>
<div class="container-fluid">
<div class="container">
<div class="row">
    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4"></div>
    <div class=" col-md-1 col-lg-2 col-xl-2"></div>
    <div class="col-sm-12 col-md-7 col-lg-6 col-xl-6">
<section class="contenedor-formulario">
    <form action="" class="formulario-contacto">
        <div class="logo-simplechat">
            <img src="/files/icon/logo-wh.png?h=70" alt="">
        </div>
        <div class="titulo">
            <span>Contáctanos</span>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                <div class="item-form">
                    <span class="etiqueta-input"><i class="far fa-user icon-etiqueta"></i>Nombres *</span>
                    <div class="input-group">
                        <input  type="text" class="form-control" required placeholder="Introduzca su nombre" id="nombre-remitente">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                <div class="item-form">
                    <span class="etiqueta-input"><i class="fas fa-at icon-etiqueta"></i>E-mail *</span>
                    <div class="input-group">
                        <input type="email" class="form-control" required placeholder="Introduzca su correo" id="correo-remitente">

                    </div>

                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                <div class="item-form">
                    <span class="etiqueta-input"><i class="fas fa-phone-alt icon-etiqueta"></i>Teléfono</span>
                    <div class="input-group">
                        <input  type="text" class="form-control" placeholder="Número telefónico" id="telefono-remitente" maxlength="15"">

                    </div>
                </div>
            </div>

        </div>
        <div class="row">
                    <div class="col-12">
                        <div class="item-form">
                            <span class="etiqueta-input"><i class="far fa-envelope icon-etiqueta"></i>Mensaje</span>
                            <div class="input-group">
                                <textarea name="" id="mensaje" cols="30" rows="10"  class="form-control" placeholder="Escriba aquí su mensaje"></textarea >

                            </div>
                        </div>
                    </div>
                </div>

        <div class="item-form contenedor-enviar">
            <button id="enviar"><i class="far fa-paper-plane icon-etiqueta"></i>Enviar mensaje</button>

        </div>
    </form>

</section>
    </div>
</div>
</div>
</div>
<script type="application/javascript" src="/files/js/ContactUs.js"></script>
</body>
</html>