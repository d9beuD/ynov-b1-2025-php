<?php

require_once __DIR__ . '/../src/autoload.php';

?>

<nav id="main-navbar">
    <div class="container">
        <ul>
            <li>
                <a class="brand" href="/">Bibliothèque Musicale</a>
            </li>
            <li>
                <a href="/artists/index.php">Artistes</a>
            </li>
            <li>
                <a href="/releases/index.php">Albums</a>
            </li>
            <li>
                <a href="/tracks/index.php">Musiques</a>
            </li>
            <li style="margin-left: auto;">
                <?php if ($isLoggedIn) { ?>
                    <a href="/logout.php">Déconnexion</a>
                <?php } else { ?>
                    <a href="/login.php">Se connecter</a>
                <?php } ?>
            </li>
        </ul>
    </div>
</nav>