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

    <script type="text/javascript" src="/files/js/Chat.js"></script>
    <script type="text/javascript" src="/files/js/Conversations.js"></script>
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
                    <div class="row">
                        <div class="col">
                            <h6 id="alerta-conversaciones" class="text-secondary">
                                Cargando conversaciones...
                            </h6>
                        </div>
                    </div>

                    <ul id="lista-conversaciones" class="list-group list-group-flush">
                        <!--Las conversaciónes con tus contactos apareceran en esta
                        lista.-->
                    </ul>
                </div>
            </div>
        </div>
        <div id="espacio-de-chat" class="col-8">
            <!-- AQUI SE CARGARA EL HISTORIAL DE CHAT DEL CONTACTO -->
        </div>
    </div>
</main>
</body>
</html>
