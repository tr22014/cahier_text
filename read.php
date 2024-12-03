<?php
include("connection.php");
$connection = new Connection();
include("prof.php");
$connection->selectDatabase("DB");

$profs = [];
// Call the static selectAllClients method and store the result of the method in $clients
if (isset($_POST['submitB'])) {
    // This logic for filtering clients by city is removed as there is no city-related functionality anymore.
    $profs = Prof::selectAllProfs("prof", $connection->conn);
} else {
   $profs = Prof::selectAllProfs("prof", $connection->conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container my-5">
    <h2>List of users from database</h2>
    <a class="btn btn-primary" href="create.php" role="button">Signup</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($profs as $row) {
                echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>" . htmlspecialchars($row['firstname']) . "</td>
                <td>" . htmlspecialchars($row['lastname']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>
                    <a class='btn btn-success' role='button' href='update.php?updatedId=" . htmlspecialchars($row['id']) . "'>Edit</a>
                    <a class='btn btn-danger' role='button' href='delete.php?deletedId=" . htmlspecialchars($row['id']) . "'>Delete</a>
                </td>
            </tr>";

              }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
