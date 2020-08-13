<!--
    PAGE DE CREATION DES FAMILLES
-->

<?php ob_start(); ?>

<form method="POST" action="<?= URL ?>back/families/create">
    <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" class="form-control" name="name">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" name="description" rows="3"></textarea>
    </div>

    <button type="submit" class="btn btn-info">Valider</button>
</form>

<?php
$content = ob_get_clean();
$title = "admin creation familles";
$h1 = "Création de familles";
require "views/inc/template.php";