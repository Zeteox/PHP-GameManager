<?php
$pageTitle = "Le Marché - La Taverne";
include('components/header.php');

loadEnv();
Database::connect("mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8", getenv('DB_USER'), getenv('DB_PASS'));
$shop_games = Database::getAllGames();
$user_games = Database::getAllGamesFromUser($_SESSION['user_id'] ?? 0);
?>

<main class="p-8 max-w-7xl mx-auto mb-20">
    <div class="text-center mb-12">
        <h1 class="text-5xl font-black text-[#ffd700] hs-text-shadow italic uppercase">Le Marché Noir</h1>
        <div class="h-1 w-40 bg-[#b8860b] mx-auto mt-4 rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($shop_games as $game): ?>
            <div
                class="bg-gradient-to-b from-[#3d2b1f] to-[#1a120b] rounded-2xl border-4 border-[#4a3621] shadow-[0_10px_25px_rgba(0,0,0,0.9)] hover:border-[#ffd700] transition-colors group flex flex-col overflow-hidden relative">

                <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-[#b8860b] rounded-tl-xl z-10"></div>
                <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-[#b8860b] rounded-tr-xl z-10"></div>

                <div class="relative h-48 border-b-4 border-[#4a3621] overflow-hidden m-2 rounded-t-lg">
                    <img src="<?php echo $game['image']; ?>" alt="<?php echo $game['title']; ?>"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 sepia-[0.2]">
                </div>

                <div class="p-5 flex flex-col flex-grow text-center">
                    <h3 class="text-2xl font-bold text-white mb-2 tracking-wider"><?php echo $game['title']; ?></h3>

                    <div class="flex flex-wrap justify-center items-center gap-2 mb-4">
                        <span
                            class="text-xs text-[#b8860b] italic uppercase"><?php echo Database::getGenreById($game['id_genre'])['name']; ?>
                            (<?php echo $game['release_year'] ?? '2026'; ?>)</span>
                        <span class="text-gray-600">•</span>
                        <span
                            class="text-[10px] font-bold px-2 py-1 bg-black/50 rounded uppercase border <?php echo $diff_colors[$game['difficulty']] ?? 'text-gray-400 border-gray-700/50'; ?>">
                            <?php echo $game['difficulty']; ?>
                        </span>
                    </div>

                    <div
                        class="bg-black/30 p-3 rounded border border-[#b8860b]/20 mb-6 flex-grow flex items-center justify-center shadow-inner">
                        <p class="text-sm text-[#e6ccac] italic">"<?php echo $game['description']; ?>"</p>
                    </div>

                    <?php if (in_array($game['id'], array_column($user_games, 'id'))): ?>
                        <div
                            class="mt-auto w-full bg-gray-600 cursor-not-allowed border-2 border-gray-500 text-white font-bold uppercase tracking-widest px-4 py-3 rounded shadow-[0_0_15px_rgba(0,0,0,0.4)] flex justify-center items-center gap-3">
                            Travail déja terminé
                        </div>
                    <?php else: ?>
                        <div class="mt-auto">
                            <a href="forgeGame.php?game_id=<?php echo $game['id']; ?>">
                                <button
                                    class="w-full bg-[#6b1111] hover:bg-[#8b1515] border-2 border-[#ffd700] text-white font-black uppercase tracking-widest px-4 py-3 rounded shadow-[0_0_15px_rgba(184,134,11,0.4)] transition transform active:scale-95 flex justify-center items-center gap-3">
                                    <img src="assets/hammer.png" alt="Forger" class="w-8 h-8 drop-shadow-md">
                                    Forger ce jeu
                                </button>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include('components/footer.php'); ?>