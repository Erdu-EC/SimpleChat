<?php namespace HS\app\view\template;

use HS\libs\core\Session; ?>

<nav class="navbar navbar-dark bg-primary navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="/files/icon/icono.png?w=30" alt="Logo" class="d-inline-block valign-middle"
                 style="background: white; border-radius: 15px; padding: 2px">
            SimpleChat
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav flex-grow-1">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Mensajes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Contacts">Contactos</a>
                </li>

                <!--<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown link
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>-->
            </ul>
            <ul class="navbar-nav m-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbar-username"
                       data-bs-toggle="dropdown">
                        <i class="material-icons">person</i>
                        <span><?= (new Session())->user_shortname; ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg-end">
                        <a id="bt-close-session" class="dropdown-item" href="/Logout">
                            Cerrar sesión
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
