<!DOCTYPE html>
<html>
<head>
    <title>Gérer les utilisateurs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="desktop">
        <h1>Gestion des Utilisateurs</h1>
        <div class="rectangle2">
            <h4>Ajouter un utilisateur</h4>
            
            <form method="post" action="add_user.php">
                <button type="submit">Ajouter</button>
            </form>
            <?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$error = $success = '';
$conn = new mysqli("mysql-addimiglobal.alwaysdata.net", "351911", "9WCQw!DynUD5!Zz", "addimiglobal_12");
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if(isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $sql_check_memories = "SELECT * FROM memoires WHERE auteur_id = $user_id";
    $result_check_memories = $conn->query($sql_check_memories);
    
    if ($result_check_memories->num_rows > 0) {
        $error = "Impossible de supprimer cet utilisateur car il est associé à des mémoires.";
    } else {
        $sql_delete_user = "DELETE FROM utilisateurs WHERE id=$user_id";
        if ($conn->query($sql_delete_user) === TRUE) {
            $success = "Utilisateur supprimé avec succès.";
        } else {
            $error = "Erreur lors de la suppression de l'utilisateur : " . $conn->error;
        }
    }
}

$sql_select = "SELECT * FROM utilisateurs";
$result = $conn->query($sql_select);
if ($result->num_rows > 0) {
    echo "<h3>Liste des utilisateurs</h3>";
    echo "<p>$error</p>";
    echo "<p>$success</p>";
    echo "<table border='1'>
    <tr>
    <th>ID</th>
    <th>Nom</th>
    <th>Prénom</th>
    <th>Email</th>
    <th>Rôle</th>
    <th>Actions</th>
    </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["nom"] . "</td>";
        echo "<td>" . $row["prenom"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["role"] . "</td>";
        echo "<td><a href='manage_users.php?delete=" . $row["id"] . "'>Supprimer</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Aucun utilisateur trouvé.";
}
$conn->close();
?>

            <br>
            <a href="admin_dashboard.php">Retour à l'accueil</a>
        </div>
    </div>
</body>
</html>
