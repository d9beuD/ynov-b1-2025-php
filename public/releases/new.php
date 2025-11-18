<?php

require_once '../../src/autoload.php';

$connection = (new Database())->getConnection();
$artistManager = new ArtistManager($connection);
$releaseManager = new ReleaseManager($connection);

$artists = $artistManager->findAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ( Utils::verifyParams(['title', 'thumbnailUrl', 'artist_id'])) {
        die('Le formulaire est incomplet.');
    }

    $releaseManager->persist(
        $_POST['title'],
        $_POST['thumbnailUrl'],
        new DateTimeImmutable($_POST['releasedAt']),
        $_POST['artist_id'],
    );

    header('Location: /releases/index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta title="viewport" content="width=device-width, initial-scale=1.0">
    <title>Releases</title>
    <link rel="stylesheet" href="/styles/main.css">
</head>
<body>
    <?php include '../../templates/navbar.php'; ?>

    <div class="container">
        <h1>Créer une release</h1>

        <form action="" method="post">
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" placeholder="Titre" required>
            </div>
            
            <div class="form-group">
                <label for="thumbnailUrl">Lien de l'image</label>
                <input type="text" name="thumbnailUrl" id="thumbnailUrl" placeholder="Lien de l'image" required>
            </div>
            
            <div class="form-group">
                <label for="artist">Artiste</label>
                
                <select type="text" name="artist_id" id="artist" required>
                    <option value="" selected disabled>Sélectionner un artiste</option>
                    
                    <?php foreach ($artists as $artist) { ?>
                        <option value="<?php echo $artist['id']; ?>"><?php echo $artist['name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="releasedAt">Date de sortie</label>
                <input type="date" name="releasedAt" id="releasedAt" required>
            </div>

            <button class="btn" type="submit">Créer</button>
        </form>
    </div>
</body>
</html>