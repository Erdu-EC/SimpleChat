<?php

namespace HS\app\view;

use const HS\config\APP_NAME;

?>

<!doctype html>
<html lang="es">
<head>
    <?php require 'template/Head.php' ?>

    <title><?= APP_NAME ?>: Inicio</title>
    <link rel="stylesheet" href="/files/scss/chat.scss">
</head>
<body class="d-flex flex-column sb-nav-fixed">
<!-- Barra superior

<nav class="sb-topnav navbar navbar-expand " id="barra-superior">

    <button class="btn nav-item" id="sidebarToggle">
        <img src="/files/icon/menu.png" alt="" class="" id="icono-sidebarToggle">
    </button>
    <a class="navbar-brand " href="/" >
        <img src="/files/icon/logo.png" alt="" id="logo-home" class="img img-fluid">

    </a>
</nav>
Fin de barra superior -->

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
            <label for="inputBuscarConversacion" class="material-icons">search</i></label>
            <input name="inputBuscarConversacion" type="text" placeholder="Buscar" maxlength="100"/>
        </div>
        <div id="listaTodosContactos">
            <ul id="listacontactos" class="no-seleccionable">

                <li class="item-contacto">
                    <div class="card  align-content-between">
                        <div class="row">
                            <div class="col-4 perfil-contacto color-5">
                                <img src="/files/profile/rachelzane.png?w=90&h=90" alt="" class="online"/>
                            </div>
                            <div class="col-8 ">
                                <div class="card-body">
                                    <h5 class="card-title">Rachel Zane</h5>
                                    <p class="cont-usuario"><span class="material-icons usuario">person</span>rachelzane</p>
                                    <div class="btn-opciones">

                                        <span class="material-icons mensaje">message</span>
                                        <span class="material-icons eliminar">delete</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </li>
                <li class="item-contacto">
                    <div class="card  align-content-between">
                        <div class="row">
                            <div class="col-4 perfil-contacto color-5">
                                <img src="/files/profile/donnapaulsen.png?w=90&h=90" alt="" class="online"/>
                            </div>
                            <div class="col-8 ">
                                <div class="card-body">
                                    <h5 class="card-title">Donna Paulsen</h5>
                                    <p class="cont-usuario"><span class="material-icons usuario">person</span>donnapaulsen</p>
                                    <div class="btn-opciones">

                                        <span class="material-icons mensaje">message</span>
                                        <span class="material-icons eliminar">delete</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </li>
                <li class="item-contacto">
                    <div class="card  align-content-between">
                        <div class="row">
                            <div class="col-4 perfil-contacto color-5">
                                <img src="/files/profile/jessicapearson.png?w=90&h=90" alt="" class="online"/>
                            </div>
                            <div class="col-8 ">
                                <div class="card-body">
                                    <h5 class="card-title">Jessica Pearson</h5>
                                    <p class="cont-usuario"><span class="material-icons usuario">person</span>jessicapearson</p>
                                    <div class="btn-opciones">

                                        <span class="material-icons mensaje">message</span>
                                        <span class="material-icons eliminar">delete</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="btn-mas">
                            <span class="material-icons align-baseline mas">chevron_right</span>
                        </div>
                    </div>
                </li>
                <li class="item-contacto">
                    <div class="card  align-content-between">
                        <div class="row">
                            <div class="col-4 perfil-contacto color-5">
                                <img src="/files/profile/haroldgunderson.png?w=90&h=90" alt="" class="online"/>
                            </div>
                            <div class="col-8 ">
                                <div class="card-body">
                                    <h5 class="card-title">Harold Gunderson Harold Gunderson</h5>
                                    <p class="cont-usuario"><span class="material-icons usuario">person</span>haroldgundersonharoldgunderson</p>
                                    <div class="btn-opciones">

                                        <span class="material-icons mensaje">message</span>
                                        <span class="material-icons eliminar">delete</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="btn-mas">
                            <span class="material-icons align-baseline mas">chevron_right</span>
                        </div>
                    </div>
                </li>
                <li class="item-contacto">
                    <div class="card  align-content-between">
                        <div class="row">
                            <div class="col-4 perfil-contacto color-5">
                                <img src="/files/profile/danielhardman.png?w=90&h=90" alt="" class="online"/>
                            </div>
                            <div class="col-8 ">
                                <div class="card-body">
                                    <h5 class="card-title">Daniel Hardman</h5>

                                    <p class="cont-usuario"><span class="material-icons usuario">person</span>danielhardman</p>
                                    <div class="btn-opciones">

                                        <span class="material-icons mensaje">message</span>
                                        <span class="material-icons eliminar">delete</span>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="btn-mas">
                            <span class="material-icons align-baseline mas">chevron_right</span>
                        </div>
                    </div>
                </li>
                <li class="item-contacto">
                    <div class="card">
                        <div class="row align-content-between">
                            <div class="col-4 perfil-contacto color-6">
                                <img src="/files/profile/katrinabennett.png?w=90&h=90" alt="" class="online"/>
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <h5 class="card-title">Katrina Bennett</h5>

                                    <p class="cont-usuario"><span class="material-icons usuario">person</span>katrinabennett</p>
                                    <div class="btn-opciones">

                                        <span class="material-icons mensaje">message</span>
                                        <span class="material-icons eliminar">delete</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="btn-mas">
                            <span class="material-icons align-baseline mas ">chevron_right</span>
                        </div>
                    </div>
                </li>
                <li class="item-contacto">
                    <div class="card  align-content-between">
                        <div class="row">
                            <div class="col-4 perfil-contacto color-5">
                                <img src="/files/profile/danielhardman.png?w=90&h=90" alt="" class="online"/>
                            </div>
                            <div class="col-8 ">
                                <div class="card-body">
                                    <h5 class="card-title">Daniel Hardman</h5>

                                    <p class="cont-usuario"><span class="material-icons usuario">person</span>danielhardman</p>
                                    <div class="btn-opciones">

                                        <span class="material-icons mensaje">message</span>
                                        <span class="material-icons eliminar">delete</span>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="btn-mas">
                            <span class="material-icons align-baseline mas">chevron_right</span>
                        </div>
                    </div>
                </li>
            </ul>


        </div>
    </div>
</div>

<!--Fin del contenedor de los contactos para nuevo chat -->



<!--
<header><php require 'template/Header.php' ?></header>

<main class="container-fluid d-flex flex-grow-1">
    <div class="row pt-2 pb-3 ps-4 pe-4 d-flex flex-grow-1">
        <div class="col-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="d-flex align-items-center mb-0 user-select-none">
                        <i class="material-icons me-2">email</i>
                        <span>Conversaciones</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 id="alerta-conversaciones" class="text-secondary">
                                Cargando conversaciones...
                            </h6>
                        </div>
                    </div>

                    <ul id="lista-conversaciones" class="list-group list-group-flush">
                       Las conversaciónes con tus contactos apareceran en esta
                        lista.-->
<!--
                    </ul>
                </div>
            </div>
        </div>
        <div id="espacio-de-chat" class="col-8"> -->
            <!-- AQUI SE CARGARA EL HISTORIAL DE CHAT DEL CONTACTO
        </div>
    </div>
-->
<script type="text/javascript" src="/files/js/events.js"></script>
<script type="text/javascript" src="/files/js/Chat.js"></script>
<script type="text/javascript" src="/files/js/Conversations.js"></script>
</main>
</body>
</html>
