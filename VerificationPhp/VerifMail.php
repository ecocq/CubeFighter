<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../BDD/connection.php';
    require 'Test_input.php';
    <script> console.log("inside");
      </script>
    if(isset($_POST['mail']) )
        {

            $email = test_input($_POST['mail']);

            $searchemail = "SELECT email FROM users WHERE email='" .$email ."'";
            $resultemail = $conn->query($searchemail);

            if($resultemail->num_rows == 0)
            {
               echo "true";

            }else
            {
              echo "false";
            }

        } else
        {
          echo "false";
        }
    require '../BDD/disconnection.php';
  }
?>
