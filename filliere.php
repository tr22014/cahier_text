<?php
class Filliere {
    public $nom_fil;
    public $annee;
    public $reg_date;

    public static $errorMessage = "";  // Déclaration correcte de la propriété statique
    public static $successMessage = "";

    // Constructeur pour initialiser une fillière
    public function __construct($nom_fil, $annee) {
        $this->nom_fil = $nom_fil;
        $this->annee = $annee;
    }

    // Méthode pour insérer une fillière dans la base de données
    public function insertFilliere($tableName, $conn) {
        $sql = "INSERT INTO $tableName (nom_fil, annee) VALUES ('$this->nom_fil', '$this->annee')";
        if (mysqli_query($conn, $sql)) {
            self::$successMessage = "New record created successfully";
        } else {
            self::$errorMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Méthode pour sélectionner toutes les fillières
    public static function selectAllFillieres($tableName, $conn) {
        $sql = "SELECT nom_fil, annee, reg_date FROM $tableName";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            self::$errorMessage = "Error in query: " . mysqli_error($conn);
            return [];
        }

        if (mysqli_num_rows($result) > 0) {
            $table = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $table[] = $row;
            }
            return $table;
        } else {
            return [];
        }
    }

    // Méthode pour sélectionner une fillière par son nom
    public static function selectFilliereByName($tableName, $conn, $nom_fil) {
        $sql = "SELECT nom_fil, annee, reg_date FROM $tableName WHERE nom_fil='$nom_fil'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return null;
        }
    }

    // Méthode pour mettre à jour une fillière
    public static function updateFilliere($filliere, $tableName, $conn, $nom_fil) {
        $sql = "UPDATE $tableName SET annee = '$filliere->annee' WHERE nom_fil = '$nom_fil'";
        if (mysqli_query($conn, $sql)) {
            self::$successMessage = "Record updated successfully";
        } else {
            self::$errorMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Méthode pour supprimer une fillière
    public static function deleteFilliere($tableName, $conn, $nom_fil) {
        $sql = "DELETE FROM $tableName WHERE nom_fil = '$nom_fil'";
        if (mysqli_query($conn, $sql)) {
            self::$successMessage = "Record deleted successfully";
        } else {
            self::$errorMessage = "Error: " . mysqli_error($conn);
        }
    }
}
?>
