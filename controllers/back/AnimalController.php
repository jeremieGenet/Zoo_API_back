<?php

require_once "./Helpers/Security.php";
require_once "./Helpers/SessionManager.php";

require_once "./models/back/AnimalManager.php";
require_once "./models/back/FamilyManager.php";
require_once "./models/back/ContinentManager.php";
require_once "./models/back/Animal_ContinentManager.php";



class AnimalController{

    private $animalManager;
    private $familyManager;
    private $continentManager;
    private $animal_continentManager;


    public function __construct()
    {
        $this->animalManager = new AnimalManager();
        $this->familyManager = new FamilyManager();
        $this->continentManager = new ContinentManager();
        $this->animal_continentManager = new Animal_ContinentManager();
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
    // Suppression d'un animal (message et redirection)
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
    // Affiche le formulaire de Création d'une famille
    public function getCreationForm(){
        // Vérif si l'admin est connecté
        if(Security::verifAccessSession()){
            // Récup de la liste des animaux, continents 
            $families = $this->familyManager->families();
            $continents = $this->continentManager->continents();

            require_once "views/admin/animal/create.php";
        }else{
            throw new Exception("Acces refusé : (vous n'avez pas le droit d'être ici, lol !)");
            // PREVOIR UN MESSAGE FLASH PUIS UNE REDIRECTION VERS LA PAGE DE CONNEXION
        }
    }

    // Création d'un animal (puis message et redirection)
    public function createAnimal(){
        // Vérif si l'admin est connecté...
        if(Security::verifAccessSession()){
            
            // Récup de l'id, du nom et de la description de l'animal postés
            $name = Security::secureHTML($_POST['name']);
            $description = Security::secureHTML($_POST['description']);
            $imageSm = "Pas de photo Sm";
            $imageLg = "Pas de phos Lg";
            $familyId = (int)Security::secureHTML($_POST['family']);
            
            // La fonction create() crée l'animal ET retourne l'animal sous forme de tableau associatif (pour afficher les infos de ce nouvel animal dans le message de succes)
            $newAnimal = $this->animalManager->create($name, $description, $imageSm, $imageLg, $familyId); 
            $newAnimalId = $newAnimal['animal_id']; // id de l'animal nouvellement crée

            // RECUP LE NB DE CONTINENTS sous forme d'un entier
            $nbContinent = (int)$this->continentManager->count()[0];
            // BOUCLE SUR LE NB DE CONTINENT
            for($i=0; $i<=$nbContinent; $i++){
                // Si la checkbox n'est pas vide...
                if(!empty($_POST["continent-".$i]))
                    // On insére l'association animal_id et continent_id dans la table de liaison animal_continent
                    $this->animal_continentManager->insert($newAnimalId, $i);
            }

            // Création d'un message de session
            SessionManager::createMessage('alert', "success", "L'animal '" .$newAnimal['animal_name']. "' à bien été créé, son identifiant est le n° ".$newAnimal['animal_id'].".");
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