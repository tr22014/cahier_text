<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding-top: 50px;
        }

        .container {
            width: 100%;
            max-width: 500px;
            margin: auto;
        }

        .card {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2em;
            margin-bottom: 10px;
            text-align: center;
        }

        .text-muted {
            color: #777;
            font-size: 0.9em;
            text-align: center;
        }

        .x {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #5cb85c;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 1.1em;
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        .social-network {
            text-align: center;
            margin-top: 20px;
        }

        .social-network li {
            display: inline-block;
            margin: 5px;
        }

        .social-network a {
            font-size: 1.5em;
            color: #555;
            text-decoration: none;
        }

        .social-network a:hover {
            color: #5cb85c;
        }

        .error-message {
            color: red;
            font-size: 0.9em;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container"> 
        <div class="row"> 
            <div class="col-md-6"> 
                <div class="card">
                    <form action="" method="POST" class="box"> 
                        <h1>Login</h1>
                        <p class="text-muted">Please enter your credentials to log in!</p>

                        <label for="login-email" class="x">Email:</label>
                        <input type="email" id="login-email" name="email" placeholder="Email" required>
                        
                        <label for="login-password" class="x">Password:</label>
                        <input type="password" id="login-password" name="password" placeholder="Password" required>
                        
                        <input type="submit" name="submit" value="Log In" >
                        <p class="text-muted">Don't have an account? <a href="signup.php" style="text-decoration: none;">Sign Up</a></p>

                        <?php
                            if (isset($error)) {
                                echo "<p class='error-message'>$error</p>";  // Afficher l'erreur si elle existe
                            }
                        ?>
                        
                        <div class="col-md-12">
                            <ul class="social-network social-circle">
                                <li><a href="https://web.facebook.com/" class="icoFacebook" title="Facebook"><i class="fab fa-facebook-f"></i></a></li> 
                                <li><a href="https://x.com/" class="icoTwitter" title="Twitter"><i class="fab fa-twitter"></i></a></li> 
                                <li><a href="https://www.google.com/" class="icoGoogle" title="Google"><i class="fab fa-google-plus"></i></a></li> 
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>