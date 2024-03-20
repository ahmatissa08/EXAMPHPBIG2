<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(isset($_SESSION['student_id'])) {
        header("Location: student_home.php");
        exit;
    }
    
    if(isset($_POST['login'])) {
        $input_email = $_POST['email'];
        $input_password = $_POST['password'];
        $sql = "SELECT id, email, mot_de_passe FROM utilisateurs WHERE email = ? AND role = 'etudiant'";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die('Erreur de préparation de la requête : ' . $conn->error);
        }
        $stmt->bind_param("s", $input_email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $student_id = $row['id'];
            $student_email = $row['email'];
            $student_password_hash = $row['mot_de_passe'];
            if (password_verify($input_password, $student_password_hash)) {
                $_SESSION['student_id'] = $student_id;
                header("Location: student_home.php");
                exit;
            } else {
                $error = "Mot de passe incorrect";
            }
        } else {
            $error = "Email incorrect ou vous n'êtes pas étudiant";
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Connexion Étudiant</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="desktop">
    <h1>Connexion Étudiant</h2>
   <div class="rectangle3">
    <?php if(isset($error)) { echo "<p>$error</p>"; } ?>
    <form method="post" action="">
        <input type="text" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br>
        <button type="submit" name="login">Se connecter</button>
    </form>
    <p>Vous n'avez pas de compte ? <a href="student_register.php">S'inscrire</a></p>
    </div>    
</div>
</body>
</html>
