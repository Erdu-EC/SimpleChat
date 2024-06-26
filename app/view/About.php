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
<html lang="es" xmlns="http://www.w3.org/1999/html">
<head>
    <?php require 'template/Head.php' ?>

    <title><?= APP_NAME ?>: Acerca de nosotros</title>
    <link rel="stylesheet" href="/files/css/about.css">
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
                <a href="/About" class="nav-link activo">
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
    <section class="top-acerca">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active align-content-center">
                    <!-- la resolcion de las imagenes es de 4950 px X 2175 para mantener la proporcio a 330x145 px -->
                    <img src="/files/photos/photo-1.jpg" class="d-block img-carousel" alt="">
                    <div class="filtro-img-carrusel">
                        <div class="mensaje-carrousel">
                            <span class="titulo">Funcionamiento sencillo </span>
                            <span class="subtitulo">& Diseño flexible</span>
                            <p class="texto-carrusel">SimpleChatdespliega perfectamente en todos los dispositivos: PC, smartphone y tablet.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/files/photos/photo-2.jpg" class="d-block img-carousel" alt="">
                    <div class="filtro-img-carrusel">
                        <div class="mensaje-carrousel">
                            <span class="titulo">Protección de Datos</span>
                            <span class="subtitulo">& Privacidad</span>
                            <p class="texto-carrusel">Tus datos están en buenas manos con nosotros, y siempre disponibles.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/files/photos/photo-3.jpg" class="d-block img-carousel" alt="">
                    <div class="filtro-img-carrusel">
                        <div class="mensaje-carrousel">
                            <span class="titulo">Diseño simple</span>
                            <span class="subtitulo">& Mensajes instantáneos</span>
                            <p class="texto-carrusel">Es tan simple que ya
                                sabes cómo utilizarlo con entrega mensajes de forma instantánea.</p>
                        </div>
                    </div>
                </div

            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

    </section>
    <section class="presentacion-acerca">
        <div class="contenedor-presentacion">
            <h2>Nuestro equipo</h2>
            <div class="texto-presentacion">
                <p>
                    Todos somos muy diferentes.
                    Nacimos en diferentes ciudades, en diferentes épocas, amamos música, comida, películas diferentes.
                    Pero tenemos algo que nos une a todos. Esto es nuestra empresa SimpleChat. Somos su corazón.
                    No somos solo un equipo, somos una familia.
                </p>

            </div>
            <a href="/Contact" class="hacia-contactanos">
                <button >
                    Contáctanos
                </button>
            </a>
        </div>

    </section>
    <section class="foto-panoramica">
    </section>
    <section class="contenido-acerca">
        <div class="acciones">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12">

                    <div class="objetivos" >
                        <figure><img src="/files/photos/mini-1.svg" alt=""></figure>
                        <div class="cuerpo-objetivos">
                            <p class="title">Desarrollo e innovación</p>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="objetivos" >
                        <figure><img src="/files/photos/mini-2.svg" alt=""></figure>
                        <div class="cuerpo-objetivos">
                            <p class="title">Actualizaciones periódicas</p>

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="objetivos" >
                        <figure><img src="/files/photos/mini-3.svg" alt=""></figure>
                        <div class="cuerpo-objetivos">
                            <p class="title">Protección de datos</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="objetivos" >
                        <figure><img src="/files/photos/mini-4.svg" alt=""></figure>
                        <div class="cuerpo-objetivos">
                            <p class="title">Diseño adaptativo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bottom-acerca">
        <div class="row hor-cont-caracteristicas">
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 cont-caracteristicas">
                <article class="caracteristicas">
                    <div class="icon-caract">
                        <img src="/files/photos/about-caract-1.svg" alt="">
                    </div>
                    <span class="titulo-caract">Creatividad</span>
                    <p class="descrip-caract">SimpleChat ha sido optimizado para dispositivos móviles de diferentes tamaños y resoluciones de pantalla.</p>
                </article>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 cont-caracteristicas">
                <article class="caracteristicas">
                    <div class="icon-caract">
                        <img src="/files/photos/about-caract-2.svg" alt="">
                    </div>
                    <span class="titulo-caract">Adaptabilidad</span>
                    <p class="descrip-caract" >Es la capacidad de pensar fuera de la caja. Generamos muchas ideas, tomamos decisiones y creamos algo nuevo.</p>
                </article>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 cont-caracteristicas">
                <article class="caracteristicas">
                    <div class="icon-caract">
                        <img src="/files/photos/about-caract-3.svg" alt="">
                    </div>
                    <span class="titulo-caract">Estilo</span>
                    <p class="descrip-caract">Diseños flexibles con colores elegantes ajustados a las tendencias actuales.</p>
                </article>
            </div>

        </div>


        <div id="carrusel-desarrolladores" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner " id="integrantes-acerca">
                <div class="carousel-item active" data-bs-interval="4000">
                    <img class="" src="/files/photos/home_pic1.jpg" alt="">

                    <div class="item-integrante">
                        <p class="palabras-integrante">Esperamos que queden muy satisfechos con nuestro trabajo, representamos a una maravillosa empresa.</p>
                        <span class="nombre-integrante">Emily Saens</span>
                        <span class="puesto-integrante">Diseñadora</span>
                    </div>



                </div>
                <div class="carousel-item" data-bs-interval="2500">
                    <img class="" src="/files/photos/home_pic2.jpg" alt="">
                    <div class="item-integrante">
                        <p class="palabras-integrante"> Tratamos de  ser precisos, todas las promesas se cumplen, todas las preguntas obtienen respuestas, la empresa presenta un enfoque muy atento y positivo.</p>
                        <span class="nombre-integrante">Dan Fonda</span>
                        <span class="puesto-integrante">Desarrollador</span>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="2500">
                    <img class="" src="/files/photos/home_pic3.jpg" alt="">
                    <div class="item-integrante">
                        <p class="palabras-integrante">Tratamos de resolver los problemas con prontitud.
                            En comunicación, tratando de ser agradables y serviciales para usted.
                            Ofrecer siempre nuevas ideas, nuevas formas de desarrollar, mejorar nuestro proyecto son nuestras principales directrices.</p>
                        <span class="nombre-integrante">Matt Dot</span>
                        <span class="puesto-integrante">Desarrollador</span>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carrusel-desarrolladores" data-bs-slide="prev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carrusel-desarrolladores" data-bs-slide="next">

                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

    </section>
    <footer class="footer-acerca">
        <div class="redes-sociales">
            <ul>

                <li><a href="http://facebook.com" class="item-red-social"><i class="fab fa-facebook-square"></i></a></li>
                <li><a href="http://twitter.com" class="item-red-social"><i class="fab fa-twitter-square"></i></a></li>
                <li><a href="http://linkedin.com" class="item-red-social"><i class="fab fa-linkedin"></i></a></li>
            </ul>
        </div>
        <p>&copy; Copyright 2021 SimpleChat - Todos los derechos reservados</p>
</div>
</footer>
<div id="hacia-arriba">
    <i class="fas fa-arrow-up"></i>
</div>


<script type="application/javascript" src="/files/js/About.js"></script>
</body>
</html>
