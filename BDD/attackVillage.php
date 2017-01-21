<?php
$idVillage = (int) $_POST['id'];
$attacked = (int) $_POST['attacked'];
$bataillon = (int) $_POST['soldats'];

/*-------------- CONSTANTES ---------------*/
$forceExtSoldat = 5;
$forceIntSoldat = 6;
$forceCitoyen = 0.01;
$forceMineur = 0.02;
/*-----------------------------------------*/

echo "Village ".$idVillage." attaque le village ". $attacked."<br/>";

if($idVillage == $attacked){
    echo "Le village ne peut s'attaquer lui-même";
    return FALSE;
}
if($bataillon<=0){
    echo "On ne lance pas d'attaques sans soldat";
    return FALSE;
}

require "connection.php";

/* Mise à jour pour avoir les bonnes ressources */
$id = $idVillage;
include "majDataVillage.php"; //Mise à jour du village attaquant

/*------------------------------------------*/
/* Vérification de la validité de l'attaque */
/*------------------------------------------*/
$sql = "SELECT soldats, attaquePossible FROM village WHERE id=" . $idVillage;

if ($result = $conn->query($sql)) {
    if($result->num_rows > 0 && $row = $result->fetch_assoc()){
        $soldatsDuVillage = $row["soldats"];
        $attaquePossible = $row["attaquePossible"];
    }
$result->free();
}else {
    echo "Pas de village avec l'id ". $idVillage."<br/>" .$sql ." ". $conn->error;
    require "disconnection.php";
    return FALSE;
}

//On vérifie si une attaque n'est pas déjà lancée
if($attaquePossible == FALSE){
    echo "Une attaque est déjà en cours";
    require "disconnection.php";
    return FALSE;
}

//On vérifie si le nombre de soldats est correct
if($bataillon > $soldatsDuVillage){
    echo "Il n'y a pas assez de soldats dans le village";
    require "disconnection.php";
    return FALSE;
}

//On vérifie si le village attaqué existe
$sql = "SELECT id FROM village WHERE id=" . $attacked;
if (!$conn->query($sql)) {
    echo "Pas de village avec l'id ". $attacked."<br/>" .$sql ." ". $conn->error;
    require "disconnection.php";
    return FALSE;
}

/* Le bataillon peut partir à l'attaque */
$sql = "INSERT INTO attaque (idAttaquant, idAttaque, bataillon, reg_date)
VALUES (".$idVillage.",".$attacked.",".$bataillon.",now())";

if ($conn->query($sql) === TRUE) {
    $attaque = $conn->insert_id;
    echo "Nouvelle attaque n°".$attaque." enregistrée<br/>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    require "disconnection.php";
    return FALSE;
}

$update = "UPDATE village SET soldats=".($soldatsDuVillage-$bataillon).", attaquePossible= FALSE WHERE id=".$idVillage;
if ($conn->query($update)) {
    echo "L'attaque est lancée!!";
} else {
    echo "Error: " . $update . "<br/>" . $conn->error . "<br/>";
}
require "disconnection.php";

/*-------------------------------------*/
/* Temps d'atteindre le village ennemi */
/*-------------------------------------*/
sleep(10);


require "connection.php";

//Mise à jour des données du village ennemi
$id = $attacked;
include "majDataVillage.php";

$sql = "SELECT protected FROM village WHERE id=" . $attacked;
if ($result = $conn->query($sql)) {
    if($result->num_rows > 0 && $row = $result->fetch_assoc()){
        if($row["protected"]!=NULL){
            /* Le villag est encore protégé */
            echo "Le village est barricadé, impossible d'attaquer";

            //rammener soldats au village sans perte

            $sql = "SELECT bataillon FROM attaque WHERE id=" . $attaque;
            if ($result = $conn->query($sql)) {
                if($result->num_rows > 0 && $row = $result->fetch_assoc()){
                    $bataillon = $row["bataillon"];
                }
            $result->free();
            }else {
                echo "Pas d'attaque avec l'id ". $attaque."<br/>" .$sql ." ". $conn->error;
                require "disconnection.php";
                return FALSE;
            }

            //Mise a jour soldats restants
            $up = "UPDATE attaque SET soldatsRestants =". $bataillon." WHERE id=".$attaque;
            if ($conn->query($up)) {
                echo "Les soldats rentrent...";
            } else {
                echo "Error: " . $up . "<br/>" . $conn->error . "<br/>";
            }

        }else{
            /*---------------------------------*/
            /* Calcul du résultat de l'attaque */
            /*---------------------------------*/

            /* -- On calcule la force d'attaque des deux camps --*/
            srand();
            //Armée extérieure
            $sql = "SELECT bataillon FROM attaque WHERE id=" . $attaque;
            if ($result = $conn->query($sql)) {
                if($result->num_rows > 0 && $row = $result->fetch_assoc()){
                    $forceExt = $row["bataillon"]*$forceExtSoldat*rand(100,150)/100;
                }
            $result->free();
            }else {
                echo "Pas d'attaque avec l'id ". $attaque."<br/>" .$sql ." ". $conn->error;
                require "disconnection.php";
                return FALSE;
            }

            //Armée intérieure
            //On récupère l'id du village attaqué
            $sql = "SELECT idAttaque FROM attaque WHERE id=" . $attaque;
            if ($result = $conn->query($sql)) {
                if($result->num_rows > 0 && $row = $result->fetch_assoc()){
                    $attacked = $row["idAttaque"];
                }
            $result->free();
            }else {
                echo "Pas d'attaque avec l'id ". $attaque."<br/>" .$sql ." ". $conn->error;
                require "disconnection.php";
                return FALSE;
            }

            //On calcule la force du village attaqué
            $sql = "SELECT * FROM village WHERE id=" . $attacked;
            if ($result = $conn->query($sql)) {
                if($result->num_rows > 0 && $row = $result->fetch_assoc()){
                    $soldInt = $row["soldats"];
                    $forceInt = $row["soldats"]*$forceIntSoldat*rand(100,150)/100+ $row["citoyens"]*$forceCitoyen + $row["mineurs"]*$forceMineur;
                    $habitations = $row["habitations"];
                    $citoyens = $row["citoyens"];
                    $casernes = $row["casernes"];
                    $centresFormation = $row["centresFormation"];
                    $mineurs = $row["mineurs"];
                    $depots1 = $row["depots1"];
                    $depots2 = $row["depots2"];
                    $reliques = $row["reliques"];
                    $ress1 = $row["ress1"];
                    $ress2 = $row["ress2"];
                }
            $result->free();
            }else {
                echo "Pas de village avec l'id ". $attacked."<br/>" .$sql ." ". $conn->error;
                require "disconnection.php";
                return FALSE;
            }

            echo "Force exterieure : ".$forceExt." - Force interieure : ".$forceInt."<br/>";

            $up = "UPDATE attaque SET ";
            $up2 = "UPDATE village SET ";
            $bataillonSave = $bataillon;

            //Si la force exterieure n'est pas suffisante, elle ne pourra pas gagner... seuls quelques rescapés pourront rentrer en vie
            if($forceExt*2 < $forceInt){
                $bataillon = round($bataillon * rand(0,30)/100);
                $soldInt = round($soldInt * rand(80,100)/100);


            }else{ //La force extérieure est suffisante
                if($forceExt < $forceInt){ //Si la force exterieure est un peu moins importante mais elle peut faire plus de dégats
                    $bataillon = round($bataillon * rand(10,50)/100);
                    $soldInt = round($soldInt * rand(60,90)/100);
                    $habDetruites = floor($habitations * rand(0,30)/100);
                    $citoyens = floor($citoyens * rand(5,30)/100);
                    $casDetruites = floor($casernes * rand(0,20)/100);
                    $cenDetruits = floor($centresFormation * rand(0,30)/100);
                    $mineurs = floor($mineurs * rand(0,30)/100);;
                    $dep1Detruits = floor($depots1 * rand(0,40)/100);
                    $dep2Detruits = floor($depots2 * rand(0,30)/100);
                    $ress1volees = 0;
                    $ress2volees = 0;
                    $reliquesvolees = 0;
                }else{
                    $bataillon = round($bataillon * rand(60,90)/100);
                    $soldInt = round($soldInt * rand(10,50)/100);
                    $habDetruites = floor($habitations * rand(10,60)/100);
                    $citoyens = floor($citoyens * rand(30,60)/100);
                    $casDetruites = floor($casernes * rand(20,50)/100);
                    $cenDetruits = floor($centresFormation * rand(30,50)/100);
                    $mineurs = floor($mineurs * rand(30,60)/100);;
                    $dep1Detruits = floor($depots1 * rand(20,70)/100);
                    $dep2Detruits = floor($depots2 * rand(20,70)/100);
                    $ress1volees = floor($ress1 * rand(10,40)/100);
                    $ress2volees = floor($ress2 * rand(10,60)/100);
                    $reliquesvolees = floor($reliques * rand(10,60)/100);
                    $up.= "ress1Volees = ".$ress1volees.", ress2Volees = ".$ress2volees.", reliquesVolees=".$reliquesvolees.",";
                    $up2.=" ress1=".($ress1-$ress1volees).", ress2=".($ress2-$ress2volees).", reliques =".($reliques-$reliquesvolees).",";
                }
                $up2.="citoyens = ".$citoyens.", mineurs=".$mineurs.",";

                require "disconnection.php";
                //Destruction des batiments
                $id = $attacked;
                $voulueStr = "false";

                $nbr = $habDetruites;
                include "remHabVillage.php";
                $nbr = $casDetruites;
                include "remCaserneVillage.php";
                $nbr = $cenDetruits;
                include "remCentreVillage.php";
                $nbr = $dep1Detruits;
                include "remDepot1Village.php";
                $nbr = $dep2Detruits;
                include "remDepot2Village.php";
            }

            /*--- Update des données de l'attaque ---*/
            require "connection.php";

            $sujet = "[Rapport de bataille n°".$attaque."]";
            $text = "Une attaque a été menée contre vous. Voici le rapport de cette bataille:
            - Soldats ennemis tués: ".($bataillonSave-$bataillon)."
            - Soldats du village restants: ".$soldInt."
            - Mineurs restants: ".$mineurs."
            - Citoyens restants: ".$citoyens."

            - Reliques volées: ".$reliquesvolees."
            - Bois volé: ".$ress1volees."
            - Or volé: ".$ress2volees."

            - Habitations détruites:".$habDetruites."
            - Casernes détruites:".$casDetruites."
            - Centres de formation détruits:".$cenDetruits."
            - Granges détruites:".$dep1Detruits."
            - Banques détruites:".$dep2Detruits."
            ";
            $id_envoi = $attacked;
            include "envoiBilan.php";

            $up.=" soldatsRestants =". $bataillon .", forceExt=".$forceExt.", forceInt=".$forceInt." WHERE id=".$attaque;
            if ($conn->query($up)) {
                echo "Il reste ".$bataillon." soldats dans l'armée extérieure";
            } else {
                echo "Error: " . $up . "<br/>" . $conn->error . "<br/>";
            }
            $up2.=" soldats = ".$soldInt.", protected=now() WHERE id=".$attacked;
            if ($conn->query($up2)) {
                echo " et ".$soldInt." soldats dans le village attaqué <br/>";
            } else {
                echo "Error: " . $up2 . "<br/>" . $conn->error . "<br/>";
            }

        }
        require "disconnection.php";

    }
}else {
    echo "Pas d'attaque avec l'id ". $attaque."<br/>" .$sql ." ". $conn->error;
    require "disconnection.php";
    return FALSE;
}
/*---------------------------------------------------------------------------*/
/* Temps que l'information de défaite ou que les soldats arrivent au village */
/*---------------------------------------------------------------------------*/

sleep(10);


require "connection.php";
/*-----------------------------------*/
/* Mise à jour des données au retour */
/*-----------------------------------*/
$_POST['id'] = $idVillage;
include "majDataVillage.php";

//On n'utilise pas directement les variables php qui pourraient avoir été modifiées entre temps, on rappelle la BDD
$sql = "SELECT * FROM attaque WHERE id=" . $attaque;
if ($result = $conn->query($sql)) {
    if($result->num_rows > 0 && $row = $result->fetch_assoc()){
        $soldatsRestants = $row["soldatsRestants"];
        $ress1Volees = $row["ress1Volees"];
        $ress2Volees = $row["ress2Volees"];
        $reliquesVolees = $row["reliquesVolees"];
    }
$result->free();
}else {
    echo "Pas d'attaque  avec l'id ". $attaque."<br/>" .$sql ." ". $conn->error;
    require "disconnection.php";
    return FALSE;
}

$sql = "SELECT * FROM village WHERE id=" . $idVillage;
if ($result = $conn->query($sql)) {
    if($result->num_rows > 0 && $row = $result->fetch_assoc()){
        $soldats = $row["soldats"];
        $ress1 = $row["ress1"];
        $ress2 = $row["ress2"];
        $reliques = $row["reliques"];
        $depots1 = $row["depots1"];
        $depots2 = $row["depots2"];
        $nbrFab = $row["fabriques"];
        $casernes = $row["casernes"];
    }
$result->free();
}else {
    echo "Pas de village  avec l'id ". $idVillage."<br/>" .$sql ." ". $conn->error;
    require "disconnection.php";
    return FALSE;
}

/* Mise a jour des ressources */
$newress1= $ress1+$ress1Volees;
if($depots1 * $stockRess1ByDep < $newRess1){
    $newRess1 = $depots1 * $stockRess1ByDep;
}

$newRess2 = $ress2+$ress2Volees;
if($depots2 * $stockRess2ByDep < $newRess2){ //On ne peut pas dépasser le stockage max
            $newRess2 = $depots2 * $stockRess2ByDep;
        }

$newReliques = $reliques+$reliquesVolees;
if($stockRelByFab * $nbrFab < $newReliques){
    $newReliques = $stockRelByFab * $nbrFab;
}

$newSoldats = $soldats+$soldatsRestants;
if($stockSolByCas * $casernes < $newSoldats){
    $newSoldats = $stockSolByCas * $casernes;
}

$up = "UPDATE village SET soldats =".$newSoldats.", ress1=".$newRess1.",ress2=".$newRess2
    .", reliques = ".$newReliques.", attaquePossible=TRUE WHERE id=".$idVillage;
if ($conn->query($up)) {
    echo "L'attaque est terminée!!";
} else {
    echo "Error: " . $up . "<br/>" . $conn->error . "<br/>";
}

$sujet = "[Rapport de bataille n°".$attaque."]";
            $text = "Vous avez mené une bataille. Voici le rapport :
            - Soldats du bataillon tués: ".($bataillonSave-$bataillon)."

            - Reliques volées: ".$reliquesvolees."
            - Bois volé: ".$ress1volees."
            - Or volé: ".$ress2volees."

            - Habitations détruites:".$habDetruites."
            - Casernes détruites:".$casDetruites."
            - Centres de formation détruits:".$cenDetruits."
            - Granges détruites:".$dep1Detruits."
            - Banques détruites:".$dep2Detruits."
            ";
            $id_envoi = $idVillage;
            include "envoiBilan.php";

require "disconnection.php";
?>
