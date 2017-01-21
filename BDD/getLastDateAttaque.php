<?php
    $id = $_POST['id_village'];


    require 'connection.php';


    $sql = "SELECT * FROM attaque WHERE idAttaquant=".$id." ORDER BY reg_date DESC LIMIT 1";

    if ($result = $conn->query($sql)) {
        if($row = $result->fetch_assoc()) {
            echo json_encode($row);
        }else {
            echo "Error : Pas d'attaque en cours.";
        }
    }else {
        echo "Error: " . $sql . "<br/>" . $conn->error;
    }

    require 'disconnection.php';
?>
