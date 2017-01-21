
<link rel="stylesheet" type="text/css" href="styleSheetPagesSite.css">
<div class="container">
    <nav class="navbar navbar-default" style="margin-top:10px;">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Cube Fighter</a>
            </div>


            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <?php
                    echo '<ul class="nav navbar-nav navbar-right">';
                if(isset($_SESSION['pseudo'])) {
                           echo '<p class="navbar-text">Connecté en tant que '.$_SESSION['pseudo'].'</p>';
                    }else {
                        echo '<p class="navbar-text">Vous n\'êtes pas connecté</p>';
                     }

                    if(!isset($_SESSION['pseudo'])) {

                       echo '
                    <a href="formulaireConnexion.php"><button type="submit" class="btn btn-default" style="margin-top:8px;" id="buttonmenu">Connexion</button></a>
                    <a href="formulaireInscription.php"><button type="submit" class="btn btn-default" style="margin-top:8px;" id="buttonmenu">Inscription</button></a>
                    ';

                    }else {
                         echo '
                         <a href="jouer.php"><button type="submit" class="btn btn-default" style="margin-top:8px;" id="buttonmenu">Jouer</button></a>
                         <a href="classementJoueur.php"><button type="submit" class="btn btn-default" style="margin-top:8px;" id="buttonmenu">Classement</button></a>
                         <a href="historiqueAttaques.php"><button type="submit" class="btn btn-default" style="margin-top:8px;" id="buttonmenu">Historique</button></a>
                         <a href="messagerieFullPage.php"><button type="submit" class="btn btn-default" style="margin-top:8px;" id="buttonmenu">Messagerie</button></a>
                         <a href="compte.php"><button type="submit" class="btn btn-default" style="margin-top:8px;" id="buttonmenu">Mon compte</button></a>
                         <a href="help.php"><button type="submit" class="btn btn-default" style="margin-top:8px;" id="buttonmenu">Aide</button></a>
                         <a href="deconnexion.php"><button type="submit" class="btn btn-default" style="margin-top:8px;" id="buttonmenu">Déconnexion</button></a>
                   ';
                    }
                echo '</ul>'
                ?>

            </div>
        </div>
    </nav>
</div>

<script src="Scripts/jquery-1.12.0.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
