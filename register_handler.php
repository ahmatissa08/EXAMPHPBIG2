<?php
session_start();

// Inclure le fichier de configuration de la base de données
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    // Assurez-vous d'avoir les données postées
    if(isset($_POST['register'])) {
        // Récupérer les données du formulaire
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Connexion à la base de données
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Échec de la connexion : " . $conn->connect_error);
        }
    
        // Vérifier si l'email est déjà utilisé
        $check_email_query = "SELECT * FROM utilisateurs WHERE email=?";
        $stmt_check_email = $conn->prepare($check_email_query);
        $stmt_check_email->bind_param("s", $email);
        $stmt_check_email->execute();
        $result_check_email = $stmt_check_email->get_result();

        if($result_check_email->num_rows > 0) {
            $_SESSION['register_error'] = "L'adresse e-mail est déjà utilisée.";
            header("Location: student_register.php");
            exit;
        }

        // Hasher le mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Préparer et exécuter la requête d'insertion
        $insert_query = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role) VALUES (?, ?, ?, ?, 'etudiant')";
        $stmt_insert = $conn->prepare($insert_query);
        $stmt_insert->bind_param("ssss", $nom, $prenom, $email, $hashed_password);

        if($stmt_insert->execute()) {
            $_SESSION['register_success'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
            header("Location: student_login.php");
            exit;
        } else {
            $_SESSION['register_error'] = "Erreur lors de l'inscription. Veuillez réessayer.";
            header("Location: student_register.php");
            exit;
        }
    } else {
        header("Location: student_register.php");
        exit;
    }
}
?>

