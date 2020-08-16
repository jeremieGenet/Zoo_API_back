<?php

// Connexion à notre bdd, et gestion de la récup des donnée sous forme de JSON
abstract class Model
{
    private static $pdo;

    // Connexion à notre BDD
    private static function setBdd(){
        self::$pdo = new PDO("mysql:host=localhost;dbname=udemy_animaux;charset=utf8", "root","",[ // A MODIFIER POUR LA MISE EN LIGNE (localhost, dbname, login et mot de passe)
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    protected function getBdd(){
        // On s'assure que la connexion à la bdd ne se fait qu'une seule fois
        if(self::$pdo === null){
            self::setBdd();
        }
        return self::$pdo;
    }

    // Transforme en JSON les données + ajout des headers
    public static function sendJSON($data){
        // Permet d'authoriser les échanges de données cross-server (ici * pour dire avec tout autre type de site)
        header("Access-control-Allow-origin: *"); // A MODIFIER POUR LA MISE EN LIGNE (mettre l'adresse du site front avec lequel on veut communiquer)
        // Définition du type de données echangées en cross-server
        header("Content-type: application/json");
        echo json_encode($data);
    }

}