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
                    'picture_small' => URL."public/images/animals-640p/".$data['animal_picture_small'],
                    'picture_large' => URL."public/images/animals-1920p/".$data['animal_picture_large'],
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

    
    public function getAnimals(){
        $animals = $this->apiManager->getDBAnimals();
        Model::sendJSON($this->formatData($animals)); // Renvoi au format JSON les continents (voir Model.php)
    }

    public function getAnimal($idAnimal){
        $animal = $this->apiManager->getDBAnimal($idAnimal);
        Model::sendJSON($this->formatData($animal)); // Renvoi au format JSON les continents (voir Model.php)
    }

    public function getContinents(){
        $continents = $this->apiManager->getDBContinents();
        Model::sendJSON($continents); // Renvoi au format JSON les continents (voir Model.php)
    }
    
    public function getFamilies(){
        $families = $this->apiManager->getDBFamilies();
        Model::sendJSON($families); // Renvoi au format JSON les familles (voir Model.php)
    }

}