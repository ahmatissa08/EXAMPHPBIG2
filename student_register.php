<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Étudiant</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="desktop">
    <h1>Inscription Étudiant</h1>
    <div class="rectangle1">
    <form action="register_handler.php" method="POST">
        <label for="nom">Nom :</label><br>
        <input type="text" id="nom" name="nom" required><br>
        <label for="prenom">Prénom :</label><br>
        <input type="text" id="prenom" name="prenom" required><br>
        <label for="email">Adresse e-mail :</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Mot de passe :</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit" name="register">S'inscrire</button>
    </form>
    <p>Déjà un compte ? <a href="student_login.php">Se connecter</a></p>
    <br>
    <a href="index.html">Retour à l'accueil</a>
    </div>
    </div>
</body>
</html>
