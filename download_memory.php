<?php
session_start();

// Inclure le fichier de configuration de la base de données
require 'db.config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Utiliser les informations de connexion de la configuration de la base de données
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    if (!isset($_SESSION['student_id'])) {
        header("Location: student_login.php");
        exit;
    }

    if (!isset($_GET['memory_id'])) {
        header("Location: view_memories.php");
        exit;
    }
    $memory_id = $_GET['memory_id'];

    $sql = "SELECT fichier FROM memoires WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Erreur de préparation de la requête : ' . $conn->error);
    }
    $stmt->bind_param("i", $memory_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $file_path = $row['fichier'];
        if (file_exists($file_path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit;
        } else {
            header("Location: view_memories.php?error=file_not_found");
            exit;
        }
    } else {
        header("Location: view_memories.php?error=memory_not_found");
        exit;
    }
}
?>
