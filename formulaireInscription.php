<!DOCTYPE html>
<html>
    <head>
        <title>Inscription - Cube fighter</title>
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
        >

        <script src="http://code.jquery.com/jquery-2.2.1.js"></script>

        <div class="container">
            <div class="col-lg-12 col-md-12">
                <p class = "text-center" id="IDMenu"><B><Font size="30pt">Inscription</Font></B></p>
            </div>
        </div>

        <div class="container">
        <div class="col-lg-12 col-md-12 col-sm-12">
        <form method="post" action="BDD/resultInscription.php" class="form-horizontal col-lg-offset-2 col-lg-8 col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10" id="forminscri">

            <div class="row">
                <div class="form-group">
                    <label for="pseudo" class="col-lg-4 col-md-3 col-sm-3 control-label" id="labelForm">Pseudo:</label>
                    <div class="col-lg-8 col-md-9 col-sm-9" id="formForm">
                        <span class = "col-lg-11 col-md-11 col-sm-11">
                            <input type="text" name="pseudo" id="pseudo" class="form-control">
                        </span>
                        <span id="pseudoverif" class="col-lg-1 col-md-1 col-sm-1"></span>
                    </div>
                    <div class ="infoErreur" style='margin-top : 35px'>
                        <FONT color='firebrick'><label id ='erreurPseudo'class="col-lg-7 col-md-8 col-sm-8 col-lg-offset-4 col-md-offset-3 col-sm-offset-3 control-label">
                        </label></FONT>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="mail" class="col-lg-4 col-md-3 col-sm-3 control-label" id="labelForm">E-mail:</label>
                    <div class = "col-lg-8 col-md-9 col-sm-9" id="formForm">
                        <span class = "col-lg-11 col-md-11 col-sm-11">
                            <input type="text" name="mail" id="mail" class="form-control">
                        </span>
                        <span id="mailverif" class="col-lg-1 col-md-1 col-sm-1"></span>
                    </div>
                    <div class ="infoErreur" style='margin-top : 35px'>
                        <FONT color='firebrick'><label id ='erreurMail'class="col-lg-7 col-md-8 col-sm-8 col-lg-offset-4 col-md-offset-3 col-sm-offset-3 control-label">
                        </label></FONT>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="password" class="col-lg-4 col-md-3 col-sm-3 control-label" id="labelForm">Mot de Passe: </label>
                    <div class="col-lg-8 col-md-9 col-sm-9" id="formForm">
                        <span class = "col-lg-11 col-md-11 col-sm-11">
                            <input type="password" name="password" id="password" class="form-control">
                        </span>
                        <span id="passwordverif"  class="col-lg-1 col-md-1 col-sm-1"></span>
                    </div>
                    <div>
                        <label for="password" class="col-lg-offset-4 col-md-offset-3 col-sm-offset-3 control-label" id="infoMdp"><i>il doit contenir au moins 8 caractères</i></label>
                    </div>
                    <div class ="infoErreur">
                        <FONT color='firebrick'><label id ='erreurMDP'class="col-lg-7 col-md-8 col-sm-8 col-lg-offset-4 col-md-offset-3 col-sm-offset-3 control-label">
                        </label></FONT>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="passwordcheck" class="col-lg-4 col-md-3 col-sm-3 control-label" id="labelForm">Confirmation du mot de passe:</label>
                    <div class="col-lg-8 col-md-9 col-sm-9" id="formForm">
                        <span class = "col-lg-11 col-md-11 col-sm-11">
                            <input type="password" name="passwordcheck" id="passwordcheck" class="form-control">
                        </span>
                        <span id="passwordcheckverif" class="col-lg-1 col-md-1 col-sm-1"></span>
                     </div>
                    <div class ="infoErreur" style='margin-top : 35px'>
                        <FONT color='firebrick'><label id ='erreurCheckMDP'class="col-lg-7 col-md-8 col-sm-8 col-lg-offset-4 col-md-offset-3 col-sm-offset-3 control-label">
                        </label></FONT>
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
