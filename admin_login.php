<?php
session_start();
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conn = new mysqli("mysql-addimiglobal.alwaysdata.net", "351911", "9WCQw!DynUD5!Zz", "addimiglobal_12");
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    if(isset($_SESSION['admin_id'])) {
        header("Location: admin_dashboard.php");
        exit;
    }

    if(isset($_POST['login'])) {
        $input_email = $_POST['email'];
        $input_password = $_POST['password'];
        $sql = "SELECT id, email, mot_de_passe FROM utilisateurs WHERE email = ? AND role = 'administrateur'";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die('Erreur de préparation de la requête : ' . $conn->error);
        }
        $stmt->bind_param("s", $input_email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $admin_id = $row['id'];
            $admin_email = $row['email'];
            $admin_password_hash = $row['mot_de_passe'];
            if (password_verify($input_password, $admin_password_hash)) {
                $_SESSION['admin_id'] = $admin_id; 
                
                header("Location: admin_dashboard.php");
                exit;
            } else {
                $error = "Mot de passe incorrect";
            }
        } else {
            $error = "Email incorrect ou vous n'êtes pas administrateur";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion Administrateur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="desktop">
    <h1>Connexion Administrateur</h2>
    <div class="rectangle3">
    <?php if(isset($error)) { echo "<p>$error</p>"; } ?>
    <form method="post" action="">
        <input type="text" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br>
        <button type="submit" name="login">Se connecter</button>
    </form>
    <p>Vous n'avez pas de compte ? <a href="inscription.php">S'inscrire</a></p>
    </div>
    </div>
</body>
</html>
