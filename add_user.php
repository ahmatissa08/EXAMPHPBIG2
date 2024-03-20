<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    /*$email = $_POST['email'];
    $password = $_POST['password'];
*/
    $conn = new mysqli("mysql-addimiglobal.alwaysdata.net", "351911", "9WCQw!DynUD5!Zz", "addimiglobal_12");
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}
$error = $success = '';
if(isset($_POST['submit'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $role = $_POST['role'];

    $sql_check_email = "SELECT * FROM utilisateurs WHERE email='$email'";
    $result_check_email = $conn->query($sql_check_email);
    if ($result_check_email->num_rows > 0) {
        $error = "Cet email est déjà utilisé par un autre utilisateur.";
    } else {
        $sql_insert_user = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role) VALUES ('$nom', '$prenom', '$email', '$mot_de_passe', '$role')";
        if ($conn->query($sql_insert_user) === TRUE) {
            $success = "Utilisateur ajouté avec succès.";
        } else {
            $error = "Erreur lors de l'ajout de l'utilisateur : " . $conn->error;
        }
    }
}
 if($error != '') { echo "<p style='color: red;'>$error</p>"; } 
 if($success != '') { echo "<p style='color: green;'>$success</p>"; } 
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un utilisateur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="desktop">
    <h1>Ajouter un utilisateur</h1>
    <div class="rectangle1">
   
   
    <form method="post" action="">
        <label>Nom:</label><br>
        <input type="text" name="nom" required><br>
        <label>Prénom:</label><br>
        <input type="text" name="prenom" required><br>
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        <label>Mot de passe:</label><br>
        <input type="password" name="mot_de_passe" required><br>
        <label>Rôle:</label><br>
        <select name="role" required>
            <option value="administrateur">Administrateur</option>
            <option value="etudiant">Étudiant</option>
        </select><br><br>
        <button type="submit" name="submit">Ajouter</button>
    </form>
    <br>
    <a href="admin_dashboard.php">Retour à l'accueil</a>
    </div>
    </div>
</body>
</html>
