<?php

require_once '../src/autoload.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="/styles/main.css">
</head>
<body>
    <?php include '../templates/navbar.php'; ?>
    
    <div class="container">
        <h1>Accueil</h1>
    
        <p>Vous êtes <?php echo $isLoggedIn ? 'connecté' : 'déconnecté'; ?>.</p>
    </div>
</body>
</html>