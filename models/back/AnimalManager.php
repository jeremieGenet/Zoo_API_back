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
    // Récup un animal en fonction de son id
    public function getAnimal($idAnimal){
        $req = "SELECT * from animal WHERE animal_id = :idAnimal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Récup un animal, les infos de sa famille, et des ses continents en fonction de son id (par LIAISON)
    public function getAnimalFamilyContinent($idAnimal){
        $req = "SELECT * from animal a
            inner join family f on a.family_id = f.family_id
            inner join animal_continent ac on ac.animal_id = a.animal_id
            WHERE a.animal_id = :idAnimal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
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
        // On retourne l'animal qui vient d'être créé (pour afficher ses infos dans le message feedback)
        return $this->getAnimal($lastId);
    }

    // Modification d'un animal
    public function update($idAnimal, $name, $description, $imageSm, $imageLg, $familyId){
        $req = "UPDATE animal SET 
            animal_name = :name, 
            animal_description = :description, 
            animal_picture_small = :imageSm, 
            animal_picture_large = :imageLg, 
            family_id = :familyId
            WHERE animal_id = :idAnimal"
        ;
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $stmt->bindValue(":name", $name, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":imageSm", $imageSm, PDO::PARAM_STR);
        $stmt->bindValue(":imageLg", $imageLg, PDO::PARAM_STR);
        $stmt->bindValue(":familyId", $familyId, PDO::PARAM_INT);
        $stmt->execute();

        // On retourne l'animal qui vient d'être modifié (pour afficher ses infos dans le message feedback)
        return $this->getAnimal($idAnimal);
    }

    // Récup le nom de l'image dans la bdd (en fonction de son id et de sa taille)
    public function getImageAnimal(int $idAnimal, string $size){
        $req = "SELECT animal_picture_{$size} from animal WHERE animal_id = :idAnimal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        $image = $stmt->fetch(PDO::FETCH_ASSOC);
        return $image['animal_picture_'.$size];
    }

}