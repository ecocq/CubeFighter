<?php
    session_start();
    if(isset($_SESSION['id']) && isset($_SESSION['pseudo']))
    {

    }
    require 'BDD/connection.php';
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
     <link rel="stylesheet" type="text/css" href="styleSheetPagesSite.css">
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="Image/icon-cube.png" />
    <title>Historique des Joueurs - Cube Fighter</title>
  <!-- Un peu de style pour la visualisation -->
    </head>
    <body>
     <div class="wrapper">
        <?php
        include 'menu.php';
      ?>
        <script src="Messagerie/affichageFormulaire.js"></script>
    <h2 class="text-center" id="titre">Consulter l'historique de vos batailles</h2><br/>
        <?php
         if(isset($_SESSION['id']))
         {
             //Liste des attaques
             $req="SELECT idAttaquant, idAttaque, bataillon, forceExt, forceInt, soldatsRestants, ress1Volees, ress2Volees, reliquesVolees, attaque.reg_date FROM attaque, listvillages, users WHERE users.id=".$_SESSION['id']." AND listvillages.id_joueur=users.id AND (idAttaquant = id_village OR idAttaque= id_village) ORDER BY attaque.reg_date DESC";


             //Infos de l'utilisateur
             $req2 = "SELECT id_village, id_joueur, pseudo FROM users, listvillages WHERE id_joueur=".$_SESSION['id']." AND users.id = id_joueur";
             $resultrequete2 = $conn->query($req2);
             $data2=$resultrequete2->fetch_assoc();

             $nblignes=0;
             $resultrequete = $conn->query($req);
             if($res = $resultrequete) {
                    $nblignes = $resultrequete->num_rows;
                }

            require 'BDD/disconnection.php';
             if($nblignes>0)
             {
        ?>
        <div class="container table-responsive col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">

        <table class="table table-bordered">
        <thead>
          <tr>
            <th>Date de l'attaque</th>
            <th>Attaquant</th>
            <th>Attaqué</th>
            <th>Soldats attaquants</th>
            <th>Soldats repartants</th>
            <th>Bois volé</th>
            <th>Or volé</th>
            <th>Relique(s) volée(s)</th>
          </tr>
        </thead>
        <tbody>
        <?php

            while($data = $resultrequete->fetch_assoc())
            {
                if ($data['idAttaquant']==$data2['id_village'])
                {

                    require "BDD/connection.php";
                    $req3 = "SELECT pseudo FROM users, listvillages WHERE users.id = id_joueur AND id_village=".$data['idAttaque'];
                    if ($result = $conn->query($req3)) {
                        $row = $result->fetch_assoc();
                    }

                    require "BDD/disconnection.php";

        ?>

                    <tr>
                        <td><B><?php echo $data['reg_date']; ?></B></td>
                        <td><B><?php echo $data2['pseudo']; ?></B></td>
                        <td><B><?php echo $row['pseudo']; ?></B></td>
                        <td><B><?php echo $data['bataillon']; ?></B></td>
                        <td><B><?php echo $data['soldatsRestants']; ?></B></td>
                        <td><B><?php echo $data['ress1Volees']; ?></B></td>
                        <td><B><?php echo $data['ress2Volees']; ?></B></td>
                        <td><B><?php echo $data['reliquesVolees']; ?></B></td>

                    </tr>

            <!--</a>-->
            <?php
                }
                else
                {

                    require "BDD/connection.php";
                    $req3 = "SELECT pseudo FROM users, listvillages WHERE users.id = id_joueur AND id_village=".$data['idAttaquant'];
                    if ($result = $conn->query($req3)) {
                        $row = $result->fetch_assoc();
                    }

                    require "BDD/disconnection.php";
                ?>
                    <tr>
                        <td><?php echo $data['reg_date']; ?></td>
                        <td><?php echo $row['pseudo']; ?></td>
                        <td><?php echo $data2['pseudo']; ?></td>
                        <td><?php echo $data['bataillon']; ?></td>
                        <td><?php echo $data['soldatsRestants']; ?></td>
                        <td><?php echo $data['ress1Volees']; ?></td>
                        <td><?php echo $data['ress2Volees']; ?></td>
                        <td><?php echo $data['reliquesVolees']; ?></td>
                    </tr>
                <?php
                }
            }
             ?>
            </tbody>
            </table>

            </div>
        <?php
            }else{
                echo "<center>Aucune bataille relative à votre village n'est enregistrée pour le moment. A l'attaque!</center>";
            }
         }
        ?>
           <div class="push"></div>
        </div>
        <?php
             include 'footer.php';
        ?>
    </body>
</html>
