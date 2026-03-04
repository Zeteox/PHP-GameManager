<?php
include('components/header.php');

$pageTitle = "Mon Profil - La Taverne";

updateUserFormHandler();

if (!$is_connected) {
    header('Location: login.php');
    exit;
}

loadEnv();
Database::connect("mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8", getenv('DB_USER'), getenv('DB_PASS'));
$userData = Database::getUserById($_SESSION['user_id'] ?? 0);

if ($userData === null) {
    Database::disconnect();
    header('Location: logout.php');
    exit;
}
Database::disconnect();

$flash = $_SESSION['flash'] ?? null;
$openTab = $flash['tab'] ?? 'login';
unset($_SESSION['flash']);
?>

<main class="max-w-7xl mx-auto mt-12 px-4 font-sans mb-20">
    <div class="flex flex-col lg:flex-row gap-10 items-center justify-between ">

        <div class="w-full lg:w-[40%] flex flex-col gap-6 max-w-[400px] mx-auto lg:max-w-none">

            <div
                class="relative w-full max-w-[400px] mx-auto hover:scale-105 transition-transform duration-500 drop-shadow-[0_20px_40px_rgba(0,0,0,0.9)] group cursor-pointer">
                <div class="absolute z-0 bottom-[35%] left-[10%] right-[10%] overflow-hidden rounded-t-full">
                    <img src="assets/lichKing.jpg" alt="Portrait"
                        class="w-full h-full object-cover object-top opacity-90">
                </div>
                <img src="assets/profileCard.png" alt="Carte de Profil"
                    class="relative z-10 w-full h-auto pointer-events-none drop-shadow-xl">
                <div class="absolute inset-0 z-20 flex flex-col items-center justify-end pb-[13%] px-14">
                    <h2
                        class="font-black text-xl text-white hs-text-shadow tracking-widest font-serif leading-none text-center">
                        <?= htmlspecialchars($userData['username'] ?? 'Aventurier Anonyme') ?>
                    </h2>
                    <span
                        class="bg-[#1a120b] text-[#b8860b] text-[10px] font-bold px-3 py-1 rounded border border-[#4a3621] mt-2 shadow-lg uppercase tracking-widest">
                        Inscrit le
                        <?= isset($userData['created_at']) ? date("d M Y", strtotime($userData['created_at'])) : 'Date Inconnue' ?>
                    </span>
                    <p class="text-[#f0d8a8] mt-2 font-serif italic text-xs text-center leading-relaxed max-w-[90%]">
                        "Habitué de l'Auberge, toujours prêt à tirer une chaise près du feu."
                    </p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 items-stretch">

                <div
                    class="w-full sm:w-1/3 bg-[#2d1e12] rounded-xl border-2 border-[#b8860b] p-4 shadow-lg flex flex-col justify-center items-center gap-2 transform transition-transform hover:scale-105">
                    <h3
                        class="text-[#b8860b] text-center font-bold uppercase tracking-widest text-[10px] font-serif leading-tight">
                        Poussière
                    </h3>
                    <div class="flex items-center gap-2">
                        <img src="assets/dust.png" class="w-8 h-8 drop-shadow-md">
                        <span class="text-blue-300 font-black text-2xl"><?= $dust ?></span>
                    </div>
                </div>

                <a href="logout.php"
                    class="w-full sm:w-2/3 bg-gradient-to-r from-[#6b1111] to-[#3d0909] hover:from-[#8b1515] hover:to-[#4a0b0b] border-2 border-[#ffd700] p-4 rounded-xl shadow-[0_10px_20px_rgba(107,17,17,0.6)] flex items-center gap-4 group transition-all transform hover:-translate-y-1">

                    <div
                        class="bg-black/50 p-2 rounded-full border border-[#ffd700] shadow-inner group-hover:rotate-90 transition-transform duration-300 shrink-0">
                        <img src="assets/cross.png" class="w-6 h-6 drop-shadow-[0_0_8px_rgba(255,0,0,0.8)]">
                    </div>

                    <div href="logout.php" class="overflow-hidden w-full">
                        <span
                            class="block font-black uppercase tracking-widest text-md font-serif text-[#ffd700] hs-text-shadow truncate">
                            Déconnexion
                        </span>
                        <span class="text-[10px] uppercase text-[#e6ccac] opacity-80 italic block truncate">
                            Quitter la Taverne
                        </span>
                    </div>

                </a>

            </div>

            <?php if ($is_admin): ?>
                <a href="admin.php"
                    class="bg-gradient-to-r from-[#4a1c40] to-[#2d1026] hover:from-[#5c2450] hover:to-[#3e1634] border-2 border-[#ffd700] p-4 rounded-xl shadow-[0_10px_20px_rgba(74,28,64,0.6)] flex items-center justify-between group transition-all transform hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div
                            class="bg-black/50 p-2 rounded-full border border-[#ffd700] shadow-inner group-hover:rotate-12 transition-transform">
                            <img src="assets/key.png" class="w-8 h-8 drop-shadow-[0_0_8px_rgba(255,215,0,0.8)]">
                        </div>
                        <div>
                            <span
                                class="block font-black uppercase tracking-widest text-lg font-serif text-[#ffd700] hs-text-shadow">Pass
                                d'Aubergiste</span>
                            <span class="text-xs uppercase text-[#e6ccac] opacity-80 italic">L'arrière-boutique</span>
                        </div>
                    </div>
                    <span class="text-[#ffd700] font-bold text-2xl group-hover:translate-x-2 transition-transform">→</span>
                </a>
            <?php endif; ?>


        </div>

        <div class="w-full lg:w-[60%] flex flex-col gap-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <a href="library.php"
                    class="bg-gradient-to-br from-[#3d2b1f] to-[#1a120b] hover:from-[#4a3621] hover:to-[#2d1e12] border-2 border-[#b8860b] hover:border-[#ffd700] text-[#ffd700] p-6 rounded-xl shadow-[0_10px_20px_rgba(0,0,0,0.6)] flex flex-col items-center justify-center gap-3 group transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden">
                    <div
                        class="w-16 h-16 bg-[#1a120b] rounded-full border-2 border-[#b8860b] flex items-center justify-center shadow-inner group-hover:border-[#ffd700] transition-colors relative z-10">
                        <img src="assets/book.png"
                            class="w-12 h-12 object-contain drop-shadow-lg group-hover:scale-110 transition-transform">
                    </div>
                    <span class="font-black uppercase tracking-widest text-lg font-serif relative z-10 text-center">Le
                        Grimoire</span>
                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-20 transition-opacity"></div>
                </a>

                <a href="achievements.php"
                    class="bg-gradient-to-br from-[#3d2b1f] to-[#1a120b] hover:from-[#4a3621] hover:to-[#2d1e12] border-2 border-[#b8860b] hover:border-[#ffd700] text-[#ffd700] p-6 rounded-xl shadow-[0_10px_20px_rgba(0,0,0,0.6)] flex flex-col items-center justify-center gap-3 group transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden">
                    <div
                        class="w-16 h-16 bg-[#1a120b] rounded-full border-2 border-[#b8860b] flex items-center justify-center shadow-inner group-hover:border-[#ffd700] transition-colors relative z-10">
                        <img src="assets/achievement/cardPack8.png"
                            class="w-12 h-12 object-contain drop-shadow-lg group-hover:scale-110 transition-transform">
                    </div>
                    <span
                        class="font-black uppercase tracking-widest text-lg font-serif relative z-10 text-center">Livre
                        de Quêtes</span>
                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-20 transition-opacity"></div>
                </a>
            </div>

            <div class="bg-[#1a120b] rounded-xl border border-[#4a3621] p-6 shadow-inner flex-grow">
                <div class="flex items-center gap-3 mb-6 border-b border-[#4a3621] pb-3">
                    <img src="assets/icon/profileIcon.png" alt="Paramètres" class="w-6 h-6 opacity-70">
                    <h2 class="text-lg font-bold text-[#b8860b] uppercase font-serif tracking-wide">Le Registre
                        Personnel</h2>
                </div>

                <?php if ($flash): ?>
                    <div class="mx-6 mt-6 px-4 py-3 rounded-lg border text-sm font-bold tracking-wide text-center
                        <?= $flash['type'] === 'success'
                            ? 'bg-[#1a3a1a] border-[#4caf50] text-[#81c784]'
                            : 'bg-[#3a1a1a] border-[#b71c1c] text-[#ef9a9a]' ?>">
                        <?= htmlspecialchars($flash['message']) ?>
                    </div>
                <?php endif; ?>

                <form action="#" method="POST" class="space-y-6">
                    <input type="hidden" name="action" value="userUpdate">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-gray-500 uppercase text-[10px] font-bold mb-1 tracking-wider">Nom
                                d'Aventurier</label>
                            <input name="username" type="text"
                                value="<?= htmlspecialchars($userData['username'] ?? 'Aventurier Anonyme') ?>"
                                class="w-full bg-[#2d1e12] border border-[#4a3621] rounded px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#b8860b] transition-colors shadow-inner font-serif">
                        </div>
                        <div>
                            <label
                                class="block text-gray-500 uppercase text-[10px] font-bold mb-1 tracking-wider">Parchemin
                                de Correspondance</label>
                            <input name="email" type="email" value="<?= htmlspecialchars($userData['email'] ?? '') ?>"
                                class="w-full bg-[#2d1e12] border border-[#4a3621] rounded px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#b8860b] transition-colors shadow-inner font-serif">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-[#4a3621]/50 space-y-4">
                        <h3
                            class="text-[#f0d8a8] font-bold text-[11px] uppercase tracking-widest mb-2 flex items-center gap-2">
                            <img src="assets/key.png" class="w-3 h-3 opacity-70"> Sécurité du Grimoire
                        </h3>
                        <div>
                            <label
                                class="block text-gray-500 uppercase text-[10px] font-bold mb-1 tracking-wider">Ancien
                                Mot de Pouvoir</label>
                            <input required name="old_password" type="password" placeholder="••••••••••••"
                                class="w-full bg-[#2d1e12] border border-[#4a3621] rounded px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#b8860b] transition-colors shadow-inner font-serif">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label
                                    class="block text-[#b8860b] uppercase text-[10px] font-bold mb-1 tracking-wider">Nouveau
                                    Mot de Pouvoir</label>
                                <input name="new_password" type="password" placeholder="••••••••••••"
                                    class="w-full bg-[#1a120b] border border-[#b8860b]/50 rounded px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#ffd700] transition-colors shadow-inner font-serif">
                            </div>
                            <div>
                                <label
                                    class="block text-[#b8860b] uppercase text-[10px] font-bold mb-1 tracking-wider">Confirmer
                                    le Sceau</label>
                                <input name="confirm_password" type="password" placeholder="••••••••••••"
                                    class="w-full bg-[#1a120b] border border-[#b8860b]/50 rounded px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#ffd700] transition-colors shadow-inner font-serif">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit"
                            class="bg-gradient-to-b from-[#4a3621] to-[#2d1e12] hover:from-[#5d442a] hover:to-[#3d2b1f] text-[#f0d8a8] hover:text-white font-bold uppercase px-8 py-3 rounded border-2 border-[#b8860b] hover:border-[#ffd700] flex items-center justify-center gap-2 transition-all transform active:scale-95 text-xs tracking-widest shadow-[0_5px_15px_rgba(0,0,0,0.5)] w-full sm:w-auto">
                            <img src="assets/checkMark.png" alt="Valider" class="w-3 h-3 drop-shadow-md"> Apposer le
                            Sceau
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include('components/footer.php'); ?>