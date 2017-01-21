<?php
    require '../BDD/connection.php';
    if(isset($_POST['mail']) AND isset($_POST['champ'])  )
        {
            $champ = $_POST['champ'];

            if (strlen($_POST['mail'])<=0)
            {
                if ($champ != 'img')
                {
                   echo "Le champ doit être rempli";
                }
                return;
            }

            if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {

            } else {
                if ($champ == 'img')
                {
                    echo '<img src="Image/not_ok.png" style="border:0;"/>';
                }
                else
                {
                    echo 'Mauvais format';
                }
                return;
            }

            $email = $_POST['mail'];

            $searchemail = "SELECT email FROM users WHERE email='" .$email ."'";
            $resultemail = $conn->query($searchemail);


            if($resultemail->num_rows == 0)
            {
                if ($champ == 'img')
                {
                     echo '<img src="Image/ok.png" style="border:0;"/>';
                }
            }else
            {
               if ($champ == 'img')
                {
                     echo '<img src="Image/not_ok.png" style="border:0;"/>';
                }
                else
                {
                    echo 'Email existe déja';
                }
            }
        }
    require '../BDD/disconnection.php';
?>
