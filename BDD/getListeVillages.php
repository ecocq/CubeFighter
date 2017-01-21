<?php
    require 'connection.php';

    $sql = "SELECT * FROM listvillages";


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


    require 'disconnection.php';
?>
