<!--
    PAGE DE FORMULAIRE DE CREATION D'UN ANIMAL
-->

<?php ob_start(); ?>

<form method="POST" action="<?= URL ?>back/animals/create">
    <!-- Champ NOM -->
    <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" class="form-control" name="name">
    </div>
    <!-- Champ DESCRIPTION -->
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" name="description" rows="3"></textarea>
    </div>
    <!-- Champ IMAGE -->
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" class="form-control" name="image">
    </div>
    <!-- Champ DES FAMILLES (select) -->
    <div class="form-group">
        <label for="family">Familles</label>
        <select class="form-control" name="family">
            <?php foreach($families as $family) : ?>
                <option value="<?= $family['family_id'] ?>">
                    <?= $family['family_id'] ?> - <?= $family['family_name'] ?>
                </option>
            <?php endforeach; ?>   
        </select>
    </div>
    <!-- Champ DES CONTINENT (checkbox) -->
    <label>Continents :</label>
    <div class="row no-gutters">
        <div class="col-1"></div> <!-- ASTUCE DESIGN (div vide pour "encadrer" proprement les checkbox) -->
        <?php foreach($continents as $continent) : ?>
        <div class="form-check col-2 mb-4">
            <!-- Ici c'est directement le "name" des checkbox qui va être traité pour la création du ou des continent  -->
            <!-- si la checkbox est coché, son 'name' figurera dans le $_POST -->
            <input type="checkbox" class="form-check-input" name="continent-<?= $continent['continent_id'] ?>"/>
            <label class="form-check-label"><?= $continent['continent_name'] ?></label> <!-- Noms des checkbox -->
            
        </div>
        <?php endforeach; ?>
    </div>

    <button type="submit" class="btn btn-info">Valider</button>
</form>

<?php
$content = ob_get_clean();
$title = "admin creation animaux";
$h1 = "Création d'animaux";
require "views/inc/template.php";