<?php
include('components/header.php');
$pageTitle = "Entrer dans l'Auberge";

if ($est_connecte) {
    header('Location: compte.php');
    exit;
}

LoginRegisterFormHandler();

$flash   = $_SESSION['flash'] ?? null;
$openTab = $flash['tab'] ?? 'login';
unset($_SESSION['flash']);

?>

<main class="max-w-4xl mx-auto mt-16 px-4 mb-20 font-sans flex justify-center">

    <div class="w-full max-w-[500px] bg-[#2d1e12] rounded-2xl border-4 border-[#b8860b] shadow-[0_20px_50px_rgba(0,0,0,0.9)] relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-[#ffd700] rounded-tl-xl z-10"></div>
        <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-[#ffd700] rounded-tr-xl z-10"></div>

        <div class="bg-gradient-to-b from-[#1a120b] to-[#2d1e12] p-8 text-center border-b-2 border-[#b8860b]/50 relative">
            <img src="assets/eventDoor.png" alt="Porte de l'Auberge" class="w-20 h-20 mx-auto mb-4 rounded-full border-2 border-[#ffd700] shadow-[0_0_15px_rgba(255,215,0,0.4)]">
            <h1 class="text-3xl font-black text-[#ffd700] hs-text-shadow tracking-widest font-serif uppercase">L'Auberge</h1>
            <p class="text-[#f0d8a8] italic text-sm mt-2">"Entrez il y a de la place autour du foyer !"</p>
        </div>

        <?php if ($flash): ?>
            <div class="mx-6 mt-6 px-4 py-3 rounded-lg border text-sm font-bold tracking-wide text-center
                <?= $flash['type'] === 'success'
                    ? 'bg-[#1a3a1a] border-[#4caf50] text-[#81c784]'
                    : 'bg-[#3a1a1a] border-[#b71c1c] text-[#ef9a9a]' ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>

        <div class="flex border-b-2 border-[#1a120b] bg-[#3d2b1f]">
            <button id="tab-login" onclick="switchTab('login')" class="flex-1 py-4 font-black uppercase tracking-widest text-[#ffd700] bg-[#2d1e12] border-t-2 border-[#ffd700] transition-colors font-serif">
                S'identifier
            </button>
            <button id="tab-register" onclick="switchTab('register')" class="flex-1 py-4 font-black uppercase tracking-widest text-[#b8860b] hover:text-[#f0d8a8] bg-[#1a120b] border-t-2 border-transparent transition-colors font-serif">
                Signer le Registre
            </button>
        </div>

        <div class="p-8">
            
            <form id="form-login" action="#" method="POST" class="space-y-6 block">
                <input type="hidden" name="action" value="login">

                <div class="bg-[#1a120b] p-5 rounded-lg border border-[#4a3621] shadow-inner relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#ffd700]"></div>
                    <label class="block text-[#f0d8a8] uppercase text-xs font-bold mb-2 tracking-wider">Parchemin (Email)</label>
                    <input required type="email" name="identifier" placeholder="voyageur@hearthstone.fr" class="w-full bg-[#2d1e12] border border-[#4a3621] rounded px-4 py-3 text-white focus:outline-none focus:border-[#ffd700] transition-colors shadow-inner font-serif placeholder-gray-600 text-lg">
                </div>

                <div class="bg-[#1a120b] p-5 rounded-lg border border-[#4a3621] shadow-inner relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#ffd700]"></div>
                    <label class="block text-[#f0d8a8] uppercase text-xs font-bold mb-2 tracking-wider">Mot de Pouvoir (Mot de passe)</label>
                    <input required type="password" name="password" placeholder="••••••••••••" class="w-full bg-[#2d1e12] border border-[#4a3621] rounded px-4 py-3 text-white focus:outline-none focus:border-[#ffd700] transition-colors shadow-inner font-serif placeholder-gray-600 text-lg">
                </div>

                <button type="submit" class="w-full mt-6 bg-gradient-to-b from-[#8b1515] to-[#5a0d0d] hover:from-[#a01a1a] hover:to-[#6b1111] text-white font-black uppercase px-6 py-4 rounded border-2 border-[#ffd700] flex justify-center items-center gap-3 shadow-[0_0_15px_rgba(184,134,11,0.4)] transition transform active:scale-95 tracking-widest text-lg">
                    <img src="assets/key.png" alt="" class="w-14 h-14 hidden sm:block drop-shadow-md" onerror="this.style.display='none'">
                    Ouvrir la porte
                </button>
            </form>

            <form id="form-register" action="#" method="POST" class="space-y-5 hidden">
                <input type="hidden" name="action" value="register">

                <div class="bg-[#1a120b] p-5 rounded-lg border border-[#4a3621] shadow-inner relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#b8860b]"></div>
                    <label class="block text-[#f0d8a8] uppercase text-xs font-bold mb-2 tracking-wider">Nom de Héros</label>
                    <input required type="text" name="username" placeholder="Ex: Thrall, Jaina..." class="w-full bg-[#2d1e12] border border-[#4a3621] rounded px-4 py-2.5 text-white focus:outline-none focus:border-[#ffd700] transition-colors shadow-inner font-serif placeholder-gray-600 text-lg">
                </div>

                <div class="bg-[#1a120b] p-5 rounded-lg border border-[#4a3621] shadow-inner relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#b8860b]"></div>
                    <label class="block text-[#f0d8a8] uppercase text-xs font-bold mb-2 tracking-wider">Parchemin de contact (Email)</label>
                    <input required type="email" name="email" placeholder="nouveau@hearthstone.fr" class="w-full bg-[#2d1e12] border border-[#4a3621] rounded px-4 py-2.5 text-white focus:outline-none focus:border-[#ffd700] transition-colors shadow-inner font-serif placeholder-gray-600 text-lg">
                </div>

                <div class="bg-[#1a120b] p-5 rounded-lg border border-[#4a3621] shadow-inner relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#b8860b]"></div>
                    <label class="block text-[#f0d8a8] uppercase text-xs font-bold mb-2 tracking-wider">Forger un Mot de Pouvoir</label>
                    <input required type="password" name="password" placeholder="••••••••••••" class="w-full bg-[#2d1e12] border border-[#4a3621] rounded px-4 py-2.5 text-white focus:outline-none focus:border-[#ffd700] transition-colors shadow-inner font-serif placeholder-gray-600 text-lg">
                </div>

                <button type="submit" class="w-full mt-6 bg-gradient-to-b from-[#4a3621] to-[#2d1e12] hover:from-[#5d442a] hover:to-[#3d2b1f] text-white font-black uppercase px-6 py-4 rounded border-2 border-[#b8860b] flex justify-center items-center gap-3 shadow-[0_0_15px_rgba(0,0,0,0.6)] transition transform active:scale-95 tracking-widest text-lg">
                    <img src="assets/feather.png" alt="" class="w-14 h-14 hidden sm:block drop-shadow-md" onerror="this.style.display='none'">
                    Rejoindre l'Auberge
                </button>
            </form>

        </div>
    </div>
</main>

<?php include('components/footer.php'); ?>