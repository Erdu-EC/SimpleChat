<?php

namespace HS\app\view;

use const HS\config\APP_NAME;
use HS\libs\collection\Collection;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php require __DIR__ . '/../template/Head.php' ?>
    <title><?= APP_NAME ?>: Inicio</title>
    <link href="/files/scss/errors.scss" rel="stylesheet" />
</head>
<body>
<main>
    <div class="container">
        <img src="/files/icon/logo-bk.png?h=40" alt="Aquí va el logo de la aplicación web SimpleChat" class="logo">
                <div class="text-center" id="mensaje">
                    <img src="/files/bg/error-404.svg" alt="" class="img-error">
                    <span class="titulo">El recurso no está disponible en Simplechat</span>
                    <p> <br/><br/>
                        Trata de volver a cargar esta página o no dudes en contactar con nosotros si el problema persiste.
                    </p>
                    <a href="/" class="regresar">
                        <span class="material-icons">arrow_back</span>
                        Ir a Inicio
                    </a>
                </div>

    </div>
</main>
</body>
</html>
