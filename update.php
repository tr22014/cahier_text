<?php
include("connection.php");
include("prof.php");

// Créer une instance de Connection
$connection = new Connection();
$connection->selectDatabase("DB");

// Initialiser les variables
$errorMesage = "";
$successMesage = "";
$fnameValue = $lnameValue = $emailValue = "";

// Vérifier la méthode GET et l'existence de 'updatedId'
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['updatedId'])) {
        $updatedId = $_GET['updatedId'];

        // Récupérer les données à partir de la base de données
        $row = Prof::selectProfById("prof", $connection->conn, $updatedId);

        if ($row) {
            $fnameValue = $row['firstname'];
            $lnameValue = $row['lastname'];
            $emailValue = $row['email'];
        } else {
            $errorMsg = "No record found with ID $updatedId.";
        }
    } else {
        $errorMsg = "Missing 'updatedId' parameter.";
    }
}

// Vérifier la méthode POST pour la mise à jour
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['updatedId'])) {
    $updatedId = $_GET['updatedId'];

    // Récupérer les valeurs du formulaire
    $fnameValue = $_POST['firstName'] ?? '';
    $lnameValue = $_POST['lastName'] ?? '';
    $emailValue = $_POST['email'] ?? '';

    // Validation des champs
    if (empty($fnameValue) || empty($lnameValue) || empty($emailValue)) {
        $errorMsg = "All fields must be filled in.";
    } else {
        // Créer une instance de Prof et mettre à jour la base de données
        $prof = new Prof($fnameValue, $lnameValue, $emailValue, '');
        $updated = Prof::updateProf($prof, "prof", $connection->conn, $updatedId);

        if ($updated) {
            $successMesage = "Record updated successfully!";
        } else {
            $errorMsg = "Failed to update record.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Update</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Update Record</h2>

        <!-- Afficher les messages d'erreur -->
        <?php if (!empty($errorMesage)): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?= htmlspecialchars($errorMesage); ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Formulaire de mise à jour -->
        <form method="post">
            <div class="row mb-3">
                <label class="col-form-label col-sm-2" for="fname">First Name:</label>
                <div class="col-sm-6">
                    <input value="<?= htmlspecialchars($fnameValue); ?>" class="form-control" type="text" id="fname" name="firstName">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-form-label col-sm-2" for="lname">Last Name:</label>
                <div class="col-sm-6">
                    <input value="<?= htmlspecialchars($lnameValue); ?>" class="form-control" type="text" id="lname" name="lastName">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-form-label col-sm-2" for="email">Email:</label>
                <div class="col-sm-6">
                    <input value="<?= htmlspecialchars($emailValue); ?>" class="form-control" type="email" id="email" name="email">
                </div>
            </div>

            <!-- Afficher les messages de succès -->
            <?php if (!empty($successMesage)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><?= htmlspecialchars($successMesage); ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row mb-3">
                <div class="col-sm-6 offset-sm-2 d-grid">
                    <button name="submit" type="submit" class="btn btn-primary">Update</button>
                </div>
                <div class="col-sm-2 d-grid">
                    <a class="btn btn-outline-primary" href="read.php">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>