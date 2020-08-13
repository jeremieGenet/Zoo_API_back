<?php

require_once "./Helpers/Security.php";
require_once "./models/back/FamilyManager.php";
require_once "./Helpers/SessionManager.php";


class FamilyController{

    private $familyManager;

    public function __construct()
    {
        $this->familyManager = new FamilyManager();
    }


    // Récup les familles (d'animaux)
    public function getFamilies(){
        // Vérif si l'admin est connecté
        if(Security::verifAccessSession()){
            $families = $this->familyManager->families();
            //var_dump($families);
            require_once "views/admin/family/families.php";
        }else{
            throw new Exception("Acces refusé : (vous n'avez pas le droit d'être ici, mdr !)");
            // PREVOIR UN MESSAGE FLASH PUIS UNE REDIRECTION VERS LA PAGE DE CONNEXION
        }

    }
    // Suppression d'une famille en fonction de son id (puis message et redirection)
    public function deleteFamily(){
        if(Security::verifAccessSession()){

            // Valeur (id de la famille, transformé en entier et sécurisé) passée dans l'input de type hidden (voir family/families.php)
            $idFamily = (int)Security::secureHTML($_POST['delete_family_id']);
            // Nombre d'animaux présent dans un famille en fonction de son id
            $nbAnimals = $this->familyManager->countAnimals($idFamily);

            // Si le nombre d'animaux est supérieur à 0 (on ne supprime pas la famille)
            if($nbAnimals > 0){
                // Création d'un message de session
                SessionManager::createMessage('alert', "danger", "La famille n'est pas supprimée. (Il y a " . $nbAnimals . " animaux présents dans cette famille)");
            // Sinon on supprime la famille de la bdd
            }else{
                $this->familyManager->delete($idFamily);
                // Création d'un message de session
                SessionManager::createMessage('alert', "success", "La famille est supprimée.");
            } 
            // Redirige vers la page d'affichage des familles
            header('Location: '.URL."back/families/display"); 

        }else{
            throw new Exception("Acces refusé : (vous n'avez pas le droit d'être ici, lol !)");
            // PREVOIR UN MESSAGE FLASH PUIS UNE REDIRECTION VERS LA PAGE DE CONNEXION
        }
    }

    // Modification de la famille (puis message et redirection)
    public function updateFamily(){
        // Vérif si l'admin est connecté
        if(Security::verifAccessSession()){           
            // Récup de l'id, du nom et de la description de la famille postés
            $idFamily = (int)$_POST['family_id'];
            $name = Security::secureHTML($_POST['family_name']);
            $description = Security::secureHTML($_POST['family_description']);

            // Modif de la famille dans la bdd
            $this->familyManager->updateFamily($idFamily, $name, $description);

            // Création d'un message de session
            SessionManager::createMessage('alert', "success", "La famille à bien été modifiée.");
            // Redirige vers la page d'affichage des familles
            header('Location: '.URL."back/families/display");  
        }else{
            throw new Exception("Acces refusé : (vous n'avez pas le droit d'être ici, lol !)");
            // PREVOIR UN MESSAGE FLASH PUIS UNE REDIRECTION VERS LA PAGE DE CONNEXION
        }
    }
    // Affiche le formulaire de Création d'une famille
    public function getCreationForm(){
        // Vérif si l'admin est connecté
        if(Security::verifAccessSession()){
            require_once "views/admin/family/create.php";
        }else{
            throw new Exception("Acces refusé : (vous n'avez pas le droit d'être ici, lol !)");
            // PREVOIR UN MESSAGE FLASH PUIS UNE REDIRECTION VERS LA PAGE DE CONNEXION
        }
    }

    // Création d'une famille (puis message et redirection)
    public function createFamily(){
        // Vérif si l'admin est connecté...
        if(Security::verifAccessSession()){
            // Récup de l'id, du nom et de la description de la famille postés
            $name = Security::secureHTML($_POST['name']);
            $description = Security::secureHTML($_POST['description']);
            // La fonction create() crée la famille ET retourne la nouvelle famille sous forme de tableau associatif
            $newFamily = $this->familyManager->create($name, $description); 

            // Création d'un message de session
            SessionManager::createMessage('alert', "success", "La famille '" .$newFamily['family_name']. "' à bien été créée avec l'identifiant n° ".$newFamily['family_id'].".");
            // Redirige vers la page d'affichage des familles
            header('Location: '.URL."back/families/display");
        }else{
            throw new Exception("Acces refusé : (vous n'avez pas le droit d'être ici, lol !)");
            // PREVOIR UN MESSAGE FLASH PUIS UNE REDIRECTION VERS LA PAGE DE CONNEXION
        }
    }

}