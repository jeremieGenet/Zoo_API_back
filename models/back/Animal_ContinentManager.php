<?php

require_once "./models/Model.php"; // Récup de la bdd

// Gère les requêtes BDD concernant la table animal_continent
class Animal_ContinentManager extends Model
{

    // Insére l'accociation id animal et id continent dans la table animal_continent
    public function insert($animalId, $continentId){
        $req = "INSERT INTO animal_continent (animal_id, continent_id)
            value (:animalId, :continentId)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":animalId", $animalId, PDO::PARAM_INT);
        $stmt->bindValue(":continentId", $continentId, PDO::PARAM_INT);
        $stmt->execute();
    }

    


}