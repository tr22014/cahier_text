<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password ,$dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (!mysqli_query($conn, $sql)) {
    echo "Erreur : " . mysqli_error($conn);
}


mysqli_select_db($conn, $dbname);


$fil = "CREATE TABLE IF NOT EXISTS filiere (
    nom_fil VARCHAR(20) NOT NULL PRIMARY KEY,
    annee DATE,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if (!mysqli_query($conn, $fil)) {
    echo "Erreur de creation de la table 'filiere' : " . mysqli_error($conn);
}

$grp = "CREATE TABLE IF NOT EXISTS groupe (
    num_grp int NOT NULL PRIMARY KEY,
    nom_grp VARCHAR(25) NOT NULL ,
    nom_fil VARCHAR(20),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (nom_fil) REFERENCES filiere(nom_fil)
)";
if (!mysqli_query($conn, $grp)) {
    echo "Erreur de creation de la table 'groupe' : " . mysqli_error($conn);
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
if (!mysqli_query($conn, $query)) {
    echo "Erreur de creation de la table 'prof' : " . mysqli_error($conn);
}

$txt = "CREATE TABLE IF NOT EXISTS cahier (
    id_prof INT(6) UNSIGNED,
    nom_grp VARCHAR(25),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id_prof, nom_grp),
    FOREIGN KEY (id_prof) REFERENCES prof(id_prof),
    FOREIGN KEY (nom_grp) REFERENCES groupe(nom_grp)
)";
if (!mysqli_query($conn, $txt)) {
    echo "Erreur de creation de la table 'cahier' : " . mysqli_error($conn);
}




mysqli_close($conn);
?>
