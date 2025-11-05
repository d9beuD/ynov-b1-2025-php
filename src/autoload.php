<?php

require_once __DIR__ . '/Database.php';

session_start();
$isLoggedIn = isset($_SESSION['user']);
