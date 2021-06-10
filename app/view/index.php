<?php

namespace HS\app\view;

use const HS\config\APP_NAME;

?>

<!doctype html>
<html lang="es">
<head>
    <?php require 'template/Head.php' ?>
    <?php
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
    ?>
    <title><?= APP_NAME ?>: Chats</title>
    <link rel="stylesheet" href="/files/scss/chat.scss">
    <meta http-equiv="Expires" content="0">
</head>
<body class="sb-nav-fixed">

<nav class="sb-topnav navbar navbar-expand " id="barra-superior">

    <button class="btn nav-item" id="sidebarToggle">
        <img src="/files/icon/menu.png" alt="" class="" id="icono-sidebarToggle">
    </button>
    <a class="navbar-brand " href="/" >
        <img src="/files/icon/logo-2.png" alt="" id="logo-home" class="img img-fluid">

    </a>



</nav>
<!--
-------------------------------------------------------------
El siguiente DIV se muestra con los contactos cada vez que se vaya a iniciar una nueva conversacion
------------------
-->
<div id="panelTodosContactos">
    <div id="sidepanelTodosContactos">
        <div class="titulo-cab no-seleccionable">
        <h1>Nuevo chat</h1>
        <div id="ocultar"><span class="material-icons">arrow_back_ios_new
</span></div>
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
                                <img src="/files/upload/profile/rachelzane.png?w=90&h=90" alt="" class="online"/>
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
                                <img src="/files/upload/profile/donnapaulsen.png?w=90&h=90" alt="" class="online"/>
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
                                <img src="/files/upload/profile/jessicapearson.png?w=90&h=90" alt="" class="online"/>
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
                                <img src="/files/upload/profile/haroldgunderson.png?w=90&h=90" alt="" class="online"/>
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
                                <img src="/files/upload/profile/danielhardman.png?w=90&h=90" alt="" class="online"/>
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
                                <img src="/files/upload/profile/katrinabennett.png?w=90&h=90" alt="" class="online"/>
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
                                <img src="/files/upload/profile/danielhardman.png?w=90&h=90" alt="" class="online"/>
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




<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav " >
            <div id="profile">
                <div class="wrap no-seleccionable">
                    <img id="profile-img" src="/files/upload/profile/mikeross.png?w=100&h=100" class="online" alt="" />

                    <div class="accordion accordion-flush ">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Mike Ross
                                </button>
                            </h2>

                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <a class="nav-link btn" href="/Logout">
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
                            <img src="/files/icon/conversaciones-1.png?w=40&h=40" alt="" class="img-fluid">
                            Conversaciones
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link align-middle" id="seccion-contactos">
                            <img src="/files/icon/contactos-2.png?w=40&h=40" alt="" class="img-fluid link-contactos">
                            Contactos
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link" href="index.html">
                            <img src="/files/icon/nosotros.png?w=40&h=40" alt="" class="img-fluid">
                            Acerca de nosotros
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link" href="index.html">
                            <img src="/files/icon/acuerdos.png?w=40&h=40" alt="" class="img-fluid">
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
                <div id="frame">
                    <div id="sidepanel">

                         <div id="search">
                             <label for="inputBuscarConversacion" class="material-icons">search</i></label>
                             <input name="inputBuscarConversacion" type="text" placeholder="Buscar Conversación..." />
                         </div>
                         <div id="contacts">
                             <ul class="no-seleccionable">
                                 <li class="contact">
                                     <div class="wrap">
                                         <span class="contact-status online"></span>
                                         <img src="/files/upload/profile/louislitt.png?w=100&h=100" alt="" />
                                         <div class="meta">
                                             <p class="name">Louis Litt</p>
                                             <p class="preview">You just got LITT up, Mike.</p>
                                         </div>
                                     </div>
                                 </li>
                                 <li class="contact active">
                                     <div class="wrap">
                                         <span class="contact-status busy"></span>
                                         <img src="/files/upload/profile/harveyspecter.png?w=100&h=100" alt="" />
                                         <div class="meta">
                                             <p class="name">Harvey Specter</p>
                                             <p class="preview">Wrong. You take the gun, or you pull out a bigger one. Or, you call their bluff. Or, you do any one of a hundred and forty six other things.</p>
                                         </div>
                                     </div>
                                 </li>
                                 <li class="contact">
                                     <div class="wrap">
                                         <span class="contact-status away"></span>
                                         <img src="/files/upload/profile/rachelzane.png?w=100&h=100" alt="" />
                                         <div class="meta">
                                             <p class="name">Rachel Zane</p>
                                             <p class="preview">I was thinking that we could have chicken tonight, sounds good?</p>
                                         </div>
                                     </div>
                                 </li>
                                 <li class="contact">
                                     <div class="wrap">
                                         <span class="contact-status online"></span>
                                         <img src="/files/upload/profile/donnapaulsen.png?w=100&h=100" alt="" />
                                         <div class="meta">
                                             <p class="name">Donna Paulsen</p>
                                             <p class="preview">Mike, I know everything! I'm Donna..</p>
                                         </div>
                                     </div>
                                 </li>
                                 <li class="contact">
                                     <div class="wrap">
                                         <span class="contact-status busy"></span>
                                         <img src="/files/upload/profile/jessicapearson.png?w=100&h=100" alt="" />
                                         <div class="meta">
                                             <p class="name">Jessica Pearson</p>
                                             <p class="preview">Have you finished the draft on the Hinsenburg deal?</p>
                                         </div>
                                     </div>
                                 </li>
                                 <li class="contact">
                                     <div class="wrap">
                                         <span class="contact-status"></span>
                                         <img src="/files/upload/profile/haroldgunderson.png?w=100&h=100" alt="" />
                                         <div class="meta">
                                             <p class="name">Harold Gunderson</p>
                                             <p class="preview">Thanks Mike! :)</p>
                                         </div>
                                     </div>
                                 </li>
                                 <li class="contact">
                                     <div class="wrap">
                                         <span class="contact-status"></span>
                                         <img src="/files/upload/profile/danielhardman.png?w=100&h=100" alt="" />
                                         <div class="meta">
                                             <p class="name">Daniel Hardman</p>
                                             <p class="preview">We'll meet again, Mike. Tell Jessica I said 'Hi'.</p>
                                         </div>
                                     </div>
                                 </li>
                                 <li class="contact">
                                     <div class="wrap">
                                         <span class="contact-status busy"></span>
                                         <img src="/files/upload/profile/katrinabennett.png?w=100&h=100" alt="" />
                                         <div class="meta">
                                             <p class="name">Katrina Bennett</p>
                                             <p class="preview">I've sent you the files for the Garrett trial.</p>
                                         </div>
                                     </div>
                                 </li>
                                 <li class="contact">
                                     <div class="wrap">
                                         <span class="contact-status"></span>
                                         <img src="/files/upload/profile/charlesforstman.png?w=100&h=100" alt="" />
                                         <div class="meta">
                                             <p class="name">Charles Forstman</p>
                                             <p class="preview">Mike, this isn't over.</p>
                                         </div>
                                     </div>
                                 </li>
                                 <li class="contact">
                                     <div class="wrap">
                                         <span class="contact-status"></span>
                                         <img src="/files/upload/profile/jonathansidwell.png?w=100&h=100" alt="" />
                                         <div class="meta">
                                             <p class="name">Jonathan Sidwell</p>
                                             <p class="preview"><span>You:</span> That's bullshit. This deal is solid.</p>
                                         </div>
                                     </div>
                                 </li>
                             </ul>
                         </div>
                         <div id="bottom-bar">
                             <button id="nuevo-chat"><img src="/files/icon/nuevo-chat.png" alt="" id="icon-nuevo-chat" class="img-fluid"> <span>Nuevo chat</span></button>
                             <button id="agregar-contacto"><img src="/files/icon/agregar-contacto.png" alt="" id="icon-agregar-contacto"><span>Agregar contacto</span></button>
                         </div>
                     </div>
                     <section class="content" id="contenido">
                         <section class="contact-profile no-seleccionable">
                             <img src="/files/upload/profile/harveyspecter.png?w=100&h=100" alt="" />
                             <p>Harvey Specter</p>
                             <div class="opciones-contacto">
                                 <div class="btn-agregar-contacto" title="Agregar a contactos" ><span class="material-icons">person_add</span>
                                 Agregar contacto
                                 </div>
                                 <hr class="separador-vertical">
                                 <div class="btn-bloquear-contacto" title="Bloquear">
                                     <span class="material-icons">block</span>
                                     Bloquear

                                 </div>
                             </div>
                             <div class="icon-info-contacto" title="Información del contacto" id="btn-info-contacto">
                                 <span class="material-icons">info</span>
                             </div>

                         </section>
                         <div class="messages">
                             <ul id="lista-mensajes">

                                 <li class="sent">
                                     <img src="/files/upload/profile/mikeross.png?w=100&h=100" alt="" />
                                     <p>How the hell am I supposed to get a jury to believe you when I am not even sure that I do?!</p>
                                 </li>
                                 <li class="replies">
                                     <img src="/files/upload/profile/harveyspecter.png?w=100&h=100" alt="" />
                                     <p>When you're backed against the wall, break the god damn thing down.</p>
                                 </li>
                                 <li class="replies">
                                     <img src="/files/upload/profile/harveyspecter.png?w=100&h=100" alt="" />
                                     <p>Excuses don't win championships.</p>
                                 </li>
                                 <li class="sent">
                                     <img src="/files/upload/profile/mikeross.png?w=100&h=100" alt="" />
                                     <p>Oh yeah, did Michael Jordan tell you that?</p>
                                 </li>
                                 <li class="replies">
                                     <img src="/files/upload/profile/harveyspecter.png?w=100&h=100" alt="" />
                                     <p>No, I told him that.</p>
                                 </li>
                                 <li class="replies">
                                     <img src="/files/upload/profile/harveyspecter.png?w=100&h=100" alt="" />
                                     <p>What are your choices when someone puts a gun to your head?</p>
                                 </li>
                                 <li class="sent">
                                     <img src="/files/upload/profile/mikeross.png" alt="" />
                                     <p>What are you talking about? You do what they say or they shoot you.</p>
                                 </li>
                                 <li class="replies">
                                     <img src="/files/upload/profile/harveyspecter.png" alt="" />
                                     <p>Wrong. You take the gun, or you pull out a bigger one. Or, you call their bluff. Or, you do any one of a hundred and forty six other things.</p>
                                 </li>
                             </ul>
                         </div>
                         <div class="message-input">
                             <div class="wrap">
                                 <input type="text" placeholder="Escribe un mensage aquí..." />
                                 <button class=" btn" id="btn-enviar-mensaje"><span class="material-icons me-2">send</span></button>
                             </div>
                         </div>
                     </section>

                     <section class="" id="panelInfoContacto">
                         <button id="btn-cerrar-contacto"><span class="material-icons">close</span></button>
                        <!--
                         <div class="card">
                             <div class="row">
                                 <div class="col-6 contact-info-img align-content-end" >
                                     <img src="/files/upload/profile/harveyspecter.png" alt="" class="img-fluid foto-perfil">
                                 </div>
                                 <div class="col-6 contact-info-primaria align-content-start">
                                     <h4>Harvey Specter</h4>
                                     <h5>Abogado</h5>
                                 </div>
                                 <div class="col-6 contact-info-redes align-content-end">
                                     <h6>Nombre completo: </h6>
                                     <h7>Email: </h7>
                                     <h7>Teléfono:</h7>
                                     <h7>País:</h7>

                                 </div>
                                 <div class="col-6 contact-info-secundaria align-content-start"></div>

                             </div>

                         </div>
-->
                         <div class="card perfil">
                             <img src="/files/upload/profile/harveyspecter.png" alt="" class="img-fluid foto-perfil">

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
                         </div>
                     </section>

                 </article>



             </div>

         </main>
     </div>



 </div>
 <script type="text/javascript" src="/files/js/chats.js"></script>
 </body>
 </html>
