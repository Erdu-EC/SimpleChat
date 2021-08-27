<?php namespace HS\app\view\template;

	use HS\libs\core\Session; ?>


<nav class="sb-topnav navbar navbar-expand " id="barra-superior">


    <button class="btn nav-item" id="sidebarToggle">
        <span class="material-icons">
menu
</span>
        <!-- <img src="/files/icon/menu.png" alt="" class="" id="icono-sidebarToggle">-->
    </button>
    <div class="indicador-mensajes" id="icon-indicador-mensaje">
        <i class="fas fa-envelope"></i>
        <div class="num-mensajes" style="display: none">
            <span>0</span>
        </div>
    </div>

    <a class="navbar-brand " href="/">
        <img src="/files/icon/logo-wh.png?h=50" alt="" id="logo-home" class="img img-fluid">
    </a>
</nav>
