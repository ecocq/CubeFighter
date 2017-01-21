<!DOCTYPE html>
<html>
    <head>
        <title>Connexion - Cube Fighter</title>
        <meta charset="utf-8" />
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link rel="icon" type="image/png" href="Image/icon-cube.png" />
        <link href="styleSheetPagesSite.css" type="text/css" rel="stylesheet">

    </head>

    <body>
        <div class="wrapper">
        <?php
            include 'menu.php';
        ?>

        <script src="http://code.jquery.com/jquery-2.2.1.js"></script>
        <div class="container">
            <div class="col-lg-12 col-md-12">
                <p class = "text-center" id="IDMenu"><B><Font size="30pt">Connexion</Font></B></p>
                <p class = "text-center" id="msgCo"></p>
            </div>
        </div>

        <div class="container">
        <div class="col-lg-12 col-md-12">
        <form method="post" action="BDD/resultConnexion.php" class="form-horizontal col-lg-offset-2 col-lg-8 col-md-offset-1 col-md-10" id="formconn">

            <div class="row">
                <div class="form-group">
                    <label for="mail" class="col-lg-4 col-md-3 control-label">Pseudo ou E-mail:</label>
                    <div class = "col-lg-8 col-md-9">
                        <input type="text" name="mailOpseudo" id="mailOpseudo" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="password" class="col-lg-4 col-md-3 control-label">Mot de Passe: </label>
                    <div class="col-lg-8 col-md-9">
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-8">
                    <input type="submit" class="btn btn-success btn-block btn-lg" value="Valider" />
                </div>
            </div>

        </form>
        </div>
        </div>

        <script src="Scripts/connexioninscription.js"></script>
        <div class="push"></div>
        </div>
        <?php
             include 'footer.php';
        ?>
    </body>
</html>
