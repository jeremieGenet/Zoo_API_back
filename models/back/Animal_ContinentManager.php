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
    // Récup les id des continents d'un animal (en fonction de l'id de l'animal)
    public function getContinentsById($idAnimal){
        $req = "SELECT continent_id from animal_continent WHERE animal_id = :idAnimal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        $continentsId = $stmt->fetchAll(PDO::FETCH_COLUMN); // "PDO::FETCH_COLUMN" retourne un tableau sous la forme index => valeur
        return $continentsId;
    }
    //
    public function delete($idAnimal){
        // Suppression de l'animal dans la table de liaison 'animal_continent'
        $req = "DELETE FROM animal_continent WHERE animal_id= :idAnimal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
    }

    


}