<?php
    session_start();
    if(!isset($_SESSION['pseudo'])) {
        header("Location: index.php");
    }

     require 'BDD/connection.php';
        // Création d'un nouveau village
        $nomDejaPris = FALSE;
        $nomInvalide = FALSE;
        $nom = "";
        $tailleMax = 20;

        //Vérification que le nom envoyé est disponible
        if(isset($_POST['nameVillage'])) {
            $nom = $conn->real_escape_string($_POST["nameVillage"]);
            if(empty($nom) || iconv_strlen($nom)>$tailleMax){
                $nomInvalide = TRUE;
            }else{
                $sql = 'SELECT nomVillage FROM listVillages WHERE nomVillage="'.$nom.'" LIMIT 1';
                $result = $conn->query($sql);
                //Si on a un résultat, on a un village qui s'appelle déjà de la même façon
                if($result->num_rows > 0) {
                    $nomDejaPris = TRUE;
                }else{ //Si on a pas de résultat, alors le nom est disponible
                    $nomDejaPris = FALSE;
                    $sql = "INSERT INTO village (reg_date, last_maj)
                    VALUES (now(), now())";

                    if ($conn->query($sql) === TRUE) {
                        $sql = "INSERT INTO listVillages (id_joueur, nomVillage, id_village)
                        VALUES (".$_SESSION['id'].", '".$nom."', ".mysqli_insert_id($conn).");
                        INSERT INTO listBatiments (id_village,  id_batiment , x, y, enConstruction)
                        VALUES (".mysqli_insert_id($conn).", 1, 0, 0, 0);
                        INSERT INTO listBatiments (id_village,  id_batiment , x, y, enConstruction)
                        VALUES (".mysqli_insert_id($conn).", 5, 0, 2, 0);
                        INSERT INTO listBatiments (id_village,  id_batiment , x, y, enConstruction)
                        VALUES (".mysqli_insert_id($conn).", 6, 0, 4, 0)";

                        if($conn->multi_query($sql) == TRUE) {
                            echo "Votre village a été créé";
                            header("Location: jouer.php");
                        }else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }

                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }

            }

        }

?>

    <!DOCTYPE html>
    <html>

   <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="Messagerie/styleSheetMessagerie.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="styleSheetPagesSite.css">
        <link rel="icon" type="image/png" href="Image/icon-cube.png" />
        <title>Cube Fighter</title>
  <!-- Un peu de style pour la visualisation -->
    </head>
    <body>
        <div class="wrapper">
        <div class="container">

            <?php
            include 'menu.php';



                // Vérifie si l'utilisateur a déjà crée son village.
                require 'BDD/connection.php';
                $sql = "SELECT * FROM listvillages WHERE id_joueur=" . $_SESSION['id'];
                if ($result = $conn->query($sql)) {
                    if($row = $result->fetch_assoc()){ //cet id existe
                        echo '<center><h1>'.$row['nomVillage'].'</h1></center><br/><br/>';
                        $_SESSION['id_village'] = $row['id_village'];
                        echo '<div id="game">';
                        echo'</div>';
                        include 'jeu.php';

                    }else {
                        //Formulaire pour saisir un nom de village
                        if($nomDejaPris){
                            echo 'Le nom '.$nom.' est déjà réservé pour un autre village. <br/><form method="post" action="jouer.php">
                    <label for="nameVillage" class="control-label">Proposez-en un nouveau: </label>';
                        }else if($nomInvalide){
                             echo 'La longueur du nom saisi est incorrecte. Le nom du village doit posséder entre 1 et '.$tailleMax.' caractères.<br/><form method="post" action="jouer.php">
                            <label for="nameVillage" class="control-label">Donnez un nom à votre village :</label>';
                        }else{
                             echo 'Vous n\'avez pas encore de village.<br/><form method="post" action="jouer.php">
                    <label for="nameVillage" class="control-label">Donnez un nom à votre village :</label>';
                        };

                        echo '<input type="text" name="nameVillage" id="nameVillage" class="form-control">
                        <br/><br/>
                        <center><input type="submit" class="btn btn-success btn-block btn-lg" value="Valider" style="max-width:100px;"/></center>
                        </form>';
                    }
                    $result->free();
                } else {
                    echo "Error: " . $sql . "<br/>" . $conn->error;
                }

                require "BDD/disconnection.php";

    ?>

<!-- Messagerie -->
        </div>


        <script src="Messagerie/affichageFormulaire.js"></script>
        <script   src="http://code.jquery.com/jquery-1.12.3.js"   integrity="sha256-1XMpEtA4eKXNNpXcJ1pmMPs8JV+nwLdEqwiJeCQEkyc="   crossorigin="anonymous"></script>

        <h2 class="text-center">Consulter les messages</h2>

        <div class = "container" id="containermsgsup">
                <label id="msgsup"></label>
        </div>

     <?php
        require 'BDD/connection.php';

            if(isset($_SESSION['id']))
            {

                ?><div class="container">
                    <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
                        <p><button type="button submit" class="btn btn-primary btn-block"  onclick=" displayForm();" id="bnewmsg" >Nouveau Message</button></p>
                    </div>
                    </div>
                <?php

                $req="SELECT joueurmessage.id, pseudo, idJoueurEnvoi, idJoueurRecue, sujet, texte, date
                FROM joueurmessage, users  WHERE users.id=joueurmessage.idJoueurEnvoi AND idJoueurRecue =".$_SESSION['id']." ORDER BY date DESC";

                $nbligne=0;
                if($resultrequete = $conn->query($req)) {
                    $nbligne = $resultrequete->num_rows;
                }
                require 'BDD/disconnection.php';
                if($nbligne>0)
                {
    ?>
                        <div class="container">
                        <div class="tab-content" >
                        <div class="tab-pane fade in active" id="home">
                        <div class="list-group">
                        <form method="post" action="Messagerie/SupprMessage.php" id="formsup">
                        <div id = "liste">


    <?php
        while($data = $resultrequete->fetch_assoc())
        {
            echo'<tr>';
    ?>
            <div class="container">
                <a class="list-group-item col-md-11 col-lg-11 col-sm-11 col-xs-11" id="msglist">
                    <input class = "col-md-1" type="checkbox" id="box" name="Message[]" value=<?php echo $data['id']?>>
                    <span onclick="displayFormLect(readData,<?php echo $data['id']?>);" id= "auteurliste" class="name col-md-1" style="min-width: 120px;display: inline-block;"><?php echo mb_strimwidth($data['pseudo'],0,10,'...')?></span>
                    <span onclick="displayFormLect(readData,<?php echo $data['id']?>);" class="col-md-2" style="padding-right:15px"><?php echo mb_strimwidth($data['sujet'],0,20,'...')?></span>
                    <span onclick="displayFormLect(readData,<?php echo $data['id']?>);"  class="text-muted col-md-5" style="font-size: 11px;"><?php echo mb_strimwidth($data['texte'],0,80,'...')?></span>
                    <span onclick="displayFormLect(readData,<?php echo $data['id']?>);" class="badge col-md-2"><?php echo $data['date']; ?></span>
                    <span onclick="displayFormLect(readData,<?php echo $data['id']?>);" class="pull-right"></span></a>
            </div>

    <?php   }   ?>
                    </div>
                    <div class="container">
                        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3" id="boutonsuppr">
                             <p><button type="button submit" class="btn btn-primary btn-block" id="bsupmsg">Supprimer les messages</button></p>
                        </div>
                    </div>
                </form>
            </div>
            </div>
            </div>
            </div>
    <?php   }   }   ?>

        <div id="nouveau">
        <div class = "container jumbotron" id = "jumbonew">
            <div class="container">
                <label><FONT size="5">Nouveau Message</FONT></label>
                <button type="button" class="close" aria-hidden="true" onclick="reverseDisplayForm()" data-dismiss="modal" id="quit"><FONT size="12">×</FONT></button><br/>
            </div>


            <form action="Messagerie/envoiMessage.php" method="post" class="container" id="formenvoi" >
                <label for="destinataire" class="col-md-2 col-lg-2 col-sm-2 col-xs-12" id="dest">Destinataire: </label>
                <textarea name="destinataire" id="destinataire"  class="col-md-9 col-lg-9 col-sm-9 col-xs-12"></textarea>
                <br>
                <label for="sujet" class="col-md-2 col-lg-2 col-sm-2 col-xs-12" id="suj">Sujet: </label>
                <textarea name="sujet" id="sujet" class="col-md-9 col-lg-9 col-sm-9 col-xs-12"></textarea>
                <br>
                <label for="text" class="col-md-2 col-lg-2 col-sm-2 col-xs-12" id="tex">Texte: </label>
                <textarea name="text" id="text"  class="col-md-9 col-lg-9 col-sm-9 col-xs-12"></textarea>
                <br>
                <button class="btn btn-primary col-md-2 col-lg-2 col-sm-2 col-xs-2 col-md-offset-5 col-lg-offset-5 col-sm-offset-5 col-xs-offset-5" type="button submit" id="val"><i class="icon icon-check icon-lg"></i>Valider</button>
            </form>

            <div class = "container">
                <label id="msgenvoye"></label>
            </div>
        </div>
        </div>

        <div id="lecture">
        <div class = "container jumbotron" id = "jumbolect">
            <div class="container">
                <label><FONT size="5">Lecture Message</FONT></label>
                <button type="button" class="close" aria-hidden="true" onclick="reverseDisplayFormLect();" data-dismiss="modal" id="quit"><FONT size="12">×</FONT></button><br/>
            </div>

            <div class="container">
                <label class="col-md-2 col-lg-2 col-sm-2 col-xs-12" id="dest">Auteur: </label>
                <textarea disabled id="auteurLect"  class="col-md-9 col-lg-9 col-sm-9 col-xs-12"></textarea>
                <br>
                <label class="col-md-2 col-lg-2 col-sm-2 col-xs-12" id="suj">Sujet: </label>
                <textarea disabled id="sujetLect" class="col-md-9 col-lg-9 col-sm-9 col-xs-12"></textarea>
                <br>
                <label class="col-md-2 col-lg-2 col-sm-2 col-xs-12" id="suj">Date: </label>
                <textarea disabled id="dateLect"  class="col-md-9 col-lg-9 col-sm-9 col-xs-12"></textarea>
                <br>
                <label class="col-md-2 col-lg-2 col-sm-2 col-xs-12" id="tex">Texte: </label>
                <textarea disabled id="textLect"  class="col-md-9 col-lg-9 col-sm-9 col-xs-12"></textarea>

                <button class="btn btn-primary col-md-4 col-lg-4 col-sm-4 col-xs-4 col-md-offset-4 col-lg-offset-4 col-sm-offset-4 col-xs-offset-4" onclick="reverseDisplayFormLect();" id="backmsgrie"><i class="icon icon-check icon-lg"></i>Revenir à la messagerie</button>
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
