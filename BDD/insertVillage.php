<?php
require "connection.php";

$sql = "INSERT INTO village (reg_date, last_maj, protected)
VALUES (now(), now(),now())";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

require "disconnection.php";
?>
