<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    // Inclure le fichier de configuration de la base de données
    require 'db.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    if(isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO utilisateurs (email, mot_de_passe) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die('Erreur de préparation de la requête : ' . $conn->error);
        }
        $bind_result = $stmt->bind_param("ss", $username, $hashed_password);
        
        if (!$bind_result) {
            die('Erreur de liaison des paramètres : ' . $stmt->error);
        }
        $execute_result = $stmt->execute();
        if (!$execute_result) {
            die('Erreur d\'exécution de la requête : ' . $stmt->error);
        }
        header("Location: confirmation.php");
        exit;
    }
}
?>
