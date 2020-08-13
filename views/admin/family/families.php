<!--
    PAGE D'AFFICHAGE DES FAMILLES (avec Modification et Suppression)
-->

<?php ob_start(); ?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Famille</th>
            <th scope="col">Description</th>
            <th scope="col" colspan="2">actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($families as $family) : ?>
            <!-- CONDITION D'AFFICHAGE DE LA LISTE DES FAMILLES (dans le but d'afficher la liste avec possibilité de modifier la ligne du bouton de modification-->
            <!-- Si le formulaire de modif n'est pas posté  (identifié par l'input hidden name="update_family_id") 
            Ou Si celui-ci est différent de l'id de la ligne sélectionné (id des familles du foreach()) alors... on affiche la liste des familles 
            (Ce qui fait que seule la ligne ou le bouton de Modification est pressé rempli cette condition, ce qui provoque sa disparition)
            -->
            <?php if(empty($_POST['update_family_id']) || $_POST['update_family_id'] !== $family['family_id']) : ?>
            
            <tr>
                <td><?= $family["family_id"] ?></td>
                <td><?= $family["family_name"] ?></td>
                <td><?= $family["family_description"] ?></td>
                <td>
                    <!-- Formulaire de MODIFICATION d'une famille -->
                    <form method="POST" action="">
                        <input type="hidden" name="update_family_id" value="<?= $family['family_id'] ?>" />
                        <button class="btn btn-warning">Modifier</button>
                    </form>
                </td>
                <td>
                    <!-- Formulaire de SUPPRESSION d'une famille -->
                    <form method="POST" action="<?= URL ?>back/families/delete" onSubmit="return confirm('Voulez-vous vraiment supprimer la famille ?')">
                        <!-- Input type hidden pour envoyer dans 'name' les infos de suppréssion -->
                        <input type="hidden" name="delete_family_id" value="<?= $family['family_id'] ?>" />
                        <button class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            
            <!-- Sinon la ligne de famille dont le bouton a été pressé se modifie avec une ligne qui contient des input et formulaire pour modifier la famille -->
            <?php else: ?>

            <!-- Formulaire de VALIDATION ou ANNULATION de la MODIFICATION d'une famille -->
            <form method="POST" action="<?= URL ?>back/families/update">
            <tr>
                <td><?= $family["family_id"] ?></td>
                <td>
                    <input type="text" class="form-control" name="family_name" value="<?= $family["family_name"] ?>" />
                </td>
                <td>
                    <textarea class="form-control" name="family_description" rows="3"><?= $family["family_description"] ?></textarea>
                </td>
                <td>
                    <input type="hidden" name="family_id" value="<?= $family['family_id'] ?>" />
                    <button class="btn btn-info">Valider</button>  
                </td>
            </form>
                <!-- Petit formulaire (qui permet au bouton annuler de reset la page)  -->
                <form>
                <td>
                    <button class="btn btn-warning">Annuler</button>
                </td>
                </form>
            </tr>
            
            

            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>


<?php
$content = ob_get_clean();
$title = "admin affichage familles";
$h1 = "Affichage des familles";
require "views/inc/template.php";