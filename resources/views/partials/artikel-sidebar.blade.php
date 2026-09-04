<!-- ===== FLOATING LEFT TRIGGER UNTUK SIDEBAR ARTIKEL ===== -->
<button id="floatingLeftArtikelBtn" onclick="openArtikelSidebar()" 
        class="fixed left-0 top-[35%] z-40 bg-sqr-green/95 hover:bg-sqr-dark text-white border-y border-r border-sqr-orange/60 shadow-xl rounded-r-xl py-2.5 px-2 flex items-center gap-2 group transition-all duration-300 hover:pr-3 cursor-pointer backdrop-blur-sm"
        title="Buka Artikel & Kegiatan SQR">
    <i class="fa-solid fa-chevron-right text-sqr-orange text-[10px] group-hover:translate-x-0.5 transition-transform"></i>
    <i class="fa-solid fa-newspaper text-sqr-orange text-sm"></i>
    <span class="font-title font-bold text-[10px] tracking-wider text-white uppercase hidden sm:inline">Artikel</span>
</button>

<!-- ===== ARTIKEL SIDEBAR BACKDROP OVERLAY ===== -->
<div id="artikelSidebarOverlay" 
     style="position: fixed; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); z-index: 9998; opacity: 0; pointer-events: none; transition: opacity 0.3s ease;">
    <div onclick="closeArtikelSidebar()" style="position: absolute; inset: 0;"></div>
</div>

<!-- ===== ARTIKEL SIDEBAR PANEL (SMOOTH SLIDE-IN DRAWER) ===== -->
<aside id="artikelSidebarPanel" 
       style="position: fixed; top: 0; left: 0; height: 100vh; height: 100dvh; width: 85vw; max-width: 360px; background-color: #1c3115 !important; color: #ffffff !important; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 8px 0 40px rgba(0,0,0,0.35); z-index: 9999; transform: translateX(-100%); transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1); overflow: hidden;">
    
    <!-- Header -->
    <div class="flex items-center justify-between px-5 py-4 border-b border-white/10 bg-sqr-dark/90 shrink-0">
        <div class="flex items-center gap-2.5">
            <i class="fa-solid fa-newspaper text-sqr-orange text-base"></i>
            <div>
                <p class="font-title font-bold text-sm text-white leading-none">Artikel & Kegiatan</p>
                <p class="text-[10px] text-sqr-light-green mt-0.5">Saung Quran Rabbani</p>
            </div>
        </div>
        <button onclick="closeArtikelSidebar()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <!-- Search Input -->
    <div class="px-4 py-3 border-b border-white/10 shrink-0">
        <div class="relative">
            <input type="text" id="artikelSearchInput" placeholder="Cari artikel..." onkeyup="filterArtikelList()"
                class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 text-xs rounded-xl px-4 py-2.5 outline-none focus:border-sqr-orange/60 pr-8">
            <i class="fa-solid fa-magnifying-glass absolute right-3 top-1/2 -translate-y-1/2 text-white/40 text-xs"></i>
        </div>
    </div>

    <!-- Artikel List Container -->
    <div class="flex-1 overflow-y-auto px-4 py-3 space-y-3" id="artikelListContainer" style="-webkit-overflow-scrolling: touch;">
        <div id="artikelLoadingState" class="text-center py-10">
            <i class="fa-solid fa-spinner fa-spin text-sqr-orange text-2xl mb-2"></i>
            <p class="text-white/60 text-xs font-semibold">Memuat artikel SQR...</p>
        </div>
    </div>

    <!-- Footer link -->
    <div class="border-t border-white/10 p-3.5 text-center bg-sqr-dark/90 shrink-0">
        <a href="{{ route('artikel') }}" class="text-xs text-sqr-orange font-bold hover:underline flex items-center justify-center gap-1.5">
            Lihat Semua Artikel <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>
</aside>

<script>
    var cachedArticles = [];

    function openArtikelSidebar() {
        var overlay  = document.getElementById('artikelSidebarOverlay');
        var panel    = document.getElementById('artikelSidebarPanel');
        var floatBtn = document.getElementById('floatingLeftArtikelBtn');
        if (!overlay || !panel) return;

        // Smooth backdrop fade-in
        overlay.style.opacity = '1';
        overlay.style.pointerEvents = 'auto';

        // Smooth panel slide-in from left
        panel.style.transform = 'translateX(0)';

        if (floatBtn) floatBtn.style.display = 'none';
        document.body.style.overflow = 'hidden';

        if (cachedArticles.length === 0) {
            fetchArticlesForSidebar();
        }
    }

    function closeArtikelSidebar() {
        var overlay  = document.getElementById('artikelSidebarOverlay');
        var panel    = document.getElementById('artikelSidebarPanel');
        var floatBtn = document.getElementById('floatingLeftArtikelBtn');
        if (!overlay || !panel) return;

        // Smooth backdrop fade-out
        overlay.style.opacity = '0';
        overlay.style.pointerEvents = 'none';

        // Smooth panel slide-out to left
        panel.style.transform = 'translateX(-100%)';

        document.body.style.overflow = '';
        if (floatBtn) floatBtn.style.display = 'flex';
    }

    function fetchArticlesForSidebar() {
        var container = document.getElementById('artikelListContainer');
        fetch('/api/artikel-list')
            .then(res => res.json())
            .then(data => {
                cachedArticles = data;
                renderArticles(cachedArticles);
            })
            .catch(err => {
                container.innerHTML = '<p class="text-xs text-red-400 text-center py-6">Gagal memuat artikel.</p>';
            });
    }

    function renderArticles(list) {
        var container = document.getElementById('artikelListContainer');
        if (!list || list.length === 0) {
            container.innerHTML = '<p class="text-xs text-gray-400 text-center py-6">Artikel tidak ditemukan.</p>';
            return;
        }

        var html = '';
        list.forEach(a => {
            var thumbHtml = a.thumbnail 
                ? '<img src="' + a.thumbnail + '" class="w-20 h-16 object-cover rounded-xl shrink-0 border border-white/10">' 
                : '<div class="w-20 h-16 bg-sqr-green rounded-xl shrink-0 flex items-center justify-center text-sqr-orange font-bold text-xs"><i class="fa-solid fa-newspaper text-base"></i></div>';

            html += '<a href="' + a.detail_url + '" class="flex gap-3 p-3 rounded-2xl bg-white/5 hover:bg-white/15 border border-white/10 transition group text-left block">' +
                        thumbHtml +
                        '<div class="flex-1 min-w-0">' +
                            '<span class="text-[9px] font-bold text-sqr-orange uppercase tracking-wider block mb-0.5">' + a.category + '</span>' +
                            '<h4 class="font-title font-bold text-xs text-white group-hover:text-sqr-bg transition line-clamp-2 leading-snug">' + a.title + '</h4>' +
                            '<p class="text-[10px] text-white/50 mt-1">' + a.date + '</p>' +
                        '</div>' +
                    '</a>';
        });

        container.innerHTML = html;
    }

    function filterArtikelList() {
        var query = document.getElementById('artikelSearchInput').value.toLowerCase();
        var filtered = cachedArticles.filter(a => {
            return a.title.toLowerCase().includes(query) || a.excerpt.toLowerCase().includes(query) || a.category.toLowerCase().includes(query);
        });
        renderArticles(filtered);
    }
</script>
