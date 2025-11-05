<?php

require_once '../../src/autoload.php';

$releaseIdExists = isset($_GET['id']);
$releaseExists = false;

$connection = (new Database())->getConnection();
$releaseManager = new ReleaseManager($connection);

if ($releaseIdExists) {
    $release = $releaseManager->find($_GET['id']);
    $releaseExists = $release !== false;
}

// if ($releaseExists) {
//     $releases = $releaseManager->findReleases($_GET['id']);
//     $releasesCount = count($releases);
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Release</title>
    <link rel="stylesheet" href="/styles/main.css">
</head>
<body>
    <?php include '../../templates/navbar.php'; ?>
    
    <div class="container" style="margin-block: 2rem;">
        <?php if (!$releaseIdExists) { ?>
            <div class="alert alert-danger">
                Aucune release n'est sélectionnée.
            </div>
        <?php } elseif (!$releaseExists) { ?>
            <div class="alert alert-danger">
                La release n'existe pas.
            </div>
        <?php } else { ?>
            <div class="layout-item">
                <div class="col-thumbnail">
                    <img src="<?php echo $release['thumbnailUrl']; ?>" alt="Illustration de l'album">
                    <a href="/releases/edit.php?id=<?php echo $release['id']; ?>" class="btn">Modifier</a>
                    <a href="/releases/delete.php?id=<?php echo $release['id']; ?>" class="btn btn-danger">Supprimer</a>
                </div>

                <div class="col-content">
                    <h1><?php echo $release['title']; ?></h1>

                    <ul class="track-list">
                        
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>