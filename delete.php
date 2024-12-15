<?php



if($_SERVER["REQUEST_METHOD"] == 'GET'){
    $id = $_GET['id'];

    include ("Connection.php");

 $connection=new Connection();

 $connection->selectDatabase("DB");

 include ("prof.php");



 Prof::deleteProf("prof",$connection->conn,$_GET['deletedId']);

}

?> 