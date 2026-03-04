<?php
require __DIR__ . '/../../app/utils/EnvUtils.php';
require __DIR__ . '/../../app/database/Database.php';
require __DIR__ . '/../../app/utils/UserUtils.php';
require __DIR__ . '/../../app/utils/FormUtils.php';
require __DIR__ . '/../../app/admin/AdminUtils.php';
require __DIR__ . '/../../app/home/HomUtils.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$est_connecte = isset($_SESSION['user_id']); 

loadEnv();

$is_admin = isUserAdmin($_SESSION['user_id'] ?? 0);

Database::connect("mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8", getenv('DB_USER'), getenv('DB_PASS'));
$achievements = Database::getAllAchievementsFromUser($_SESSION['user_id'] ?? 0);
$poussiere = 0;
foreach ($achievements as $achievement) {
    $poussiere += $achievement['points'];
}
Database::disconnect();

$diff_colors = [
    'Easy' => 'text-green-400 border-green-700/50',
    'Medium' => 'text-yellow-400 border-yellow-700/50',
    'Hard' => 'text-orange-400 border-orange-700/50',
    'Infernal' => 'text-red-400 border-red-700/50',
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/icon/favicon.ico" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title><?php echo $pageTitle ?? "L'Auberge"; ?></title>
</head>
<body class="bg-[#1a120b] text-[#f0d8a8] min-h-screen flex flex-col">

    <header class="bg-[#3d2b1f] border-b-4 border-[#b8860b] shadow-2xl relative z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex flex-col md:flex-row items-center justify-between gap-4">
            
            <div class="flex items-center gap-3">
                <img src="assets/icon/icon.jpg" alt="Logo" class="w-12 h-12 object-cover rounded-full border-2 border-[#ffd700]">
                <span class="text-2xl font-black uppercase tracking-tighter hs-text-shadow text-[#ffd700]">L'Auberge</span>
            </div>

            <nav>
                <ul class="flex gap-6 md:gap-8 uppercase tracking-widest text-sm font-bold items-center">
                    <li>
                        <a href="index.php" class="nav-link flex items-center justify-center gap-2 hover:text-[#ffd700] transition-colors py-2 text-[#f0d8a8]">
                            <img src="assets/icon/homeIcon.png" alt="Accueil" class="w-7 h-7 object-contain drop-shadow-md">
                            <span class="leading-none mt-1">Accueil</span>
                        </a>
                    </li>
                    <li>
                        <a href="boutique.php" class="nav-link flex items-center justify-center gap-2 hover:text-[#ffd700] transition-colors py-2 text-[#f0d8a8]">
                            <img src="assets/icon/shop.png" alt="Boutique" class="w-7 h-7 object-contain drop-shadow-md">
                            <span class="leading-none mt-1">Boutique</span>
                        </a>
                    </li>
                    
                    <?php if ($est_connecte): ?>
                        <li>
                            <a href="compte.php" class="nav-link flex items-center justify-center gap-2 hover:text-[#ffd700] transition-colors py-2 text-[#f0d8a8]">
                                <img src="assets/icon/profileIcon.png" alt="Mon Compte" class="w-7 h-7 object-contain drop-shadow-md">
                                <span class="leading-none mt-1">Mon Compte</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>

            <div class="hidden md:flex items-center gap-4">
                <?php if ($est_connecte): ?>
                    <div class="flex items-center gap-1 text-blue-300 font-bold">
                        <span><?= $poussiere ?></span>
                        <img src="assets/dust.png" alt="Poussière" class="w-6 h-6">
                    </div>
                <?php else: ?>
                    <a href="login.php" class="bg-[#6b1111] hover:bg-[#8b1515] border-2 border-[#ffd700] text-white font-bold uppercase text-xs px-5 py-2 rounded shadow-lg transition transform active:scale-95">
                        Se connecter
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <div class="flex-grow">