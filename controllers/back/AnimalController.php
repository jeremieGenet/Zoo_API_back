<?php

require_once "./Helpers/Security.php";
require_once "./Helpers/SessionManager.php";
require_once "./Helpers/ImageManager.php";

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
            // Récup de la liste des animaux
            $animals = $this->animalManager->animals();
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

            // Suppression des images (small et large) du repertoire "public/images/.."
            $imageSm = $this->animalManager->getImageAnimal($idAnimal, "small");
            unlink("public/images/animals-640p/".$imageSm);
            $imageLg = $this->animalManager->getImageAnimal($idAnimal, "large");
            unlink("public/images/animals-1920p/".$imageLg);

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
            // Récup de la liste des familles, continents 
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
            
            // Récup du nom, description, id de la famille de l'animal postés
            $name = Security::secureHTML($_POST['name']);
            $description = Security::secureHTML($_POST['description']);
            $familyId = (int)Security::secureHTML($_POST['family']);
            $imageSm = ""; // initialisé à vide (évite les erreurs si il n'y a pas d'image postée)
            $imageLg = ""; // initialisé à vide (évite les erreurs si il n'y a pas d'image postée)

            /*
            //var_dump($_POST);
            var_dump($_FILES);
            var_dump($_FILES['imageSm']);
            die();

            var_dump($_FILES['imageSm']);
            array (size=5)
                'name' => string 'persona-makoto.jpg' (length=18)
                'type' => string 'image/jpeg' (length=10)
                'tmp_name' => string 'D:\Code\xampp\tmp\php8B51.tmp' (length=29)
                'error' => int 0
                'size' => int 135378
            */
            
            // Si il y une image nommée "imageSm"...
            if($_FILES['imageSm']['size'] > 0){
                // Direction ou stocker l'image
                $repertory = "public/images/animals-640p/"; 
                // Traitement de l'image (vérif taille, extension...) et stockage dans le répertoire
                $imageSmRenamed = ImageManager::addImage($_FILES['imageSm'], $repertory);
                // Stockage du nom de l'image dans la bdd
                $imageSm = $imageSmRenamed;
            }
            // Si il y une image nommée "imageLg"..
            if($_FILES['imageLg']['size'] > 0){
                // Direction ou stocker l'image
                $repertory = "public/images/animals-1920p/";
                // Traitement de l'image (vérif taille, extension...) et stockage dans le répertoire
                $imageLgRenamed = ImageManager::addImage($_FILES['imageLg'], $repertory);
                // Stockage du nom de l'image dans la bdd
                $imageLg = $imageLgRenamed;
            }

            
            
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
    // Affiche le FORMULAIRE de MODIFICATION d'un animal en fonction de son id (passé en param d'url dans le bouton "Modifier" de l'affichages des animaux => animals.php)
    public function getUpdateForm($idAnimal){
        // Vérif si l'admin est connecté
        if(Security::verifAccessSession()){
            // Récup de la liste des familles et des continents 
            $families = $this->familyManager->families();
            $continents = $this->continentManager->continents();
            // Récup les id des continents d'un animal (en fonction de l'id de l'animal) 
            $continentsById = $this->animal_continentManager->getContinentsById($idAnimal);
            // Récup de l'animal à modifier (en fonction de son id, passé en param d'url par le bouton modifier)
            $animal = $this->animalManager->getAnimal($idAnimal);

            // Création d'un tableau de l'ensemble des id des continents de la bdd (pour le comparer à "$continentsById" dans l'unput checkbox)
            $tabAllContinentsId = []; 
            foreach($continents as $continent){
                $tabContinentsId[] = $continent['continent_id'];
            }

            require_once "views/admin/animal/update.php";
        }else{
            throw new Exception("Acces refusé : (vous n'avez pas le droit d'être ici, lol !)");
            // PREVOIR UN MESSAGE FLASH PUIS UNE REDIRECTION VERS LA PAGE DE CONNEXION
        }
    }

    
    // Modification de l'animal puis message et redirection (param $id :param d'url passé dans l'attribut action du formulaire de modification => update.php)
    public function updateAnimal($id){
        // Vérif si l'admin est connecté...
        if(Security::verifAccessSession()){
            // Récup de l'id, nom, description, et id de la famille de l'animal postés
            $idAnimal = (int)$id;
            $name = Security::secureHTML($_POST['name']);
            $description = Security::secureHTML($_POST['description']);
            $familyId = (int)Security::secureHTML($_POST['family']);
            // Récup des noms des images (small et large) dans la bdd
            $imageSm = $this->animalManager->getImageAnimal($idAnimal, "small");
            $imageLg = $this->animalManager->getImageAnimal($idAnimal, "large");
            
            // Si il y a bien une image (small) postée... (alors on fait des modification)
            if($_FILES['imageSm']['size'] > 0){
                // Suppression de l'image actuelle
                unlink("public/images/animals-640p/".$imageSm);
                // Direction ou stocker l'image
                $repertory = "public/images/animals-640p/"; 
                // Traitement de l'image (vérif taille, extension...) et stockage dans le répertoire
                $imageSmRenamed = ImageManager::addImage($_FILES['imageSm'], $repertory);
                // Stockage du nom de l'image dans la bdd
                $imageSm = $imageSmRenamed;
            }

            // Si il y a bien une image (large) postée... (alors on fait des modification)
            if($_FILES['imageLg']['size'] > 0){
                // Suppression de l'image actuelle
                unlink("public/images/animals-1920p/".$imageLg);
                // Direction ou stocker l'image
                $repertory = "public/images/animals-1920p/"; 
                // Traitement de l'image (vérif taille, extension...) et stockage dans le répertoire
                $imageLgRenamed = ImageManager::addImage($_FILES['imageLg'], $repertory);
                // Stockage du nom de l'image dans la bdd
                $imageLg = $imageLgRenamed;
            }

            // Update de l'animal dans la table "animal"
            $animalUpdated = $this->animalManager->update($idAnimal, $name, $description, $imageSm, $imageLg, $familyId); 
            $idAnimalUpdated = $animalUpdated['animal_id'];


            // Suppression de l'animal de la table de liaison 'animal_continent'
            $this->animal_continentManager->delete($idAnimal);

            // RECUP LE NB DE CONTINENTS sous forme d'un entier
            $nbContinent = (int)$this->continentManager->count()[0];
            // BOUCLE SUR LE NB DE CONTINENT
            for($i=0; $i<=$nbContinent; $i++){
                // Si la checkbox n'est pas vide...
                if(!empty($_POST["continent-".$i]))
                    // On insére l'association animal_id et continent_id dans la table de liaison animal_continent
                    $this->animal_continentManager->insert($idAnimalUpdated, $i);
            }

            // Création d'un message de session
            SessionManager::createMessage('alert', "success", "L'animal '" .$animalUpdated['animal_name']. "' à bien été modifié, son identifiant est le n° ".$idAnimalUpdated.".");
            // Redirige vers la page d'affichage des animaux
            header('Location: '.URL."back/animals/display");
            
            
            
        }else{
            throw new Exception("Acces refusé : (vous n'avez pas le droit d'être ici, lol !)");
            // PREVOIR UN MESSAGE FLASH PUIS UNE REDIRECTION VERS LA PAGE DE CONNEXION
        }
    }
    


}