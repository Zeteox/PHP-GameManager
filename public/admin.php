<?php
$pageTitle = "Arrière-Boutique - Administration";
$is_admin = true;
if (!$is_admin) {
    header("Location: index.php");
    exit();
}
include('components/header.php');

$utilisateurs = [
    ['id' => 1, 'pseudo' => 'Chevalier des Glaces', 'email' => 'joueur@hearthstone.fr', 'role' => 'Aubergiste (Admin)'],
    ['id' => 2, 'pseudo' => 'Mage Noir', 'email' => 'mage@dalaran.com', 'role' => 'Aventurier'],
    ['id' => 3, 'pseudo' => 'Voleur de l\'Ombre', 'email' => 'valera@rogue.net', 'role' => 'Aventurier'],
];

$jeux = [
    [
        'id' => 101,
        'titre' => 'Cyberpunk 2077',
        'genre' => 'Grimoire Futuriste',
        'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1091500/header.jpg',
        'description' => 'Explorez Night City, une mégalopole obsédée par le pouvoir...',
        'difficulte' => 'Difficile',
        'couleur_diff' => 'text-orange-400 border-orange-700/50'
    ],
    [
        'id' => 102,
        'titre' => 'The Witcher 3',
        'genre' => 'Conte de Sorceleur',
        'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/292030/header.jpg',
        'description' => 'Incarnez Geralt de Riv, un tueur de monstres à gages...',
        'difficulte' => 'Normal',
        'couleur_diff' => 'text-yellow-400 border-yellow-700/50'
    ],
    [
        'id' => 103,
        'titre' => 'Hollow Knight',
        'genre' => 'Légende d\'Hallownest',
        'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/367520/header.jpg',
        'description' => 'Bravoure et mystères vous attendent dans les profondeurs...',
        'difficulte' => 'Cauchemar',
        'couleur_diff' => 'text-red-500 border-red-700/50'
    ]
];
?>

<main class="max-w-7xl mx-auto mt-12 px-4 font-sans mb-20 relative">

    <div class="text-center mb-12">
        <div
            class="inline-block bg-black/50 p-4 rounded-full border-2 border-[#ffd700] shadow-[0_0_20px_rgba(255,215,0,0.5)] mb-4">
            <img src="assets/key.png" alt="Admin" class="w-12 h-12 drop-shadow-lg" onerror="this.style.display='none'">
        </div>
        <h1 class="text-5xl font-black text-[#ffd700] hs-text-shadow italic font-serif uppercase">L'Arrière-Boutique
        </h1>
        <p class="text-[#b8860b] text-lg mt-2 font-serif italic">"Ici, l'Aubergiste tire les ficelles. Personne d'autre
            n'est admis."</p>
        <div class="h-1 w-40 bg-[#b8860b] mx-auto mt-4 rounded-full"></div>
    </div>

    <section
        class="mb-12 bg-[#2d1e12] rounded-2xl border-4 border-[#4a3621] shadow-[0_15px_40px_rgba(0,0,0,0.8)] overflow-hidden">
        <div
            class="bg-gradient-to-b from-[#1a120b] to-[#2d1e12] p-6 border-b-2 border-[#b8860b]/30 flex justify-between items-center">
            <h2
                class="text-2xl font-black text-white uppercase tracking-widest font-serif hs-text-shadow flex items-center gap-3">
                <img src="assets/icon/profileIcon.png" class="w-8 h-8 opacity-80"> Registre des Aventuriers
            </h2>
            <span
                class="bg-[#1a120b] text-[#ffd700] border border-[#b8860b] px-4 py-1 rounded text-sm font-bold shadow-inner">3
                Inscrits</span>
        </div>

        <div class="p-6 overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead>
                    <tr class="text-[#b8860b] uppercase text-xs tracking-widest border-b-2 border-[#4a3621]">
                        <th class="p-4 font-bold">Pseudo</th>
                        <th class="p-4 font-bold">Email</th>
                        <th class="p-4 font-bold">Rôle</th>
                        <th class="p-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-[#f0d8a8] text-sm font-serif">
                    <?php foreach ($utilisateurs as $user): ?>
                        <tr class="border-b border-[#4a3621]/50 hover:bg-[#3d2b1f] transition-colors">
                            <td class="p-4 font-bold text-white"><?php echo $user['pseudo']; ?></td>
                            <td class="p-4 italic opacity-80"><?php echo $user['email']; ?></td>
                            <td class="p-4">
                                <span
                                    class="px-3 py-1 rounded text-xs font-bold border <?php echo $user['role'] == 'Aubergiste (Admin)' ? 'bg-purple-900/50 border-purple-500 text-purple-300' : 'bg-black/50 border-[#b8860b] text-[#b8860b]'; ?>">
                                        <?php echo $user['role']; ?>
                                </span>
                            </td>
                            <td class="p-4 text-right flex justify-end gap-2">
                                <button onclick="openModal('modal-edit-user')"
                                    class="bg-[#3d2b1f] hover:bg-[#b8860b] p-2 rounded border border-[#b8860b] shadow-md transition transform active:scale-95 group"
                                    title="Modifier les droits">
                                    <img src="assets/hammer.png" class="w-4 h-4 opacity-80 group-hover:opacity-100">
                                </button>
                                <button onclick="openModal('modal-delete-user')"
                                    class="bg-[#6b1111] hover:bg-[#8b1515] p-2 rounded border border-[#ffd700] shadow-md transition transform active:scale-95 group"
                                    title="Bannir de la Taverne">
                                    <img src="assets/cross.png" class="w-4 h-4 opacity-80 group-hover:opacity-100">
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section
        class="bg-[#2d1e12] rounded-2xl border-4 border-[#4a3621] shadow-[0_15px_40px_rgba(0,0,0,0.8)] overflow-hidden">
        <div
            class="bg-gradient-to-b from-[#1a120b] to-[#2d1e12] p-6 border-b-2 border-[#b8860b]/30 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2
                class="text-2xl font-black text-white uppercase tracking-widest font-serif hs-text-shadow flex items-center gap-3">
                <img src="assets/icon/shop.png" class="w-8 h-8 opacity-80"> Bibliothèque Magique
            </h2>
            <button onclick="openModal('modal-edit-game')"
                class="bg-gradient-to-b from-green-700 to-green-900 hover:from-green-600 hover:to-green-800 text-white font-bold uppercase text-xs px-5 py-3 rounded border border-[#ffd700] flex items-center gap-2 shadow-lg transition transform active:scale-95 tracking-widest">
                <img src="assets/hammer.png" class="w-4 h-4"> Ajouter un Grimoire
            </button>
        </div>

        <div class="p-6 overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="text-[#b8860b] uppercase text-xs tracking-widest border-b-2 border-[#4a3621]">
                        <th class="p-4 font-bold">Aperçu</th>
                        <th class="p-4 font-bold">Titre & Genre</th>
                        <th class="p-4 font-bold">Description</th>
                        <th class="p-4 font-bold text-center">Difficulté</th>
                        <th class="p-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-[#f0d8a8] text-sm font-serif">
                    <?php foreach ($jeux as $jeu): ?>
                        <tr class="border-b border-[#4a3621]/50 hover:bg-[#3d2b1f] transition-colors group">
                            <td class="p-4">
                                <div class="w-24 h-12 rounded border border-[#b8860b] overflow-hidden shadow-md">
                                    <img src="<?php echo $jeu['image']; ?>" class="w-full h-full object-cover sepia-[0.2]">
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="font-bold text-white text-base"><?php echo $jeu['titre']; ?></div>
                                <div class="text-[10px] uppercase text-[#b8860b] tracking-wider">
                                
                                    <?php echo $jeu['genre']; ?></div>
                            </td>
                                <td class="p-4 text-xs italic opacity-80 max-w-[200px] truncate">
                                <?php echo $jeu['description']; ?>
                            </td>
                            <td class="p-4 text-center">
                                <span
                                        class="text-[10px] font-bold px-2 py-1 bg-black/50 rounded uppercase border <?php echo $jeu['couleur_diff']; ?>">
                                    <?php echo $jeu['difficulte']; ?>
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button onclick="openModal('modal-edit-game')"
                                        class="bg-[#3d2b1f] hover:bg-[#b8860b] p-2 rounded border border-[#b8860b] shadow-md transition transform active:scale-95"
                                        title="Modifier">
                                        <img src="assets/hammer.png" class="w-4 h-4">
                                    </button>
                                    <button onclick="openModal('modal-delete-game')"
                                        class="bg-[#6b1111] hover:bg-[#8b1515] p-2 rounded border border-[#ffd700] shadow-md transition transform active:scale-95"
                                        title="Détruire">
                                        <img src="assets/cross.png" class="w-4 h-4">
                                    </button>
                                </div>
                            </td>
                            </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<div id="modal-edit-user"
    class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div
        class="bg-[#2d1e12] border-4 border-[#b8860b] rounded-2xl w-full max-w-md shadow-[0_0_50px_rgba(0,0,0,0.9)] overflow-hidden transform scale-95 transition-transform duration-300">
        <div class="bg-gradient-to-b from-[#1a120b] to-[#2d1e12] p-4 border-b-2 border-[#b8860b]/30">
            <h3 class="text-xl font-black text-[#ffd700] font-serif uppercase tracking-widest text-center">Droits de
                l'Aventurier</h3>
        </div>
        <form class="p-6 space-y-4">
            <div>
                <label class="block text-[#b8860b] uppercase text-[10px] font-bold mb-1 tracking-widest">Rôle
                    accordé</label>
                <select
                    class="w-full bg-[#1a120b] border border-[#4a3621] rounded px-3 py-3 text-white focus:outline-none focus:border-[#ffd700] font-serif cursor-pointer">
                    <option value="user" selected>Aventurier (Joueur classique)</option>
                    <option value="admin">Aubergiste (Administrateur)</option>
                </select>
            </div>
            <div class="flex gap-4 mt-6">
                <button type="button" onclick="closeModal('modal-edit-user')"
                    class="flex-1 bg-transparent hover:bg-[#1a120b] border-2 border-[#4a3621] text-gray-400 font-bold uppercase py-3 rounded transition-colors text-xs tracking-widest">Annuler</button>
                <button type="submit"
                    class="flex-1 bg-[#4a3621] hover:bg-[#b8860b] text-[#f0d8a8] hover:text-[#1a120b] border-2 border-[#b8860b] font-bold uppercase py-3 rounded transition-colors text-xs tracking-widest shadow-lg">Confirmer</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-delete-user"
    class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div
        class="bg-[#2d1e12] border-4 border-[#8b1515] rounded-2xl w-full max-w-md shadow-[0_0_50px_rgba(139,21,21,0.5)] overflow-hidden transform scale-95 transition-transform duration-300">
        <div class="bg-gradient-to-b from-[#3d0909] to-[#2d1e12] p-6 text-center border-b-2 border-[#8b1515]/30">
            <img src="assets/cross.png" class="w-12 h-12 mx-auto mb-2 drop-shadow-md">
            <h3 class="text-2xl font-black text-[#ff4444] font-serif uppercase tracking-widest">Bannir l'Aventurier</h3>
        </div>
        <div class="p-6 text-center">
            <p class="text-[#f0d8a8] font-serif italic mb-6">Êtes-vous certain de vouloir expulser cette personne de la
                Taverne ? Ses registres seront détruits à jamais.</p>
            <div class="flex gap-4">
                <button type="button" onclick="closeModal('modal-delete-user')"
                    class="flex-1 bg-transparent hover:bg-[#1a120b] border-2 border-[#4a3621] text-gray-400 font-bold uppercase py-3 rounded transition-colors text-xs tracking-widest">Épargner</button>
                <button type="button"
                    class="flex-1 bg-[#8b1515] hover:bg-[#ff4444] text-white border-2 border-[#ff4444] font-bold uppercase py-3 rounded transition-colors text-xs tracking-widest shadow-[0_0_15px_rgba(255,68,68,0.4)]">Bannir</button>
            </div>
        </div>
    </div>
</div>

<div id="modal-edit-game"
    class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div
        class="bg-[#2d1e12] border-4 border-[#b8860b] rounded-2xl w-full max-w-2xl shadow-[0_0_50px_rgba(0,0,0,0.9)] overflow-hidden transform scale-95 transition-transform duration-300">
        <div
            class="bg-gradient-to-b from-[#1a120b] to-[#2d1e12] p-4 border-b-2 border-[#b8860b]/30 flex justify-between items-center">
            <h3 class="text-xl font-black text-[#ffd700] font-serif uppercase tracking-widest flex items-center gap-2">
                <img src="assets/hammer.png" class="w-6 h-6"> Forger un Grimoire
            </h3>
            <button onclick="closeModal('modal-edit-game')"
                class="text-gray-500 hover:text-white text-2xl font-black leading-none">&times;</button>
        </div>
        <form class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label
                        class="block text-[#b8860b] uppercase text-[10px] font-bold mb-1 tracking-widest">Titre</label>
                    <input type="text" placeholder="Ex: Elden Ring"
                        class="w-full bg-[#1a120b] border border-[#4a3621] rounded px-3 py-2 text-white focus:outline-none focus:border-[#ffd700] font-serif">
                </div>
                <div>
                    <label
                        class="block text-[#b8860b] uppercase text-[10px] font-bold mb-1 tracking-widest">Genre</label>
                    <input type="text" placeholder="Ex: Aventure Epique"
                        class="w-full bg-[#1a120b] border border-[#4a3621] rounded px-3 py-2 text-white focus:outline-none focus:border-[#ffd700] font-serif">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[#b8860b] uppercase text-[10px] font-bold mb-1 tracking-widest">Lien de
                        l'Image (URL)</label>
                    <input type="url" placeholder="https://..."
                        class="w-full bg-[#1a120b] border border-[#4a3621] rounded px-3 py-2 text-white focus:outline-none focus:border-[#ffd700] font-serif">
                </div>
                <div>
                    <label
                        class="block text-[#b8860b] uppercase text-[10px] font-bold mb-1 tracking-widest">Difficulté</label>
                    <select
                        class="w-full bg-[#1a120b] border border-[#4a3621] rounded px-3 py-2.5 text-white focus:outline-none focus:border-[#ffd700] font-serif">
                        <option value="facile">Balade (Facile)</option>
                        <option value="normal" selected>Normal</option>
                        <option value="difficile">Héroïque (Difficile)</option>
                        <option value="cauchemar">Cauchemar</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-[#b8860b] uppercase text-[10px] font-bold mb-1 tracking-widest">Récit
                    (Description)</label>
                <textarea rows="3" placeholder="Racontez l'histoire du jeu..."
                    class="w-full bg-[#1a120b] border border-[#4a3621] rounded px-3 py-2 text-white focus:outline-none focus:border-[#ffd700] font-serif resize-none"></textarea>
            </div>

            <div class="pt-4 flex justify-end gap-3 border-t border-[#4a3621]">
                <button type="button" onclick="closeModal('modal-edit-game')"
                    class="bg-transparent hover:bg-[#1a120b] border-2 border-[#4a3621] text-gray-400 font-bold uppercase px-6 py-2 rounded transition-colors text-xs tracking-widest">Annuler</button>
                <button type="submit"
                    class="bg-gradient-to-b from-green-700 to-green-900 hover:from-green-600 hover:to-green-800 border-2 border-[#ffd700] text-white font-bold uppercase px-6 py-2 rounded transition-colors text-xs tracking-widest shadow-lg flex items-center gap-2">
                    <img src="assets/checkMark.png" class="w-3 h-3"> Valider
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modal-delete-game"
    class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div
        class="bg-[#2d1e12] border-4 border-[#8b1515] rounded-2xl w-full max-w-md shadow-[0_0_50px_rgba(139,21,21,0.5)] overflow-hidden transform scale-95 transition-transform duration-300">
        <div class="bg-gradient-to-b from-[#3d0909] to-[#2d1e12] p-6 text-center border-b-2 border-[#8b1515]/30">
            <h3 class="text-2xl font-black text-[#ff4444] font-serif uppercase tracking-widest">Détruire ce Grimoire
            </h3>
        </div>
        <div class="p-6 text-center">
            <p class="text-[#f0d8a8] font-serif italic mb-6">Ce jeu sera retiré de l'inventaire de la Taverne et brûlé.
                Continuer ?</p>
            <div class="flex gap-4">
                <button type="button" onclick="closeModal('modal-delete-game')"
                    class="flex-1 bg-transparent hover:bg-[#1a120b] border-2 border-[#4a3621] text-gray-400 font-bold uppercase py-3 rounded transition-colors text-xs tracking-widest">Conserver</button>
                <button type="button"
                    class="flex-1 bg-[#8b1515] hover:bg-[#ff4444] text-white border-2 border-[#ff4444] font-bold uppercase py-3 rounded transition-colors text-xs tracking-widest shadow-[0_0_15px_rgba(255,68,68,0.4)]">Détruire</button>
            </div>
        </div>
    </div>
</div>

<?php include('components/footer.php'); ?>