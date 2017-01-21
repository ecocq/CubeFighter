<?php
if(!isset($id)) {
    $id = (int) $_POST['id'];
}
if(!isset($nbr)) {
    $nbr = (int) $_POST['nbr'];
}
if(!isset($voulueStr)) {
    $voulueStr = (string) $_POST['voulue'];
}
if($voulueStr=="true") {
    $x = (int) $_POST['x'];
    $y = (int) $_POST['y'];
}

//Proteger la valeur reçue contre usage froduleux
$voulueStr = htmlspecialchars($voulueStr);
if($voulueStr=="true"){
    $voulue = TRUE;

}elseif($voulueStr=="false"){
    $voulue = FALSE;
}else{
    echo "Erreur du parametre : voulue";
    return FALSE;
}

if($nbr<=0){
    echo "Le nombre de batiments est inférieur ou égal à 0";
    return FALSE;
}

require "connection.php";

/* Mise à jour pour avoir les bonnes ressources */
include "majDataVillage.php";

$sql = "SELECT * FROM village WHERE id=" . $id;


if ($result = $conn->query($sql)) {
    if($result->num_rows > 0 && $row = $result->fetch_assoc()){
        /*-- On vérifie qu'on peut lancer la destruction --*/
        include "constants.php";
        $ress1 = $row["ress1"];
        $ress2 = $row["ress2"];
        $fabriques = $row["fabriques"];
        $reliquess = $row["reliques"];
        $reliqueDateDebut = $row["reliqueDateDebut"];
        $constrEnCours = $row["constrEnCours"];

        //On considère que le nombre de fabriques communiqué doit être correct
        if($nbr>$fabriques){
            echo "Le nombre de batiments à détruire est supérieur au contenu du village";
            require "disconnection.php";
            return FALSE;
        }
        if($voulue && ($ress1<$nbr*$ress1fab/2 || $ress2<$nbr*$ress2fab/2)){ //pas suffisamment de ressources pour demander une destruction
            echo "Pas suffisamment de ressources pour demander la destruction de ". $nbr." batiment(s) : besoin de ". ($nbr*$ress1fab/2)." ress1 et ".($nbr*$ress2fab/2)." ress2";
            require "disconnection.php";
            return FALSE;
        }

        /* On peut donc commencer la destruction */

        $update = "UPDATE village SET ";

        //On perd aussi les reliques qui étaient stockées dedans
        if($reliques>($fabriques-$nbr)*$stockRelByFab){
            $reliques=($fabriques-$nbr)*$stockRelByFab;
            //Dans ce cas, toute formation dans ce batiment est annulée
            if($reliqueDateDebut!=NULL){
                $update.="reliqueDateDebut = NULL,";
            }
            $update.="reliques = ". $reliques.",";
        }elseif($reliques+1>($fabriques-$nbr)*$stockRelByFab){
            //Si on était tout juste, il faut aussi annuler la creation de la prochaine relique
            if($reliqueDateDebut!=NULL){
                $update.="reliqueDateDebut = NULL,";
            }
        }

        //On perd les ressources si la destruction a été demandée
        if($voulue){
            $update.="ress1=". ($ress1-$nbr*$ress1fab/2) .", ress2=". ($ress2-$nbr*$ress2fab/2) .",";
        }

        //On perd finalement les batiments et le batiment en construction si il y en avait un
        $update.="constrEnCours=0, fabriques = ".($fabriques-$nbr)." WHERE id=" . $id ;

        if ($conn->query($update)) {
            //echo "Destruction de ".$nbr. " fabriques(s) du village ".$id. " <br />";
            if($voulue) {
                $update = "DELETE FROM listBatiments WHERE id_village=".$id." AND id_batiment=4 AND x=".$x." AND y=".$y;
             }else {
                $update = "DELETE FROM listBatiments WHERE id_village=".$id." AND id_batiment=4  LIMIT ".$nbr;
             }

            if ($conn->query($update)) {
                if($voulue) {
                    $update = "DELETE FROM listBatiments WHERE id_village=".$id." AND enConstruction=1";

                    if($conn->query($update)) {
                        echo json_encode("true");
                    }else {
                        echo "Error: " . $update . "<br/>" . $conn->error . "<br/>";
                    }
                }else {
                    echo json_encode("true");
                }
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
