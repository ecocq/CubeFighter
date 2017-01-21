<?php
    require '../BDD/connection.php';
        if(isset($_POST['pseudo']) AND isset($_POST['champ'])  )
        {
            $champ = $_POST['champ'];

            if (strlen($_POST['pseudo'])<=0)
            {
                if ($champ != 'img')
                {
                   echo "Le champ doit être rempli";
                }
                return;
            }

            if((strlen($_POST['pseudo'])<4 &&strlen($_POST['pseudo'])>0) || filter_var($_POST["pseudo"], FILTER_VALIDATE_EMAIL))
            {
                if ($champ == 'img')
                {
                    echo '<img src="Image/not_ok.png" style="border:0;"/>';
                }
                else
                {
                    echo 'Pseudonyme trop court';
                }
                return;
            }

            $pseudo = $_POST['pseudo'];

            $searchpseudo = "SELECT pseudo FROM users WHERE pseudo='" .$pseudo ."'";
            $resultpseudo = $conn->query($searchpseudo);


            if($resultpseudo->num_rows == 0)
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
                    echo 'Le pseudonyme existe déja';
                }
            }
        }
    require '../BDD/disconnection.php';
?>
