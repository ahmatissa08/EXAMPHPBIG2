<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    require 'db.php';

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    if(isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die('Erreur de préparation de la requête : ' . $conn->error);
        }
        $stmt->bind_param("ss", $username, $hashed_password);
        $execute_result = $stmt->execute();
        if (!$execute_result) {
            die('Erreur d\'exécution de la requête : ' . $stmt->error);
        }
        header("Location: admin_login.php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Inscription Administrateur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="desktop">
    <h1>Inscription Administrateur</h2>
    <div class="rectangle3">
    <form method="post" action="inscription_handler.php">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br>
        <label for="nom">Nom :</label><br>
        <input type="text" id="nom" name="nom" required><br>
        <label for="prenom">Prénom :</label><br>
        <input type="text" id="prenom" name="prenom" required><br>
        <button type="submit" name="register">S'inscrire</button>
    </form>
    <br>
    <a href="index.html">Retour à l'accueil</a>
    </div>
</div>
</body>
</html>
