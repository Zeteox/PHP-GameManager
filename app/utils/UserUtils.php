<?php
function isUserAdmin($userId)
{
    Database::connect("mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8", getenv('DB_USER'), getenv('DB_PASS'));
    $user = Database::getUserById($userId);
    Database::disconnect();
    return $user && $user['role'] === 'admin';
}

?>