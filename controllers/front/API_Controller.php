<?php

require_once "./models/front/API_Manager.php";
require_once "./models/Model.php";


class API_Controller{

    private $apiManager;

    public function __construct()
    {
        $this->apiManager = new API_Manager();
    }

    // Mise en forme des données (fonction PRIVEE)
    private function formatData($rawData){
        $tab = [];
        foreach($rawData as $data){
            // Condition qui permet dans notre boucle foreach() de ne pas réecraser les données et d'ajouter chacun des continents
            if(!array_key_exists($data['animal_id'], $tab)){ // array_key_exists —> Vérifie si une clé existe dans un tableau
                // Modification de nos données
                $tab[$data['animal_id']] = [
                    'id' => $data['animal_id'],
                    'name' => $data['animal_name'],
                    'description' => $data['animal_description'],
                    'picture_small' => URL."public/images/animals-640p/".$data['animal_picture_small'], //http://localhost/Animal-project/animal-back-php/public/images/animals-640p/singe-640x426.jpg
                    'picture_large' => URL."public/images/animals-1920p/".$data['animal_picture_large'], //http://localhost/Animal-project/animal-back-php/public/images/animals-1920p/singe-1920x1280.jpg
                    'family' => [
                        'id' => $data['family_id'],
                        'name' => $data['family_name'],
                        'description' => $data['family_description']
                    ]
                ];
            }
            // Ajout des continents (il peut y en avoir plusieurs pour un animal)
            $tab[$data['animal_id']]['continents'][] = [
                'id' => $data['continent_id'],
                'name' => $data['continent_name']
            ];
        }
        return $tab;
    }

    // Gére la récup des animaux
    public function getAnimals($idFamily, $idContinent){
        $animals = $this->apiManager->getDBAnimals($idFamily, $idContinent);
        Model::sendJSON($this->formatData($animals)); // Renvoi au format JSON les continents (voir Model.php)
    }
    // Gère la récup d'un animal
    public function getAnimal($idAnimal){
        $animal = $this->apiManager->getDBAnimal($idAnimal);
        Model::sendJSON($this->formatData($animal)); // Renvoi au format JSON les continents (voir Model.php)
    }
    // Gère la récup des continents
    public function getContinents(){
        $continents = $this->apiManager->getDBContinents();
        Model::sendJSON($continents); // Renvoi au format JSON les continents (voir Model.php)
    }
    // Gère la récup des familles
    public function getFamilies(){
        $families = $this->apiManager->getDBFamilies();
        Model::sendJSON($families); // Renvoi au format JSON les familles (voir Model.php)
    }

    // Gére les données réçues en POST du formulaire de contact (objet Message, avec name, email, et message) de la partie front-React (MyZoo)
    public function postDataFormContact(){

        // Authorisation de communication cross-server
        header("Access-Control-Allow-Origin: *"); // MODIFIER LE "*" LORS DE LA MISE EN LIGNE (par le nom du site avec lequel va communique l'API)
        // Méthodes acceptées (Communication cross-server)
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
        // Headers acceptés lors d'une communication cross-server
        header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");

        // On récup les données du formulaire de contact, et les décode pour quelles soit lisible en php ("php://" indique le type de flux de données)
        $obj = json_decode(file_get_contents('php://input')); // "php://input" est un flux en lecture seule qui vous permet de lire des données brutes à partir du corps de la requête
        
        // $to = "contact@h2prog.com";
        // $subject = "Message du site MyZoo de : ".$obj->nom;
        // $message = $obj->contenu;
        // $headers = "From : ".$obj->email;
        // mail($to, $subject, $message, $headers);

        $messageRetour = [
            'from' => $obj->email,
            'to' => "contact@h2prog.com"
        ];

        echo json_encode($messageRetour);

    }

}