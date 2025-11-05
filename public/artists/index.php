<?php

require_once '../../src/autoload.php';

$database = new Database();
$request = $database->getConnection()->query('SELECT * FROM artists');
$artists = $request->fetchAll();

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
        <h1>Liste des artistes</h1>

        <div style="margin-bottom: 1rem">
            <a class="btn" href="/artists/new.php">Créer un artiste</a>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($artists as $artist) { ?>
                        <tr>
                            <td><?php echo $artist['id']; ?></td>
                            <td>
                                <div class="thumbnail-container">
                                    <img class="thumbnail" src="<?php echo $artist['thumbnailUrl']; ?>" alt="Illustration artiste">
                                    <a href="/artists/show.php?id=<?php echo $artist['id']; ?>"><?php echo $artist['name']; ?></a>
                                </div>
                            </td>
                            <td>
                                <div class="text-truncate">
                                    <?php echo $artist['description']; ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>