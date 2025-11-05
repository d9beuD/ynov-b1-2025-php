<?php

require_once '../../src/autoload.php';

$connection = new Database()->getConnection();
$releaseManager = new ReleaseManager($connection);
$releases = $releaseManager->findAll(joinArtist: true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Albums</title>
    <link rel="stylesheet" href="/styles/main.css">
</head>
<body>
    <?php include '../../templates/navbar.php'; ?>

    <div class="container">
        <h1>Liste des albums</h1>

        <div style="margin-bottom: 1rem">
            <a class="btn" href="/releases/new.php">Créer un album</a>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>Artiste</th>
                        <th>Date de sortie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($releases as $release) { ?>
                        <tr>
                            <td><?php echo $release['id']; ?></td>
                            <td>
                                <div class="thumbnail-container">
                                    <img class="thumbnail" src="<?php echo $release['thumbnailUrl']; ?>" alt="Illustration releasee">
                                    <a href="/releases/show.php?id=<?php echo $release['id']; ?>"><?php echo $release['title']; ?></a>
                                </div>
                            </td>
                            <td>
                                <div class="thumbnail-container">
                                    <img class="thumbnail" src="<?php echo $release['artist_thumbnailUrl']; ?>" alt="Illustration releasee">
                                    <a href="/artists/show.php?id=<?php echo $release['artist_id']; ?>"><?php echo $release['artist_name']; ?></a>
                                </div>
                            </td>
                            <td><?php echo new DateTime($release['releasedAt'])->format('d/m/Y'); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>