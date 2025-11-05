<?php

require_once __DIR__ . '/../src/autoload.php';

$_SESSION = [];
session_destroy();

header('Location: /login.php');
exit;
