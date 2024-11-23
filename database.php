<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (!$conn->query($sql)) {
    echo "Erreur : " . $conn->error;
}

$conn->select_db($dbname);




$mod = "CREATE TABLE IF NOT EXISTS module(
nom_module VARCHAR(20) NOT NULL PRIMARY KEY,
nbr INT 
)";

if (!$conn->query($mod)) {
    echo "Erreur de creation de la table 'module' : " . $conn->error;
}

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

$pr = "CREATE TABLE IF NOT EXISTS prof (
    id_prof INT(6) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    firstname VARCHAR(20) NOT NULL,
    lastname VARCHAR(20) NOT NULL,
    email VARCHAR(30) NOT NULL,
    pass VARCHAR(15) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if (!$conn->query($pr)) {
    echo "Erreur de creation de la table 'prof' : " . $conn->error;
}

$rem = "CREATE TABLE IF NOT EXISTS  reminder(
    id_reminder INT AUTO_INCREMENT PRIMARY KEY,
    temps DATE ,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if (!$conn->query($rem)) {
    echo "Erreur de creation de la table 'reminder' : " . $conn->error;
}

$adm = "CREATE TABLE IF NOT EXISTS adm(
id_admin INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if(!$conn->query($adm)){
    echo"Erreur de creation de la table 'admin' : " . $conn->error;
}

$ens ="CREATE TABLE IF NOT EXISTS enseigner(
 id_prof INT(6) UNSIGNED  NOT NULL,
 nom_module VARCHAR(20) NOT NULL,
 num_grp INT UNSIGNED NOT NULL,
 reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY(id_prof,nom_module,num_grp),
 FOREIGN KEY(nom_module) REFERENCES module(nom_module),
 FOREIGN KEY(id_prof) REFERENCES prof(id_prof),
 FOREIGN KEY (num_grp) REFERENCES groupe(num_grp)
)";

if(!$conn->query($ens)){
    echo"Erreuer de la creation de la table 'enseigner' : " . $conn->error ; 
}

$app = "CREATE TABLE IF NOT EXISTS appartient(
nom_module VARCHAR(20) NOT NULL,
nom_fil VARCHAR(20) NOT NULL ,
PRIMARY KEY (nom_module , nom_fil),
FOREIGN KEY (nom_module) REFERENCES module(nom_module),
FOREIGN KEY (nom_fil) REFERENCES filiere(nom_fil)
)";

if(!$conn->query($app)){
    echo"erreur de la creation de la table 'appartient' : " . $conn->error ;
}

$rec ="CREATE TABLE IF NOT EXISTS recevoir(
id_prof INT(6) UNSIGNED  NOT NULL,
id_reminder INT ,
PRIMARY KEY (id_prof , id_reminder),
FOREIGN KEY (id_prof) REFERENCES prof(id_prof),
FOREIGN KEY (id_reminder) REFERENCES reminder(id_reminder)
)";

if(!$conn->query($rec)){
    echo"Erreur de la creation de la table 'recevoir' : " . $conn->error;
}

$ent ="CREATE TABLE IF NOT EXISTS entree(
    id_ent INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    id_prof INT(6) UNSIGNED NOT NULL,
    id_admin INT NOT NULL ,
    FOREIGN KEY (id_prof) REFERENCES prof(id_prof),
    FOREIGN KEY (id_admin) REFERENCES adm(id_admin)
    )";
    
    if(!$conn->query($ent)){
        echo"Erreur de la creation de la table 'entree' : " . $conn->error;
    }

 $sea ="CREATE TABLE IF NOT EXISTS seance(
    id_seance INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    id_ent INT  NOT NULL,
    FOREIGN KEY (id_ent) REFERENCES entree(id_ent)
        )";
        
    if(!$conn->query($sea)){
            echo"Erreur de la creation de la table 'seance' : " . $conn->error;
        } 
$conn->close();
?>
