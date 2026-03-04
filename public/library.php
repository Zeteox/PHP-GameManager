<?php 
$pageTitle = "Mon Grimoire - L'Auberge";
include('components/header.php'); 
// NOUVEAUX CHAMPS: played_times et added_at
$jeux_collection = [
    [
        'title' => 'Cyberpunk 2077', 
        'genre' => 'Grimoire Futuriste', 
        'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1091500/header.jpg',
        'difficulty' => 'Difficile',
        'couleur_diff' => 'text-orange-400 border-orange-700/50',
        'played_times' => 124,
        'added_at' => '12/10/2023',
    ],
    [
        'title' => 'The Witcher 3', 
        'genre' => 'Conte de Sorceleur', 
        'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/292030/header.jpg',
        'difficulty' => 'Normal',
        'couleur_diff' => 'text-yellow-400 border-yellow-700/50',
        'played_times' => 45,
        'added_at' => '05/01/2024',
    ],
    [
        'title' => 'Hollow Knight', 
        'genre' => 'Légende d\'Hallownest', 
        'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/367520/header.jpg',
        'difficulty' => 'Cauchemar',
        'couleur_diff' => 'text-red-500 border-red-700/50',
        'played_times' => 8,
        'added_at' => 'Aujourd\'hui',
    ]
];
?>

<main class="p-8 max-w-7xl mx-auto mb-20 font-sans">
    
    <div class="text-center mb-12">
        <h1 class="text-5xl font-black text-[#ffd700] hs-text-shadow italic font-serif uppercase">Le Grimoire</h1>
        <p class="text-[#b8860b] text-lg mt-2 font-serif italic">"Vos récits passés et vos aventures en cours se trouvent ici."</p>
        <div class="h-1 w-40 bg-[#b8860b] mx-auto mt-4 rounded-full"></div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach($jeux_collection as $jeu): ?>
            <div class="bg-gradient-to-b from-[#3d2b1f] to-[#1a120b] rounded-2xl border-4 border-[#4a3621] shadow-[0_10px_25px_rgba(0,0,0,0.9)] hover:border-[#ffd700] transition-colors group flex flex-col overflow-hidden relative">
                
                <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-[#b8860b] rounded-tl-xl z-10"></div>
                <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-[#b8860b] rounded-tr-xl z-10"></div>

                <div class="relative h-48 border-b-4 border-[#4a3621] overflow-hidden m-2 rounded-t-lg">
                    <img src="<?php echo $jeu['image']; ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 sepia-[0.1]">
                    
                    <div class="absolute top-2 right-2 bg-black/80 border border-[#b8860b] text-[#ffd700] text-xs font-bold px-3 py-1 rounded backdrop-blur-sm shadow-lg">
                        ⏳<?php echo $jeu['played_times']; ?> h Joué
                    </div>
                </div>
                
                <div class="p-5 flex flex-col flex-grow">
                    <h3 class="text-2xl font-bold text-white mb-2 tracking-wider font-serif text-center"><?php echo $jeu['title']; ?></h3>
                    
                    <div class="flex flex-wrap justify-center items-center gap-2 mb-4 border-b border-[#4a3621] pb-4">
                        <span class="text-xs text-[#b8860b] italic uppercase"><?php echo $jeu['genre']; ?></span>
                        <span class="text-gray-600">•</span>
                        <span class="text-[10px] font-bold px-2 py-1 bg-black/50 rounded uppercase border <?php echo $jeu['couleur_diff']; ?>">
                            <?php echo $jeu['difficulty']; ?>
                        </span>
                    </div>

                    <div class="text-center mt-auto">
                        <span class="text-[10px] text-[#f0d8a8] font-bold uppercase tracking-wider opacity-80">
                            Forgé dans le grimoire le : <?php echo $jeu['added_at']; ?>
                        </span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include('components/footer.php'); ?>