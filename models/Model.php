<?php

// Connexion à notre bdd, et gestion de la récup des donnée sous forme de JSON
abstract class Model
{
    private static $pdo;

    // Connexion à notre BDD
    private static function setBdd(){
        self::$pdo = new PDO("mysql:host=localhost;dbname=udemy_animaux;charset=utf8", "root","",[
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
        header("Access-control-Allow-origin: *"); // Permet d'authoriser les échanges de données cross-server (ici * pour dire avec tout autre type de site)
        header("Content-type: application/json"); // Définition du type de données echangées en cross-server
        echo json_encode($data);
    }

}