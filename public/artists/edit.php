<?php

require_once '../../src/autoload.php';

$artistIdExists = isset($_GET['id']);
$artistExists = false;

if ($artistIdExists) {
    $connection = (new Database())->getConnection();
    $request = $connection->prepare('SELECT * FROM artists a WHERE a.id = :id');
    $request->execute(['id' => $_GET['id']]);

    $artist = $request->fetch();

    $artistExists = $artist !== false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $artistIdExists && $artistExists) {
    if (
        !isset($_POST['name'])
        || !isset($_POST['thumbnailUrl'])
        || !isset($_POST['description'])
    ) {
        die('Le formulaire est incomplet.');
    }

    if (
        empty($_POST['name'])
        || empty($_POST['thumbnailUrl'])
        || empty($_POST['description'])
    ) {
        die('Tous les champs requis doivent être renseignés.');
    }

    $request = (new Database())->getConnection()->prepare(
        'UPDATE artists a
        SET name = :name, thumbnailUrl = :thumbnailUrl, description = :description
        WHERE a.id = :id'
    );
    $request->execute([
        'id' => $_GET['id'],
        'name' => $_POST['name'],
        'thumbnailUrl' => $_POST['thumbnailUrl'],
        'description' => $_POST['description'],
    ]);

    header('Location: /artists/edit.php?id='.$_GET['id']);
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
        <h1>Modifier un artiste</h1>

        <?php if (!$artistIdExists) { ?>
            <div class="alert alert-danger">
                Aucun artist n'est sélectionné.
            </div>
        <?php } elseif (!$artistExists) { ?>
            <div class="alert alert-danger">
                L'artiste n'existe pas.
            </div>
        <?php } else { ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="name">Nom</label>
                    <input type="text" name="name" id="name" placeholder="Nom" value="<?php echo $artist['name']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="thumbnailUrl">Lien de l'image</label>
                    <input type="text" name="thumbnailUrl" id="thumbnailUrl" placeholder="Lien de l'image" value="<?php echo $artist['thumbnailUrl']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea type="text" name="description" id="description" placeholder="Description" required><?php echo $artist['description']; ?></textarea>
                </div>

                <a class="btn btn-secondary" href="/artists/index.php">Annuler</a>
                <button class="btn" type="submit">Mettre à jour</button>
            </form>
        <?php } ?>
    </div>
</body>
</html>