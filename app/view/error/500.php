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
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
<div id="layoutError">
    <div id="layoutError_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="text-center mt-4">
                            <h1 class="display-1">500</h1>
                            <p class="lead">Internal Server Error</p>
                            <a href="index.html">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Return to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
