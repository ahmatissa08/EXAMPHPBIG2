<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  /*  $email = $_POST['email'];
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
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $fichier = $_POST['fichier'];
    $date_publication = $_POST['date_publication'];
    if(empty($titre) || empty($fichier) || empty($date_publication)) {
        $error = "Veuillez remplir tous les champs obligatoires.";
    } else {
        $sql = "INSERT INTO memoires (titre, description, fichier, date_publication, auteur_id) VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $error = 'Erreur de préparation de la requête : ' . $conn->error;
        } else {
            $stmt->bind_param("ssssi", $titre, $description, $fichier, $date_publication, $_SESSION['admin_id']);
            if($stmt->execute()) {
                $success = "Mémoire ajoutée avec succès.";
                $titre = $description = $fichier = $date_publication = '';
            } else {
                $error = "Erreur lors de l'ajout de la mémoire : " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une mémoire</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="desktop">
    <h1>Ajouter une mémoire</h1>
    <div class="rectangle2">
     
    <?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
      /* $email = $_POST['email'];
        $password = $_POST['password'];
    */
        $conn = new mysqli("localhost", "root", "123456", "examphp");
        if ($conn->connect_error) {
            die("Échec de la connexion : " . $conn->connect_error);
        }if($error != '') { echo "<p style='color: red;'>$error</p>"; }
    if($success != '') { echo "<p style='color: green;'>$success</p>"; } } ?>
    <form method="post" action="">
        <label>Titre :</label><br>
        <input type="text" name="titre" value="<?php echo isset($titre) ? $titre : ''; ?>" required><br><br>
        <label>Description :</label><br>
        <textarea name="description"><?php echo isset($description) ? $description : ''; ?></textarea><br><br>
        <label>Fichier :</label><br>
        <input type="text" name="fichier" value="<?php echo isset($fichier) ? $fichier : ''; ?>" required><br><br>
        <label>Date de publication :</label><br>
        <input type="date" name="date_publication" value="<?php echo isset($date_publication) ? $date_publication : ''; ?>" required><br><br>
        <button type="submit" name="submit">Ajouter</button>
    </form> <br>
    <a href="admin_dashboard.php">Retour à l'accueil</a>
    </div>
    </div>
</body>
</html>

