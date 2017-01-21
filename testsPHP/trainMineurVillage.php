<?php
$id = (int) $_GET['id'];

require "connection.php";

/* Mise à jour pour avoir les bonnes ressources */
include "majDataVillage.php";

$sql = "SELECT * FROM village WHERE id=" . $id;


if ($result = $conn->query($sql)) {
    if($result->num_rows > 0 && $row = $result->fetch_assoc()){
        /*-- On vérifie qu'on peut lancer la formation d'un mineur --*/
        include "constants.php";
        $ress1 = $row["ress1"];
        $ress2 = $row["ress2"];
        $nbrCitoyens = $row["citoyens"];
        $nbrCentres = $row["centresFormation"];
        $nbrMineurs = $row["mineurs"];
        $mineurDateDebut = $row["mineurDateDebut"];
        $last_maj = $row["last_maj"];
        if ($mineurDateDebut!=NULL){ //un mineur a déjà été formé une fois
            $EndTime =  strtotime(date_format(date_create($mineurDateDebut), 'Y-m-d H:i:s')) + $timeFormMineur;
            if(($nowSec - $EndTime)<0){
                echo "Un nouveau mineur ne peut pas encore être formé : il reste encore ". ($EndTime -$nowSec). "sec de préparation";
                require "disconnection.php";
                return FALSE;
            }
        }
        if($ress1<$ress1min || $ress2<$ress2min || $nbrCitoyens<$nbrCitoyensToFormMin){ //pas suffisamment de ressources
            echo "Pas suffisamment de ressources pour former un mineur : besoin de ". $ress1min. " ress1, de ". $ress2min. " ress2 et de "
                .$nbrCitoyensToFormMin." citoyens";
            require "disconnection.php";
            return FALSE;
        }else if($stockMinByCen * $nbrCentres < $nbrMineurs + 1){ //pas suffisamment de centres pour stocker un autre mineur
            echo "Pas suffisamment de centres de formation pour former un nouveau mineur";
            require "disconnection.php";
            return FALSE;
        }
        /* On peut donc commencer la formation */
        $update = "UPDATE village SET ress1=". ($ress1-$ress1min) .", ress2=". ($ress2-$ress2min)
            .", citoyens=".($nbrCitoyens-$nbrCitoyensToFormMin) .", mineurs=".($nbrMineurs+1).
            ", mineurDateDebut=\"".$last_maj. "\" WHERE id=" . $id;

        if ($conn->query($update)) {
            echo "Formation d'un nouveau mineur du village ".$id. " <br />";
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
