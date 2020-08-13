<?php 
session_start();

define("URL", str_replace("index.php","",(isset($_SERVER['HTTPS']) ? "https" : "http").
"://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

require_once "./controllers/front/API_Controller.php";
require_once "./controllers/back/AdminController.php";
require_once "./controllers/back/FamilyController.php";
require_once "./controllers/back/AnimalController.php";
$apiController = new API_Controller();
$adminController = new AdminController();
$familyController = new FamilyController();
$animalController = new AnimalController();


try{
    if(empty($_GET['page'])){
        //var_dump($_GET['page']);
        throw new Exception("La page n'existe pas 1");
    } else {
        // On récup dans "$url" les variables qui se trouvent après un "/" ($url[0] va représenter la première variable, $url[1] la seconde...)
        $url = explode("/",filter_var($_GET['page'],FILTER_SANITIZE_URL));
        //var_dump($url);
        // S'il la première, la 2eme ou la 3eme variable d'url est vide on jette une exeption
        if(empty($url[0]) || empty($url[1])) throw new Exception ("La page n'existe pas 2");
        switch($url[0]){
            // PARTIE FRONT (échange de données avec la partie front React)
            case "front" : 
                switch($url[1]){
                    // Application front : http://localhost:3000/?page=front/animals
                    // Obtenir les animaux : http://localhost/Animal-project/animal-back-php/front/animals
                    case "animals": 
                        if(!isset($url[2]) || !isset($url[3])){ // S'il n'y a pas de 3eme ou de 4eme param d'url alors...
                            $apiController->getAnimals(-1, -1); // On affiche l'ensemble des animaux (les -1 seront défini comme arguments par défaut)
                        }else{
                            $apiController->getAnimals((int)$url[2], (int)$url[3]); // (int) pour signifier que le param url utilisé devra être de type entier
                        }
                    break;
                    // Obtenir un animal : http://localhost/Animal-project/animal-back-php/front/animal/1
                    case "animal": 
                        if(empty($url[2])) throw new Exception("L'identifiant de l'animal est manquant");
                        $apiController->getAnimal($url[2]);
                    break;
                    // Obtenir les continents : http://localhost/Animal-project/animal-back-php/front/continents
                    case "continents": $apiController->getContinents(); // 
                    break;
                    // Obtenir les familles : http://localhost/Animal-project/animal-back-php/front/families
                    case "families": $apiController->getFamilies(); // 
                    break;
                    // Récup les données du formulaire de contact (en Post, ne fonctionne que de la partie front) : http://localhost/animal-Project/animal-back-php/front/dataFormContact
                    case "dataFormContact": $apiController->postDataFormContact();
                    break;
                    default : throw new Exception ("La page n'existe pas 3");
                }
            break;
            // PARTIE BACK (administration)
            case "back" : 
                switch($url[1]){
                    // Page du formulaire d'identification de l'administrateur : http://localhost/Animal-project/animal-back-php/back/login-page
                    case "login-page" : $adminController->getLoginPage();
                    break;
                    // Traitement de la connexion
                    case "login" : $adminController->login();
                    break;
                    // Traitement de la déconnexion
                    case "logout" : $adminController->logout();
                    break;
                    // Page d'accueil de l'administration : http://localhost/Animal-project/animal-back-php/back/admin
                    case "admin" : $adminController->getHomeAdmin();
                    break;
                    // RACINE des familles : http://localhost/Animal-project/animal-back-php/back/families
                    case "families" :
                        switch($url[2]){
                            // Page d'affichage des familles : http://localhost/Animal-project/animal-back-php/back/families/diplay
                            case "display" : $familyController->getFamilies();
                            break;
                            // Page de suppression de familles : http://localhost/Animal-project/animal-back-php/back/families/delete
                            case "delete" : $familyController->deleteFamily();
                            break;
                            // Page de modification de familles : http://localhost/Animal-project/animal-back-php/back/families/update
                            case "update" : $familyController->updateFamily();
                            break;
                            // Page d'affichage du formulaire de création de familles : http://localhost/Animal-project/animal-back-php/back/families/creation_formulary
                            case "creation-formulary" : $familyController->getCreationForm();
                            break;
                            // Page de création de familles : http://localhost/Animal-project/animal-back-php/back/families/create
                            case "create" : $familyController->createFamily();
                            break;
                            default : throw new Exception ("La page n'existe pas 4");
                        }
                    break;
                    case "animals" :
                        switch($url[2]){
                            // Page d'affichage des animaux : http://localhost/Animal-project/animal-back-php/back/animals/display
                            case "display" : $animalController->getAnimals();
                            break;
                            // Page de suppression de familles : http://localhost/Animal-project/animal-back-php/back/animals/delete
                            case "delete" : $animalController->deleteAnimal();
                            break;
                            default : throw new Exception ("La page n'existe pas 5");
                        }
                    break;
                    default : throw new Exception ("La page n'existe pas 7");

                }
            break;
            default : throw new Exception ("La page n'existe pas 7");
        }
    }
} catch (Exception $e){
    $msg = $e->getMessage();
    echo $msg;
    echo " "."<a href='".URL."back/login-page'>Page de connexion</a>";
}

