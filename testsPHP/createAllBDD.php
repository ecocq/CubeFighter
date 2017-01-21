<?php
    require 'connection.php';

// Créer la base de données
$sql = 'CREATE DATABASE IF NOT EXISTS '.$dbname;
if ($conn->query($sql)) {
    echo "Base de données créée correctement\n";
} else {
    echo 'Erreur lors de la création de la base de données : ' . mysql_error() . "\n";
}

// Connexion à la base de donnees créée
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/*
 * Creation de la table USERS
 */
$sql = "CREATE TABLE IF NOT EXISTS users (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
pseudo VARCHAR(30) NOT NULL,
password VARCHAR(255) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP
)";

if ($conn->query($sql) == TRUE) {
    echo "Table users ok";
} else {
    echo "Error creating table: " . $conn->error;
}

/*
 * Creation de la table JOUEURMESSAGE gérant les messages entre joueurs
 */
$sql = "CREATE TABLE IF NOT EXISTS joueurmessage (
  id int(6) unsigned NOT NULL AUTO_INCREMENT,
  idJoueurEnvoi int(6) unsigned DEFAULT NULL,
  idJoueurRecue int(6) unsigned DEFAULT NULL,
  sujet varchar(100) NOT NULL,
  texte varchar(1000) NOT NULL,
  date timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id),
  KEY idJoueurEnvoi (idJoueurEnvoi),
  KEY idJoueurRecue (idJoueurRecue))";

if ($conn->query($sql) == TRUE) {
    echo "Table joueurmessage ok";
} else {
    echo "Error creating table: " . $conn->error;
}

/*
 * Creation de la table VILLAGE modélisant le village d'un joueur
 */

$nbrCitoyens = 5;
$nbrSoldats = 0;
$nbrRess1 = 400;
$nbrRess2 = 200;
$nbrMineurs = 0;
$nbrReliques = 0;
$nbrCasernes = 0;
$nbrCentres = 0;
$nbrHabitations = 1;
$nbrFabriques = 0;
$nbrDepots1 = 1;
$nbrDepots2 = 1;

$sql = "CREATE TABLE IF NOT EXISTS village (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    citoyens INT UNSIGNED DEFAULT ".$nbrCitoyens.",
    soldats INT UNSIGNED DEFAULT ".$nbrSoldats.",
    soldatDateDebut TIMESTAMP NULL,
    mineurs INT UNSIGNED DEFAULT ".$nbrMineurs.",
    mineurDateDebut TIMESTAMP NULL,
    ress1 INT UNSIGNED DEFAULT ".$nbrRess1.",
    ress2 INT UNSIGNED DEFAULT ".$nbrRess2.",
    reliques INT UNSIGNED DEFAULT ".$nbrReliques.",
    reliqueDateDebut TIMESTAMP NULL,
    casernes INT UNSIGNED DEFAULT ".$nbrCasernes.",
    habitations INT UNSIGNED DEFAULT ".$nbrHabitations.",
    centresFormation INT UNSIGNED DEFAULT ".$nbrCentres.",
    fabriques INT UNSIGNED DEFAULT ".$nbrFabriques.",
    depots1 INT UNSIGNED DEFAULT ".$nbrDepots1.",
    depots2 INT UNSIGNED DEFAULT ".$nbrDepots2.",
    constrEnCours INT UNSIGNED DEFAULT 0,
    constrDateDebut TIMESTAMP NULL,
    attaquePossible BOOLEAN DEFAULT TRUE,
    protected TIMESTAMP,
    reg_date TIMESTAMP,
    last_maj TIMESTAMP
    )";

//constrEnCours: 0:rien - 1:habitation - 2:caserne - 3:centre de formation - 4:fabrique à reliques
//               5:dépot de ressources 1 - 6:dépot de ressources 2
if ($conn->query($sql) == TRUE) {
    echo "Table village ok";
} else {
    echo "Error creating table: " . $conn->error;
}

/*
* Création de la table ATTAQUE modélisant l'historique des attaques
*/
$sql = "CREATE TABLE IF NOT EXISTS attaque (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    idAttaquant INT UNSIGNED DEFAULT 0,
    idAttaque INT UNSIGNED DEFAULT 0,
    bataillon INT UNSIGNED DEFAULT 0,
    forceExt FLOAT DEFAULT 0,
    forceInt FLOAT DEFAULT 0,
    soldatsRestants INT UNSIGNED DEFAULT 0,
    ress1Volees INT UNSIGNED DEFAULT 0,
    ress2Volees INT UNSIGNED DEFAULT 0,
    reliquesVolees INT UNSIGNED DEFAULT 0,
    reg_date TIMESTAMP
    )";

//constrEnCours: 0:rien - 1:habitation - 2:caserne - 3:centre de formation - 4:fabrique à reliques
//               5:dépot de ressources 1 - 6:dépot de ressources 2
if ($conn->query($sql) == TRUE) {
    echo "Table attaque ok";
} else {
    echo "Error creating table: " . $conn->error;
}

    require 'disconnection.php';
?>
