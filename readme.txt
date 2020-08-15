API du Site MyZoo (back php-mysql) => L'api communique avec Le site MyZoo fait en REACT (front)

    L'API possède elle-même 2 parties :
        - la partie front gére la communication avec le site "MyZoo" fait avec React
        - la partie back gère l'administration qui force une connexion pour pouvoir faire des modifications sur les animaux/familles/continents

    Connexion à la partie back :
        - Administrateur n°1 => name : admin, password : admin01 (password crypté dans la bdd)
        - Administrateur n°2 => name : admin02, password : admin02 (password crypté dans la bdd)

<!-- Champ IMAGE -->
<div class="form-group">
    <label for="imageLg">Image (Grande taille)</label>
    <input type="file" class="form-control-file" id="imageLg" name="imageLg"/>
</div>