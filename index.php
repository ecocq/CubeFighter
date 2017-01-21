<?php
    session_start();
    if(isset($_SESSION['id']) && isset($_SESSION['pseudo']))
    {
    }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
       <title>Cube Fighter</title>
      <link rel="icon" type="image/png" href="Image/icon-cube.png" />
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styleSheetPagesSite.css">
  <!-- Un peu de style pour la visualisation -->

  </head>
  <body>
        <div class="wrapper">

      <?php include 'BDD/createAllBDD.php';
        include 'menu.php';
      ?>
        <script   src="http://code.jquery.com/jquery-1.12.3.js"   integrity="sha256-1XMpEtA4eKXNNpXcJ1pmMPs8JV+nwLdEqwiJeCQEkyc="   crossorigin="anonymous"></script>
        <script src="AccueilJS/GalerieImageAccueil.js"></script>
        <div class="container">
            <div class="col-lg-12">
                <p class = "text-center" id="IDMenu"><B><Font size="30pt">Cube fighter</Font></B></p>
            </div>
        </div>



        <div class="container">
            <div class="col-lg-offset-1 col-lg-10 col-md-offset-1 col-md-10" id = "IDTempoTexteDescr">
            <p class = "text-left" style="text-align:justify;">
                <h3>Bienvenue dans Cube Fighter</h3>
                Cube Fighter est un jeu de gestion et de stratégie en temps réel par navigateur.
                <br>
                Plongez dans un univers de cube, développez votre ville, attaquez vos ennemis et devenez le maitre du monde.
                <br>
                Cube Fighter vous fera entrer dans un monde cubique dans lequel vous pourrez développer un village, amassez des ressources, créer une armée et même récolter des reliques afin de devenir le plus fort et côtoyer les sommets du classement mondial.
                <br>
                Pour développer votre village, vous devrez aussi bien créer de nouveaux bâtiments qu’attaquer vos ennemis pour obtenir plus d’or et de bois, qui seront nécessaires aux constructions et au développement de votre armée. Pillez leurs reliques pour montrer votre puissance et votre richesse!
                <br>
                Devenez le meilleur stratège aussi bien en gestion des ressources qu’en attaque.
                <br><br>
                N’attendez plus, rejoignez-nous et obtenez votre parcelle de village immédiatement !
            </p>
            </div>
        </div>

        <?php
            if(!isset($_SESSION['pseudo'])) {
        ?>
        <div class="container">
        <div class="col-lg-offset-4 col-lg-4 col-md-offset-3 col-md-6" id="IDContButton">
            <div class="btn-group-vertical btn-group-lg" id="IDButton">
                <form method="post" action="formulaireInscription.php">
                    <p><button type="button submit" class="btn btn-primary btn-block" id="IDButton">Créer un compte</button></p>
                </form>
                 <form method="post" action="formulaireConnexion.php">
                    <p><button type="button submit" class="btn btn-primary btn-block" id="IDButton">
                    <span class="glyphicon glyphicon-user"></span>Connexion</button></p>
                </form>
            </div>
        </div>
        </div>
        <?php
            }
      ?>
      <br/>
        <div class="container">
        <div class = "col-lg-12 col-md-12">
        <div class="jumbotron" id = "IDJumboThumb">
        <div class = "container" id = "IDRowThumb">

                <div class="col-lg-3 col-md-3 col-sm-6">
                    <a href="Image/village1_bobinch.PNG" class="thumbnail" id="galerie1" title="Village de bobbinch">
                        <img src ="Image/village1_bobinch.PNG" alt="Generic placeholder thumbnail" class="img-rounded">
                    </a>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6">
                    <a href="Image/BM.PNG" class="thumbnail" id="galerie2" title="Village de la Flute Enchantée">
                        <img src ="Image/BM.PNG" alt="Generic placeholder thumbnail" class="img-rounded" >
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <a href ="Image/CatCubeCity.PNG" class="thumbnail" id="galerie3" title="Village CatCubeCity">
                        <img src ="Image/CatCubeCity.PNG" alt="Generic placeholder thumbnail" class="img-rounded">
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <a href = "Image/village_paul.PNG" class="thumbnail" id="galerie4" title="Village de Paul">
                        <img src ="Image/village_paul.PNG" alt="Generic placeholder thumbnail" class="img-rounded">
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <a href = "Image/villageBapt.PNG" class="thumbnail" id="galerie5" title="Village de Monger">
                        <img src ="Image/villageBapt.PNG" alt="Generic placeholder thumbnail" class="img-rounded">
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <a href = "Image/messagerie.PNG" class="thumbnail" id="galerie6" title="Parlez à vos amis">
                        <img src ="Image/messagerie.PNG" alt="Generic placeholder thumbnail" class="img-rounded">
                    </a>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6">
                    <a href = "Image/classement.PNG" class="thumbnail" id="galerie7" title="Comparez vous à vos amis">
                        <img src ="Image/classement.PNG" alt="Generic placeholder thumbnail" class="img-rounded">
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <a href = "Image/compte.PNG" class="thumbnail" id="galerie8" title="Consultez votre compte">
                        <img src ="Image/compte.PNG" alt="Generic placeholder thumbnail" class="img-rounded">
                    </a>
                </div>

            </div>
        </div>
        </div>
        </div>

        <div id ="overlay">
        <div id="inOverlay" class="container jumbotron">
            <div class="container">
                <label><FONT size="5" id="titreimg">Lecture Message</FONT></label>
                <button type="button" class="close" aria-hidden="true" onclick="reverseDisplayImg();" data-dismiss="modal" id="quit"><FONT size="12">×</FONT></button><br/>
            </div>
            <div class="container">
                 <img id="imgOverlay">
            </div>

        </div>
        </div>

        <div class="push"></div>
        </div>
        <?php
             include 'footer.php';
        ?>

       </body>

</html>
