<?php
$servername = "mysql-addimiglobal.alwaysdata.net"; 
$username = "351911"; 
$password = "9WCQw!DynUD5!Zz"; 
$dbname = "addimiglobal_12"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}
?>
