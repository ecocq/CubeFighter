<?php
    $req = "SELECT id_joueur FROM listvillages WHERE id_village=".$id_envoi;


     if ($result = $conn->query($req)) {
         if($row = $result->fetch_assoc()) {
             $id_joueur = $row['id_joueur'];
         }
     } else {
         echo "Error: " . $req . "<br/>" . $conn->error . "<br/>";
     }



    $req = "INSERT INTO joueurmessage (idJoueurEnvoi, idJoueurRecue, sujet, texte, date)
            VALUES (".$id_joueur.", ".$id_joueur.", \"".$conn->real_escape_string($sujet)."\", \"".$conn->real_escape_string($text)."\", NOW())";

    if ($result = $conn->query($req)) {
        echo "Attaqué : ".$id_joueur."; attaqued : ".$attacked;
     } else {
         echo "Error: " . $req . "<br/>" . $conn->error . "<br/>";
     }

?>
