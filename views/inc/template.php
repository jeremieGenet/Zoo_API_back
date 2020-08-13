<?php
    require_once "./Helpers/SessionManager.php";
?>
<!--
    TEMPLATE DE BASE
-->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?></title>

    <!-- Bootswatch (CSS, theme: Cyborg) -->
    <link rel="stylesheet" href="https://bootswatch.com/4/cyborg/bootstrap.min.css" >
</head>
<body>

    <?php require_once("views/inc/navbar.php") ?>

    <div class="container">

        <?php //var_dump($_SESSION['alert']) ?>

        <h1 class="m-2 p-2 text-center"><?= $h1 ?></h1>

        <!-- MESSAGE D'ALERTE -->
        <?php SessionManager::displaySessionMessage('alert'); ?>

        <?= $content ?>
    </div>
    
    <!-- Bootstrap (CDN) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>