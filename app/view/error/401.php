<?php

namespace HS\app\view;

use const HS\config\APP_NAME;
use HS\libs\collection\Collection;
http_response_code(401);
?>

<!doctype html>
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
            <img src="/files/error/error-401.svg" alt="" class="img-error">
            <span class="titulo">No tiene autorización</span>
            <p> <br/><br/>
                Esta sección requiere una contraseña o está protegida de otro modo. Si cree que ha llegado a esta página por error, vuelva a la página de inicio de sesión y vuelva a intentarlo, o póngase en contacto con el administrador si sigue teniendo problemas.
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