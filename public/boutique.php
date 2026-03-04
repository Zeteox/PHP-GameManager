<?php
$pageTitle = "Le Marché - L'Auberge";
include('components/header.php');

$jeux_boutique = [
    [
        'titre' => 'Cyberpunk 2077',
        'genre' => 'Grimoire Futuriste',
        'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1091500/header.jpg',
        'description' => 'Explorez Night City, une mégalopole obsédée par le pouvoir, la gloire et les modifications corporelles.',
        'difficulte' => 'Difficile',
        'couleur_diff' => 'text-orange-400 border-orange-700/50'
    ],
    [
        'titre' => 'The Witcher 3',
        'genre' => 'Conte de Sorceleur',
        'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/292030/header.jpg',
        'description' => 'Incarnez Geralt de Riv, un tueur de monstres à gages, et partez à la recherche de l\'enfant de la prophétie.',
        'difficulte' => 'Normal',
        'couleur_diff' => 'text-yellow-400 border-yellow-700/50'
    ],
    [
        'titre' => 'Hollow Knight',
        'genre' => 'Légende d\'Hallownest',
        'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/367520/header.jpg',
        'description' => 'Bravoure et mystères vous attendent dans les profondeurs d\'un royaume d\'insectes en ruine.',
        'difficulte' => 'Cauchemar',
        'couleur_diff' => 'text-red-500 border-red-700/50'
    ],
    [
        'titre' => 'Stardew Valley',
        'genre' => 'Simulation Agricole',
        'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/413150/header.jpg',
        'description' => 'Héritez de la vieille ferme de votre grand-père et transformez un champ envahi par les herbes en une terre prospère.',
        'difficulte' => 'Paisible',
        'couleur_diff' => 'text-green-400 border-green-700/50'
    ],
    [
        'titre' => 'Baldur\'s Gate 3',
        'genre' => 'Épopée Stratégique',
        'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1086940/header.jpg',
        'description' => 'Rassemblez votre groupe et retournez aux Royaumes Oubliés dans une histoire de fraternité, de trahison et de survie.',
        'difficulte' => 'Tactique',
        'couleur_diff' => 'text-blue-400 border-blue-700/50'
    ],
    [
        'titre' => 'ELDEN RING',
        'genre' => 'Mythe de l\'Entre-terre',
        'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1245620/header.jpg',
        'description' => 'Levez-vous, Sans-éclat, et laissez-vous guider par la grâce pour brandir la puissance du Cercle d\'Elden.',
        'difficulte' => 'Légendaire',
        'couleur_diff' => 'text-purple-400 border-purple-700/50 shadow-[0_0_10px_rgba(168,85,247,0.4)]',
        'release_year' => '2022'
    ],
];
?>

<main class="p-8 max-w-7xl mx-auto mb-20">
    <div class="text-center mb-12">
        <h1 class="text-5xl font-black text-[#ffd700] hs-text-shadow italic uppercase">Le Marché Noir</h1>
        <div class="h-1 w-40 bg-[#b8860b] mx-auto mt-4 rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($jeux_boutique as $jeu): ?>
            <div
                class="bg-gradient-to-b from-[#3d2b1f] to-[#1a120b] rounded-2xl border-4 border-[#4a3621] shadow-[0_10px_25px_rgba(0,0,0,0.9)] hover:border-[#ffd700] transition-colors group flex flex-col overflow-hidden relative">

                <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-[#b8860b] rounded-tl-xl z-10"></div>
                <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-[#b8860b] rounded-tr-xl z-10"></div>

                <div class="relative h-48 border-b-4 border-[#4a3621] overflow-hidden m-2 rounded-t-lg">
                    <img src="<?php echo $jeu['image']; ?>" alt="<?php echo $jeu['titre']; ?>"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 sepia-[0.2]">
                </div>

                <div class="p-5 flex flex-col flex-grow text-center">
                    <h3 class="text-2xl font-bold text-white mb-2 tracking-wider"><?php echo $jeu['titre']; ?></h3>

                    <div class="flex flex-wrap justify-center items-center gap-2 mb-4">
                        <span class="text-xs text-[#b8860b] italic uppercase"><?php echo $jeu['genre']; ?> (<?php echo $jeu['release_year'] ?? '2026'; ?>)</span>
                        <span class="text-gray-600">•</span>
                        <span class="text-[10px] font-bold px-2 py-1 bg-black/50 rounded uppercase border <?php echo $jeu['couleur_diff']; ?>">
                            <?php echo $jeu['difficulte']; ?>
                        </span>
                    </div>

                    <div class="bg-black/30 p-3 rounded border border-[#b8860b]/20 mb-6 flex-grow flex items-center justify-center shadow-inner">
                        <p class="text-sm text-[#e6ccac] italic">"<?php echo $jeu['description']; ?>"</p>
                    </div>

                    <div class="mt-auto">
                        <button onclick="alert('Ce jeu a été ajouté à votre grimoire !')"
                            class="w-full bg-[#6b1111] hover:bg-[#8b1515] border-2 border-[#ffd700] text-white font-black uppercase tracking-widest px-4 py-3 rounded shadow-[0_0_15px_rgba(184,134,11,0.4)] transition transform active:scale-95 flex justify-center items-center gap-3">
                            <img src="assets/hammer.png" alt="Forger" class="w-8 h-8 drop-shadow-md">
                            Forger ce jeu
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include('components/footer.php'); ?>