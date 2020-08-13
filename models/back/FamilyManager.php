<?php

require_once "./models/Model.php"; // Récup de la bdd

// Gère les requêtes BDD concernant la table family
class FamilyManager extends Model
{

    // Récup toutes les familles (d'animaux)
    public function families(){
        $req = "SELECT * FROM family";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Supprime une famille en fonction de son id
    public function delete($idFamily){
        $req = "DELETE FROM family WHERE family_id= :idFamily";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idFamily", $idFamily, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Compte le nombre d'animaux d'une famille ($idFamily)
    public function countAnimals($idFamily){
        //
        $req = "SELECT count(*) as 'nb' FROM family f
        inner join animal a on a.family_id = f.family_id
        WHERE f.family_id = :idFamily";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idFamily", $idFamily, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['nb'];
    }

    // Modification d'une famille
    public function updateFamily($idFamily, $name, $description){
        $req = "UPDATE family SET family_name = :name, family_description = :description
        WHERE family_id= :idFamily";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idFamily", $idFamily, PDO::PARAM_INT);
        $stmt->bindValue(":name", $name, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Création d'une famille ET RETOURNE LA FAMILLE NOUVELLEMENT CREEE
    public function create($name, $description){
        $req = "INSERT INTO family (family_name, family_description) value (:name, :description)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":name", $name, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->execute();

        // Récup de l'id de la famille nouvellement créée
        $lastId = $this->getBdd()->lastInsertId();

        // Réquête pour récup la famille sous forme de tableau ASSOCiatif (et la retourne)
        $req2 = "SELECT * FROM family WHERE family_id = :lastId";
        $stmt = $this->getBdd()->prepare($req2);
        $stmt->bindValue(":lastId", $lastId, PDO::PARAM_INT);
        $stmt->execute();
        $newFamily = $stmt->fetch(PDO::FETCH_ASSOC);
        return $newFamily;

    }

    
    
}