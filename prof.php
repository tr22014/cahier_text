<?php
 class Prof{
 public $id;
 public $firstname;
 public $lastname;
 public $email;
 public $pass;
 public $reg_date;

 public static $errorMesage = "";  // Déclaration correcte de la propriété statique
 public static $successMesage  = "";

 public function __construct($firstname,$lastname,$email,$pass){
  //initialize the attributs of the class with the parameters, and hash the password
    $this->firstname = $firstname;
    $this->lastname = $lastname;
    $this->email = $email;
    $this->pass = password_hash($pass , PASSWORD_DEFAULT);
 }
 public function insertProf($tableName,$conn){
    //insert a client in the database, and give a message to $successMsg and $errorMsg
        $sql = "INSERT INTO $tableName  (firstname, lastname, email,pass)
        VALUES ('$this->firstname', '$this->lastname', '$this->email','$this->pass')";
        if (mysqli_query($conn, $sql)) {
        self::$successMesage =  "New record created successfully";
        } else {
        self::$errorMesage = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
 }
 public static function selectAllProfs($tableName, $conn) {
    // Préparer la requête SQL
    $sql = "SELECT id, firstname, lastname, email FROM $tableName";

    // Exécuter la requête
    $result = mysqli_query($conn, $sql);

    // Vérifier si la requête a réussi
    if (!$result) {
        // La requête a échoué, retournez un tableau vide ou gérez l'erreur comme vous le souhaitez
        self::$errorMesage = "Error in query: " . mysqli_error($conn);
        return [];
    }

    // Vérifier s'il y a des résultats
    if (mysqli_num_rows($result) > 0) {
        $table = [];
        // Parcourir les résultats et les ajouter au tableau
        while ($row = mysqli_fetch_assoc($result)) {
            $table[] = $row;
        }
        return $table;
    } else {
        // Aucun résultat trouvé
        return [];
    }
}

 static function selectProfById($tableName,$conn,$id){
  //select a client by id, and return the row result
            $sql = "SELECT firstname, lastname, email FROM $tableName WHERE id='$id'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
            return $row;

            }
        }
 }
 static function updateProf($prof,$tableName,$conn,$id){
  //update a client of $id, with the values of $client in parameter and send the user to read.php
            $sql = "UPDATE $tableName SET firstname = '$prof->firstname', lastname ='$prof->lastname' , email = '$prof->email' WHERE id='$id'";
                if (mysqli_query($conn, $sql)) {
                self::$successMesage =  "New record updated successfully";
                header('Location:read.php');
                } else {
                self::$errorMesage = "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
 }
 static function deleteProf($tableName,$conn,$id){
  //delet a client by his id, and send the user to read.php
        $sql = "DELETE FROM $tableName WHERE id='$id'";
            if (mysqli_query($conn, $sql)) {
            echo "Record deleted successfully";
            header('Location:read.php');
            } else {
                echo "Error deleting record: " . mysqli_error($conn);
            }
 
  }
 }
 ?>