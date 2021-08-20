<?php

namespace HS\app\view;

use HS\libs\core\Session;
use const HS\config\APP_NAME;

$SESSION = new Session();
$SESSION_USER_SHORTNAME = $SESSION->user_shortname;
$SESSION_USER_PROFILE_IMG = $SESSION->user_profile_img;
unset($SESSION);
?>
<!doctype html>
<html lang="es">
<head>
    <?php require 'template/Head.php' ?>

    <title><?= APP_NAME ?>: Inicio</title>
    <link rel="stylesheet" href="/files/scss/chat.scss">
    <link rel="stylesheet" href="/files/vanillatoasts/vanillatoasts.css">
</head>
<body class="d-flex flex-column sb-nav-fixed sb-sidenav-toggled">
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
            <div id="ocultar"><span class="material-icons">arrow_back</span>
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
                    <img id="profile-img" src="<?= $SESSION_USER_PROFILE_IMG ?>?w=100&h=100" class="online" alt="" />

                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <button class="accordion-header collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne" id="btn-sesion">
                                <span class="material-icons izquierda">account_circle</span>
                                <?= $SESSION_USER_SHORTNAME ?>
                                <span class="material-icons  derecha">arrow_drop_down</span>
                            </button>

                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="item-accordion-body">
                                        <button class="nav-link" id="btn-configuraciones" >
                                           <span class="material-icons">settings</span>
                                            Configuraciones

                                        </button>
                                    </div>
                                    <div class="item-accordion-body">
                                        <a class="nav-link" href="/Logout">
                                            <span class="material-icons icono-centrado">logout</span>
                                            Cerrar sesión

                                        </a>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <ul class="nav flex-column nav-pills no-seleccionable" id="LateralMenu">
                    <li class="nav-item active">
                        <div class="nav-link" id="seccion-conversaciones">
                            <i class="far fa-comments icon-nav-link"></i>
                           <!--  <img src="/files/icon/conversaciones.svg" alt="" class="img-fluid">-->
                          <span>Conversaciones</span>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link align-middle" id="seccion-contactos">
                            <i class="far fa-address-book icon-nav-link"></i> <!--
                            <img src="/files/icon/contactos.svg" alt="" class="img-fluid link-contactos">-->
                           <span>Contactos</span>

                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link" id="seccion-acerca">
                            <i class="fas fa-users icon-nav-link"></i>
                            <!-- <img src="/files/icon/nosotros.svg" alt="" class="img-fluid"> -->
                            Acerca de nosotros
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link" id="seccion-politicas">
                            <i class="fas fa-file-contract icon-nav-link"></i>
                            <!--
                            <img src="/files/icon/acuerdos.svg" alt="" class="img-fluid">       -->
                            Términos y condiciones de uso
                        </div>
                    </li>
                </ul>

        </nav>
        <div class="sb-sidenav-footer">

            SimpleChat
        </div>


    </div>

    <div id="layoutSidenav_content">
        <main class="container-fluid">
            <div class="row">
                <article id="frame">
                    <div id="sidepanel">

                        <div class="img-perfil no-seleccionable" id="mi-perfil-sidepanel">
                            <img src="<?= $SESSION_USER_PROFILE_IMG?>?w=100&h=100" alt="" />
                            <div class="usuario-perfil">
                                <?= $SESSION_USER_SHORTNAME ?>
                            </div>

<div class="usuario-perfil-opciones">
    <span class="material-icons" title="">arrow_drop_down</span>
</div>
<div class="opciones-sesion inactivo">
    <div class="item-opciones-sesion " id="btn-conf-sesion">

        <div title="Configuraciones de cuenta" class="opc-sesion">
            <span class="material-icons">settings</span>
            <p>Configuraciones</p>
        </div>
    </div>

    <div class="item-opciones-sesion ">
    <a href="/Logout" class="opc-sesion">
        <span class="material-icons" title="Cerrar sesión">logout</span>
        <p>Cerrar sesión</p>
    </a>
</div>

</div>
                        </div>
                        <div id="search">
                            <label for="inputBuscarConversacion" class="material-icons">search</i></label>
                            <input name="inputBuscarConversacion" type="text" placeholder="Buscar Conversación..." />
                        </div>
                        <div id="contacts">
                            <ul class="no-seleccionable" id="lista-conversaciones">

                            </ul>
                        </div>
                        <div id="bottom-bar">
                            <button id="nuevo-chat"><img src="/files/icon/nuevo-chat.svg" alt="" id="icon-nuevo-chat" class="img-fluid"> <span>Nuevo chat</span></button>

                            <!-- <button id="agregar-contacto"><img src="/files/icon/agregar-contacto.svg" alt="" id="icon-agregar-contacto"><span>Agregar contacto</span></button>-->
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
                                    <small></small>
                                </div>
                                <div class="contacto-redes">

                                </div>

                            </div>
                           <div class=" card contacto-extra">
                                <div class="item-contacto-extra email">
                                    <h6 class="campo">Correo</h6>
                                    <span class="valor"></span>
                                </div>
                                <div class="item-contacto-extra tel">
                                    <h6>Teléfono</h6>
                                    <span></span>
                                </div>
                                <div class="item-contacto-extra fn">
                                    <h6>Fecha de nacimiento</h6>
                                    <span></span>
                                </div>
                                <div class="item-contacto-extra sexo">
                                    <h6>Sexo</h6>
                                    <span></span>
                                </div>
                            </div>
                            <!--
-->
                        </div>

                    </section>
                </article>

            </div>


        </main>
    </div>
</div>

<script type="application/javascript" src="/files/js/chat/MsgItems.js"></script>

<script type="application/javascript" src="/files/js/emojis.min.js"></script>
<script type="text/javascript" src="/files/js/events.js"></script>
<script type="text/javascript" src="/files/js/notifications.js"></script>
<script type="text/javascript" src="/files/js/Chat.js"></script>
<script type="text/javascript" src="/files/js/Conversations.js"></script>
<script type="application/javascript" src="/files/js/Contacts.js"></script>
<script type="application/javascript" src="/files/js/Instant.js"></script>

<script type="application/javascript" src="/files/vanillatoasts/vanillatoasts.js"></script>


</body>
</html>
