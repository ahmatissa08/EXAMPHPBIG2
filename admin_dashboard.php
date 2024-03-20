<?php
session_start();

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    if (!isset($_SESSION['admin_id'])) {
        header("Location: admin_login.php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord Administrateur</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <div class="desktop">
    <h1>Tableau de bord Administrateur</h1>
    <div class="rectangle6">
         <ul>
        <p>Gestion des memoires</p>
        <li><a href="view_memories.php">Visualiser les mémoires</a></li>
        <li><a href="add_memory.php">Ajouter une mémoire</a></li>
        <li><a href="edit_memory.php">Modifier une mémoire</a></li>
        <li><a href="delete_memory.php">Supprimer une mémoire</a></li><br>
      
        <li><a href="manage_users.php"> <p>Gérer les utilisateurs</p></a></li>
    </ul>
    <a href="logout.php">Déconnexion</a>
    </div>

    </div>
</body>
</html>

