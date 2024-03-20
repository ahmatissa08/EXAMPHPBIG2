<?php
session_start();

// Inclure le fichier de configuration de la base de données
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /*
    $email = $_POST['email'];
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
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $memoire_id = $_GET['id'];
        if (isset($_POST['submit'])) {
            $titre = $_POST['titre'];
            $description = $_POST['description'];
            $fichier = $_POST['fichier'];
            $date_publication = $_POST['date_publication'];
            if (empty($titre) || empty($fichier) || empty($date_publication)) {
                $error = "Veuillez remplir tous les champs obligatoires.";
            } else {
                $sql = "UPDATE memoires SET titre=?, description=?, fichier=?, date_publication=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    $error = 'Erreur de préparation de la requête : ' . $conn->error;
                } else {
                    $stmt->bind_param("ssssi", $titre, $description, $fichier, $date_publication, $memoire_id);
                    if ($stmt->execute()) {
                        $success = "Mémoire mise à jour avec succès.";
                    } else {
                        $error = "Erreur lors de la mise à jour de la mémoire : " . $stmt->error;
                    }
                    $stmt->close();
                }
            }
        } else {
            $sql = "SELECT * FROM memoires WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $memoire_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $titre = $row['titre'];
                $description = $row['description'];
                $fichier = $row['fichier'];
                $date_publication = $row['date_publication'];
            } else {
                $error = "Mémoire non trouvée.";
            }
        }
    } else {
        $error = "";
    }
    if ($error != '') {
        echo "<p style='color: red;'>$error</p>";
    }
    if ($success != '') {
        echo "<p style='color: green;'>$success</p>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Modifier une mémoire</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="desktop">
    <h1>Modifier une mémoire</h1>
    <div class="rectangle2">
   
    <form method="post" action="">
        <label>Titre :</label><br>
        <input type="text" name="titre" value="<?php echo isset($titre) ? $titre : ''; ?>" required><br><br>
        <label>Description :</label><br>
        <textarea name="description"><?php echo isset($description) ? $description : ''; ?></textarea><br><br>
        <label>Fichier :</label><br>
        <input type="text" name="fichier" value="<?php echo isset($fichier) ? $fichier : ''; ?>" required><br><br>
        <label>Date de publication :</label><br>
        <input type="date" name="date_publication" value="<?php echo isset($date_publication) ? $date_publication : ''; ?>" required><br><br>
        <button type="submit" name="submit">Enregistrer</button>
    </form>
    <a href="admin_dashboard.php">Retour à l'accueil</a>
    <div>
    <div>
</body>
</html>
