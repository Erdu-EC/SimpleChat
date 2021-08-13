<?php

namespace HS\app\view;

use HS\libs\core\http\HttpResponse;
use HS\libs\core\Session;
use const HS\config\APP_NAME;
?>
<!doctype html>
<html lang="es" xmlns="http://www.w3.org/1999/html">
<head>
    <?php require 'template/Head.php' ?>

    <title><?= APP_NAME ?>: Acerca de nosotros</title>
    <link rel="stylesheet" href="/files/scss/about.scss">
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
            <li class="nav-list-item ">
                <a href="/About" class="nav-link activo">
                    <span class="material-icons">people_outline</span>Sobre Nosotros
                </a>
            </li>
            <li class="nav-list-item">
                <a href="/Contact" class="nav-link">
                    <span class="material-icons"><span class="material-icons-outlined">support_agent</span></span>Contacto
                </a>
            </li>


        </ul>

    </nav>
</header>
<div class="container-fluid">
    <section class="top-acerca">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active align-content-center">
                 <!-- la resolcion de las imagenes es de 4950 px X 2175 para mantener la proporcio a 330x145 px -->
                    <img src="/files/photos/photo-1.jpg" class="d-block img-carousel" alt="...">
                    <div id="filtro">
                        <div class="mensaje-carrousel">

                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/files/photos/photo-2.jpg" class="d-block img-carousel" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/files/photos/photo-3.jpg" class="d-block img-carousel" alt="...">
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
                    <p class="title">Lorem ipsum</p>
                    <p>Lorem ipsum dolor sit amet, consec tetuer adipi scing. Praesent vestibu lum molestie.</p>
                </div>
            </div>

        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="objetivos" >
                <figure><img src="/files/photos/mini-2.svg" alt=""></figure>
                <div class="cuerpo-objetivos">
                    <p class="title">Lorem ipsum</p>
                    <p>Lorem ipsum dolor sit amet, consec tetuer adipi scing. Praesent vestibu lum molestie.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="objetivos" >
                <figure><img src="/files/photos/mini-3.svg" alt=""></figure>
                <div class="cuerpo-objetivos">
                    <p class="title">Lorem ipsum</p>
                    <p>Lorem ipsum dolor sit amet, consec tetuer adipi scing. Praesent vestibu lum molestie.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="objetivos" >
                <figure><img src="/files/photos/mini-4.svg" alt=""></figure>
                <div class="cuerpo-objetivos">
                    <p class="title">Lorem ipsum</p>
                    <p>Lorem ipsum dolor sit amet, consec tetuer adipi scing. Praesent vestibu lum molestie.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
     <section class="bottom-acerca">
         <div class="row">
             <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 cont-caracteristicas"><article class="caracteristicas">
                     <div class="icon-caract">
                         <img src="/files/photos/about-caract-1.svg" alt="">
                     </div>
                     <span>Creatividad</span>
                     <p class="descrip-caract"></p>
                 </article></div>
             <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 cont-caracteristicas"><article class="caracteristicas">
                     <div class="icon-caract">
                         <img src="/files/photos/about-caract-2.svg" alt="">
                     </div>
                     <span>Creatividad</span>
                     <p class="descrip-caract" ></p>
                 </article></div>
             <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 cont-caracteristicas"><article class="caracteristicas">
                     <div class="icon-caract">
                         <img src="/files/photos/about-caract-1.svg" alt="">
                     </div>
                     <span>Creatividad</span>
                     <p class="descrip-caract"></p>
                 </article></div>

         </div>


       <div class="row">
           <article class="col-xl-4 col-lg-4 col-md-6 col-sm-12 seccion-ultimo">
               <h2>Ultimas noticias</h2>
               <ul class="lista-noticias">
                   <li>
                       <time datetime="20.09.2015">20.09.2015</time>
                       <p class="subtitulo">Lorem ipsum dolor sit amet, consec teer adipiscing. Prsent vestibulum.</p>
                       <p>Lorem ipsum dolor sit amet, consec tetuer adipi scing. Praesent vestibu.  lum molestie lacuiirhs. Aenean non ummy hendreriauris. Phasellllus.</p>
                             </li>
                   <li>
                       <time datetime="09.09.2015">09.09.2015</time>
                       <p class="subtitulo">Lorem ipsum dolor sit amet, consec teer adipiscing. Prsent vestibulum.</p>
                       <p>Lorem ipsum dolor sit amet, consec tetuer adipi scing. Praesent vestibu.  lum molestie lacuiirhs. Aenean non ummy hendreriauris. Phasellllus.</p>
                   </li>
               </ul>
               <hr class="separador-secciones">
           </article>
           <article class="col-xl-4 col-lg-4 col-md-6 col-sm-12 seccion-benvenida">
               <h2>Bienvenido(a)</h2>
               <p class="subtitulo">Fusce suscipit varius mium sociis totdnatibus et magis dis parturient montes, nascetur ridiculus mus. </p>
               <p class="descrip">Lorem ipsum dolor sit amet, consec teer adipiscing. Prsent vestibulum molestie lacuiirhs. Aeneon my . Phasellllus. porta. Fusce suscipit varius mium sociis.</p>
               <p>Lorem ipsum dolor sit amet, consec tetuer adipiscing. Praesent vestibu lum molestie lacuiirhs. Aenean non ummy hendreriauris. Phasellllus. porta. Fusce suscipit varius mium sociis totdnatibus et magis dis parturient montes, nascetur ridiculus mus. Nulla dui.</p>

               <hr class="separador-secciones">
           </article>
           <article class="col-xl-4 col-lg-4 col-md-6 col-sm-12  seccion-desarrolladores">
               <h2>Nuestros desarrolladores</h2>
               <p class="subtitulo">Lorem ipsum dolor sit amet, consec teer adipiscing. Prsent vestibulum mo.</p>
               <ul class="lista-desarrolladores">
                   <li>
                       <div class="item-desarrollador">
                           <figure class="foto-desarrollador"><img src="/files/photos/home_pic1.jpg" alt=""></figure>
                           <div class="descr-desarrollador">
                               <span class="nombre-desarrollador">Lorem Ipsum</span>
                               <p>Consec tetuer adipiscing. Praesent vestibu.</p>
                           </div>
                       </div>
                   </li>
                   <li>
                       <div class="item-desarrollador">
                           <figure class="foto-desarrollador"><img src="/files/photos/home_pic2.jpg" alt=""></figure>
                           <div class="descr-desarrollador">
                               <span class="nombre-desarrollador">Dolor set amet</span>
                               <p>Aenean non ummy hendreria uris. Phasellllu porta. </p>
                           </div>
                       </div>
                   </li>
                   <li>
                       <div class="item-desarrollador">
                           <figure class="foto-desarrollador"><img src="/files/photos/home_pic3.jpg" alt=""></figure>
                           <div class="descr-desarrollador">
                               <span class="nombre-desarrollador"></span>
                               <p>Praesent vestiblum molestie lacuiirhs. Aenean non ummy. </p>
                           </div>
                       </div>

                   </li>
               </ul>
               <hr class="separador-secciones">
           </article>
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
