<?php
require __DIR__ . '/../app/database/Database.php';
require_once __DIR__ . '/../app/utils/EnvUtils.php';
require_once __DIR__ . '/../app/utils/AchievementsUtils.php';
session_start();

// Verify if the user is logged in
$user_id = $_SESSION['user_id'] ?? null;
if ($user_id === null) {
    header('Location: login.php');
    exit;
}

// Verify if the game_id is present in the URL
$gameId = $_GET['game_id'] ?? null;
if ($gameId === null) {
    header('Location: library.php');
    exit;
}

// Remove the game from the user's library
loadEnv();
Database::connect("mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8", getenv('DB_USER'), getenv('DB_PASS'));
Database::deleteGameFromUser($_SESSION['user_id'], $gameId);

updateAchievements($user_id);

Database::disconnect();
header('Location: library.php');
?>