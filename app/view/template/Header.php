<?php namespace HS\app\view\template;

	use HS\libs\core\Session; ?>


<nav class="sb-topnav navbar " id="barra-superior">


    <button class="btn nav-item" id="sidebarToggle">
        <span class="material-icons">menu</span>
    </button>
    <div class="indicador-mensajes" id="icon-indicador-mensaje">
        <i class="fas fa-envelope"></i>
        <div class="num-mensajes" style="display: none">
            <span></span>
        </div>
    </div>
<div class="msg-indicador-notificaciones">
    <div class="sup"></div>
    <div class="body">
        <p>Presione el ícono para habilitar las notificaciones</p>
    </div>

</div>

    <a class="navbar-brand " href="/" title="Inicio">
        <img src="/files/icon/logo-wh.png?h=50" alt="" id="logo-home" class="img img-fluid">
    </a>
</nav>
