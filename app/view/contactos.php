<?php namespace HS\app\view\template;
use HS\libs\core\http\HttpResponse;
use HS\libs\core\Session;
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
    <link rel="stylesheet" href="/files/scss/contactos.scss">

</head>
<body class="sb-nav-fixed">

<nav class="sb-topnav navbar navbar-expand " id="barra-superior">

    <button class="btn nav-item" id="sidebarToggle">
        <img src="/files/icon/menu.png" alt="" class="" id="icono-sidebarToggle">
    </button>
    <a class="navbar-brand " href="index.php" >
        <img src="/files/icon/logo-2.png" alt="" id="logo-home" class="img img-fluid">
    </a>



</nav>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav " >
            <div id="profile">
                <div class="wrap">
                    <img id="profile-img" src="/files/upload/profile/mikeross.png?w=100&h=100" class="online" alt="" />

                    <div class="accordion accordion-flush">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Mike Ross
                                </button>
                            </h2>

                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <a class="nav-link btn" >
                                        Cerrar sesión
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <ul class="nav flex-column nav-pills " id="LateralMenu">
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

    <section id="layoutSidenav_content">
        <main class="container-fluid">
            <div class="row">
                <div id="frame">
                    <div id="sidepanel">
                        <h1>Contactos</h1>
                        <div id="buscar-contacto">
                            <label for="inputBuscarConversacion" class="material-icons">search</i></label>
                            <input name="inputBuscarConversacion" type="text" placeholder="Buscar" maxlength="100"/>
                        </div>
                        <div id="listaTodosContactos">
                            <ul id="listacontactos">
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
                                        <div class="btn-mas">
                                            <span class="material-icons align-baseline mas">chevron_right</span>
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
                                        <div class="btn-mas">
                                            <span class="material-icons align-baseline mas">chevron_right</span>
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
                    <section class="content" id="contenido">
                        <div class="perfil-contacto container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <article class="card" id="ful-perfil-contacto">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                        <section class="row">
                                            <div class="col-12">
                                                <div class="card-imagen-perfil justify-content-end">

                                                    <img src="/files/upload/profile/rachelzane.png?w=90&h=90" alt="" class="img-fluid">

                                                    <small>Redes sociales</small> <hr>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="card-redes-sociales">

                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <section class="row">
                                            <div class="col-lg-12 col-md-5 col-sm-5">
                                                <div class="card-header">
                                                    <h4>Rachel Zane</h4>


                                                    <button class="btn btn-info">Mensaje</button>
                                                    <button class="btn btn-danger">Eliminar</button>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-7  col-sm-7">
                                                <div class="card-body">

                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                </article>
                            </div>
                        </div>
                        </div>
                    </section>
                </div>

            </div>
        </main>
    </section>
</div>
<script type="text/javascript" src="/files/js/chats.js"></script>
<script type="application/javascript" src="/files/js/contactos.js"></script>
</body>
</html>
