<?php

require_once "./models/Model.php";


// Gère les requêtes BDD concernant la table administrato
class AdminManager extends Model
{

    // (PRIVEE) Récup le password de l'administrateur en fonction de son nom (name)
    private function getPasswordUser($name){
        $req = 'SELECT * FROM administrator WHERE name = :name';
        $stmt = $this->getBDD()->prepare($req);
        $stmt->bindValue(":name", $name, PDO::PARAM_STR); // "PDO::PARAM_STR" = Données de type CHAR, VARCHAR ou les autres types de données sous forme de chaîne de caractères SQL.
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $admin['password'];
    }

    // Vérifie si le "name" correspond au password (retourne booléen)
    public function isConnexionValid($name, $password){

        $passwordDB = $this->getPasswordUser($name);
        return password_verify($password, $passwordDB); // Retourne un booleen

    }

    
    
}