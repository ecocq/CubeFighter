<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projetwebbd";

// Connexion au serveur
$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {
    die('Connexion impossible : ' . mysql_error());
}

// Connexion à la base de donnees créée
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Creation de la table
$sql = "CREATE TABLE IF NOT EXISTS JoueurMessage (
id INT(6) UNSIGNED AUTO_INCREMENT,
idJoueurEnvoi INT(6) UNSIGNED,
idJoueurRecue INT(6) UNSIGNED,
sujet VARCHAR(100) NOT NULL,
texte VARCHAR(1000) NOT NULL,
date TIMESTAMP,
PRIMARY KEY (id),
FOREIGN KEY (idJoueurEnvoi) REFERENCES users(id),
FOREIGN KEY (idJoueurRecue) REFERENCES users(id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table JoueurMessage ok";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
