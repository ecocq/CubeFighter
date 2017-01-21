<?php
    $idVillage = $_POST['id'];

    require 'connection.php';


    $sql = "SELECT protected FROM village WHERE id=" . $idVillage;

    if ($result = $conn->query($sql)) {
        if($result->num_rows > 0 && $row = $result->fetch_assoc()){
            echo json_encode($row["protected"]);
        }
    }

    require 'disconnection.php';
?>
