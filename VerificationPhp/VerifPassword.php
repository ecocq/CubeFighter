<?php
  require 'Test_input.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['password']) && isset($_POST['passwordcheck'])) {

      $pwd = test_input($_POST['password']);

      if(strlen($pwd)<8) {
        echo "false";

      // On revérifie que les deux mots de passes sont correctes
      }elseif(empty($_POST['passwordcheck']) == false && $_POST['passwordcheck'] === $pwd) {
        echo "true";
      }elseif(empty($_POST['passwordcheck']) == true && $_POST['password'] === $pwd){
      }else {
        echo 'false';
      }
    } else echo "false";

  }
?>
