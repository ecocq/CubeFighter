<?php
    session_start();
    if(isset($_SESSION['id']) && isset($_SESSION['pseudo']))
    {
    }

    if(isset($_POST['Message']) && isset($_SESSION['id']) && count($_POST['Message'])>0 )
    {
        require '../BDD/connection.php';

        $v2="";
        foreach($_POST['Message'] as $valeur)
        {
            if($v2 =="")
            {
                $v2 = $v2.$conn->real_escape_string($valeur);
            }
            else {
                $v2 = $v2.", ".$conn->real_escape_string($valeur);;
            }

        }

        $req ="DELETE FROM joueurmessage WHERE id IN (".$v2.")";
        $resultrequete = $conn->query($req);

        if ($resultrequete == TRUE) {
            $reponse= "Les messages ont correctement été supprimés";
        } else {
             $reponse= "Les messages n'ont pas correctement été supprimés";
        }

        require '../BDD/disconnection.php';

    }
    else {
        $reponse = "Aucun message n'a été sélectionné";
    }

    echo json_encode(['reponse'=>$reponse]);
?>
