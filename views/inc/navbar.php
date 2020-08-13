<!--
    NAVBAR (barre de navigation, inclue dans template.php)
-->

<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
    <a class="navbar-brand" href="<?= URL?>back/admin">MyZoo</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <!-- Si l'admin est connecté (on affiche les élément de la navBar) -->
            <?php if(Security::verifAccessSession()) : ?>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= URL?>back/admin">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Autre</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Familles
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= URL?>back/families/display">Visualisation</a>
                        <a class="dropdown-item" href="<?= URL?>back/families/creation-formulary">Création</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Animaux
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= URL?>back/animals/display">Visualisation</a>
                        <a class="dropdown-item" href="<?= URL?>back/animals/creation-formulary">Création</a>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
        <div>
            <ul class="navbar-nav mr-auto">
                <!-- Si l'admin n'est pas connecté (on affiche le bouton de LOGIN) -->
                <?php if(!Security::verifAccessSession()) : ?>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-success my-1 mr-2" href="<?= URL?>back/loginPage">Se connecter</a>
                </li>
                <!-- Sinon si l'admin estconnecté (on affiche le bouton de LOGOUT) -->
                <?php else : ?>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-danger my-1" href="<?= URL?>back/logout">Déconnexion</a>
                </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>