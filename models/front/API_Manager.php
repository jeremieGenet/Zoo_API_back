<?php

require_once "./models/Model.php";


// Requêtes à notre bdd
class API_Manager extends Model{

    // Récup des animaux, de leurs famille et de leurs continents (jointures)
    public function getDBAnimals($idFamily, $idContinent){

        // "$whereClause" représentera l'ajoute de la condition "WHERE" et de concaténer d'autres condition si elles sont réunies
        $whereClause = "";
        // Si l'idFamilly ou l'idContinent sont renseignés (différent de -1) on ajoute un WHERE à notre requête
        if($idFamily !== -1 || $idContinent !== -1) $whereClause .= "WHERE ";
        // Si l'id de la famille est renseigné on ajoute la condition de sélection de famille à notre requête 
        if($idFamily !== -1) $whereClause .= "f.family_id = :idFamily"; 
        // Si les 2 id sont renseignés on ajoute AND à notre requête
        if($idFamily !== -1 && $idContinent !== -1) $whereClause .=" AND "; 
        // Si l'id du continent est renseigné on ajoute la condition de sélection de continent à notre requête (sous requête, a.animal_id pour animal_id dans la table animal)
        if($idContinent !== -1) $whereClause .= "a.animal_id IN (
            select animal_id from animal_continent where continent_id = :idContinent
        )"; 

        $req = "SELECT *
            from animal a 
            inner join family f on f.family_id = a.family_id
            inner join animal_continent ac on ac.animal_id = a.animal_id
            inner join continent c on c.continent_id = ac.continent_id ".$whereClause
        ;

        $stmt = $this->getBdd()->prepare($req);
        if($idFamily !== -1) $stmt->bindValue(":idFamily", $idFamily, PDO::PARAM_INT); // On défini le param de requête "idFamily" si celui-ci est défini
        if($idContinent !== -1) $stmt->bindValue(":idContinent", $idContinent, PDO::PARAM_INT); // On défini le param de requête "idContinent" si celui-ci est défini
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