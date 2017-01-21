<?php
    session_start();
    if(isset($_SESSION['id']) && isset($_SESSION['pseudo']))
    {
    }

    if(isset($_POST['destinataire']) && isset($_POST['sujet']) && isset($_POST['text']) && isset($_SESSION['id']))
    {
        require '../BDD/connection.php';

        $dest = $conn->real_escape_string($_POST["destinataire"]);
        $req ="SELECT id FROM users WHERE pseudo='".$dest."'";
        $resultrequete = $conn->query($req);

        $donnees = $resultrequete->fetch_assoc();

        if($donnees)
        {
            $iddes=$donnees["id"];
            $idEnv = $_SESSION['id'];
            $sujet = $conn->real_escape_string($_POST["sujet"]);
            $text = $conn->real_escape_string($_POST["text"]);


            $req = "INSERT INTO joueurmessage (idJoueurEnvoi, idJoueurRecue, sujet, texte, date)
            VALUES (".$idEnv.", ".$iddes.", \"".$sujet."\", \"".$text."\", NOW())";
            $resultrequete = $conn->query($req);

            $reponse = 'Votre message a bien été envoyé!';

        }
        else
        {
            $reponse = "Le joueur n'existe pas";
        }
        require '../BDD/disconnection.php';

        echo json_encode(['reponse'=>$reponse]);
    }
?>
