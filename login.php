<?php
// Inclure le fichier de connexion
include('connection.php');

// Variables pour gérer les messages
$errorMessage = "";
$emailValue = "";

// Vérifier si le formulaire a été soumis
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Vérification des champs vides
    if (empty($email) || empty($password)) {
        $errorMessage = "Tous les champs doivent être remplis !";
    } else {
        // Créer une instance de la classe Connection
        $connection = new Connection();
        $connection->selectDatabase('DB');

        // Préparer et exécuter la requête SQL
        $sql = "SELECT * FROM prof WHERE email = ? LIMIT 1";
        $stmt = $connection->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            // Vérifier si un utilisateur a été trouvé
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                // Vérifier le mot de passe avec password_verify
                if (password_verify($password, $user['pass'])) {
                    // Mot de passe correct, redirection vers la page "home.php"
                    header("Location: home.php");
                    exit();
                } else {
                    $errorMessage = "Mot de passe incorrect.";
                }
            } else {
                $errorMessage = "Aucun utilisateur trouvé avec cet email.";
            }
        } else {
            $errorMessage = "Erreur dans la requête SQL : " . $connection->conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2>Login</h2>

    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($errorMessage); ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($emailValue); ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary">Login</button>
        <a href="create.php" class="btn btn-secondary">Sign up</a>
    </form>
</div>
</body>
</html>
