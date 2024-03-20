<?php
session_start();

// Inclure le fichier de configuration de la base de données
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    /* $email = $_POST['email'];
    $password = $_POST['password'];
    */
    // Utiliser les informations de connexion de la configuration de la base de données
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }
    

    if (!isset($_SESSION['admin_id'])) {
        header("Location: admin_login.php");
        exit;
    }

    $error = $success = '';
    if(isset($_POST['delete'])) {
        $memoire_id = $_POST['memoire_id'];

        $sql = "DELETE FROM memoires WHERE id=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $error = 'Erreur de préparation de la requête : ' . $conn->error;
        } else {
            $stmt->bind_param("i", $memoire_id);
            if($stmt->execute()) {
                $success = "Mémoire supprimée avec succès.";
            } else {
                $error = "Erreur lors de la suppression de la mémoire : " . $stmt->error;
            }
            $stmt->close();
        }
    }
    if($error != '') { echo "<p style='color: red;'>$error</p>"; } 
    if($success != '') { echo "<p style='color: green;'>$success</p>"; } 
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Supprimer une mémoire</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="desktop">
    <h1>Supprimer une mémoire</h1>
    <div class="rectangle3">
    
    <form method="post" action="">
        <label>ID de la mémoire à supprimer :</label><br>
        <input type="number" name="memoire_id" required><br><br>
        <button type="submit" name="delete">Supprimer</button>
    </form>
    <a href="admin_dashboard.php">Retour à l'accueil</a>
    </div>
    </div>
</body>
</html>
