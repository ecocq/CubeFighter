<?php
    $valid=0;

    $reponse="no";

    if(isset($_POST["pseudo"])) {
    }
    elseif (filter_var($_POST["pseudo"], FILTER_VALIDATE_EMAIL))
    {
        $valid = 1;
    }
    else
    {
        $valid = 1;
    }

    if(isset($_POST["mail"]) && filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
    }
    else
    {
        $valid=1;
    }

    if(isset($_POST['password']) && isset($_POST['passwordcheck']) && $_POST['password'] == $_POST['passwordcheck'] && strlen($_POST['password'])>=8)
    {
    }
    else
    {
        $valid=1;
    }

    if($valid==0)
    {
        require 'connection.php';

        $pseudo = $conn->real_escape_string($_POST["pseudo"]);
        $req = "SELECT id FROM users WHERE pseudo='".$pseudo."'";

        $resultrequete = $conn->query($req);

        if($resultrequete->num_rows > 0)
        {
        }
        else
        {
            $email = $conn->real_escape_string($_POST["mail"]);
            $req = "SELECT id FROM users WHERE email='".$email."'";
            $resultrequete = $conn->query($req);

            if($resultrequete->num_rows > 0)
            {
            }
            else
            {

                $sql = "INSERT INTO users (pseudo,password,email,reg_date)
                VALUES ('".$pseudo."', '".$conn->real_escape_string(sha1($_POST["password"]))."', '".$email."', NOW())";

                if ($conn->query($sql)== TRUE)
                {
                    $reponse="ok";
                } else {
                   $reponse="Erreur: " . $sql . " " . $conn->error;
                }



            }
        }
        require 'disconnection.php';
    }
    echo json_encode(['reponse'=>$reponse]);
?>
