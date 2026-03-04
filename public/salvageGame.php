<?php
require('../app/database/Database.php');
require_once('../app/utils/EnvUtils.php');
session_start();

$user_id = $_SESSION['user_id'] ?? null;
if ($user_id === null) {
    header('Location: login.php');
    exit;
}
$gameId = $_GET['game_id'] ?? null;
if ($gameId === null) {
    header('Location: library.php');
    exit;
}
loadEnv();
Database::connect("mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8", getenv('DB_USER'), getenv('DB_PASS'));
Database::deleteGameFromUser($_SESSION['user_id'], $gameId);
header('Location: library.php');
?>