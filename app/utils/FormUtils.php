<?php
function LoginRegisterFormHandler() {
    session_start();
    loadEnv();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        Database::connect("mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8", getenv('DB_USER'), getenv('DB_PASS'));

        // ── Login ──
        if ($action === 'login') {
            $identifier = trim($_POST['identifier'] ?? '');
            $password   = $_POST['password'] ?? '';

            if (empty($identifier) || empty($password)) {
                $_SESSION['flash'] = ['type' => 'error', 'tab' => 'login', 'message' => "Veuillez remplir tous les champs."];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            $user = Database::getUserByUsernameOrEmail($identifier);

            if ($user === null || !password_verify($password, $user['password'])) {
                $_SESSION['flash'] = ['type' => 'error', 'tab' => 'login', 'message' => "Email ou mot de passe incorrect."];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['flash']   = ['type' => 'success', 'tab' => 'login', 'message' => "Bienvenue, {$user['username']} !"];
            header('Location: compte.php');
            exit;
        }

        // ── Register ──
        if ($action === 'register') {
            $username  = trim($_POST['username'] ?? '');
            $email     = trim($_POST['email'] ?? '');
            $password  = $_POST['password'] ?? '';

            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['flash'] = ['type' => 'error', 'tab' => 'register', 'message' => "Veuillez remplir tous les champs."];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['flash'] = ['type' => 'error', 'tab' => 'register', 'message' => "L'adresse email est invalide."];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            if (strlen($password) < 6) {
                $_SESSION['flash'] = ['type' => 'error', 'tab' => 'register', 'message' => "Le mot de passe doit contenir au moins 6 caractères."];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            // Check for duplicates
            if (Database::getUserByUsernameOrEmail($username) !== null) {
                $_SESSION['flash'] = ['type' => 'error', 'tab' => 'register', 'message' => "Ce nom de héros est déjà pris."];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            if (Database::getUserByUsernameOrEmail($email) !== null) {
                $_SESSION['flash'] = ['type' => 'error', 'tab' => 'register', 'message' => "Cet email est déjà utilisé."];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            Database::addUser([$username, $email, $password]);
            $user = Database::getUserByUsernameOrEmail($username);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['flash']   = ['type' => 'success', 'tab' => 'register', 'message' => "Bienvenue dans l'Auberge, {$username} !"];
            header('Location: compte.php');
            exit;
        }
    }
    Database::disconnect();
}

function updateUserFormHandler() {
    session_start();
    loadEnv();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        Database::connect("mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8", getenv('DB_USER'), getenv('DB_PASS'));

        if ($action === 'userUpdate') {
            $identifier = trim($_POST['username'] ?? '');
            $email      = trim($_POST['email'] ?? '');
            $oldPassword = $_POST['old_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($identifier) || empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
                $_SESSION['flash'] = ['type' => 'error', 'tab' => 'login', 'message' => "Veuillez remplir tous les champs."];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            $user = Database::getUserById($_SESSION['user_id'] ?? 0);

            if ($user === null || !password_verify($oldPassword, $user['password'])) {
                $_SESSION['flash'] = ['type' => 'error', 'tab' => 'updateUser', 'message' => "Mot de passe incorrect."];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            if ($newPassword !== $confirmPassword) {
                $_SESSION['flash'] = ['type' => 'error', 'tab' => 'updateUser', 'message' => "Les nouveaux mots de passe ne correspondent pas."];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            if (strlen($newPassword) < 6) {
                $_SESSION['flash'] = ['type' => 'error', 'tab' => 'updateUser', 'message' => "Le nouveau mot de passe doit contenir au moins 6 caractères."];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['flash'] = ['type' => 'error', 'tab' => 'updateUser', 'message' => "L'adresse email est invalide."];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            if ($email && $email !== $user['email'] && Database::getUserByUsernameOrEmail($email)) {
                $_SESSION['flash'] = ['type' => 'error', 'tab' => 'updateUser', 'message' => "L'adresse email est déjà utilisée."];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            if ($identifier !== $user['username'] && Database::getUserByUsernameOrEmail($identifier)) {
                $_SESSION['flash'] = ['type' => 'error', 'tab' => 'updateUser', 'message' => "Le nom d'utilisateur est déjà pris."];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            if ($newPassword !== $confirmPassword) {
                $_SESSION['flash'] = ['type' => 'error', 'tab' => 'updateUser', 'message' => "Les nouveaux mots de passe ne correspondent pas."];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            Database::updateUser([$identifier, $email, $newPassword, $_SESSION['user_id']]);
            $_SESSION['flash']   = ['type' => 'success', 'tab' => 'updateUser', 'message' => "Information utilisateur mise à jour avec succès!"];
            header('Location: compte.php');
            exit;
        }
        Database::disconnect();
    }
}
?>