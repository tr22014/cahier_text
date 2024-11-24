<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            background-color: #333;
            padding: 20px;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .container a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            margin: 0 10px;
            transition: color 0.3s;
        }

        .container a:hover {
            color: #f39c12;
        }

        .cahier-txt {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .cahier-txt label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        .cahier-txt input[type="text"], 
        .cahier-txt input[type="time"] {
            width: calc(100% - 10px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .cahier-txt button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .cahier-txt button:hover {
            background-color: #f39c12;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="#">Home</a>
        <a href="#">Cahier de text</a>
        <a href="login.php">User</a>
    </div>
    <div class="cahier-txt">
        <label for="filliere">Filliere:</label>
        <input type="text" id="filliere" placeholder="Veuillez saisir la filliere" required>
        <label for="module">Module:</label>
        <input type="text" id="module" placeholder="Veuillez saisir le module">
        <label for="groupe">Groupe:</label>
        <input type="text" id="groupe" placeholder="Veuillez saisir le groupe">
        <label for="seance">Seance:</label>
        <input type="text" id="seance" placeholder="Veuillez saisir la seance">
        <label for="Debut">Debut:</label>
        <input type="time" id="Debut">
        <label for="Fin">Fin:</label>
        <input type="time" id="Fin">
        <button>Rechercher</button>
    </div>
</body>
</html>
