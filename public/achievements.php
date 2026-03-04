<?php 
$pageTitle = "Trophées - L'Auberge";
include('components/header.php'); 

// BDD Achievements : id, name, description, points (qui représente la Poussière !)
$hauts_faits = [
    ['name' => 'Collectionneur Débutant', 'description' => 'Acheter votre premier jeu dans l\'Auberge.', 'points' => 10, 'icon' => 'cardPack10.png', 'debloque' => true],
    ['name' => 'Le Sorceleur', 'description' => 'Terminer la quête principale.', 'points' => 50, 'icon' => 'cardPack14.png', 'debloque' => true],
    ['name' => 'Explorateur d\'Hallownest', 'description' => 'Découvrir toute la carte.', 'points' => 30, 'icon' => 'cardPack26.png', 'debloque' => true],
    ['name' => 'Ferme Luxueuse', 'description' => 'Gagner 1 000 000 pièces d\'or.', 'points' => 100, 'icon' => 'cardPack28.png', 'debloque' => false],
];
?>

<main class="p-8 max-w-5xl mx-auto mb-20">
    <div class="text-center mb-12">
        <h1 class="text-5xl font-black text-[#ffd700] hs-text-shadow italic uppercase">Journal des Exploits</h1>
        <div class="h-1 w-40 bg-[#b8860b] mx-auto mt-4 rounded-full"></div>
    </div>

    <div class="flex flex-col gap-6">
        <?php foreach($hauts_faits as $hf): ?>
            <div class="bg-gradient-to-r from-[#4a3621] to-[#1a120b] p-4 rounded-xl border-2 border-[#b8860b] shadow-lg flex flex-col md:flex-row items-center gap-6 <?php echo $hf['debloque'] ? '' : 'opacity-70 grayscale'; ?> hover:border-[#ffd700] transition-colors relative overflow-hidden group">
                
                <div class="w-24 h-24 shrink-0 bg-[#1a120b] rounded-full border-4 border-[#ffd700] flex items-center justify-center shadow-inner relative z-10">
                    <img src="assets/achievement/<?php echo $hf['icon']; ?>" alt="Badge" class="max-h-[80%] drop-shadow-xl <?php echo $hf['debloque'] ? 'group-hover:scale-110' : ''; ?> transition-transform duration-300">
                </div>

                <div class="flex-grow z-10 w-full text-center md:text-left">
                    <div class="flex flex-col md:flex-row justify-between items-center md:items-start mb-2">
                        <h4 class="font-black text-2xl text-white tracking-wide"><?php echo $hf['name']; ?></h4>
                        <span class="flex items-center gap-2 text-xs font-bold text-[#1a120b] bg-[#ffd700] px-3 py-1 rounded-full uppercase border border-[#b8860b] mt-2 md:mt-0">
                            + <?php echo $hf['points']; ?> <img src="assets/dust.png" class="w-4 h-4 drop-shadow-sm" alt="Poussière">
                        </span>
                    </div>
                    <p class="text-md text-[#f0d8a8] italic mb-3">"<?php echo $hf['description']; ?>"</p>
                    
                    <?php if($hf['debloque']): ?>
                        <div class="flex items-center justify-center md:justify-start gap-2 text-[11px] text-[#4ade80] uppercase font-bold">
                            <img src="assets/checkMark.png" class="w-4 h-4"> Débloqué
                        </div>
                    <?php else: ?>
                        <div class="flex items-center justify-center md:justify-start gap-2 text-[11px] text-red-400 uppercase font-bold">
                            <img src="assets/cross.png" class="w-4 h-4"> Verrouillé
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include('components/footer.php'); ?>