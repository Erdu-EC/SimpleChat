<?php

namespace HS\app\view;

use const HS\config\APP_NAME;

?>

<!doctype html>
<html lang="es">
<head>
    <?php require 'template/Head.php' ?>

    <title><?= APP_NAME ?>: Inicio</title>
</head>
<body class="d-flex flex-column">
<header><?php require 'template/Header.php' ?></header>

<main class="container-fluid d-flex flex-grow-1">
    <div class="row pt-2 pb-3 ps-4 pe-4 d-flex flex-grow-1">
        <div class="col-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="d-flex align-items-center mb-0">
                        <i class="material-icons me-2">email</i>
                        <span>Conversaciones</span>
                    </h5>
                </div>
                <div class="card-body">
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
                    <h5 class="d-flex align-items-center mb-0">
                        <i class="material-icons me-2">email</i>
                        <span>Nombre</span>
                    </h5>
                </div>
                <div class="card-body">
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
    </div>
</main>
</body>
</html>
