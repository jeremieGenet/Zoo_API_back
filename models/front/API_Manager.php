<?php

require_once "./models/Model.php";


// Requêtes à notre bdd
class API_Manager extends Model{

    // Récup des animaux, de leurs famille et de leurs continents (jointures)
    public function getDBAnimals(){
        $req = "SELECT *
            from animal a 
            inner join family f on f.family_id = a.family_id
            inner join animal_continent ac on ac.animal_id = a.animal_id
            inner join continent c on c.continent_id = ac.continent_id
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récup d'un animal, de sa famille et de son continent (jointure)
    public function getDBAnimal($idAnimal){
        $req = "SELECT *
            from animal a 
            inner join family f on f.family_id = a.family_id
            inner join animal_continent ac on ac.animal_id = a.animal_id
            inner join continent c on c.continent_id = ac.continent_id
            WHERE a.animal_id = :idAnimal
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT); // SECURITE pour la variable $idAnimal (éviter les injection sql)
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récup des familles (d'animaux)
    public function getDBFamilies(){
        $req = "SELECT *from family";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récup des continents
    public function getDBContinents(){
        $req = "SELECT * from continent";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}