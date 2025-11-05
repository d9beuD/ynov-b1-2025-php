<?php

require_once '../src/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        die('Le formulaire n\'est pas complet.');
    }
    
    if (empty($_POST['email']) || empty($_POST['password'])) {
        die('Toutes les informations requises doivent être complétées.');
    }

    $database = new Database();
    $connection = $database->getConnection();

    $request = $connection->prepare('SELECT * FROM users u WHERE u.email = :email');
    $request->execute(['email' => $_POST['email']]);

    $user = $request->fetch();

    if ($user === false) {
        die('Utilisateur inconnu.');
    }

    if (!password_verify($_POST['password'], $user['password'])) {
        die('Mot de passe incorrect.');
    }

    @session_start();
    $_SESSION = ['user' => $user];

    header('Location: /');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="/styles/main.css">
</head>
<body>
    <?php include '../templates/navbar.php'; ?>

    <div class="container">
        <h1>Connexion</h1>

        <form action="" method="post">
            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" name="email" id="email" placeholder="Adresse email" required>
            </div>
    
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" placeholder="Mot de passe" required>
            </div>
    
            <button class="btn" type="submit">Se connecter</button>
            Vous n'avez pas de compte ? <a href="/singup.php">Inscrivez-vous.</a>
        </form>
    </div>
</body>
</html>