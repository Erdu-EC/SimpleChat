<?php

namespace HS\app\view;

use const HS\config\APP_NAME;

?>

<!doctype html>
<html lang="es">
<head>
    <?php require 'template/Head.php' ?>

    <title><?= APP_NAME ?>: Inicio</title>

    <link rel="stylesheet" href="/files/css/chat.css">
</head>
<body class="d-flex flex-column">
<header><?php require 'template/Header.php' ?></header>

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
                    <div class="row border-bottom">
                        <div class="col">
                            <button class="btn btn-outline-primary">Nueva</button>
                        </div>
                        <div class="col"></div>
                    </div>
                    <h6 class="card-subtitle text-secondary">Las conversaciónes con tus contactos apareceran en esta
                        lista.</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">An item</li>
                        <li class="list-group-item">A second item</li>
                        <li class="list-group-item">A third item</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="d-flex align-items-center mb-0 user-select-none">
                        <i class="material-icons me-2">person</i>
                        <span>Nombre</span>
                        <span class="badge alert-success border-3 ms-2">Activo</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="popover bs-popover-end" style="position: relative; max-width: none">
                        <div class="popover-arrow" style="position: absolute; transform: translate(0px, 47px);"></div>
                        <h3 class="popover-header">Popover title</h3>
                        <div class="popover-body">And here's some amazing content. It's very engaging. Right?</div>
                    </div>
                    <div class="popover bs-popover-start" style="position: relative; max-width: none">
                        <div class="popover-arrow" style="position: absolute; transform: translate(0px, 47px);"></div>
                        <h3 class="popover-header">Popover title</h3>
                        <div class="popover-body">And here's some amazing content. It's very engaging. Right?</div>
                    </div>
                </div>
                <div class="card-footer row">
                    <div class="col">
                        <div class="input-group">
                            <textarea class="form-control border-primary" rows="2"
                                      placeholder="Escriba un mensaje..."></textarea>
                            <button class="btn btn-outline-primary d-flex align-items-center input-group-text">
                                <b>Enviar</b>
                                <i class="material-icons ms-2">send</i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
