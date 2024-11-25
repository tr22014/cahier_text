<?php
class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $dbname = 'DB';
    private $conn;

    public function __construct() {
        // Connect to server
        $this->conn = new mysqli($this->host, $this->user, $this->password);
        if ($this->conn->connect_error) {
            die("Erreur de connexion : " . $this->conn->connect_error);
        }
    }

    // Création de la base de données
    public function createdatabase() {
        $sql = "CREATE DATABASE IF NOT EXISTS " . $this->dbname; 
        if (!$this->conn->query($sql)) {
            die("Erreur de création de la base de données : " . $this->conn->error);
        }
    }

    // Connexion à la base de données
    public function connectToDatabase() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname); // Inclure la base de données
        if ($this->conn->connect_error) {
            die("Erreur de connexion à la base de données : " . $this->conn->connect_error);
        }
    }

    // Exécution des requêtes
    public function executeQuery($sql) {
        if ($this->conn->query($sql) === FALSE) {
            echo "Erreur : " . $this->conn->error . "<br>";
        }
    }

    // Création des tables
    public function CreateTables() {
        $queries = [
            "CREATE TABLE IF NOT EXISTS module(
            nom_module VARCHAR(20) NOT NULL PRIMARY KEY,
            nbr INT 
            )",

            "CREATE TABLE IF NOT EXISTS filliere (
                nom_fil VARCHAR(20) NOT NULL PRIMARY KEY,
                annee DATE,
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",

            "CREATE TABLE IF NOT EXISTS groupe (
                num_grp INT NOT NULL PRIMARY KEY,
                nom_grp VARCHAR(25) NOT NULL,
                nom_fil VARCHAR(20),
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (nom_fil) REFERENCES filliere(nom_fil)
            )",

            "CREATE TABLE IF NOT EXISTS prof (
                id_prof INT(6) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
                firstname VARCHAR(20) NOT NULL,
                lastname VARCHAR(20) NOT NULL,
                email VARCHAR(30) NOT NULL,
                pass VARCHAR(255) NOT NULL,
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",

            "CREATE TABLE IF NOT EXISTS reminder (
                id_reminder INT AUTO_INCREMENT PRIMARY KEY,
                temps DATE,
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",

            "CREATE TABLE IF NOT EXISTS adm (
                id_admin INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",

            "CREATE TABLE IF NOT EXISTS enseigner (
                id_prof INT(6) UNSIGNED NOT NULL,
                nom_module VARCHAR(20) NOT NULL,
                num_grp INT NOT NULL,
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY(id_prof, nom_module, num_grp),
                FOREIGN KEY (nom_module) REFERENCES module(nom_module),
                FOREIGN KEY (id_prof) REFERENCES prof(id_prof)
            )",

            "CREATE TABLE IF NOT EXISTS appartient (
                nom_module VARCHAR(20) NOT NULL,
                nom_fil VARCHAR(20) NOT NULL,
                PRIMARY KEY (nom_module, nom_fil),
                FOREIGN KEY (nom_module) REFERENCES module(nom_module),
                FOREIGN KEY (nom_fil) REFERENCES filliere(nom_fil)
            )",

            "CREATE TABLE IF NOT EXISTS recevoir (
                id_prof INT(6) UNSIGNED NOT NULL,
                id_reminder INT,
                PRIMARY KEY (id_prof, id_reminder),
                FOREIGN KEY (id_prof) REFERENCES prof(id_prof),
                FOREIGN KEY (id_reminder) REFERENCES reminder(id_reminder)
            )",

            "CREATE TABLE IF NOT EXISTS entree (
                id_ent INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
                id_prof INT(6) UNSIGNED NOT NULL,
                id_admin INT NOT NULL,
                FOREIGN KEY (id_prof) REFERENCES prof(id_prof),
                FOREIGN KEY (id_admin) REFERENCES adm(id_admin)
            )",
            
            "CREATE TABLE IF NOT EXISTS seance (
                id_seance INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
                id_ent INT UNSIGNED NOT NULL,
                FOREIGN KEY (id_ent) REFERENCES entree(id_ent)
            )"
        ];

        // Parcourir et exécuter chaque requête
        foreach ($queries as $query) {
            $this->executeQuery($query);
        }
    }

    // Fermeture de la connexion
    public function closeConnection() {
        $this->conn->close();
    }
}

// Appel des fonctions
$db = new Database();
$db->createdatabase();
$db->connectToDatabase();
$db->CreateTables();
$db->closeConnection();
?>
