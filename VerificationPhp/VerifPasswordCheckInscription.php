<?php
    if(isset($_POST['password']) && isset($_POST['passwordcheck']) && isset($_POST['champ']))
    {
        $champ = $_POST['champ'];
        if (strlen($_POST['passwordcheck'])<=0)
        {
            if ($champ != 'img')
            {
               echo "Le champ doit être rempli";
            }
            return;
        }

        if($_POST['password']!=$_POST['passwordcheck'])
        {
            if ($champ == 'img')
            {
                echo '<img src="Image/not_ok.png" style="border:0;"/>';
            }
            else
            {
                echo 'Les mots de passe sont différents';
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
