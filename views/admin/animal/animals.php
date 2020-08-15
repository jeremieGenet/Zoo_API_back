<!--
    PAGE D'AFFICHAGE DES ANIMAUX
-->

<?php ob_start(); ?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Animaux</th>
            <th scope="col">Photo</th>
            <th scope="col">Description</th>
            <th scope="col" colspan="2">actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($animals as $animal) : ?>
            
            <tr>
                <td><?= $animal["animal_id"] ?></td>
                <td><?= $animal["animal_name"] ?></td>
                <td>
                    <img 
                        src="../../public/images/animals-640p/<?= $animal["animal_picture_small"] ?>" 
                        class="img-thumbnail" 
                        alt="<?= $animal["animal_name"] ?>">
                </td>
                <td><?= $animal["animal_description"] ?></td>
                <td>
                    <!-- Formulaire de MODIFICATION d'un animal -->
                    <form method="POST" action="">
                        <input type="hidden" name="update_animal_id" value="<?= $animal['animal_id'] ?>" />
                        <!-- L'id de l'animal en param d'url (pour identifier l'animal dans le formulaire de modification) -->
                        <a href="<?= URL?>back/animals/update-formulary/<?= $animal['animal_id'] ?>"> 
                            <button class="btn btn-warning" type="button">Modifier</button>
                        </a>
                    </form>
                </td>
                <td>
                    <!-- Formulaire de SUPPRESSION d'un animal -->
                    <form method="POST" action="<?= URL ?>back/animals/delete" onSubmit="return confirm('Voulez-vous vraiment supprimer l'animal ?')">
                        <!-- Input type hidden pour envoyer dans 'name' les infos de suppréssion -->
                        <input type="hidden" name="delete_animal_id" value="<?= $animal['animal_id'] ?>" />
                        <button class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            
        <?php endforeach; ?>
    </tbody>
</table>


<?php
$content = ob_get_clean();
$title = "Les animaux";
$h1 = "Les animaux";
require "views/inc/template.php";