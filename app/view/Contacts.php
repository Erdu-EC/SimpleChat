<?php

namespace HS\app\view;

use const HS\config\APP_NAME;

?>

<!doctype html>
<html lang="es">
<head>
    <?php require 'template/Head.php' ?>

    <title><?= APP_NAME ?>: Contactos</title>

    <link rel="stylesheet" href="/files/css/chat.css">
    <script type="application/javascript" src="/files/js/Contacts.js"></script>
</head>
<body class="d-flex flex-column">
<header><?php require 'template/Header.php' ?></header>

<main class="container-fluid d-flex flex-grow-1">
    <div class="row pt-2 pb-3 ps-4 pe-4 d-flex flex-grow-1">
        <div class="col-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="d-flex align-items-center mb-0 user-select-none">
                        <i class="material-icons me-2">person</i>
                        <span>Contactos</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col border-bottom pb-3 mb-3">
                            <div class="input-group">
                                <label for="cuadro-busqueda-usuario" class="input-group-text material-icons text-primary">search</label>
                                <input id="cuadro-busqueda-usuario" type="search" class="form-control" placeholder="Buscar contactos actuales o nuevos">
                            </div>
                            <small id="alerta-busqueda-usuario" class="text-secondary mt-3">
                            </small>
                            <div id="lista-resultados-busqueda">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                           <h6 id="alerta-lista-contactos" class="text-secondary">
                               Cargando contactos...
                            </h6>
                        </div>
                    </div>

                    <ul id="lista-contactos" class="list-group list-group-flush">

                    </ul>
                </div>
            </div>
        </div>
        <div id="espacio-de-chat" class="col">
            <!-- AQUI SE CARGARA EL HISTORIAL DE CHAT DEL CONTACTO -->
        </div>
    </div>
</main>
</body>
</html>


