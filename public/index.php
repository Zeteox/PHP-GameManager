<?php
$pageTitle = "Auberge de HearthStone - Accueil";
include('components/header.php');

$homeData = getHomeData();
$selection_jeux = $homeData['featuredGames'];

loadEnv();
Database::connect("mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8", getenv('DB_USER'), getenv('DB_PASS'));
?>

<main class="max-w-7xl mx-auto mt-12 px-4 mb-20 font-sans">

    <div class="text-center mb-12">
        <h1 class="text-5xl font-black text-[#ffd700] hs-text-shadow italic font-serif uppercase">Bienvenue à l'Auberge
        </h1>
        <p class="text-[#b8860b] text-lg mt-2 font-serif italic">"Il y a toujours une place près du foyer pour un
            voyageur fatigué."</p>
        <div class="h-1 w-40 bg-[#b8860b] mx-auto mt-4 rounded-full"></div>
    </div>

    <div class="flex flex-col lg:flex-row gap-10 items-center justify-center">

        <div
            class="w-full <?php echo (isset($est_connecte) && $est_connecte) ? 'lg:w-2/3' : 'lg:w-full'; ?> bg-[#2d1e12] rounded-2xl border-4 border-[#4a3621] shadow-[0_15px_40px_rgba(0,0,0,0.8)] relative overflow-hidden flex flex-col transition-all duration-500">

            <div
                class="bg-gradient-to-b from-[#1a120b] to-[#2d1e12] py-4 border-b-2 border-[#b8860b]/30 flex justify-center items-center gap-4">
                <div class="w-12 h-1 bg-[#b8860b] rounded-full hidden sm:block"></div>
                <h2
                    class="text-2xl font-black text-[#ffd700] uppercase tracking-widest font-serif hs-text-shadow text-center">
                    La Sélection de l'Aubergiste</h2>
                <div class="w-12 h-1 bg-[#b8860b] rounded-full hidden sm:block"></div>
            </div>

            <div
                class="relative p-6 md:p-10 min-h-[400px] flex items-center justify-center bg-[#e6ccac] border-t-4 border-b-4 border-[#3d2b1f] shadow-inner">
                <div
                    class="absolute inset-0 bg-[url('assets/eventChoiceUnselected.png')] bg-cover bg-center opacity-40 mix-blend-multiply pointer-events-none">
                </div>

                <div class="relative z-10 w-full text-[#3d2b1f] font-serif">

                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 <?php echo (isset($est_connecte) && $est_connecte) ? '' : 'lg:grid-cols-4'; ?> gap-6">
                        <?php foreach ($selection_jeux as $jeu):
                            ?>
                            <a href="boutique.php"
                                class="bg-[#1a120b] rounded-xl border-2 border-[#b8860b] overflow-hidden shadow-lg group hover:-translate-y-1 hover:border-[#ffd700] hover:shadow-[0_10px_20px_rgba(0,0,0,0.6)] transition-all flex flex-col">

                                <div class="h-32 overflow-hidden relative border-b-2 border-[#b8860b]">
                                    <img src="<?php echo htmlspecialchars($jeu['image']); ?>"
                                        alt="<?php echo htmlspecialchars($jeu['title']); ?>"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 sepia-[0.1]">
                                </div>

                                <div class="p-4 flex-grow flex flex-col">
                                    <h3
                                        class="font-bold text-white uppercase tracking-wider font-serif text-lg leading-tight truncate">
                                        <?php echo htmlspecialchars($jeu['title']); ?>
                                    </h3>

                                    <div class="flex justify-between items-center border-b border-[#4a3621] pb-2 mb-2 mt-1">
                                        <span
                                            class="text-[10px] text-[#b8860b] uppercase tracking-widest group-hover:text-[#f0d8a8] transition-colors truncate pr-2">
                                            <?php echo Database::getGenreById($jeu['id_genre'])['name'] ?? 'Légende de la Taverne'; ?>
                                        </span>

                                        <span
                                            class="text-[9px] font-bold px-2 py-0.5 bg-black/50 rounded border <?php echo $diff_colors[$jeu['difficulty']]; ?> uppercase whitespace-nowrap shadow-sm">
                                            <?php echo htmlspecialchars($jeu['difficulty']); ?>
                                        </span>
                                    </div>

                                    <p class="text-xs text-gray-400 italic line-clamp-3 leading-relaxed">
                                        "<?php echo htmlspecialchars($jeu['description']); ?>"
                                    </p>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>

            <div class="bg-[#1a120b] h-6 w-full border-t-2 border-[#b8860b]/30"></div>
        </div>

        <?php if (isset($est_connecte) && $est_connecte): ?>
            <div class="w-full lg:w-1/3 flex flex-col gap-6">

                <div class="flex flex-col gap-5">

                    <a href="compte.php"
                        class="bg-gradient-to-br from-[#2d1e12] to-[#1a120b] hover:from-[#3d2b1f] hover:to-[#1a120b] border-2 border-[#b8860b] hover:border-[#ffd700] text-[#ffd700] p-5 rounded-xl transform transition-all duration-300 hover:-translate-y-1 shadow-[0_10px_20px_rgba(0,0,0,0.6)] flex items-center gap-4 group relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#6b1111]/10 to-transparent pointer-events-none">
                        </div>

                        <div
                            class="w-16 h-16 rounded-full border-2 border-[#b8860b] group-hover:border-[#ffd700] shadow-inner group-hover:scale-105 transition-all shrink-0 overflow-hidden relative z-10">
                            <img src="assets/icon/icon.jpg" class="w-full h-full object-cover">
                        </div>

                        <div class="relative z-10">
                            <span class="block font-black uppercase tracking-widest text-lg font-serif">Votre Profil</span>
                            <span
                                class="text-[10px] uppercase text-[#b8860b] group-hover:text-[#f0d8a8] opacity-80 flex items-center gap-1 mt-1">
                                <img src="assets/icon/profileIcon.png" class="w-3 h-3 opacity-70"> Gérer les registres
                            </span>
                        </div>
                    </a>

                    <a href="boutique.php"
                        class="bg-gradient-to-br from-[#6b1111] to-[#3d0909] hover:from-[#8b1515] hover:to-[#4a0b0b] border-2 border-[#ffd700] text-white p-5 rounded-xl transform transition-all duration-300 hover:-translate-y-1 shadow-[0_10px_20px_rgba(107,17,17,0.5)] flex items-center gap-4 group">
                        <div
                            class="bg-[#1a120b] p-3 rounded-full border border-[#ffd700] shadow-inner group-hover:scale-110 transition-transform">
                            <img src="assets/icon/shop.png" class="w-12 h-12 drop-shadow-md">
                        </div>
                        <div>
                            <span class="block font-black uppercase tracking-widest text-lg font-serif text-[#ffd700]">Le
                                Marché Noir</span>
                            <span class="text-[10px] uppercase text-[#f0d8a8] opacity-80">Trouver de nouveaux jeux</span>
                        </div>
                    </a>

                    <a href="library.php"
                        class="bg-gradient-to-br from-[#2d1e12] to-[#1a120b] hover:from-[#3d2b1f] hover:to-[#1a120b] border-2 border-[#b8860b] hover:border-[#ffd700] text-[#ffd700] p-5 rounded-xl transform transition-all duration-300 hover:-translate-y-1 shadow-[0_10px_20px_rgba(0,0,0,0.6)] flex items-center gap-4 group">
                        <div
                            class="bg-[#1a120b] p-3 rounded-full border border-[#b8860b] group-hover:border-[#ffd700] shadow-inner group-hover:scale-110 transition-all">
                            <img src="assets/book.png" class="w-14 h-14 drop-shadow-md">
                        </div>
                        <div>
                            <span class="block font-black uppercase tracking-widest text-lg font-serif">Mon Grimoire</span>
                            <span
                                class="text-[10px] uppercase text-[#b8860b] group-hover:text-[#f0d8a8] opacity-80">Consultez
                                votre collection</span>
                        </div>
                    </a>

                    <a href="achievements.php"
                        class="bg-gradient-to-br from-[#2d1e12] to-[#1a120b] hover:from-[#3d2b1f] hover:to-[#1a120b] border-2 border-[#b8860b] hover:border-[#ffd700] text-[#ffd700] p-5 rounded-xl transform transition-all duration-300 hover:-translate-y-1 shadow-[0_10px_20px_rgba(0,0,0,0.6)] flex items-center gap-4 group">
                        <div
                            class="bg-[#1a120b] p-3 rounded-full border border-[#b8860b] group-hover:border-[#ffd700] shadow-inner group-hover:scale-110 transition-all">
                            <img src="assets/achievement/cardPack8.png" class="w-14 h-14 drop-shadow-md">
                        </div>
                        <div>
                            <span class="block font-black uppercase tracking-widest text-lg font-serif">Livre de
                                Quêtes</span>
                            <span class="text-[10px] uppercase text-[#b8860b] group-hover:text-[#f0d8a8] opacity-80">Vos
                                exploits accomplis</span>
                        </div>
                    </a>

                </div>

            </div>
        <?php endif; ?>

    </div>
</main>

<?php include('components/footer.php'); ?>