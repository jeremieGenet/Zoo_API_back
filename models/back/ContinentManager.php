<?php

require_once "./models/Model.php"; // Récup de la bdd

// Gère les requêtes BDD concernant la table continents
class ContinentManager extends Model
{

    // Récup toutes les familles (d'animaux)
    public function continents(){
        $req = "SELECT * FROM continent";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Supprime un continent en fonction de son id
    public function delete($idcontinent){
        $req = "DELETE FROM continent WHERE continent_id= :idcontinent";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idcontinent", $idcontinent, PDO::PARAM_INT);
        $stmt->execute();
    }
    // Retourne le nb de continent de la bdd
    public function count(){
        $req ="SELECT count(continent_id) FROM continent";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_NUM);
    }

}