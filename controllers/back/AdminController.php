<?php

require_once "./Helpers/Security.php";
require_once "./models/back/AdminManager.php";


class AdminController{

    private $adminManager;

    public function __construct()
    {
        $this->adminManager = new AdminManager();
    }

    // Affichage de la page de Connexion (login.php)
    public function getLoginPage(){
        require_once "views/admin/login.php";
    }

    // Vérifie les données envoyées du formulaire de connexion et Redirige
    public function login(){
        //echo password_hash("admin02", PASSWORD_DEFAULT); // GENERATION D'UN NOUVEL ADMIN (avec cette méthode)

        // Si les champs login et password ne sont pas vide...
        if(!empty($_POST['name']) && !empty($_POST['password'])){
            $name = Security::secureHTML($_POST['name']);       // On sécurise le name (htmlentities)
            $password = Security::secureHTML($_POST['password']); // On sécurise le password (htmlentities)

            // Si la vérif que l'admin à valider sa connexion (bon name et password) ...
            if($this->adminManager->isConnexionValid($name, $password)){
                // Création d'une variable de session (qui permettra de vérifier)
                $_SESSION['access'] = 'admin';
                // Création d'un message de session
                SessionManager::createMessage('alert', "success", "Vous êtes maintenant connecté.");
                // Redirige vers la page d'accueil de l'administration
                header('Location: '.URL."back/admin"); 
            }else{
                // Création d'un message de session
                SessionManager::createMessage('alert', "danger", "Le 'Nom' ou le 'Password' ne sont pas correctement renseignés.");
                // Redirige vers la page de connexion
                header('Location: '.URL."back/login-page"); 
            }
        }else{
            echo "Champs name et pass vides!!!!";
            // Création d'un message de session
            SessionManager::createMessage('alert', "danger", "Les champs ne sont pas renseignés.");
            // Redirige vers la page d'affichage des animaux
            header('Location: '.URL."back/login-page");
        }
    }

    // Déconnexion
    public function logout(){
        session_destroy();
        header('Location: '.URL."back/login-page"); // Redirige vers la page de connexion
    }

    // Dirige vers la page d'accueil de l'administration (seulement si l'admin est connecté)
    public function getHomeAdmin(){
        if(Security::verifAccessSession()){
            require_once "views/admin/home.php";
        }else{
            header('Location: '.URL."back/login-page"); // Redirige vers la page de connexion
        }
    }


}