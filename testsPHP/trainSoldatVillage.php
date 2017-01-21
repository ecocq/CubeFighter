<?php
$id = (int) $_GET['id'];

require "connection.php";

/* Mise à jour pour avoir les bonnes ressources */
include "majDataVillage.php";

$sql = "SELECT * FROM village WHERE id=" . $id;


if ($result = $conn->query($sql)) {
    if($result->num_rows > 0 && $row = $result->fetch_assoc()){
        /*-- On vérifie qu'on peut lancer la formation d'un soldat --*/
        include "constants.php";
        $ress1 = $row["ress1"];
        $ress2 = $row["ress2"];
        $nbrCitoyens = $row["citoyens"];
        $nbrCasernes = $row["casernes"];
        $nbrSoldats = $row["soldats"];
        $soldatDateDebut = $row["soldatDateDebut"];
        $last_maj = $row["last_maj"];
        if ($soldatDateDebut!=NULL){ //un soldat est deja en formation
            echo "Un soldat est déjà en formation";
            require "disconnection.php";
            return FALSE;
        }else if($ress1<$ress1sol || $ress2<$ress2sol || $nbrCitoyens<$nbrCitoyensToFormSol){ //pas suffisamment de ressources
            echo "Pas suffisamment de ressources pour former un soldat : besoin de ". $ress1sol. " ress1, de ". $ress2sol. " ress2 et de "
                .$nbrCitoyensToFormSol." citoyens";
            require "disconnection.php";
            return FALSE;
        }else if($stockSolByCas * $nbrCasernes < $nbrSoldats + 1){ //pas suffisamment de casernes pour stocker un autre soldat
            echo "Pas suffisamment de casernes pour former un nouveau soldat";
            require "disconnection.php";
            return FALSE;
        }
        /* On peut donc commencer la formation */
        $update = "UPDATE village SET ress1=". ($ress1-$ress1sol) .", ress2=". ($ress2-$ress2sol)
            .", citoyens=".($nbrCitoyens-$nbrCitoyensToFormSol) .
            ", soldatDateDebut=\"".$last_maj. "\" WHERE id=" . $id;

        if ($conn->query($update)) {
            echo "Lancement de la formation d'un soldat du village ".$id. " <br />";
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
