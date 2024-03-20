<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    // Inclure le fichier de configuration de la base de données
    require 'db.php';

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    if(isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $sql = "SELECT id, email, mot_de_passe FROM utilisateurs WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if(password_verify($password, $row['mot_de_passe'])) {
                $_SESSION['etudiant_id'] = $row['id'];
                header("Location: student_home.php");
                exit;
            } else {
                $_SESSION['login_error'] = "Adresse e-mail ou mot de passe incorrect.";
                header("Location: student_login.php");
                exit;
            }
        } else {
            $_SESSION['login_error'] = "Adresse e-mail ou mot de passe incorrect.";
            header("Location: student_login.php");
            exit;
        }
    } else {
        header("Location: student_login.php");
        exit;
    }
}
?>

