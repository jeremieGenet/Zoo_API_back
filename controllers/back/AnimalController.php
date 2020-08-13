<?php

require_once "./Helpers/Security.php";
require_once "./models/back/AnimalManager.php";
require_once "./Helpers/SessionManager.php";


class AnimalController{

    private $animalManager;

    public function __construct()
    {
        $this->animalManager = new AnimalManager();
    }


    // Récup les animaux
    public function getAnimals(){
        // Vérif si l'admin est connecté
        if(Security::verifAccessSession()){
            $animals = $this->animalManager->animals();
            //var_dump($animals);
            require_once "views/admin/animal/animals.php";
        }else{
            throw new Exception("Acces refusé : (vous n'avez pas le droit d'être ici, mdr !)");
            // PREVOIR UN MESSAGE FLASH PUIS UNE REDIRECTION VERS LA PAGE DE CONNEXION
        }

    }

    //
    public function deleteAnimal(){
        if(Security::verifAccessSession()){

            // Valeur (id de l'animal, transformé en entier et sécurisé) passée dans l'input de type hidden (voir animal/animals.php)
            $idAnimal = (int)Security::secureHTML($_POST['delete_animal_id']);

            $this->animalManager->delete($idAnimal);
            // Création d'un message de session
            SessionManager::createMessage('alert', "success", "L'animal est supprimé.");
            
            // Redirige vers la page d'affichage des animaux
            header('Location: '.URL."back/animals/display"); 

        }else{
            throw new Exception("Acces refusé : (vous n'avez pas le droit d'être ici, lol !)");
            // PREVOIR UN MESSAGE FLASH PUIS UNE REDIRECTION VERS LA PAGE DE CONNEXION
        }
    }

    /*
    // Modification de l'animal (puis message et redirection)
    public function updateAnimal(){
        // Vérif si l'admin est connecté
        if(Security::verifAccessSession()){           
            // Récup de l'id, du nom et de la description de l'animal postés
            $idAnimal = (int)$_POST['animal_id'];
            $name = Security::secureHTML($_POST['animal_name']);
            $description = Security::secureHTML($_POST['animal_description']);

            // Modif de l'animal dans la bdd
            $this->animalManager->updateAnimal($idAnimal, $name, $description);

            // Création d'un message de session
            SessionManager::createMessage('alert', "success", "L'animal à bien été modifiée.");
            // Redirige vers la page d'affichage des animaux
            header('Location: '.URL."back/animals/display");  
        }else{
            throw new Exception("Acces refusé : (vous n'avez pas le droit d'être ici, lol !)");
            // PREVOIR UN MESSAGE FLASH PUIS UNE REDIRECTION VERS LA PAGE DE CONNEXION
        }
    }
    */


}