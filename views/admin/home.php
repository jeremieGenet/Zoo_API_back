<!--
    PAGE D'ACCUEIL DE L'ADMINISTRATION
-->

<?php ob_start(); ?>



<?php
$content = ob_get_clean();
$title = "administration";
$h1 = "Administration";
require "views/inc/template.php";

