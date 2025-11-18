<?php

require_once '../../src/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Utils::verifyParams(['name', 'thumbnailUrl', 'description'])) {
        die('Le formulaire est incomplet.');
    }

    $artistManager = new ArtistManager((new Database())->getConnection());
    $artistManager->persist($_POST['name'], $_POST['thumbnailUrl'], $_POST['description']);

    header('Location: /artists/index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artistes</title>
    <link rel="stylesheet" href="/styles/main.css">
</head>
<body>
    <?php include '../../templates/navbar.php'; ?>

    <div class="container">
        <h1>Créer un artiste</h1>

        <form action="" method="post">
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" name="name" id="name" placeholder="Nom" required>
            </div>
            
            <div class="form-group">
                <label for="thumbnailUrl">Lien de l'image</label>
                <input type="text" name="thumbnailUrl" id="thumbnailUrl" placeholder="Lien de l'image" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea type="text" name="description" id="description" placeholder="Description" required></textarea>
            </div>

            <button class="btn" type="submit">Créer</button>
        </form>
    </div>
</body>
</html>