<?php

  $valid=0;
  $reponse="no";

  if($valid == 0) {

    session_start();
    require 'connection.php';
    require '../VerificationPhp/Test_input.php';

    if(isset($_POST['currentMDP'])) {
    $pwd = sha1($conn->real_escape_string(test_input($_POST['currentMDP'])));
    $pseudo = $conn->real_escape_string($_SESSION["pseudo"]);
    $req = "SELECT id, password FROM users WHERE pseudo='".$pseudo."' AND password='".$pwd."'";
    $resultrequete = $conn->query($req);

    if($resultrequete->num_rows != 1){
        $row = $resultrequete->fetch_assoc();
        $reponse="false:id:".$row['id'].",pseudo: ".$pseudo .", pasBD: ".$row['password'].", pasCurrent: ".$pwd;
    } else {
        if(isset($_SESSION["pseudo"]) and isset($_POST["email"]) and isset($_POST["newMDP"])) {

          $pseudo = $conn->real_escape_string($_SESSION["pseudo"]);
          $req = "SELECT id FROM users WHERE pseudo='".$pseudo."'";
          $resultrequete = $conn->query($req);

          if(($row = $resultrequete->fetch_assoc()) and (empty($_POST["email"]) == false or empty($_POST["newMDP"]) == false)) {
            $updateDB = "UPDATE users SET ";
            if(empty($_POST["newMDP"]) == false){
              $updateDB= $updateDB."password='".$conn->real_escape_string(sha1($_POST["newMDP"]))."' ";
            }
            if(empty($_POST["email"]) == false){
              $updateDB= $updateDB."email='".$conn->real_escape_string($_POST["email"])."' ";
            }
            $updateDB= $updateDB."WHERE id='".$row["id"]."'";

            if($conn->query($updateDB) == TRUE) {
              $reponse= "ok";
            } else {
              $reponse= "Erreur: " . $updateDB . "<br>" . $conn->error;
            }
          }
        }
        if(isset($_SESSION["pseudo"]) && isset($_POST["village"]) && empty($_POST['village'] == false)){
           $pseudo = $conn->real_escape_string($_SESSION["pseudo"]);
          $req = "SELECT id FROM users WHERE pseudo='".$pseudo."'";
          $resultrequete = $conn->query($req);

          if($row = $resultrequete->fetch_assoc()) {
            $updateDB = "UPDATE listvillages SET nomVillage='".$conn->real_escape_string($_POST["village"])."' WHERE id_joueur='".$row["id"]."'";
            if($conn->query($updateDB) == TRUE) {
              $reponse= "ok";
            }else {
               $reponse= "Erreur: " . $updateDB . "<br>" . $conn->error;
            }
          }
        }
      }
      require 'disconnection.php';
    }
  }
  echo json_encode(['reponse'=>$reponse]);
?>
