<?php
    $reponse="Erreur";

    if(isset($_POST['mailOpseudo']) && isset($_POST['password']))
    {
        require 'connection.php';
        $mailpseud=1; //si c'est un mail, mailpseud=0, si c'est un pseudo, mailpseud=1
        if(filter_var($_POST["mailOpseudo"], FILTER_VALIDATE_EMAIL)) {
            $mailpseud=0;
        }
        else
        {
            $mailpseud=1;
        }


        $password = sha1($conn->real_escape_string($_POST['password']));
        $mp = $conn->real_escape_string($_POST["mailOpseudo"]);

        if($mailpseud=0)
        {
            $requete = "SELECT id,pseudo FROM users WHERE email='" .$mp ."' AND password='".$password."'";
        }
        else
        {
            $requete = "SELECT id,pseudo FROM users WHERE pseudo='" .$mp ."' AND password='".$password."'";
        }

        $resultrequete = $conn->query($requete);


        if($resultrequete->num_rows != 1)
        {
            $reponse="Identifiants incorrects";
        }
        else
        {
            session_start();
            $reponse="Vous etes connecté";

            $sess = $resultrequete->fetch_assoc();
            $_SESSION['id'] =$sess["id"];
            $_SESSION['pseudo'] = $sess["pseudo"];


        }
        require 'disconnection.php';
    }
    echo json_encode(['reponse'=>$reponse]);
?>
