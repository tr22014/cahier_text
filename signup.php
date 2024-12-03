<?php
session_start();

class UserRegistration {
    private $conn;
    private $error_message = "";

    public function __construct($servername, $username, $password, $dbname) {
        // Establish the database connection
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function registerUser($firstname, $lastname, $email, $pass, $cpass) {
        // Validate input
        if (empty($firstname) || empty($lastname) || empty($email) || empty($pass) || empty($cpass)) {
            $this->error_message = "Please fill in all fields.";
        } elseif (!preg_match("/^[\w\.-]+@emsi\.edu$/", $email)) {
            $this->error_message = "Email must end with @emsi.edu.";
        } elseif (strlen($pass) < 8) {
            $this->error_message = "Password must contain at least 8 characters.";
        } elseif ($pass !== $cpass) {
            $this->error_message = "Passwords do not match.";
        } else {
            // Check if email exists
            if ($this->emailExists($email)) {
                $this->error_message = "Email is already in use by another user.";
            } else {
                // Insert user into the database
                $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                if ($this->insertUser($firstname, $lastname, $email, $hashed_pass)) {
                    $_SESSION["firstname"] = $firstname;
                    $_SESSION["lastname"] = $lastname;
                    $_SESSION["email"] = $email;
                    header("Location: home.php");
                    exit;
                } else {
                    $this->error_message = "Database error: Unable to register user.";
                }
            }
        }
        return $this->error_message;
    }

    private function emailExists($email) {
        $query = "SELECT id_prof FROM prof WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    private function insertUser($firstname, $lastname, $email, $hashed_pass) {
        $query = "INSERT INTO prof (firstname, lastname, email, pass) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $firstname, $lastname, $email, $hashed_pass);

        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}

// Instantiate the UserRegistration class
$registration = new UserRegistration("localhost", "root", "", "DB");

$error_message = "";
if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    $error_message = $registration->registerUser($firstname, $lastname, $email, $password, $confirm_password);
}

$registration->closeConnection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f0f2f5;
}

.container {
    max-width: 400px;
    width: 100%;
    padding: 20px;
}

.card {
    background: #ffffff;
    padding: 2em;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    text-align: center;
}

h1 {
    margin-bottom: 1rem;
    color: #333;
}

.text-muted {
    color: #666;
    font-size: 0.9em;
    margin-bottom: 1.5rem;
}

form .x {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: bold;
    text-align: left;
    color: #555;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 0.8em;
    margin-bottom: 1em;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1em;
}

input[type="submit"] {
    width: 100%;
    padding: 0.8em;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 1em;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}


.social-network {
    display: flex;
    justify-content: center;
    margin-top: 1.5em;
    list-style: none;
    padding: 0;
}

.social-network li {
    margin: 0 0.5em;
}

.social-network a {
    display: inline-block;
    color: #fff;
    width: 40px;
    height: 40px;
    line-height: 40px;
    border-radius: 50%;
    background-color: #007bff;
    text-align: center;
    font-size: 1.2em;
    transition: background 0.3s ease;
}

.icoFacebook:hover { background-color: #3b5998; }
.icoTwitter:hover { background-color: #1da1f2; }
.icoGoogle:hover { background-color: #db4437; }

    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <form action="" method="POST" class="box">
                    <h1>Sign Up</h1>
                    <p class="text-muted">Please fill in the details to create an account!</p>

                    <?php if (!empty($error_message)) : ?>
                        <p style="color:red;"><?= htmlspecialchars($error_message) ?></p>
                    <?php endif; ?>

                    <label for="signup-first-name" class="x">First Name:</label>
                    <input type="text" id="signup-first-name" name="firstname" placeholder="First Name" required>

                    <label for="signup-last-name" class="x">Last Name:</label>
                    <input type="text" id="signup-last-name" name="lastname" placeholder="Last Name" required>

                    <label for="signup-email" class="x">Email:</label>
                    <input type="email" id="signup-email" name="email" placeholder="Email" required>

                <select name="cars" id="cars">
                        <option value="volvo">Volvo</option>
                        <option value="saab">Saab</option>
                        <option value="opel">Opel</option>
                        <option value="audi">Audi</option>
                 </select>

                    <label for="signup-password" class="x">Password:</label>
                    <input type="password" id="signup-password" name="password" placeholder="Password" required>

                    <label for="signup-confirm-password" class="x">Confirm Password:</label>
                    <input type="password" id="signup-confirm-password" name="confirm-password" placeholder="Confirm Password" required>

                    <input type="submit" name="submit" value="Sign Up">
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>