<?php
  require 'Test_input.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['password']) && isset($_POST['passwordcheck']))
    {
      $pwd = test_input($_POST['password']); // on ne vérifie que pour un
      if($pwd!=$_POST['passwordcheck'])
      {
        echo "false";
      }else
      {
        echo "true";
      }
    }
  }
?>
