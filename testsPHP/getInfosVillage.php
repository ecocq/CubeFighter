<?php
$id = (int) $_GET['id'];

require "connection.php";

/* Mise à jour de la derniere connexion */
require "majDataVillage.php";


$sql = "SELECT * FROM village WHERE id=" . $id;

if ($result = $conn->query($sql)) {
    if($row = $result->fetch_assoc()){ //cet id existe
        // on n'a pas besoin de boucler sur les differents resultats car il ne doit y en avoir qu'un seul
        echo " Village " . $id . " : "
            ."<br/>Citoyens: ". $row['citoyens']
            ."<br/>Soldats: ". $row['soldats']
            ."<br/>Soldat en cours: ". $row['soldatDateDebut']
            ."<br/>Mineurs: ". $row['mineurs']
            ."<br/>Dernier mineur formé: ". $row['mineurDateDebut']
            ."<br/>Ressource 1: ". $row['ress1']
            ."<br/>Ressource 2: ". $row['ress2']
            ."<br/>Reliques: ". $row['reliques']
            ."<br/>Relique en cours: ". $row['reliqueDateDebut']
            ."<br/>Casernes: ". $row['casernes']
            ."<br/>Habitations: ". $row['habitations']
            ."<br/>Centres de formation: ". $row['centresFormation']
            ."<br/>Fabriques à reliques: ". $row['fabriques']
            ."<br/>Dépots de ressources 1: ". $row['depots1']
            ."<br/>Dépots de ressources 2: ". $row['depots2']
            ."<br/>Construction en cours: ". $row['constrEnCours']
            ."<br/>Date de derniere construction: ". $row['constrDateDebut']
            ."<br/>Attaque possible: ". $row['attaquePossible']
            ."<br/>Protégé: ". $row['protected']
            ."<br/>Date de creation: ". $row['reg_date']
            ."<br/>Date de derniere maj: ". $row['last_maj'];

    }else {
        echo "Pas de village avec l'id ". $id;
    }
    $result->free();
} else {
    echo "Error: " . $sql . "<br/>" . $conn->error;
}

require "disconnection.php";
?>
