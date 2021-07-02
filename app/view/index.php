<?php

namespace HS\app\view;

use HS\libs\core\Session;
use const HS\config\APP_NAME;

$SESSION_USER_SHORTNAME = (new Session())->user_shortname;

?>
<!doctype html>
<html lang="es">
<head>
    <?php require 'template/Head.php' ?>

    <title><?= APP_NAME ?>: Inicio</title>
    <link rel="stylesheet" href="/files/scss/chat.scss">
</head>
<body class="d-flex flex-column sb-nav-fixed">
<!-- Barra superior -->
<header><?php require 'template/Header.php' ?></header>
<!-- Fin de barra superior -->

<!-- -------------------------------------------------------------
Contactos cada vez que se vaya a iniciar una nueva conversación
--------------------------------------------------------------- -->
<div id="panelTodosContactos">
    <div id="sidepanelTodosContactos">
        <div class="titulo-cab no-seleccionable">
            <h1>Nuevo chat</h1>
            <div id="ocultar"><span class="material-icons">arrow_back_ios_new</span>
            </div>
        </div>
        <div id="buscar-contacto">
            <label for="cuadro-busqueda-usuario" class="material-icons">search</i></label>
            <input id="cuadro-busqueda-usuario" type="text" placeholder="Buscar" maxlength="100"/>


        </div>
        <div id="listaTodosContactos">
            <ul id="lista-contactos" class="no-seleccionable">

            </ul>
            <ul id="lista-contactos-buscar" class="no-seleccionable">

            </ul>

        </div>
    </div>
</div>

<!--Fin del contenedor de los contactos para nuevo chat -->
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav " >
            <div id="profile">
                <div class="wrap no-seleccionable">
                    <img id="profile-img" src="/files/profile/mikeross.png?w=100&h=100" class="online" alt="" />

                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <button class="accordion-header collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne" id="btn-sesion">
                                <span class="material-icons izquierda">account_circle</span>
                                <?= $SESSION_USER_SHORTNAME ?>
                                <span class="material-icons  derecha">arrow_drop_down</span>
                            </button>

                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <a class="nav-link" href="/Logout">
                                        <span class="material-icons icono-centrado">logout</span>
                                        Cerrar sesión

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <ul class="nav flex-column nav-pills no-seleccionable" id="LateralMenu">
                    <li class="nav-item active">
                        <div class="nav-link" id="seccion-conversaciones">
                            <img src="/files/icon/conversaciones.svg" alt="" class="img-fluid">
                            Conversaciones
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link align-middle" id="seccion-contactos">
                            <img src="/files/icon/contactos.svg" alt="" class="img-fluid link-contactos">
                            Contactos
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link" href="index.html">
                            <img src="/files/icon/nosotros.svg" alt="" class="img-fluid">
                            Acerca de nosotros
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link" href="index.html">
                            <img src="/files/icon/acuerdos.svg" alt="" class="img-fluid">
                            Términos y condiciones de uso
                        </div>
                    </li>
                </ul>
                <div class="sb-sidenav-footer">
                    <div class="small">SimpleChat</div>
                    Start Bootstrap
                </div>

        </nav>


    </div>

    <div id="layoutSidenav_content">
        <main class="container-fluid">
            <div class="row">
                <article id="frame">
                    <div id="sidepanel">

                        <div id="search">
                            <label for="inputBuscarConversacion" class="material-icons">search</i></label>
                            <input name="inputBuscarConversacion" type="text" placeholder="Buscar Conversación..." />
                        </div>
                        <div id="contacts">
                            <ul class="no-seleccionable" id="lista-conversaciones">
                                <!--
                               <li class="contact">
                                   <div class="wrap">
                                       <span class="contact-status online"></span>
                                       <img src="/files/profile/louislitt.png?w=100&h=100" alt="" />
                                       <div class="meta">
                                           <p class="name">Louis Litt</p>
                                           <p class="preview">You just got LITT up, Mike.</p>
                                       </div>
                                   </div>
                               </li>

                               -->
                            </ul>
                        </div>
                        <div id="bottom-bar">
                            <button id="nuevo-chat"><img src="/files/icon/nuevo-chat.svg" alt="" id="icon-nuevo-chat" class="img-fluid"> <span>Nuevo chat</span></button>
                            <button id="agregar-contacto"><img src="/files/icon/agregar-contacto.svg" alt="" id="icon-agregar-contacto"><span>Agregar contacto</span></button>
                        </div>
                    </div>
                    <section class="content" id="espacio-de-chat">
                        <div class="temporal">

                            <div class="cuerpo-temporal align-self-center">
                                <img src="/files/img/bg/fondo-tmp.svg" alt="" class="align-self-center">
                                <span class="bienvenida">Bienvenido(a) a <?= APP_NAME ?></span>
                                <p>Conéctate a SimpleChat desde cualquier dispositivo a través del navegador web de tu preferencia.</p>
                                <hr>
                                <div class="iconos-dispositivos">
                                    <span class="material-icons">desktop_windows</span>
                                    <span class="material-icons">laptop</span>
                                    <span class="material-icons">tablet_android</span>
                                    <span class="material-icons">tablet</span>
                                    <span class="material-icons">smartphone</span>
                                </div>
                            </div>
                        </div>

                        <!-- -->




                    </section>
                    <section class="" id="panelInfoContacto">
                        <button id="btn-cerrar-contacto"><span class="material-icons">close</span></button>
                        <div class="contenedor-perfil">
                            <div class="card perfil">
                                <img src="/files/profile/harveyspecter.png" alt="" class="img-fluid foto-perfil away">

                                <div class="card-body">
                                    <h5>Harvey Specter</h5>
                                    <h6>Abogado</h6>
                                    <small>últ. conex. 18 de may 2021 a la(s) 4:05 p.m.</small>
                                </div>
                                <div class="contacto-redes">

                                </div>

                            </div>
                            <div class=" card contacto-extra">
                                <div class="item-contacto-extra">
                                    <h6 class="campo">Correo</h6>
                                    <span class="valor">harveyspecter@email.com</span>
                                </div>
                                <div class="item-contacto-extra">
                                    <h6>Teléfono</h6>
                                    <span>(EEUU) 6231 445</span>
                                </div>
                                <div class="item-contacto-extra">
                                    <h6>Fecha de nacimiento</h6>
                                    <span>12 de junio de 1970</span>
                                </div>
                                <div class="item-contacto-extra">
                                    <h6>Sexo</h6>
                                    <span>Masculino</span>
                                </div>
                            </div>

                        </div>

                    </section>
                </article>

            </div>


        </main>
    </div>
</div>

<script type="text/javascript" src="/files/js/events.js"></script>
<script type="text/javascript" src="/files/js/Chat.js"></script>
<script type="text/javascript" src="/files/js/Conversations.js"></script>
<script type="application/javascript" src="/files/js/Contacts.js"></script>
</main>
</body>
</html>
