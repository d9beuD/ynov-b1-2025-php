<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Utils.php';
require_once __DIR__ . '/Services/EntityManager.php';
require_once __DIR__ . '/Services/ArtistManager.php';
require_once __DIR__ . '/Services/ReleaseManager.php';

session_start();
$isLoggedIn = isset($_SESSION['user']);
