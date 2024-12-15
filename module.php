<?php
class Module {
    public $nom_module;
    public $nbr_heures;

    public static $errorMessage = "";  // Déclaration correcte de la propriété statique
    public static $successMessage = "";

    // Constructeur pour initialiser un module
    public function __construct($nom_module, $nbr_heures) {
        $this->nom_module = $nom_module;
        $this->nbr_heures = $nbr_heures;
    }

    // Méthode pour insérer un module dans la base de données
    public function insertModule($tableName, $conn) {
        $sql = "INSERT INTO $tableName (nom_module, nbr_heures) VALUES ('$this->nom_module', '$this->nbr_heures')";
        if (mysqli_query($conn, $sql)) {
            self::$successMessage = "New record created successfully";
        } else {
            self::$errorMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Méthode pour sélectionner tous les modules
    public static function selectAllModules($tableName, $conn) {
        $sql = "SELECT nom_module, nbr_heures FROM $tableName";
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

    // Méthode pour sélectionner un module par son nom
    public static function selectModuleByName($tableName, $conn, $nom_module) {
        $sql = "SELECT nom_module, nbr_heures FROM $tableName WHERE nom_module='$nom_module'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return null;
        }
    }

    // Méthode pour mettre à jour un module
    public static function updateModule($module, $tableName, $conn, $nom_module) {
        $sql = "UPDATE $tableName SET nbr_heures = '$module->nbr_heures' WHERE nom_module = '$nom_module'";
        if (mysqli_query($conn, $sql)) {
            self::$successMessage = "Record updated successfully";
        } else {
            self::$errorMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Méthode pour supprimer un module
    public static function deleteModule($tableName, $conn, $nom_module) {
        $sql = "DELETE FROM $tableName WHERE nom_module = '$nom_module'";
        if (mysqli_query($conn, $sql)) {
            self::$successMessage = "Record deleted successfully";
        } else {
            self::$errorMessage = "Error: " . mysqli_error($conn);
        }
    }
}
?>
