<?php

	namespace HS\app\view;

	use HS\libs\core\Session;
	use const HS\config\APP_NAME;

	$SESSION = new Session();
	$SESSION_USER_SHORTNAME = $SESSION->user_shortname;
	$SESSION_USER_PROFILE_IMG = $SESSION->user_profile_img;
$SESSION_USER_NAME = $SESSION->user_name;
	unset($SESSION);
?>
<!doctype html>
<html lang="es">
<head>
	<?php require 'template/Head.php' ?>

    <title><?= APP_NAME ?>: Inicio</title>
    <link rel="stylesheet" href="/files/scss/chat.scss">
    <link rel="stylesheet" href="/files/scss/chat-movil.scss">
    <link rel="stylesheet" href="/files/vanillatoasts/vanillatoasts.css">
</head>
<body class=" sb-nav-fixed sb-sidenav-toggled">
<div id="preloader">
    <div id="espacio-temporal" class="no-visible-sm">
        <div class="temporal">
            <div class="cuerpo-temporal align-self-center">
                <img src="/files/img/bg/fondo-tmp.svg" alt="" class="align-self-center">
                <div class="page-loader"><span class="preloader-interior"></span></div>
                <span class="bienvenida">Bienvenido(a) a <?= APP_NAME ?></span>
                <p>Conéctate a SimpleChat desde cualquier dispositivo a través del navegador web de tu
                    preferencia.</p>
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
    </div>
</div>
<!-- Barra superior -->
<header class="header-sitio"><?php require 'template/Header.php' ?></header>
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
            <div id="sin-resultados">
                <span>Mis contactos</span>
            </div>
            <ul id="lista-contactos-buscar" class="no-seleccionable">

            </ul>
            <ul id="lista-contactos" class="no-seleccionable">

            </ul>


        </div>
    </div>
</div>
<!--Fin del contenedor de los contactos para nuevo chat -->

<div id="layoutSidenav">
    <div id="layoutSidenav_nav" class="no-seleccionable">
        <div id="profile">
            <div class="wrap">
                <img id="profile-img" src="<?= $SESSION_USER_PROFILE_IMG ?>?w=80&h=80" class="online" title="<?=$SESSION_USER_NAME?>" alt=""/>
                <div class="usuario-perfil" id="btn-sesion">
                    <span class="material-icons izquierda">account_circle</span>
                    <?= $SESSION_USER_SHORTNAME ?>

                    <div class="usuario-perfil-opciones derecha">
                        <span class="material-icons  ">arrow_drop_down</span>
                    </div>
                </div>
            </div>
        </div>

        <nav class="sb-sidenav " id="LateralMenu">

        <ul class="nav flex-column nav-pills no-seleccionable" id="">
                    <li class="nav-item active">
                        <div class="nav-link" id="seccion-conversaciones">
                            <i class="far fa-comments icon-nav-link"></i>
                            <span>Conversaciones</span>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link align-middle" id="seccion-contactos">
                            <i class="far fa-address-book icon-nav-link"></i>
                            <span>Contactos</span>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link" id="seccion-politicas">
                            <i class="fas fa-file-contract icon-nav-link"></i>
                            Términos y condiciones de uso
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link" id="seccion-acerca">
                            <i class="fas fa-users icon-nav-link"></i>
                            Acerca de nosotros
                        </div>
                    </li>

                    <li class="nav-item">
                        <div class="nav-link" id="seccion-contactanos">
                            <span class="material-icons icon-nav-link">support_agent</span>
                            Contáctanos
                        </div>
                    </li>
                </ul>

        </nav>
        <div class="sb-sidenav-footer">
            SimpleChat
        </div>
    </div>

    <div id="layoutSidenav_content">

                <article id="frame">
                    <div id="sidepanel" class="">

                        <div class="img-perfil no-seleccionable" id="mi-perfil-sidepanel">
                            <img src="<?= $SESSION_USER_PROFILE_IMG ?>?w=50&h=50" title="<?=$SESSION_USER_NAME?>" alt=""/>
                            <div class="usuario-perfil">
								<?= $SESSION_USER_SHORTNAME ?>
                            </div>

                            <div class="usuario-perfil-opciones">
                                <span class="material-icons" title="">arrow_drop_down</span>
                            </div>
                        </div>
                        <div id="search">
                            <label for="inputBuscarConversacion" class="material-icons">search</i></label>
                            <input name="inputBuscarConversacion" type="text" placeholder="Buscar conversación..." id="inputBuscarConversacion"/>
                            <div id="cerrar-busqueda-conversacion"><span class="material-icons">close</span></div>
                        </div>
                        <div id="contacts">
                            <ul class="no-seleccionable" id="lista-conversaciones">

                            </ul>
                            <ul class="no-seleccionable" id="lista-conversaciones-buscar">

                            </ul>
                        </div>
                        <div id="bottom-bar">
                            <button id="nuevo-chat"><img src="/files/icon/nuevo-chat.svg" alt="" id="icon-nuevo-chat"
                                                         class="img-fluid"> <span>Nuevo chat</span></button>
                        </div>
                    </div>

                    <div class="content" id="espacio-de-chat" style="display: none">
                        <div class="contact-profile no-seleccionable">
                            <div class="chat-atras" id="btn-chat-atras"><span class="material-icons">arrow_back</span></div>
                                <img src="/files/profile/undefined-photo.png?w=40&h=40" alt="" class="img-contacto">

                            <div class="chat-conexion">
                                <div class="nombre-chat">Desconocido</div>
                                <div class="ult-conex">Desconocido</div>
                            </div>

                            <div class="opciones-contacto">
                                <div class="btn-agregar-contacto" title="Agregar a contactos">
                                    <span class="material-icons">person_add</span>
                                    Agregar contacto
                                </div>

                            </div>

                            <div class="icon-info-contacto" title="Información del contacto" id="btn-info-contacto">
                                <span class="material-icons">info</span>
                            </div>
                        </div>

                        <div class="messages" onscroll="CambiarUbicacion()">
                            <ul id="lista-mensajes"></ul>
                        </div>
                        <div id="" class="hacia-abajo" style="display: none"><i class="fas fa-angle-double-down"></i> </div>
                        <div class="message-input" id="espacio-de-escritura">
                            <div class="utiles no-seleccionable">
                                <div class="emojis">
                                    <span class="material-icons" id="btn-emojis">sentiment_satisfied_alt</span>
                                </div>

                            </div>
                            <div class="panel-grabando">
                            <div class="indicador-tiempo">
                                <div class="led-recording"></div>
                                <div class="tiempo-transcurrido">1:00</div>

                            </div>
                                <div class="cancelar-grabacion">
                                    <i class="fas fa-trash"></i>
                                </div>
                                <div class="fin-grabacion">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                            </div>
                            <div class="wrap">
                                    <div class="entrada-placeholder">Escribe un mensaje aquí...</div>
                                    <div id="contenido-mensaje" contenteditable="true" spellcheck="true"></div>
                            </div>
                            <button class="btn modo-microfono" id="btn-enviar-mensaje" title="Grabar audio"><!-- <i class="fas fa-paper-plane"></i> --> <i class="fas fa-microphone"></i></button>
                            <input type="file" accept="image/gif,image/jpeg,image/jpg,image/png" id="archivo-imagen-enviar">
                            <div id="icon-archivo-imagen">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>
                    </div>

                    <div class="no-visible-sm" id="espacio-de-configuracion" style="display: none">
                    </div>

                    <div class="" id="panelInfoContacto">
                        <button id="btn-cerrar-contacto"><span class="material-icons">arrow_back</span></button>
                        <div class="contenedor-perfil">
                            <div class="card perfil">
                                <img src="" alt="" class="img-fluid foto-perfil away">

                                <div class="card-body">
                                    <h5></h5>
                                    <h6></h6 >

                                        <small></small>

                                </div>
                                <div class="contacto-redes">

                                </div>

                            </div>
                            <div class=" card contacto-extra">
                                <div class="item-contacto-extra email">
                                    <div class="icon"><i class="fas fa-envelope"></i></div>
                                    <div class="texto">
                                        <h6 class="campo">Correo</h6>
                                        <span class="valor"></span>
                                    </div>

                                </div>
                                <div class="item-contacto-extra tel">
                                    <div class="icon"><i class="fas fa-phone-alt"></i></div>
                                    <div class="texto">
                                    <h6>Teléfono</h6>
                                    <span></span>
                                    </div>
                                </div>
                                <div class="item-contacto-extra fn">
                                    <div class="icon"><i class="fas fa-birthday-cake"></i></div>
                                    <div class="texto">
                                        <h6>Fecha de nacimiento</h6>
                                        <span></span>
                                    </div>
                                </div>
                                <div class="item-contacto-extra sexo">
                                    <div class="icon"><i class="fas fa-male"></i><i class="fas fa-female"></i></div>
                                    <div class="texto">
                                    <h6>Sexo</h6>
                                    <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </article>


    </div>
</div>
<div id="ocultables" style="display: none">
<div class="barra-visible"></div>
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
<script type="text/javascript" src="/files/sweetalert/sweetalert.min.js"></script>
<script type="application/javascript" src="/files/js/Settings.js" defer id="sh-setting"></script>

</body>
</html>
