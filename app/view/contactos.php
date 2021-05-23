<?php namespace HS\app\view\template;
use HS\libs\core\http\HttpResponse;
use HS\libs\core\Session;
use const HS\config\APP_NAME;

?>
<!doctype html>
<html lang="es">
<head>
    <?php require 'template/Head.php' ?>
    <title><?= APP_NAME ?>: Chats</title>
    <link rel="stylesheet" href="/files/scss/chat.scss">

</head>
<body class="sb-nav-fixed">

<nav class="sb-topnav navbar navbar-expand " id="barra-superior">

    <button class="btn nav-item" id="sidebarToggle">
        <img src="/files/icon/menu.png" alt="" class="" id="icono-sidebarToggle">
    </button>
    <a class="navbar-brand " href="index.php" >
        <img src="/files/icon/logo.png" alt="" id="logo-home" class="img img-fluid">
    </a>



</nav>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div id="profile">
                <div class="wrap">
                    <img id="profile-img" src="/files/upload/profile/mikeross.png?w=100&h=100" class="online" alt="" />

                    <div class="accordion accordion-flush" id="accordionPanels">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                  Mike Ross
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                        <span>Cerrar sesión</span>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">

                            <div id="flush-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample" aria-expanded="true">
                                <div class="accordion-body">
                                    <div class="sb-sidenav-menu">
                                        <div class="nav">
                                            <button class="nav-link btn" type="button">
                                                <img src="/files/icon/conversaciones-2.png?w=40&h=40" alt="" class="img-fluid">
                                                <div class="sb-sidenav-menu-heading"> Conversaciones</div>
                                            </button>
                                            <hr class="dropdown-divider">
                                            <button class="nav-link link-contactos btn">
                                                <img src="/files/icon/contactos-1.png?w=40&h=40" alt="" class="img-fluid link-contactos">
                                                <div class="sb-sidenav-menu-heading link-contactos"> Contactos</div>
                                            </button>
                                            <hr class="dropdown-divider">
                                            <button class="nav-link btn" href="index.html" >
                                                <img src="/files/icon/nosotros-1.png?w=40&h=40" alt="" class="img-fluid">
                                                <div class="sb-sidenav-menu-heading">Acerca de nosotros</div>
                                            </button>
                                            <hr class="dropdown-divider">
                                            <button class="nav-link btn" href="index.html">
                                                <img src="/files/icon/acuerdos-1.png?w=40&h=40" alt="" class="img-fluid">
                                                <div class="sb-sidenav-menu-heading">Términos y condiciones de uso</div>
                                            </button>


                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="accordion-item">

                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingThree">
                                <div class="accordion-body ">
                                    <div class="sb-sidenav-footer">
                                        <div class="small">SimpleChat</div>
                                        Start Bootstrap
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link" href="index.html">
                        <div class="sb-sidenav-menu-heading"> Conversaciones</div>
                    </a>
                    <a class="nav-link" href="index.html">
                        <div class="sb-sidenav-menu-heading">Acerca de nosotros</div>
                    </a>
                    <a class="nav-link" href="index.html">
                        <div class="sb-sidenav-menu-heading">Politicas y condiciones de uso</div>
                    </a>

                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">SimpleChat</div>
                Start Bootstrap
            </div> -->
        </nav>
    </div>

<div id="layoutSidenav_content">

</div>
</div>
<script type="text/javascript" src="/files/js/chats.js"></script>
</body>
</html>
