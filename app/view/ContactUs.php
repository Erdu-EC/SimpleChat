<?php
namespace HS\app\view;

use HS\libs\core\http\HttpResponse;
use HS\libs\core\Session;
use const HS\config\APP_NAME;

if (Session::IsLogin()){
    $SESSION = new Session();
    $SESSION_USER_SHORTNAME = $SESSION->user_shortname;
    $SESSION_USER_PROFILE_IMG = $SESSION->user_profile_img;
    unset($SESSION);
}

?>
<!doctype html>
<html lang="es">
<head>
    <?php require 'template/Head.php' ?>

    <title><?= APP_NAME ?>: Acerca de nosotros</title>
    <link rel="stylesheet" href="/files/scss/contact.css">
</head>
<body>
<header class="">

    <nav class="menu-navegacion">
        <button class="navbar-toggler" id="btn-navbar-toggler">
            <span class="material-icons">menu</span>
        </button>

        <ul class="nav-lista inactivo">
            <?php if (Session::IsLogin()){
    echo ' <li class="nav-list-item"><a href="/" class="nav-link usuario"><img src="'.$SESSION_USER_PROFILE_IMG.'?w=40&h=40" alt="">'. $SESSION_USER_SHORTNAME.'</a></li>';
            }else{
                echo ' <li class="nav-list-item"><a href="/Login" class="nav-link "> <span class="material-icons">login</span>Acceder</a></li><li class="nav-list-item"> <a href="/Register" class="nav-link"><span class="material-icons">add</span>Registrarse</a></li>';
            }?>
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

    <div class="container">
        <h1>Contáctanos</h1>
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <article class="cont-info-contacto">

                    <div class="item-info-contacto">
                        <i class="fas fa-map-marker-alt icon-info"></i>
                        <span class="subtitulo">Dirección</span>
                        <p> Esquina del CUUN, 1/2c. al oeste, León, Nicaragua.</p>
                    </div>
                    <div class="item-info-contacto ">
                        <i class="fas fa-phone-alt icon-info"></i>
                        <span class="subtitulo">Teléfono</span>
                        <p> (+505) 2311 2311</p>
                    </div>

                    <div class="item-info-contacto">
                        <i class="fas fa-envelope icon-info"></i>
                        <span class="subtitulo">E-mail</span>
                        <p>support@simplechat.com</p>
                    </div>
                </article>
            </div>
            <div class=" col-md-1 col-lg-2 col-xl-2"></div>
            <div class="col-sm-12 col-md-7 col-lg-6 col-xl-6">
                <section class="contenedor-formulario">
                    <form action="" class="formulario-contacto">
                        <div class="logo-simplechat">
                            <img src="/files/icon/logo-wh.png?h=50" alt="">
                        </div>
                        <div class="cont-titulo">
                            <span class="titulo">Envíanos un mensaje</span>
                            <p>Si quieres reportar un problema o tienes sugerencias de nuestro sitio web puedes escribirnos un mensaje.</p>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                <div class="item-form">
                                    <span class="etiqueta-input"><i class="far fa-user icon-etiqueta"></i>Nombres *</span>
                                    <div class="input-group">
                                        <input  type="text" class="form-control" required placeholder="Introduzca su nombre" id="nombre-remitente" value="<?= (isset($SESSION_USER_SHORTNAME)) ?$SESSION_USER_SHORTNAME : ""?>">
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
    <footer class="footer-acerca ">
        <div class="redes-sociales">
            <ul>

                <li><a href="http://facebook.com" class="item-red-social"><i class="fab fa-facebook-square"></i></a></li>
                <li><a href="http://twitter.com" class="item-red-social"><i class="fab fa-twitter-square"></i></a></li>
                <li><a href="http://linkedin.com" class="item-red-social"><i class="fab fa-linkedin"></i></a></li>
            </ul>
        </div>
        <p>&copy; Copyright 2021 SimpleChat - Todos los derechos reservados</p>
    </footer>
</div>

<script type="application/javascript" src="/files/js/ContactUs.js"></script>
<script type="text/javascript" src="/files/sweetalert/sweetalert.min.js"></script>
</body>
</html>
