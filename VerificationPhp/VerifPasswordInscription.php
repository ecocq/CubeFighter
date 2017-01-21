<?php
    if(isset($_POST['password']) AND isset($_POST['champ']))
    {
        $champ = $_POST['champ'];
        if (strlen($_POST['password'])==0)
        {
            if ($champ != 'img')
            {
               echo "Le champ doit être rempli";
            }
            return;
        }
        if(strlen($_POST['password'])<8)
        {
            if ($champ == 'img')
            {
                echo '<img src="Image/not_ok.png" style="border:0;"/>';
            }
            else
            {
                echo 'Mot de passe trop court';
            }
        }else
        {
            if ($champ == 'img')
            {
                echo '<img src="Image/ok.png" style="border:0;"/>';
            }
        }
    }

?>
