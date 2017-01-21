<?php
$id = (int) $_POST['id_village'];
$x = $_POST['x'];
$y = $_POST['y'];

require "connection.php";

/* Mise à jour pour avoir les bonnes ressources */
include "majDataVillage.php";

$sql = "SELECT * FROM village WHERE id=" . $id;


if ($result = $conn->query($sql)) {
    if($result->num_rows > 0 && $row = $result->fetch_assoc()){
        /*-- On vérifie qu'on peut lancer la création d'un batiment --*/
        include "constants.php";
        $ress1 = $row["ress1"];
        $ress2 = $row["ress2"];
        $constrEnCours = $row["constrEnCours"];
        $constrDateDebut = $row["constrDateDebut"];
        $last_maj = $row["last_maj"];
        if ($constrEnCours!=0){ //batiment deja en construction
            echo "Un batiment est deja en construction";
            require "disconnection.php";
            return FALSE;
        }else if($ress1<$ress1cen || $ress2<$ress2cen){ //pas suffisamment de ressources
            echo "Pas suffisamment de ressources pour construire le batiment : besoin de ". $ress1cen. " ress1 et ". $ress2cen. " ress2";
            require "disconnection.php";
            return FALSE;
        }
        /* On peut donc commencer la construction */
        $update = "UPDATE village SET ress1=". ($ress1-$ress1cen) .", ress2=". ($ress2-$ress2cen) .
            ", constrEnCours=3, constrDateDebut=\"".$last_maj. "\" WHERE id=" . $id;

        if ($conn->query($update)) {
            // echo "Lancement d'une construction d'un centre de formation du village ".$id. " <br />";

            $update = "INSERT INTO listBatiments (id_village, id_batiment, x, y, enConstruction)
                VALUES (".$id.", 3, ".$x.", ".$y.", 1)";

                if ($conn->query($update)) {
                    echo json_encode("true");
                }else {
                    echo "Error: " . $update . "<br/>" . $conn->error . "<br/>";
                }
        } else {
            echo "Error: " . $update . "<br/>" . $conn->error . "<br/>";
            require "disconnection.php";
            return FALSE;
        }

    }
    $result->free();
}else {
    echo "Pas de village avec l'id ". $id."<br/>" .$sql ." ". $conn->error;
    require "disconnection.php";
    return FALSE;
}

require "disconnection.php";
return TRUE;
?>
