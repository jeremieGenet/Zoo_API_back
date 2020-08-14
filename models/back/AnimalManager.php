<?php

require_once "./models/Model.php"; // Récup de la bdd

// Gère les requêtes BDD concernant la table animal
class AnimalManager extends Model
{

    // Récup toutes les animaux
    public function animals(){
        $req = "SELECT * from animal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Supprime un animal en fonction de son id
    public function delete($idAnimal){
        // Suppression de l'animal dans la table de liaison 'animal_continent'
        $req = "DELETE FROM animal_continent WHERE animal_id= :idAnimal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        // Suppression de l'animal dans la table 'animal'
        $req2 = "DELETE FROM animal WHERE animal_id= :idAnimal";
        $stmt = $this->getBdd()->prepare($req2);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Création d'un animal ET RETOURNE L'ANIMAL NOUVELLEMENT CREE
    public function create($name, $description, $imageSm, $imageLg, $familyId){
        $req = "INSERT INTO animal (animal_name, animal_description, animal_picture_small, animal_picture_large, family_id)
            value (:name, :description, :imageSm, :imageLg, :familyId)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":name", $name, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":imageSm", $imageSm, PDO::PARAM_STR);
        $stmt->bindValue(":imageLg", $imageLg, PDO::PARAM_STR);
        $stmt->bindValue(":familyId", $familyId, PDO::PARAM_INT);
        $stmt->execute();

        // Récup de l'id de l'animal nouvellement créé
        $lastId = $this->getBdd()->lastInsertId();

        // Réquête pour récup l'animal sous forme de tableau ASSOCiatif (et la retourne)
        $req2 = "SELECT * FROM animal WHERE animal_id = :lastId";
        $stmt = $this->getBdd()->prepare($req2);
        $stmt->bindValue(":lastId", $lastId, PDO::PARAM_INT);
        $stmt->execute();
        $newAnimal = $stmt->fetch(PDO::FETCH_ASSOC);
        return $newAnimal;

    }

}