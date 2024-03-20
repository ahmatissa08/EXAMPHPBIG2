<?php
session_start();
include 'db.php';

$themes = []; 
$query_themes = "SELECT * FROM themes";
$result_themes = $conn->query($query_themes);

if ($result_themes->num_rows > 0) {
    while ($row = $result_themes->fetch_assoc()) {
        $themes[] = $row;
    }
}

$recent_memories = [];
$query_memories = "SELECT * FROM memoires ORDER BY date_publication DESC LIMIT 5";
$result_memories = $conn->query($query_memories);

if ($result_memories->num_rows > 0) {
    while ($row_memory = $result_memories->fetch_assoc()) {
        $recent_memories[] = $row_memory;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content ="width=device-width, initial-scale=1.0">
    <title>Accueil Étudiant</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="desktop">
    <h1>Bienvenue sur la plateforme de gestion des mémoires</h1>
    <h2>Choisissez un thème pour découvrir les mémoires associés :</h2>
    
    <div class="rectangle2">
    <ul>
        <?php foreach ($themes as $theme) { ?>
            <li><a href="view_memories.php?theme_id=<?php echo $theme['id']; ?>"><?php echo $theme['nom']; ?></a></li>
        <?php } ?>
    </ul>

    <h3>Rechercher des mémoires :</h3>
    <form method="get" action="view_memories.php">
        <input type="text" name="search_query" placeholder="Rechercher...">
        <button type="submit">Rechercher</button>
    </form>

    <h3>Mémoires récemment ajoutées :</h3>
    <ul>
        <?php foreach ($recent_memories as $memory) { ?>
            <li>
                <a href="view_memory.php?memory_id=<?php echo $memory['id']; ?>"><?php echo $memory['titre']; ?></a>
                <a href="download_memory.php?memory_id=<?php echo $memory['id']; ?>">Télécharger</a>
            </li>
        <?php } ?>
        <?php if (empty($recent_memories)) { ?>
            <li>Aucune mémoire disponible pour le moment.</li>
        <?php } ?>
    </ul>
    
    <a href="logout.php">Déconnexion</a>
    </div>
    </div>
</body>
</html>
