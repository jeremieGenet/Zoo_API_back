<?php

class ImageManager
{

    // Ajoute une image (param $file) dans un dossier (param $dir)
    static public function addImage($file, $dir){
        // Vérif si le param $file est renseigné
        if(!isset($file['name']) || empty($file['name']))
            throw new Exception("Vous devez indiquer une image");

        // Vérif si le dossier existe à la direction renseigée ($dir) sinon crée un dossier sur le serveur
        if(!file_exists($dir)) mkdir($dir,0777);

        $extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION)); // Récup de l'extension du fichier
        $random = rand(0,99999);
        $target_file = $dir.$random."_".$file['name']; // on renomme le fichier (de façon unique)
        
        // Différente vérif sur le fichier et ajout dans le dossier
        if(!getimagesize($file["tmp_name"]))
            throw new Exception("Le fichier n'est pas une image");
        if($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "gif")
            throw new Exception("L'extension du fichier n'est pas reconnu");
        if(file_exists($target_file))
            throw new Exception("Le fichier existe déjà");
        if($file['size'] > 500000)
            throw new Exception("Le fichier est trop gros");
        if(!move_uploaded_file($file['tmp_name'], $target_file))
            throw new Exception("l'ajout de l'image n'a pas fonctionné");
        else return ($random."_".$file['name']);

    }

    
}