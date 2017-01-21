<?php
    require 'connection.php';

    $id = $_POST['id_village'];

    include 'majDataVillage.php';



    $sql = "SELECT * FROM listBatiments WHERE id_village=" . $id;


    if ($result = $conn->query($sql)) {
        while($row = $result->fetch_assoc()){
            // $rows[] = $r; has the same effect, without the superfluous data attribute
             $rows[]['data'] = $row;
        }

        echo json_encode($rows);

        $result->free();
    } else {
        echo "Error: " . $sql . "<br/>" . $conn->error;
    }

    require "disconnection.php";


?>
