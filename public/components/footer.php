</div>
<footer
    class="bg-gradient-to-b from-[#1a120b] to-[#0f0a06] border-t-4 border-[#b8860b] mt-20 relative shadow-[0_-15px_40px_rgba(0,0,0,0.9)] z-40">

    <div
        class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#ffd700] to-transparent opacity-40">
    </div>

    <div class="max-w-7xl mx-auto px-6 py-14">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 items-start justify-items-center md:justify-items-start">

            <div class="flex flex-col items-center md:items-start text-center md:text-left">
                <div class="flex items-center gap-4 mb-5 group cursor-pointer">
                    <img src="assets/icon/icon.jpg" alt="Logo"
                        class="w-12 h-12 object-cover rounded-full border-2 border-[#b8860b] group-hover:border-[#ffd700] group-hover:shadow-[0_0_15px_rgba(255,215,0,0.6)] transition-all duration-300">
                    <h3 class="text-[#ffd700] text-3xl uppercase tracking-widest font-black font-serif hs-text-shadow">
                        L'Auberge</h3>
                </div>
                <p class="text-[#e6ccac] text-sm leading-relaxed italic opacity-80 font-serif max-w-[280px]">
                    "Prenez une chaise près du feu, voyageur. Il y a toujours de la place pour un autre joueur dans
                    notre auberge."
                </p>
            </div>

            <div class="flex flex-col items-center md:items-start text-center md:text-left w-full">
                <h4
                    class="text-[#b8860b] font-black mb-5 uppercase text-sm tracking-widest border-b-2 border-[#4a3621] pb-2 w-full md:w-[80%]">
                    Pancartes</h4>
                <ul class="space-y-4 text-sm font-bold uppercase tracking-wider text-[#f0d8a8]">
                    <li>
                        <a href="index.php"
                            class="hover:text-[#ffd700] transition-colors flex items-center gap-3 group">
                            <span
                                class="text-[#b8860b] group-hover:text-[#ffd700] group-hover:scale-125 transition-transform">♦</span>
                            Accueil
                        </a>
                    </li>
                    <li>
                        <a href="boutique.php"
                            class="hover:text-[#ffd700] transition-colors flex items-center gap-3 group">
                            <span
                                class="text-[#b8860b] group-hover:text-[#ffd700] group-hover:scale-125 transition-transform">♦</span>
                            Le Marché Noir
                        </a>
                    </li>
                    <li>
                        <a href="library.php"
                            class="hover:text-[#ffd700] transition-colors flex items-center gap-3 group">
                            <span
                                class="text-[#b8860b] group-hover:text-[#ffd700] group-hover:scale-125 transition-transform">♦</span>
                            Mon Grimoire
                        </a>
                    </li>
                </ul>
            </div>

            <div class="flex flex-col items-center md:items-start text-center md:text-left w-full">
                <h4
                    class="text-[#b8860b] font-black mb-5 uppercase text-sm tracking-widest border-b-2 border-[#4a3621] pb-2 w-full md:w-[80%]">
                    Réseaux Magiques</h4>
                <ul class="space-y-4 text-sm font-bold uppercase tracking-wider text-[#f0d8a8]">
                    <li>
                        <a href="https://discord.com/invite/hearthstone"
                            class="hover:text-[#ffd700] transition-colors flex items-center gap-3 group">
                            <img src="assets/icon/profileIcon.png"
                                class="w-4 h-4 opacity-70 group-hover:opacity-100 transition-opacity">
                            Discord de la Taverne
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/hearthstone"
                            class="hover:text-[#ffd700] transition-colors flex items-center gap-3 group">
                            <img src="assets/feather.png"
                                class="w-4 h-4 opacity-70 group-hover:opacity-100 transition-opacity"
                                onerror="this.src=''">
                            Corbeaux (Twitter)
                        </a>
                    </li>
                    <li>
                        <a href="https://www.facebook.com/hearthstone"
                            class="hover:text-[#ffd700] transition-colors flex items-center gap-3 group">
                            <img src="assets/book.png"
                                class="w-4 h-4 opacity-70 group-hover:opacity-100 transition-opacity"
                                onerror="this.src=''">
                            Le Livre des Visages (Facebook)
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="border-t-2 border-[#3d2b1f] mt-14 pt-8 flex flex-col items-center text-center">
            <img src="assets/feather.png" alt="Plume"
                class="w-10 h-10 mb-5 opacity-30 drop-shadow-md hover:opacity-80 transition-opacity duration-500 cursor-pointer"
                onerror="this.style.display='none'">
            <p class="text-[10px] text-[#b8860b] uppercase tracking-[0.2em] leading-loose">
                &copy; <?php echo date('Y'); ?> L'Auberge - Projet Web.<br>
                <span class="opacity-50 hover:opacity-100 transition-opacity cursor-default">Toutes les images sont la
                    propriété de Blizzard Entertainment.</span>
            </p>
        </div>
    </div>
</footer>

</body>

</html>