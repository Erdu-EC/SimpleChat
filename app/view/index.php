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
            <div id="sin-resultados">
            </div>

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
        <nav class="sb-sidenav ">
            <div id="profile">
                <div class="wrap no-seleccionable">
                    <img id="profile-img" src="<?= $SESSION_USER_PROFILE_IMG ?>?w=100&h=100" class="online" alt=""/>

                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <button class="accordion-header collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne" id="btn-sesion">
                                <span class="material-icons izquierda">account_circle</span>
								<?= $SESSION_USER_SHORTNAME ?>
                                <span class="material-icons  derecha">arrow_drop_down</span>
                            </button>

                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                 aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="item-accordion-body">
                                        <button class="nav-link" id="btn-configuraciones">
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
                        <div class="nav-link" id="seccion-acerca">
                            <i class="fas fa-users icon-nav-link"></i>
                            Acerca de nosotros
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link" id="seccion-politicas">
                            <i class="fas fa-file-contract icon-nav-link"></i>
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
        <div class="container-fluid">
            <div class="row">
                <article id="frame">
                    <section id="sidepanel" class="no-visible-sm">

                        <div class="img-perfil no-seleccionable" id="mi-perfil-sidepanel">
                            <img src="<?= $SESSION_USER_PROFILE_IMG ?>?w=100&h=100" alt=""/>
                            <div class="usuario-perfil">
								<?= $SESSION_USER_SHORTNAME ?>
                            </div>

                            <div class="usuario-perfil-opciones">
                                <span class="material-icons" title="">arrow_drop_down</span>
                            </div>
                        </div>
                        <div id="search">
                            <label for="inputBuscarConversacion" class="material-icons">search</i></label>
                            <input name="inputBuscarConversacion" type="text" placeholder="Buscar Conversación..."/>
                        </div>
                        <div id="contacts">
                            <ul class="no-seleccionable" id="lista-conversaciones">

                            </ul>
                        </div>
                        <div id="bottom-bar">
                            <button id="nuevo-chat"><img src="/files/icon/nuevo-chat.svg" alt="" id="icon-nuevo-chat"
                                                         class="img-fluid"> <span>Nuevo chat</span></button>
                        </div>
                    </section>
                    <section id="espacio-temporal">
                        <div class="temporal">
                            <div class="cuerpo-temporal align-self-center">
                                <img src="/files/img/bg/fondo-tmp.svg" alt="" class="align-self-center">
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
                    </section>

                    <section class="content" id="espacio-de-chat" style="display: none">
                        <section class="contact-profile no-seleccionable">
                            <div class="chat-atras" id="btn-chat-atras"><span class="material-icons">arrow_back</span></div>
                                <img src="/files/profile/undefined-photo.png?w=40&h=40" alt="" class="img-contacto">

                            <div class="chat-conexion">
                                <span class="nombre-chat">Desconocido</span>
                                <span class="ult-conex">Desconocido</span>
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
                        </section>

                        <div class="messages">

                            <ul id="lista-mensajes"></ul>

                        </div>

                        <div class="message-input" id="espacio-de-escritura">
                            <div class="utiles">
                                <div class="emojis">
                                    <span class="material-icons" id="btn-emojis">sentiment_satisfied_alt</span>

                                </div>

                            </div>
                            <div class="wrap">
                                <label for="contenido-mensaje" style="display: none"></label>
                                <input id="contenido-mensaje" type="text" placeholder="Escribe un mensage aquí..."/>

                                <button class=" btn" id="btn-enviar-mensaje"><span class="material-icons me-2">send</span></button>
                            </div>
                            <input type="file" accept="image/gif,image/jpeg,image/jpg,image/png" id="archivo-imagen-enviar">
                            <div id="icon-archivo-imagen">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>
                    </section>

                    <section class="content" id="espacio-de-configuracion" style="display: none">
                    </section>

                    <section class="" id="panelInfoContacto">
                        <button id="btn-cerrar-contacto"><span class="material-icons">close</span></button>
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

                    </section>
                </article>
            </div>
        </div>
    </div>
</div>

 <script type="text/javascript" charset="utf-8">
        (function() {
        function size() {

            if (/Android|webos|iphone|ipad|iPod|blackberry|nokia|opera mini|opera mobi|skyfire|maemo|windows phone|Palm|iemobile|symbian|symbianos|fennec/i.test(navigator.userAgent.toLowerCase())) {
                var theminheight = Math.min(document.documentElement.clientHeight, window.screen.height, window.innerHeight);

                $('#frame').css('height', theminheight);
                console.log(theminheight);
            }
        }
        window.addEventListener('resize orientationchange', function() {
        size();
    }, false);
        size();
    }());
</script>
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
