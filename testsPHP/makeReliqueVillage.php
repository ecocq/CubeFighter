<?php
$id = (int) $_GET['id'];

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
        $nbrCitoyens = $row["citoyens"];
        $nbrFab = $row["fabriques"];
        $nbrReliques = $row["reliques"];
        $reliqueDateDebut = $row["reliqueDateDebut"];
        $last_maj = $row["last_maj"];
        if ($reliqueDateDebut!=NULL){ //une relique est deja en formation
            echo "Une relique est déjà en formation";
            require "disconnection.php";
            return FALSE;
        }else if($ress1<$ress1rel || $ress2<$ress2rel || $nbrCitoyens<$nbrCitoyensToMakeRel){ //pas suffisamment de ressources
            echo "Pas suffisamment de ressources pour créer une relique : besoin de ". $ress1rel. " ress1, de ". $ress2rel. " ress2 et de "
                .$nbrCitoyensToMakeRel." citoyens";
            require "disconnection.php";
            return FALSE;
        }else if($stockRelByFab * $nbrFab < $nbrReliques + 1){ //pas suffisamment de fabrique pour stocker une autre relique
            echo "Pas suffisamment de fabriques pour stocker une nouvelle relique";
            require "disconnection.php";
            return FALSE;
        }
        /* On peut donc commencer la fabrication */
        $update = "UPDATE village SET ress1=". ($ress1-$ress1rel) .", ress2=". ($ress2-$ress2rel)
            .", citoyens=".($nbrCitoyens-$nbrCitoyensToMakeRel) .
            ", reliqueDateDebut=\"".$last_maj. "\" WHERE id=" . $id;

        if ($conn->query($update)) {
            echo "Lancement de la création d'une relique dans le village ".$id. " <br />";
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
