
<?php
    session_start();
    if(isset($_SESSION['id']) && isset($_SESSION['pseudo']))
    {
    }
    require '../BDD/connection.php';

    $id_mess = (int) $conn->real_escape_string($_GET['id']);

    $req = "SELECT pseudo, idJoueurEnvoi, idJoueurRecue, sujet, texte, date
    FROM joueurmessage, users
    WHERE joueurmessage.id=".$id_mess." AND idJoueurEnvoi=users.id";

    $resultrequete = $conn->query($req);

    $ligne = $resultrequete->fetch_assoc();

    if($_SESSION['id'] != $ligne["idJoueurRecue"]) die(" Mauvais utilisateur");

    require '../BDD/disconnection.php';

    echo json_encode($ligne);
?>
