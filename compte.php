<?php
    session_start();
    if(!isset($_SESSION['pseudo'])) {
        header("Location: index.php");
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="styleSheetPagesSite.css">
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link rel="icon" type="image/png" href="Image/icon-cube.png" />
        <title>Mon Compte - Cube Fighter</title>
    </head>

    <body>
        <div class="wrapper"> <!--Ne rien mettre avant-->

        <div class="container">
        <?php
            include 'menu.php';
        ?>
          <h1  id="titre">Compte</h1>
          <!-- Première partie avec le profil du joueur -->
        <div class="jumbotron" style="padding-top:10px; padding-bottom:10px; padding-left:20px; padding-right:30px; margin-left:30px" id="nomCompte">
          <div class="row">
            <div class ="col-lg-6 col-md-8 col-sm-7 col-xs-7">
              <h2 style="padding-top:0px;"><?php echo $_SESSION['pseudo'] ?></h2>
            </div>
          </div>
        </div>
        <!-- Deuxième partie sur les infos du joueurs -->
        <div class="well" align="center" style="margin-left:20%; margin-right:20%">
        <h4 style="text-align:left">Mes informations</h4><br/>
          <p><b>Nom de mon village</b> :
            <?php
              require 'BDD/connection.php';
              $sql = "SELECT nomVillage FROM listvillages WHERE id_joueur=" .$_SESSION["id"];
              if($result = $conn->query($sql)) {
                if($row = $result->fetch_assoc()) {
                  if($row['nomVillage']) {
                    $_SESSION['nomVillage'] = $row['nomVillage'];
                  }
                }else {
                  $_SESSION['nomVillage'] = '';
                }
                echo $_SESSION['nomVillage'];
                $result->free();
              }else {
                echo "Error: ".$sql."<br/>".$conn->error;
              }
              require "BDD/disconnection.php";
            ?>
            <br/>
            <br/>
          </p>
          <?php
            require 'BDD/connection.php';
            $sql = "SELECT email, reg_date FROM users WHERE id=" .$_SESSION["id"];
            if($result = $conn->query($sql)) {
              if($row = $result->fetch_assoc()) {
                echo "<p><b>Adresse Mail</b> : ".$row['email']."<br/><br/></p>";
                echo "<p><b>Date d'inscription</b> : ".
                  date("d/m/Y",strtotime($row['reg_date']))."<br/><br/><br/></p>";
                $_SESSION['email'] = $row['email'];
              }else {
                echo "<p><b>Adresse Mail</b> : <br/><br/></p>";
                echo "<p><b>Date d'inscription</b> : <br/><br/></p>";
              }
              $result->free();
            }else {
              echo "Error: ".$sql."<br/>".$conn->error;
            }
            require "BDD/disconnection.php";
          ?>
          <a data-toggle="collapse" href="#modif" align="center"  class="btn btn-info" >Modifier mes informations</a>
        </div>
        <div id="modif" class="collapse">
          <div class="well" align="center" style="margin-left:20%; margin-right:20%; text-align:left">
            <form class="form-horizontal" role="form" name ="formModif" id="formModif" method="post"  action="BDD/resultModification.php">
              <div class="form-group">
                <label class="control-label col-sm-4" for="village">Nom de village:</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="village" name ="village" placeholder='<?php echo $_SESSION["nomVillage"]?>'>
                  <span class="glyphicon form-control-feedback" id="village1"></span>
                </div>
              </div>
              <div class="form-group has-feedback">
                <label class="control-label col-sm-4" for="email">email:</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="email" id="email" placeholder='<?php echo $_SESSION["email"]?>'>
                  <span class="glyphicon form-control-feedback" id="email1"></span>
                </div>
              </div>
              <div class="form-group has-feedback">
                <label class="control-label col-sm-4" for="newMDP">Nouveau mot de passe:</label>
                <div class="col-sm-8">
                  <input type="password" class="form-control" name="newMDP" id="newMDP" placeholder=''>
                  <span class="glyphicon form-control-feedback" id="newMDP1"></span>
                </div>
              </div>
              <div class="form-group has-feedback">
                <label class="control-label col-sm-4" for="confNewMDP">Confirmation mot de passe:</label>
                <div class="col-sm-8">
                  <input type="password" class="form-control" name="confNewMDP" id="confNewMDP" placeholder=''>
                  <span class="glyphicon form-control-feedback" id="confNewMDP1"></span>
                </div>
              </div>
              <div class="form-group has-feedback">
                <span class="help-block" style="text-align:center"><strong>Veuillez confirmez ces modifications en entrant votre mot de passe actuel:</strong></span>
                <label class="control-label col-sm-4" for="currentMDP">Mot de passe actuel:</label>
                <div class="col-sm-8">
                <input type="password" class="form-control" name="currentMDP" id="currentMDP" placeholder=''>
                <span class="glyphicon form-control-feedback" id="currentMDP1"></span>

                </div>
              </div>
               <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8">
                  <button type="submit" class="btn btn-default" id="buttoncompte">Enregistrer les modifications</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        </div>
        <div class="push"></div><!--Ne rien mettre en dessous ni dedans-->
        </div>
        <?php
             include 'footer.php';
        ?>
      <!-- plugins et script de jquery pour la validation de forme avec changement de style  -->
      <script src="http://code.jquery.com/jquery-2.2.1.js"></script>
      <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
      <script src="CompteJS/CompteModifsForms.js"></script>
    </body>
</html>

