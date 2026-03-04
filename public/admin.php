<?php
$pageTitle = "Arrière-Boutique - Administration";
include('components/header.php');
AdminFormHandler();

if (!$is_admin) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

$adminData = getAdminData();
$utilisateurs = $adminData['utilisateurs'];
$jeux = $adminData['jeux'];

loadEnv();
Database::connect("mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8", getenv('DB_USER'), getenv('DB_PASS'));
$genres = Database::getAllGenres();
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
                class="bg-[#1a120b] text-[#ffd700] border border-[#b8860b] px-4 py-1 rounded text-sm font-bold shadow-inner">
                <?php echo count($utilisateurs); ?> Inscrits
            </span>
        </div>

        <div class="p-6 overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead>
                    <tr class="text-[#b8860b] uppercase text-xs tracking-widest border-b-2 border-[#4a3621]">
                        <th class="p-4 font-bold">Username</th>
                        <th class="p-4 font-bold">Email</th>
                        <th class="p-4 font-bold">Inscrit le</th>
                        <th class="p-4 font-bold">Rôle</th>
                        <th class="p-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-[#f0d8a8] text-sm font-serif">
                    <?php foreach ($utilisateurs as $user): ?>
                        <tr class="border-b border-[#4a3621]/50 hover:bg-[#3d2b1f] transition-colors">
                            <td class="p-4 font-bold text-white"><?php echo htmlspecialchars($user['username']); ?></td>
                            <td class="p-4 italic opacity-80"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td class="p-4 opacity-80 text-xs"><?php echo $user['created_at']; ?></td>
                            <td class="p-4">
                                <span
                                    class="px-3 py-1 rounded text-xs font-bold border <?php echo $user['role'] === 'admin' ? 'bg-purple-900/50 border-purple-500 text-purple-300' : 'bg-black/50 border-[#b8860b] text-[#b8860b]'; ?>">
                                    <?php echo strtoupper($user['role']); ?>
                                </span>
                            </td>
                            <td class="p-4 text-right flex justify-end gap-2">
                                <?php if ($user['id'] != 1 && $user['id'] != $_SESSION['user_id']): ?>
                                    <button onclick="openEditUser(<?php echo $user['id']; ?>, '<?php echo $user['role']; ?>')"
                                        class="bg-[#3d2b1f] hover:bg-[#b8860b] p-2 rounded border border-[#b8860b] shadow-md transition transform active:scale-95 group">
                                        <img src="assets/hammer.png" class="w-4 h-4 opacity-80 group-hover:opacity-100">
                                    </button>
                                <?php endif; ?>
                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                    <button onclick="openDeleteUser(<?php echo $user['id']; ?>)"
                                        class="bg-[#6b1111] hover:bg-[#8b1515] p-2 rounded border border-[#ffd700] shadow-md transition transform active:scale-95 group">
                                        <img src="assets/cross.png" class="w-4 h-4 opacity-80 group-hover:opacity-100">
                                    </button>
                                <?php endif; ?>
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
            <button onclick="openEditGame(null)"
                class="bg-gradient-to-b from-green-700 to-green-900 hover:from-green-600 hover:to-green-800 text-white font-bold uppercase text-xs px-5 py-3 rounded border border-[#ffd700] flex items-center gap-2 shadow-lg transition transform active:scale-95 tracking-widest">
                <img src="assets/hammer.png" class="w-6 h-6"> Ajouter un Grimoire
            </button>
        </div>

        <div class="p-6 overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="text-[#b8860b] uppercase text-xs tracking-widest border-b-2 border-[#4a3621]">
                        <th class="p-4 font-bold">Image</th>
                        <th class="p-4 font-bold">Titre & Sortie</th>
                        <th class="p-4 font-bold">Genres</th>
                        <th class="p-4 font-bold text-center">Difficulté</th>
                        <th class="p-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-[#f0d8a8] text-sm font-serif">
                    <?php foreach ($jeux as $jeu): ?>
                        <tr class="border-b border-[#4a3621]/50 hover:bg-[#3d2b1f] transition-colors group">
                            <td class="p-4">
                                <div class="w-24 h-12 rounded border border-[#b8860b] overflow-hidden shadow-md">
                                    <img src="<?php echo htmlspecialchars($jeu['image']); ?>"
                                        class="w-full h-full object-cover sepia-[0.2]">
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="font-bold text-white text-base"><?php echo htmlspecialchars($jeu['title']); ?>
                                </div>
                                <div class="text-[10px] text-gray-500 tracking-wider">Sortie :
                                    <?php echo $jeu['release_year']; ?>
                                </div>
                            </td>
                            <td class="p-4 text-xs uppercase text-[#b8860b]">
                                <?php echo Database::getGenreById($jeu['id_genre'])['name']; ?>
                            </td>
                            <td class="p-4 text-center">
                                <span
                                    class="text-[10px] font-bold px-2 py-1 bg-black/50 rounded uppercase border <?php echo $diff_colors[$jeu['difficulty']]; ?>">
                                    <?php echo $jeu['difficulty']; ?>
                                </span>
                            </td>
                            <td class="p-4 text-right flex justify-end gap-2">
                                <button
                                    onclick='openEditGame(<?php echo json_encode($jeu, JSON_HEX_APOS | JSON_HEX_QUOT); ?>)'
                                    class="bg-[#3d2b1f] hover:bg-[#b8860b] p-2 rounded border border-[#b8860b] shadow-md transition transform active:scale-95">
                                    <img src="assets/hammer.png" class="w-4 h-4">
                                </button>
                                <button onclick="openDeleteGame(<?php echo $jeu['id']; ?>)"
                                    class="bg-[#6b1111] hover:bg-[#8b1515] p-2 rounded border border-[#ffd700] shadow-md transition transform active:scale-95">
                                    <img src="assets/cross.png" class="w-4 h-4">
                                </button>
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
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="p-6 space-y-4">
            <input type="hidden" name="action" value="edit_user">
            <input type="hidden" name="user_id" id="edit_user_id">

            <div>
                <label class="block text-[#b8860b] uppercase text-[10px] font-bold mb-1 tracking-widest">Rôle
                    accordé</label>
                <select name="role" id="edit_user_role"
                    class="w-full bg-[#1a120b] border border-[#4a3621] rounded px-3 py-3 text-white focus:outline-none focus:border-[#ffd700] font-serif cursor-pointer">
                    <option value="user">Aventurier (Joueur classique)</option>
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
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="p-6 text-center">
            <input type="hidden" name="action" value="delete_user">
            <input type="hidden" name="user_id" id="delete_user_id">

            <p class="text-[#f0d8a8] font-serif italic mb-6">Êtes-vous certain de vouloir expulser cette personne de la
                Taverne ? Ses registres seront détruits à jamais.</p>
            <div class="flex gap-4">
                <button type="button" onclick="closeModal('modal-delete-user')"
                    class="flex-1 bg-transparent hover:bg-[#1a120b] border-2 border-[#4a3621] text-gray-400 font-bold uppercase py-3 rounded transition-colors text-xs tracking-widest">Épargner</button>
                <button type="submit"
                    class="flex-1 bg-[#8b1515] hover:bg-[#ff4444] text-white border-2 border-[#ff4444] font-bold uppercase py-3 rounded transition-colors text-xs tracking-widest shadow-[0_0_15px_rgba(255,68,68,0.4)]">Bannir</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit-game"
    class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div
        class="bg-[#2d1e12] border-4 border-[#b8860b] rounded-2xl w-full max-w-2xl shadow-[0_0_50px_rgba(0,0,0,0.9)] overflow-hidden transform scale-95 transition-transform duration-300">
        <div
            class="bg-gradient-to-b from-[#1a120b] to-[#2d1e12] p-4 border-b-2 border-[#b8860b]/30 flex justify-between items-center">
            <h3 class="text-xl font-black text-[#ffd700] font-serif uppercase tracking-widest flex items-center gap-2">
                <img src="assets/hammer.png" class="w-6 h-6"> <span id="game_modal_title">Forger un Grimoire</span>
            </h3>
            <button type="button" onclick="closeModal('modal-edit-game')"
                class="text-gray-500 hover:text-white text-2xl font-black leading-none">&times;</button>
        </div>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST"
            class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
            <input type="hidden" name="action" value="save_game">
            <input type="hidden" name="game_id" id="form_game_id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label
                        class="block text-[#b8860b] uppercase text-[10px] font-bold mb-1 tracking-widest">Titre</label>
                    <input type="text" name="title" id="form_game_title" required
                        class="w-full bg-[#1a120b] border border-[#4a3621] rounded px-3 py-2 text-white focus:outline-none focus:border-[#ffd700] font-serif">
                </div>
                <div>
                    <label
                        class="block text-[#b8860b] uppercase text-[10px] font-bold mb-1 tracking-widest">Année</label>
                    <input type="number" name="release_year" id="form_game_year" required
                        class="w-full bg-[#1a120b] border border-[#4a3621] rounded px-3 py-2 text-white focus:outline-none focus:border-[#ffd700] font-serif">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[#b8860b] uppercase text-[10px] font-bold mb-1 tracking-widest">Genre
                        Principal</label>
                    <select name="genre_id" id="form_game_genre" required
                        class="w-full bg-[#1a120b] border border-[#4a3621] rounded px-3 py-2.5 text-white focus:outline-none focus:border-[#ffd700] font-serif">
                        <?php foreach ($genres as $genre): ?>
                            <option value="<?php echo $genre['id']; ?>"><?php echo htmlspecialchars($genre['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label
                        class="block text-[#b8860b] uppercase text-[10px] font-bold mb-1 tracking-widest">Difficulté</label>
                    <select name="difficulty" id="form_game_diff"
                        class="w-full bg-[#1a120b] border border-[#4a3621] rounded px-3 py-2.5 text-white focus:outline-none focus:border-[#ffd700] font-serif">
                        <option value="Easy">Facile (Easy)</option>
                        <option value="Medium">Normal (Medium)</option>
                        <option value="Hard">Héroïque (Hard)</option>
                        <option value="Infernal">Cauchemar (Infernal)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-[#b8860b] uppercase text-[10px] font-bold mb-1 tracking-widest">Lien Image
                    (URL)</label>
                <input type="text" name="image" id="form_game_image" required
                    class="w-full bg-[#1a120b] border border-[#4a3621] rounded px-3 py-2 text-white focus:outline-none focus:border-[#ffd700] font-serif">
            </div>

            <div>
                <label
                    class="block text-[#b8860b] uppercase text-[10px] font-bold mb-1 tracking-widest">Description</label>
                <textarea name="description" id="form_game_desc" rows="3" required
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
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="p-6 text-center">
            <input type="hidden" name="action" value="delete_game">
            <input type="hidden" name="game_id" id="delete_game_id">

            <p class="text-[#f0d8a8] font-serif italic mb-6">Ce jeu sera retiré de l'inventaire de la Taverne et brûlé.
                Continuer ?</p>
            <div class="flex gap-4">
                <button type="button" onclick="closeModal('modal-delete-game')"
                    class="flex-1 bg-transparent hover:bg-[#1a120b] border-2 border-[#4a3621] text-gray-400 font-bold uppercase py-3 rounded transition-colors text-xs tracking-widest">Conserver</button>
                <button type="submit"
                    class="flex-1 bg-[#8b1515] hover:bg-[#ff4444] text-white border-2 border-[#ff4444] font-bold uppercase py-3 rounded transition-colors text-xs tracking-widest shadow-[0_0_15px_rgba(255,68,68,0.4)]">Détruire</button>
            </div>
        </form>
    </div>
</div>

<?php include('components/footer.php'); ?>