<?php
$pageTitle = "Mon Grimoire - L'Auberge";
include('components/header.php');

loadEnv();
Database::connect("mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8", getenv('DB_USER'), getenv('DB_PASS'));
$jeux_collection = Database::getAllGamesFromUser($_SESSION['user_id'] ?? 0);
?>

<main class="p-8 max-w-7xl mx-auto mb-20 font-sans">

    <div class="text-center mb-12">
        <h1 class="text-5xl font-black text-[#ffd700] hs-text-shadow italic font-serif uppercase">Le Grimoire</h1>
        <p class="text-[#b8860b] text-lg mt-2 font-serif italic">"Vos récits passés et vos aventures en cours se
            trouvent ici."</p>
        <div class="h-1 w-40 bg-[#b8860b] mx-auto mt-4 rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php if (empty($jeux_collection)): ?>
            <div
                class="col-span-full bg-gradient-to-b from-[#3d2b1f] to-[#1a120b] rounded-2xl border-4 border-[#4a3621] shadow-[0_10px_25px_rgba(0,0,0,0.9)] flex flex-col items-center justify-center gap-6 p-10">
                <h2
                    class="text-2xl font-black text-[#ffd700] uppercase tracking-widest font-serif hs-text-shadow text-center">
                    Votre grimoire est encore vide...
                </h2>

                <p class="text-[#e6ccac] text-center max-w-md font-serif italic text-lg">
                    "Explorez le marché et forgez de nouvelles aventures !"
                </p>

                <a href="boutique.php"
                    class="mt-4 inline-block bg-gradient-to-br from-[#4a3621] to-[#2d1e12] hover:from-[#5c4321] hover:to-[#3d2b1f] border-2 border-[#b8860b] hover:border-[#ffd700] text-[#ffd700] font-bold uppercase tracking-widest text-sm px-8 py-3 rounded shadow-[0_5px_15px_rgba(0,0,0,0.5)] transition-all duration-300 transform hover:-translate-y-1">
                    Explorer le Marché
                </a>
            </div>
        <?php endif; ?>
        <?php foreach ($jeux_collection as $jeu): ?>
            <div
                class="bg-gradient-to-b from-[#3d2b1f] to-[#1a120b] rounded-2xl border-4 border-[#4a3621] shadow-[0_10px_25px_rgba(0,0,0,0.9)] hover:border-[#ffd700] transition-colors group flex flex-col overflow-hidden relative">

                <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-[#b8860b] rounded-tl-xl z-10"></div>
                <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-[#b8860b] rounded-tr-xl z-10"></div>

                <div class="relative h-48 border-b-4 border-[#4a3621] overflow-hidden m-2 rounded-t-lg">
                    <img src="<?php echo $jeu['image']; ?>"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 sepia-[0.1]">

                    <div
                        class="absolute top-2 right-2 bg-black/80 border border-[#b8860b] text-[#ffd700] text-xs font-bold px-3 py-1 rounded backdrop-blur-sm shadow-lg">
                        <?php echo $jeu['played_times']; ?> h Joué
                    </div>
                </div>

                <div class="p-5 flex flex-col flex-grow">
                    <h3 class="text-2xl font-bold text-white mb-2 tracking-wider font-serif text-center">
                        <?php echo $jeu['title']; ?>
                    </h3>

                    <div class="flex flex-wrap justify-center items-center gap-2 mb-4 border-b border-[#4a3621] pb-4">
                        <span
                            class="text-xs text-[#b8860b] italic uppercase"><?php echo Database::getGenreById($jeu['id_genre'])['name']; ?></span>
                        <span class="text-gray-600">•</span>
                        <span
                            class="text-[10px] font-bold px-2 py-1 bg-black/50 rounded uppercase border <?php echo $diff_colors[$jeu['difficulty']] ?? 'text-gray-400 border-gray-700/50'; ?>">
                            <?php echo $jeu['difficulty']; ?>
                        </span>
                    </div>

                    <div class="text-center mt-auto">
                        <span class="text-[10px] text-[#f0d8a8] font-bold uppercase tracking-wider opacity-80">
                            Forgé dans le grimoire le :
                            <?= isset($jeu['added_at']) ? date("d M Y", strtotime($jeu['added_at'])) : 'Date Inconnue' ?>
                        </span>
                    </div>

                    <div class="text-center mt-auto">
                        <a href="salvageGame.php?game_id=<?php echo $jeu['id']; ?>"
                            class="mt-2 w-full bg-[#6b1111] hover:bg-[#8b1515] border-2 border-[#ffd700] text-white font-black uppercase tracking-widest px-4 py-3 rounded shadow-[0_0_15px_rgba(184,134,11,0.4)] transition transform active:scale-95 flex justify-center items-center gap-3">
                            <img src="assets/cross.png" class="w-6 h-6 drop-shadow-[0_0_8px_rgba(255,0,0,0.8)]">
                            Retirer du grimoire
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include('components/footer.php'); ?>