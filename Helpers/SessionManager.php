<?php

// Gère les actions liés à la SESSION
class SessionManager{

    // Affiche le message de la session (div bootstrap), SIGNATURE : SessionManager::displaySessionMessage('alert');
    public static function displaySessionMessage($name)
    {
        // Si la session n'est pas vide (alors on affiche)
        if(!empty($_SESSION[$name])){
            echo 
                '<div class="alert alert-' .$_SESSION[$name]['type']. '" role="alert">'
                    .$_SESSION[$name]['message'].
                '</div>'
            ;
        }
        // Suppression de la variable de session (pour qu'elle ne s'affiche pas perpétuellement)
        unset($_SESSION[$name]);
    }

    // Création d'une Message de session (avec class bootstrap), SIGNATURE : SessionManager::createMessage('alert', "success", "La famille est supprimée");
    public static function createMessage(string $name, string $type, string $message)
    {
        $_SESSION[$name] = [
            "type" => $type,
            "message" => $message
        ];
    }

}