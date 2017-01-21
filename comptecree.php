<!DOCTYPE html>
<html>
    <head>
        <title>Cube Fighter</title>
        <meta charset="utf-8" />
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="styleSheetPagesSite.css" type="text/css" rel="stylesheet">
        <link rel="icon" type="image/png" href="Image/icon-cube.png" />

    </head>

    <body>
        <div class="wrapper">
        <?php
            include 'menu.php';
        ?>

        <div class="container">
            <div class="col-lg-12 col-md-12">
                <p class = "text-center" id="IDMenu"><B><Font size="30pt">Inscription</Font></B></p>
                <p class = "text-center">
                Votre compte à été créé. Cliquez sur le bouton pour revenir à l'accueil et vous connecter
                </p>
                </div>
        </div>

        <div class="container">
        <div class="col-lg-12 col-md-12">
        <form method="post" action="index.php" class="form-horizontal col-lg-offset-2 col-lg-8 col-md-offset-1 col-md-10">

            <div class="row">
                <div class="col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-8">
                    <input type="submit" class="btn btn-success btn-block btn-lg" value="Retour à l'acceuil" />
                </div>
            </div>

        </form>
        </div>
        </div>
        <div class="push"></div>
        </div>
        <?php
            include 'footer.php';
        ?>
    </body>
</html>
