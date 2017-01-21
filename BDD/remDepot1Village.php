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
        $depots1 = $row["depots1"];
        $constrEnCours = $row["constrEnCours"];

        //On considère que le nombre de batiments communiqué doit être correct
        if($nbr>=$depots1){
            echo "Le nombre de batiments à détruire est supérieur ou égal au contenu du village";
            require "disconnection.php";
            return FALSE;
        }
        if($voulue && ($ress1<$nbr*$ress1dep1/2 || $ress2<$nbr*$ress2dep1/2)){ //pas suffisamment de ressources pour demander une destruction
            echo "Pas suffisamment de ressources pour demander la destruction de ". $nbr." batiment(s) : besoin de ". ($nbr*$ress1dep1/2)." ress1 et ".($nbr*$ress2dep1/2)." ress2";
            require "disconnection.php";
            return FALSE;
        }

        /* On peut donc commencer la destruction */

        $update = "UPDATE village SET ";

        //On perd les ressources si la destruction a été demandée
        if($voulue){
            $ress1=$ress1-$nbr*$ress1dep1/2;
            $ress2=$ress2-$nbr*$ress2dep1/2;
        }

        //On perd aussi les ressources qui étaient stockés dedans
        if($ress1>($depots1-$nbr)*$stockRess1ByDep){
            $ress1=($depots1-$nbr)*$stockRess1ByDep;
        }

        //On perd finalement les batiments et le batiment en construction si il y en avait un
        $update.="constrEnCours=0, depots1 = ".($depots1-$nbr).", ress1= ".$ress1.", ress2= ".$ress2." WHERE id=" . $id ;

        if ($conn->query($update)) {
            //echo "Destruction de ".$nbr. " dépôt(s) 1 du village ".$id. " <br />";
            if($voulue) {
                $update = "DELETE FROM listBatiments WHERE id_village=".$id." AND id_batiment=5 AND x=".$x." AND y=".$y;
             }else {
                $update = "DELETE FROM listBatiments WHERE id_village=".$id." AND id_batiment=5  LIMIT ".$nbr;
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
