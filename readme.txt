API du Site MyZoo (back php-mysql) => L'api communique avec Le site MyZoo fait en REACT (front)
    L'API possède elle-même 2 parties :
        - la partie front gére la communication avec le site "MyZoo" fait avec React
        - la partie back gère l'administration qui force une connexion pour pouvoir faire des modifications sur les animaux/familles/continents

    Connexion à la partie back :
        - Administrateur n°1 => name : admin, password : admin01 (password crypté dans la bdd)
        - Administrateur n°2 => name : admin02, password : admin02 (password crypté dans la bdd)


Mise en ligne (modifications à faire):
    1. models/Model.php (route vers l'hébergement, nom de la bdd donné sur l'hébergeur et son login et mot de passe)
    2. Fichier .htaccess


AMELIORATIONS : 
    => La page de connexion ne devrais pas être accessible si l'admin est déja connecté!
    => Créer une pagination des animaux et famille...
    => Améliorer le routage (ex : http://localhost/Animal-Project/animal-back-php/back/animals  => notice d'erreur)
    => Gerer les Exception dans le routage (index.php), dans les controlleur (AnimalController.php et FamilyController.php)

