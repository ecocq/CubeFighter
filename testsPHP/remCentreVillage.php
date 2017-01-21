<?php
$id = (int) $_GET['id'];
$nbr = (int) $_GET['nbr'];
$voulueStr = (string) $_GET['voulue'];

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
        $centres = $row["centresFormation"];
        $mineurs = $row["mineurs"];
        $mineurDateDebut = $row["mineurDateDebut"];
        $constrEnCours = $row["constrEnCours"];

        //On considère que le nombre de batiments communiqué doit être correct
        if($nbr>$centres){
            echo "Le nombre de batiments à détruire est supérieur au contenu du village";
            require "disconnection.php";
            return FALSE;
        }
        if($voulue && ($ress1<$nbr*$ress1cen/2 || $ress2<$nbr*$ress2cen/2)){ //pas suffisamment de ressources pour demander une destruction
            echo "Pas suffisamment de ressources pour demander la destruction de ". $nbr." batiment(s) : besoin de ". ($nbr*$ress1cen/2)." ress1 et ".($nbr*$ress2cen/2)." ress2";
            require "disconnection.php";
            return FALSE;
        }

        /* On peut donc commencer la destruction */

        $update = "UPDATE village SET ";

        //On perd aussi les mineurs qui étaient stockés dedans
        if($mineurs>($centres-$nbr)*$stockMinByCen){
            $mineurs=($centres-$nbr)*$stockMinByCen;
            $update.="mineurs = ". $mineurs.",";
        }

        //On perd les ressources si la destruction a été demandée
        if($voulue){
            $update.="ress1=". ($ress1-$nbr*$ress1cen/2) .", ress2=". ($ress2-$nbr*$ress2cen/2) .",";
        }

        //On perd finalement les batiments et le batiment en construction si il y en avait un
        $update.="constrEnCours=0, centresFormation = ".($centres-$nbr)." WHERE id=" . $id ;

        if ($conn->query($update)) {
            echo "Destruction de ".$nbr. " centre(s) de formation du village ".$id. " <br />";
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
