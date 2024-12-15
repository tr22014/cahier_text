<?php

// Inclure le fichier de connexion
include('connection.php');

// Créer une instance de la classe Connection
$connection = new Connection();

// Créer la base de données "DB"
$connection->createDatabase('DB');

// Sélectionner la base de données
$connection->selectDatabase('DB');

// Liste des requêtes SQL pour créer les tables
$queries = [
    "CREATE TABLE IF NOT EXISTS module (
        nom_module VARCHAR(20) NOT NULL PRIMARY KEY,
        nbr_heures INT 
    )",
    "CREATE TABLE IF NOT EXISTS filliere (
        nom_fil VARCHAR(20) NOT NULL PRIMARY KEY,
        annee DATE,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )",
     "CREATE TABLE IF NOT EXISTS groupe (
        id_grp INT AUTO_INCREMENT PRIMARY KEY,
        nom_grp VARCHAR(50) NOT NULL,
        nom_fil VARCHAR(50) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (nom_fil) REFERENCES filiere(nom_fil) ON DELETE CASCADE
    )",
    "CREATE TABLE IF NOT EXISTS prof (
        id INT(6) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
        firstname VARCHAR(20) NOT NULL,
        lastname VARCHAR(20) NOT NULL,
        email VARCHAR(30) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        pass VARCHAR(255) NOT NULL
    )",
    "CREATE TABLE IF NOT EXISTS enseigner (
        id INT(6) UNSIGNED NOT NULL,
        nom_module VARCHAR(20) NOT NULL,
        id_grp INT NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id_prof, nom_module, num_grp),
        FOREIGN KEY (nom_module) REFERENCES module(nom_module),
        FOREIGN KEY (id) REFERENCES prof(id),
        FOREIGN KEY (id_grp) REFERENCES groupe(id_grp)
    )",
    "CREATE TABLE IF NOT EXISTS appartient (
        nom_module VARCHAR(20) NOT NULL,
        nom_fil VARCHAR(20) NOT NULL,
        PRIMARY KEY (nom_module, nom_fil),
        FOREIGN KEY (nom_module) REFERENCES module(nom_module),
        FOREIGN KEY (nom_fil) REFERENCES filliere(nom_fil)
    )",
     "CREATE TABLE IF NOT EXISTS seance (
        id_seance INT(6) NOT NULL,
        id INT(6) UNSIGNED NOT NULL,
        PRIMARY KEY (id_seance),
        FOREIGN KEY (id) REFERENCES prof(id)
    )"

];

// Créer les tables
foreach ($queries as $query) {
    $connection->createTable($query);
}

//call the selectDatabase method to select the chap4Db
$connection->selectDatabase('DB');

//call the createTable method to create table with the $query
$connection->createTable($query);


?>