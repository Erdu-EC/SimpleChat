<?php

namespace HS\app\view;

use HS\libs\core\Session;
use HS\libs\core\http\HttpResponse;
use const HS\config\APP_NAME;

if (Session::IsLogin()) HttpResponse::Redirect('/');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php require 'template/Head.php' ?>

    <title><?= APP_NAME ?>: Registro</title>
</head>
<body>

</body>
</html>
