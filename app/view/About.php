<?php

namespace HS\app\view;

use HS\libs\core\http\HttpResponse;
use HS\libs\core\Session;
use const HS\config\APP_NAME;
?>
<!doctype html>
<html lang="es">
<head>
    <?php require 'template/Head.php' ?>

    <title><?= APP_NAME ?>: Inició de sesión</title>
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
                <a href="/Register" class="nav-link"><span class="material-icons">add</span>Registrarse</a>
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
                <a href="/About" class="nav-link">
                    <span class="material-icons"><span class="material-icons-outlined">support_agent</span></span>Contacto
                </a>
            </li>


        </ul>

    </nav>
</header>
<div class="container-fluid"></div>
</body>
</html>
