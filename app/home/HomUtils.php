<?php
function getHomeData() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    loadEnv();
    Database::connect("mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8", getenv('DB_USER'), getenv('DB_PASS'));
    $allGames = Database::getAllGames();
    Database::disconnect();
    $featuredGames = array_slice($allGames, 0, 4);

    return [
        'featuredGames' => $featuredGames
    ];
}
?>