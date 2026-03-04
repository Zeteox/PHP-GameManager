<?php
function AdminFormHandler()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    loadEnv();

    $userId = $_SESSION['user_id'] ?? 0;
    if (!$userId || !isUserAdmin($userId)) {
        header("Location: index.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        Database::connect("mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8", getenv('DB_USER'), getenv('DB_PASS'));

        if ($action === 'delete_user') {
            $targetId = (int) ($_POST['user_id'] ?? 0);
            if ($targetId != $userId) {
                Database::deleteUser([$targetId]);
            }
            header('Location: admin.php');
            exit;
        }

        if ($action === 'edit_user') {
            $targetId = (int) ($_POST['user_id'] ?? 0);
            $role = $_POST['role'] ?? 'user';
            Database::updateUserRole([$role, $targetId]);
            header('Location: admin.php');
            exit;
        }

        if ($action === 'save_game') {
            $id = $_POST['game_id'] ?? '';
            $title = trim($_POST['title'] ?? '');
            $release_year = (int) ($_POST['release_year'] ?? date('Y'));
            $image = trim($_POST['image'] ?? '');
            $difficulty = $_POST['difficulty'] ?? 'Medium';
            $description = trim($_POST['description'] ?? '');
            $genre_id = (int) ($_POST['genre_id'] ?? 0);

            if (empty($id)) {
                Database::createGame([$title, $genre_id, $image, $difficulty, $release_year, $description]);
                $id = Database::getConnection()->lastInsertId();
            } else {
                Database::updateGame([$title, $genre_id, $image, $difficulty, $release_year, $description, $id]);
            }

            header('Location: admin.php');
            exit;
        }

        if ($action === 'delete_game') {
            $id = (int) ($_POST['game_id'] ?? 0);
            Database::deleteGame($id);
            header('Location: admin.php');
            exit;
        }

        Database::disconnect();
    }
}

function getAdminData()
{
    Database::connect("mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8", getenv('DB_USER'), getenv('DB_PASS'));
    $utilisateurs = Database::getAllUsers();
    $jeux = Database::getAllGames();

    Database::disconnect();

    return [
        'utilisateurs' => $utilisateurs,
        'jeux' => $jeux
    ];
}
?>