<!--
    PAGE DE CONNEXION (login)
-->

<?php ob_start(); ?>

<!-- Envoi vers la page de traitement du formulaire, à la soummission (http://localhost/Animal-project/animal-back-php/back/login) -->
<form method="POST" action="<?= URL ?>back/login">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>

    <button type="submit" class="btn btn-primary">Valider</button>
</form>

<?php
$content = ob_get_clean();
$title = "page de connexion";
$h1 = "Page de connexion";
require "views/inc/template.php";