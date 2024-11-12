<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (!$conn->query($sql)) {
    echo "Erreur : " . $conn->error;
}

$conn->select_db($dbname);

$fil = "CREATE TABLE IF NOT EXISTS filiere (
    nom_fil VARCHAR(20) NOT NULL PRIMARY KEY,
    annee DATE,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if (!$conn->query($fil)) {
    echo "Erreur de creation de la table 'filiere' : " . $conn->error;
}

$grp = "CREATE TABLE IF NOT EXISTS groupe (
    num_grp INT NOT NULL PRIMARY KEY,
    nom_grp VARCHAR(25) NOT NULL,
    nom_fil VARCHAR(20),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (nom_fil) REFERENCES filiere(nom_fil)
)";
if (!$conn->query($grp)) {
    echo "Erreur de creation de la table 'groupe' : " . $conn->error;
}

$query = "CREATE TABLE IF NOT EXISTS prof (
    id_prof INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(20) NOT NULL,
    lastname VARCHAR(20) NOT NULL,
    email VARCHAR(30) NOT NULL,
    pass VARCHAR(15) NOT NULL,
    nom_fil VARCHAR(20),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (nom_fil) REFERENCES filiere(nom_fil)
)";
if (!$conn->query($query)) {
    echo "Erreur de creation de la table 'prof' : " . $conn->error;
}

$txt = "CREATE TABLE IF NOT EXISTS cahier (
    id_prof INT(6) UNSIGNED,
    num_grp INT,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id_prof, num_grp),
    FOREIGN KEY (id_prof) REFERENCES prof(id_prof),
    FOREIGN KEY (num_grp) REFERENCES groupe(num_grp)
)";
if (!$conn->query($txt)) {
    echo "Erreur de creation de la table 'cahier' : " . $conn->error;
}

$conn->close();
?>
