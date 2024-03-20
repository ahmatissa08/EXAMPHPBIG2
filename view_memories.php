<?php
session_start();

// Inclusion du fichier de configuration de la base de données
include 'db.php';

$theme_id = isset($_GET['theme_id']) ? $_GET['theme_id'] : null;
$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : null;

$sql = "SELECT * FROM memoires";

if ($theme_id) {
    $sql .= " INNER JOIN memoires_themes ON memoires.id = memoires_themes.memoire_id WHERE memoires_themes.theme_id = $theme_id";
} elseif ($search_query) {
    $sql .= " WHERE titre LIKE '%$search_query%' OR description LIKE '%$search_query%'";
}

$sql .= " ORDER BY date_publication DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mémoires</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="desktop"></div>
    <h1>Mémoires</h1>
    <div class="rectangle2">
    <?php if ($result->num_rows > 0) { ?>
        <ul>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <li>
                    <h4><?php echo $row['titre']; ?></h4>
                    <p><?php echo $row['description']; ?></p>
                    <a href="download_memory.php?memory_id=<?php echo $row['id']; ?>">Télécharger</a>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>Aucun mémoire trouvé.</p>
    <?php } ?>
    <a href="student_home.php">Retour à l'accueil</a>
    </div>
</body>
</html>
