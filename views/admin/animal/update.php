<!--
    PAGE DE FORMULAIRE DE MODIFICATION D'UN ANIMAL
-->

<?php ob_start(); ?>

<form method="POST" action="<?= URL ?>back/animals/update/<?= $animal['animal_id'] ?>" enctype="multipart/form-data">

    <!-- CHAMP CACHE (pour passé l'id de l'animal à modifié au traitement de la modification => updateAnimal()) -->
    <input type="hidden" name="animal_id" value="<?= $animal['animal_id'] ?>"/>

    <!-- Champ NOM -->
    <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" class="form-control" name="name" value="<?= $animal['animal_name'] ?>">
    </div>
    <!-- Champ DESCRIPTION -->
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" name="description" rows="3"><?= $animal['animal_description'] ?></textarea>
    </div>
    <!-- Champ IMAGE SMALL-->
    <div class="form-group">
        <img src="<?= URL ?>public/images/animals-640p/<?= $animal['animal_picture_small'] ?>" 
            class="img-thumbnail" 
            style="width:120px;"
            alt="<?= $animal['animal_name'] ?>"
        >
        <label for="imageSm">Image (Petite taille)</label>
        <input type="file" class="form-control" name="imageSm">
    </div>
    <!-- Champ IMAGE LARGE-->
    <div class="form-group">
        <img src="<?= URL ?>public/images/animals-1920p/<?= $animal['animal_picture_large'] ?>" 
            class="img-thumbnail"
            style="width:140px;"
            alt="<?= $animal['animal_name'] ?>"
        >
        <label for="imageLg">Image (Grande taille)</label>
        <input type="file" class="form-control" name="imageLg">
    </div>
    <!-- Champ DES FAMILLES (select) -->
    <div class="form-group">
        <label for="family">Familles</label>
        <select class="form-control" name="family">
            <?php foreach($families as $family) : ?>
                <!-- Condition de l'option pour sélectionner la famille de l'animal à modifier (si l'id de la famille === l'id de l'animal à modif on ajoute l'attribut "selected") -->
                <option value="<?= $family['family_id'] ?>"
                    <?php if($family['family_id'] === $animal['family_id']) echo "selected" ?>
                >
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
            <!-- Ici c'est directement le "name" des checkbox qui va être traité pour la création du ou des continents  -->
            <!-- si la checkbox est cochée, son 'name' figurera dans le $_POST -->
            <!-- CONDITION pour coché la checkbox qui comporte un continent ou se trouve l'animal ($continentsById représente un tab des id des continents sur lequel l'animal est présent)-->
            <input type="checkbox" class="form-check-input" name="continent-<?= $continent['continent_id'] ?>"
                <?php if(in_array($continent['continent_id'], $continentsById)) echo "checked"; ?>
            />
            <label class="form-check-label"><?= $continent['continent_name'] ?></label> <!-- Noms des checkbox -->
            
        </div>
        <?php endforeach; ?>
    </div>

    <button type="submit" class="btn btn-info">Modifier</button>
</form>

<?php
$content = ob_get_clean();
$title = "admin modification animaux";
$h1 = "Modification de l'animal ID = ".$animal['animal_id'];
require "views/inc/template.php";