<?php

require_once '../../src/autoload.php';

$releaseIdExists = Utils::verifyParams(['id'], inPost: false);
$releaseExists = false;
$connection = (new Database())->getConnection();
$releaseManager = new ReleaseManager($connection);
$artistManager = new ArtistManager($connection);

if ($releaseIdExists) {
    $release = $releaseManager->find($_GET['id']);
    $releaseExists = $release !== false;

    $artists = $artistManager->findAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $releaseIdExists && $releaseExists) {
    if ( Utils::verifyParams(['title', 'thumnailUrl', 'releasedAt', 'artist_id'])) {
        die('Le formulaire est incomplet.');
    }

    $releaseManager->update(
        $_GET['id'],
        $_POST['title'],
        $_POST['thumbnailUrl'],
        new DateTimeImmutable($_POST['releasedAt']),
        $_POST['artist_id'],
    );

    header('Location: /releases/edit.php?id='.$_GET['id']);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Releases</title>
    <link rel="stylesheet" href="/styles/main.css">
</head>
<body>
    <?php include '../../templates/navbar.php'; ?>

    <div class="container">
        <h1>Modifier une release</h1>

        <?php if (!$releaseIdExists) { ?>
            <div class="alert alert-danger">
                Aucune release n'est sélectionné.
            </div>
        <?php } elseif (!$releaseExists) { ?>
            <div class="alert alert-danger">
                La release n'existe pas.
            </div>
        <?php } else { ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="title">Titre</label>
                    <input type="text" name="title" id="title" placeholder="Titre" value="<?php echo $release['title']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="thumbnailUrl">Lien de l'image</label>
                    <input type="text" name="thumbnailUrl" id="thumbnailUrl" placeholder="Lien de l'image" value="<?php echo $release['thumbnailUrl']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="artist">Artiste</label>
                    <select type="text" name="artist_id" id="artist" required>
                        <?php foreach ($artists as $artist) { ?>
                            <option 
                                value="<?php echo $artist['id']; ?>"
                                <?php if ($artist['id'] === $release['artist_id']) { echo 'selected'; } ?>
                            >
                                <?php echo $artist['name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="releasedAt">Date de sortie</label>
                    <input type="date" name="releasedAt" id="releasedAt"  value="<?php echo $release['releasedAt']; ?>" required>
                </div>

                <a href="/releases/index.php" class="btn btn-secondary">Annuler</a>
                <button class="btn" type="submit">Mettre à jour</button>
            </form>
        <?php } ?>
    </div>
</body>
</html>