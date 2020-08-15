<?php
/*
    Classe qui posséde les fonctions liées à la sécurité de l'application
*/

class Security{

    // Sécurise avec htmlentities()
    public static function secureHTML($string){
        return htmlentities($string);
    }

    // Vérif si dans Session on a bien la valeur "access" et que access = admin (Valeur ajoutée aprés avoir vérif que le nom et password admin soient valides)
    public static function verifAccessSession(){
        return (!empty($_SESSION['access']) && $_SESSION['access'] === "admin");
    }

}