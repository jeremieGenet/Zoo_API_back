<?php 
//http://localhost/...
//https://www.site_en_question/...
define("URL", str_replace("index.php","",(isset($_SERVER['HTTPS']) ? "https" : "http").
"://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

require_once "./controllers/front/API_Controller.php";
$apiController = new API_Controller();


try{
    if(empty($_GET['page'])){
        //var_dump($_GET['page']);
        throw new Exception("La page n'existe pas 1");
    } else {
        // On récup dans "$url" les variables qui se trouvent après un "/" ($url[0] va représenter la première variable, $url[1] la seconde...)
        $url = explode("/",filter_var($_GET['page'],FILTER_SANITIZE_URL));
        //var_dump($url);
        // S'il la première ou la seconde variable d'url est vide on jette une exeption
        if(empty($url[0]) || empty($url[1])) throw new Exception ("La page n'existe pas 2");
        switch($url[0]){
            case "front" : 
                switch($url[1]){
                    case "animals": $apiController->getAnimals(); // http://localhost:3000/?page=front/animals
                    break;
                    case "images": 
                    case "animal": // http://localhost:3000/?page=front/animal/1
                        if(empty($url[2])) throw new Exception("L'identifiant de l'animal est manquant");
                        $apiController->getAnimal($url[2]);
                    break;
                    case "continents": $apiController->getContinents(); // http://localhost:3000/?page=front/continents
                    break;
                    case "families": $apiController->getFamilies(); // http://localhost:3000/?page=front/families
                    break;
                    default : throw new Exception ("La page n'existe pas 3");
                }
            break;
            case "back" : echo "page back end demandée";
            break;
            default : throw new Exception ("La page n'existe pas 4");
        }
    }
} catch (Exception $e){
    $msg = $e->getMessage();
    echo $msg;
}


/*
try{
    

        // On récup dans "$url" les variables qui se trouvent après un "/" ($url[0] va représenter la première variable, $url[1] la seconde...)
        $url = explode("/",filter_var($_GET['page'],FILTER_SANITIZE_URL));
        //var_dump($url);
        // S'il la première ou la seconde variable d'url est vide on jette une exeption
        if(empty($url[0]) || empty($url[1])) throw new Exception ("La page n'existe pas 2");
        switch($url[0]){
            case "front" : 
                switch($url[1]){
                    case "animals": $apiController->getAnimals(); // http://localhost:3000/?page=front/animals
                    break;
                    case "images": 
                    case "animal": // http://localhost:3000/?page=front/animal/1
                        if(empty($url[2])) throw new Exception("L'identifiant de l'animal est manquant");
                        $apiController->getAnimal($url[2]);
                    break;
                    case "continents": $apiController->getContinents(); // http://localhost:3000/?page=front/continents
                    break;
                    case "families": $apiController->getFamilies(); // http://localhost:3000/?page=front/families
                    break;
                    default : throw new Exception ("La page n'existe pas 3");
                }
            break;
            case "back" : echo "page back end demandée";
            break;
            default : throw new Exception ("La page n'existe pas 4");
        }

} catch (Exception $e){
    $msg = $e->getMessage();
    echo $msg;
}
*/