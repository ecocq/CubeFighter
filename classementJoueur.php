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
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styleSheetPagesSite.css">
    <link rel="icon" type="image/png" href="Image/icon-cube.png" />
    <title>Classement des Joueurs - Cuve Fighter</title>
  <!-- Un peu de style pour la visualisation -->
    </head>
    <body>
        <div class="wrapper">
        <?php
        include 'menu.php';
      ?>
        <script src="Messagerie/affichageFormulaire.js"></script>
    <h2 class="text-center"  id="titre">Consulter le classement des Joueurs</h2>
        <?php
         if(isset($_SESSION['id']))
         {
             // Mise à jour des données des joueurs
             $req = "SELECT id FROM village";
             $listIdfetch = $conn->query($req);
             $id = 0;
             while($listId = $listIdfetch->fetch_assoc()) {
                 $id = $listId['id'];
                 include 'BDD/majDataVillage.php';
             }


             $req="SELECT `id_joueur`,pseudo,SUM(citoyens) AS Citoyens,(SUM(citoyens)+SUM(reliques)*10000+SUM(ress1)+SUM(ress2)*2+SUM(soldats)) AS Clsmt FROM `listvillages`,`village`,`users` WHERE id_village=village.id AND users.id=listvillages.id_joueur GROUP BY id_joueur ORDER BY `Clsmt` DESC";

             $req2 = "SELECT pseudo FROM users WHERE users.id=".$_SESSION['id'];
             $resultrequete2 = $conn->query($req2);
             $data2=$resultrequete2->fetch_assoc();

             $nbligne=0;
             $resultrequete = $conn->query($req);
             if($resultrequete) {
                    $nbligne = $resultrequete->num_rows;
                }
            require 'BDD/disconnection.php';
             if($nbligne>0)
             {
        ?>
        <div class="container table-responsive col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">

        <table class="table table-bordered">
        <thead>
          <tr>
            <th>Rang</th>
            <th>Pseudo</th>
            <th>Citoyens</th>
            <th>Score</th>
          </tr>
        </thead>
        <tbody>
        <?php
             }
             $classJoueur=1;
            while($data = $resultrequete->fetch_assoc())
            {
                if ($data['pseudo']==$data2['pseudo'])
                {
        ?>
<!--  sera utilisé pour envoyer un message au joueur en cliquant dessus          -->
           <!-- <a href="./messagerie.php?action=consulter&amp;id=<?php // echo $data['id_joueur']?>" class="list-group-item">-->

                    <tr>
                        <td class="rang"><B><?php echo $classJoueur; ?></B></td>
                        <td class="pseudo"><B><?php echo $data['pseudo']; ?></B></td>
                        <td class="citoyens"><B><?php echo $data['Citoyens']; ?></B></td>
                        <td class="score"><B><?php echo $data['Clsmt']; ?></B></td>
                    </tr>

            <!--</a>-->
            <?php
                }
                else
                {
                ?>
                    <tr>
                        <td class="rang"><?php echo $classJoueur; ?></td>
                        <td class="pseudo"><?php echo $data['pseudo']; ?></td>
                        <td class="citoyens"><?php echo $data['Citoyens']; ?></td>
                        <td class="score"><?php echo $data['Clsmt']; ?></td>
                    </tr>
                <?php
                }
                $classJoueur=$classJoueur+1;
            }
             ?>
            </tbody>
            </table>

            </div>
        <?php
         }
        ?>
        <div class="push"></div>
        </div>
        <?php
             include 'footer.php';
        ?>
    </body>
</html>
