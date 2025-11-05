<?php

require_once '../src/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        die('Le formulaire n\'est pas complet.');
    }
    
    if (empty($_POST['email']) || empty($_POST['password'])) {
        die('Toutes les informations requises doivent être complétées.');
    }
    
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        die('L\'adresse email n\'est pas valide.');
    }

    $database = new Database();
    $connection = $database->getConnection();

    // Est-ce que l'utilisateur existe ?
    $request = $connection->prepare('SELECT id FROM users u WHERE u.email = :email');
    $request->execute(['email' => $_POST['email']]);

    if ($request->fetch() !== false) {
        die('L\'utilisateur existe déjà.');
    }

    // Hash du mot passe
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insertion de l'utilisateur
    $request = $connection->prepare('INSERT INTO users(email, password) VALUES(:email, :password)');
    $request->execute([
        'email' => $_POST['email'],
        'password' => $password,
    ]);

    header('Location: /login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <form action="" method="post">
        <div>
            <label for="email">Adresse email</label>
            <input type="email" name="email" id="email" placeholder="Adresse email" required>
        </div>

        <div>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" placeholder="Mot de passe" required>
        </div>

        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>