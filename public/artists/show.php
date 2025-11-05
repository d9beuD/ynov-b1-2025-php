<?php

require_once '../../src/autoload.php';

$artistIdExists = isset($_GET['id']);
$artistExists = false;

$connection = (new Database())->getConnection();
$artistManager = new ArtistManager($connection);

if ($artistIdExists) {
    $artist = $artistManager->find($_GET['id']);
    $artistExists = $artist !== false;
}

if ($artistExists) {
    $releases = $artistManager->findReleases($_GET['id']);
    $releasesCount = count($releases);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/styles/main.css">
</head>
<body>
    <?php include '../../templates/navbar.php'; ?>
    
    <div class="container" style="margin-block: 2rem;">
        <?php if (!$artistIdExists) { ?>
            <div class="alert alert-danger">
                Aucun artist n'est sélectionné.
            </div>
        <?php } elseif (!$artistExists) { ?>
            <div class="alert alert-danger">
                L'artiste n'existe pas.
            </div>
        <?php } else { ?>
            <div class="layout-item">
                <div class="col-thumbnail">
                    <img src="<?php echo $artist['thumbnailUrl']; ?>" alt="Illustration de l'artiste">

                    <a class="btn" href="/artists/edit.php?id=<?php echo $artist['id']; ?>">Modifier</a>
                    <a class="btn btn-danger" href="/artists/edit.php?id=<?php echo $artist['id']; ?>">Supprimer</a>
                </div>
                <div class="col-content">
                    <h1><?php echo $artist['name']; ?></h1>
                    <p><?php echo nl2br($artist['description']); ?></p>
                </div>
            </div>

            <h2>Releases (<?php echo $releasesCount; ?>)</h2>
            <ul class="list-releases">
                <?php foreach ($releases as $release) { ?>
                    <li>
                        <div class="card">
                            <img src="<?php echo $release['thumbnailUrl'] ?>" alt="Illustration d'album" class="card-img">
                            <div class="card-body">
                                <h3><?php echo $release['title'] ?></h3>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
</body>
</html>