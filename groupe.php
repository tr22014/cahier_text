<?php

class groupe {
    public $num_grp;
    public $nom_grp;
    public $nom_fil;
    public static $errorMessage = "";
    public static $successMessage = "";
    
    // Constructeur pour initialiser un groupe
    public function __construct($num_grp, $nom_grp, $nom_fil) {
        $this->num_grp = $num_grp;
        $this->nom_grp = $nom_grp;
        $this->nom_fil = $nom_fil;
    }

    // Méthode statique pour ajouter un groupe
    public static function createGroupe($num_grp, $nom_grp, $nom_fil, $conn) {
        // Requête d'insertion
        $sql = "INSERT INTO groupe (id_grp, nom_grp, nom_fil) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        // Vérification si la préparation a échoué
        if (!$stmt) {
            return "Erreur de préparation de la requête : " . $conn->error;
        }
    
        // Lier les paramètres
        $stmt->bind_param("iss", $num_grp, $nom_grp, $nom_fil);
    
        // Exécuter la requête
        if ($stmt->execute()) {
            return "Groupe ajouté avec succès.";
        } else {
            return "Erreur lors de l'ajout du groupe : " . $stmt->error;
        }
    }
    
    // Méthode pour obtenir tous les groupes
    public static function selectAllGroupes($table, $conn) {
        try {
            $sql = "SELECT * FROM " . $table;
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                return [];
            }
        } catch (Exception $e) {
            return "Erreur de sélection : " . $e->getMessage();
        }
    }

    // Méthode pour sélectionner un groupe par son numéro
    public static function selectGroupeByNum($num_grp, $conn) {
        try {
            $sql = "SELECT * FROM groupe WHERE id_grp = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $num_grp);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                return new groupe($row['id_grp'], $row['nom_grp'], $row['nom_fil']);
            } else {
                return null; // Aucun groupe trouvé
            }
        } catch (Exception $e) {
            return "Erreur de sélection : " . $e->getMessage();
        }
    }

    // Méthode pour mettre à jour un groupe
    public static function updateGroupe($tableName, $conn, $num_grp, $nom_grp, $nom_fil) {
        // Créer une requête SQL pour mettre à jour les informations du groupe
        $query = "UPDATE $tableName SET nom_grp = ?, nom_fil = ? WHERE id_grp = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $nom_grp, $nom_fil, $num_grp);  // "s" pour string, "i" pour integer
        
        if ($stmt->execute()) {
            return "Groupe mis à jour avec succès.";
        } else {
            return "Erreur lors de la mise à jour du groupe.";
        }

        $stmt->close();
    }

    // Méthode pour supprimer un groupe
    public static function deleteGroupe($tableName, $conn, $num_grp) {
        // Créer une requête SQL pour supprimer le groupe avec le numéro de groupe spécifié
        $query = "DELETE FROM $tableName WHERE id_grp = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $num_grp);  // "i" pour l'entier (numéro du groupe)
        
        if ($stmt->execute()) {
            echo "Groupe supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression du groupe.";
        }

        $stmt->close();
    }
}

?>
