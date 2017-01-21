<?php
  require 'Test_input.php'
  require '../BDD/connection.php';
  if(isset($_POST['password'])) {
    $pwd = sha1($conn->real_escape_string(test_input($_POST['password'])));
    $pseudo = $conn->real_escape_string($_SESSION["pseudo"]);
    $req = "SELECT id FROM users WHERE pseudo='".$pseudo."' AND password='".$pwd."'";
    $resultrequete = $conn->query($req);

    if($resultrequete->num_rows != 1){
        echo 'false';
    } else {
      echo 'true';
    }

  } else echo 'false';
  require '../BDD/disconnection.php';
?>
