<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance – Saung Quran Rabbani</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sqr-bg':          '#f0f8d3',
                        'sqr-green':       '#2d4a22',
                        'sqr-orange':      '#e67e22',
                        'sqr-light-green': '#a3c585',
                        'sqr-dark':        '#1c3115',
                    },
                    fontFamily: {
                        'title': ['Montserrat', 'sans-serif'],
                        'body':  ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; overflow-x: hidden; }
        .font-title { font-family: 'Montserrat', sans-serif; }

        /* Floating Particles */
        @keyframes float-particle {
            0%   { transform: translateY(0px) rotate(0deg) scale(1); opacity: 0.6; }
            33%  { transform: translateY(-30px) rotate(120deg) scale(1.1); opacity: 0.3; }
            66%  { transform: translateY(-15px) rotate(240deg) scale(0.9); opacity: 0.5; }
            100% { transform: translateY(0px) rotate(360deg) scale(1); opacity: 0.6; }
        }
        .particle-float {
            animation: float-particle ease-in-out infinite;
        }

        /* Gear rotation */
        @keyframes gear-spin {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }
        @keyframes gear-spin-reverse {
            from { transform: rotate(0deg); }
            to   { transform: rotate(-360deg); }
        }
        .gear-main { animation: gear-spin 8s linear infinite; }
        .gear-small { animation: gear-spin-reverse 4s linear infinite; }

        /* Pulse ring */
        @keyframes pulse-ring {
            0%   { transform: scale(0.9); box-shadow: 0 0 0 0 rgba(230,126,34,0.5); }
            70%  { transform: scale(1); box-shadow: 0 0 0 20px rgba(230,126,34,0); }
            100% { transform: scale(0.9); box-shadow: 0 0 0 0 rgba(230,126,34,0); }
        }
        .pulse-ring { animation: pulse-ring 2.5s ease-out infinite; }

        /* Progress wave */
        @keyframes progress-wave {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .progress-wave {
            background: linear-gradient(90deg, #e67e22, #f39c12, #a3c585, #2d4a22, #e67e22);
            background-size: 300% 100%;
            animation: progress-wave 3s ease infinite;
        }

        /* Slide Up */
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .slide-up { animation: slide-up 0.7s ease-out forwards; }
        .d1 { animation-delay: 0.1s; opacity: 0; }
        .d2 { animation-delay: 0.25s; opacity: 0; }
        .d3 { animation-delay: 0.4s; opacity: 0; }
        .d4 { animation-delay: 0.6s; opacity: 0; }
        .d5 { animation-delay: 0.8s; opacity: 0; }

        /* Glitch for "503" */
        @keyframes glitch-1 {
            0%, 100% { clip-path: inset(0 0 95% 0); transform: translate(-5px, 0); }
            50%       { clip-path: inset(0 0 95% 0); transform: translate(5px, 0); }
        }
        @keyframes glitch-2 {
            0%, 100% { clip-path: inset(90% 0 0 0); transform: translate(5px, 0); }
            50%       { clip-path: inset(90% 0 0 0); transform: translate(-5px, 0); }
        }
        .glitch-text {
            position: relative;
        }
        .glitch-text::before,
        .glitch-text::after {
            content: attr(data-text);
            position: absolute;
            top: 0; left: 0; right: 0;
            background: inherit;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .glitch-text::before {
            animation: glitch-1 3s infinite;
            color: #e67e22;
            text-shadow: -2px 0 #e67e22;
        }
        .glitch-text::after {
            animation: glitch-2 3s infinite;
            color: #a3c585;
            text-shadow: 2px 0 #a3c585;
        }

        /* Islamic Star Rotate */
        @keyframes star-rotate {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }
        .star-rotate { animation: star-rotate 20s linear infinite; }
        .star-rotate-reverse { animation: star-rotate 15s linear infinite reverse; }

        /* Blink */
        @keyframes blink-cursor {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0; }
        }
        .blink { animation: blink-cursor 1s step-end infinite; }

        /* Countdown flip */
        @keyframes count-flip {
            0%   { transform: rotateX(0); }
            50%  { transform: rotateX(-90deg); }
            100% { transform: rotateX(0); }
        }
        .count-flip { animation: count-flip 1s ease-in-out; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-sqr-dark via-[#243d1a] to-[#1a3510] relative overflow-x-hidden">

    <!-- Ambient Blobs -->
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-sqr-orange/8 rounded-full blur-[150px]"></div>
        <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] bg-sqr-light-green/8 rounded-full blur-[150px]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-white/3 rounded-full blur-[100px]"></div>
    </div>

    <!-- Islamic Star Decorations -->
    <div class="fixed top-8 left-8 w-24 h-24 opacity-10 pointer-events-none z-0">
        <svg viewBox="0 0 100 100" class="w-full h-full star-rotate" fill="none">
            <polygon points="50,5 61,35 95,35 68,57 79,91 50,70 21,91 32,57 5,35 39,35" fill="#e67e22"/>
        </svg>
    </div>
    <div class="fixed top-8 right-8 w-32 h-32 opacity-8 pointer-events-none z-0">
        <svg viewBox="0 0 100 100" class="w-full h-full star-rotate-reverse" fill="none">
            <polygon points="50,5 61,35 95,35 68,57 79,91 50,70 21,91 32,57 5,35 39,35" fill="#a3c585"/>
        </svg>
    </div>
    <div class="fixed bottom-12 right-12 w-20 h-20 opacity-10 pointer-events-none z-0">
        <svg viewBox="0 0 100 100" class="w-full h-full star-rotate" fill="none">
            <polygon points="50,5 61,35 95,35 68,57 79,91 50,70 21,91 32,57 5,35 39,35" fill="#e67e22"/>
        </svg>
    </div>

    <!-- Floating Particles -->
    <div id="particleArea" class="fixed inset-0 pointer-events-none z-0 overflow-hidden"></div>

    <!-- MAIN CONTENT -->
    <div class="relative z-10 min-h-screen flex flex-col items-center justify-center px-4 py-16">

        <!-- Header Logo Brand -->
        <div class="slide-up d1 mb-10 sm:mb-12 flex items-center gap-3">
            <div class="w-12 h-12 bg-white rounded-2xl p-1.5 shadow-xl border border-white/20 flex items-center justify-center overflow-hidden">
                <img src="/logo_sqr.png" alt="SQR" class="w-full h-full object-contain">
            </div>
            <div>
                <p class="font-title font-black text-sqr-bg text-base sm:text-lg tracking-wide leading-none">SAUNG QURAN RABBANI</p>
                <p class="text-sqr-orange text-[10px] sm:text-xs font-bold tracking-widest uppercase mt-0.5">Sistem Informasi Manajemen</p>
            </div>
        </div>

        <!-- Gear Illustration -->
        <div class="slide-up d1 mb-8 relative">
            <div class="relative flex items-center justify-center">

                <!-- Main Gear -->
                <div class="relative w-28 h-28 sm:w-36 sm:h-36">
                    <svg class="w-full h-full gear-main" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M43,5 L57,5 L60,18 C63,19 66,20 69,22 L81,16 L91,26 L85,38 C87,41 88,44 89,47 L103,50 L103,64 L89,67 C88,70 87,73 85,76 L91,88 L81,98 L69,92 C66,94 63,95 60,96 L57,110 L43,110 L40,96 C37,95 34,94 31,92 L19,98 L9,88 L15,76 C13,73 12,70 11,67 L-3,64 L-3,50 L11,47 C12,44 13,41 15,38 L9,26 L19,16 L31,22 C34,20 37,19 40,18 Z"
                              transform="translate(-3, -10) scale(1.1)"
                              fill="#2d4a22" stroke="#a3c585" stroke-width="1" opacity="0.8"/>
                        <circle cx="50" cy="50" r="20" fill="#1c3115" stroke="#e67e22" stroke-width="2"/>
                        <circle cx="50" cy="50" r="8" fill="#e67e22" opacity="0.8"/>
                    </svg>
                </div>

                <!-- Small Gear (interlocked) -->
                <div class="absolute -top-4 -right-4 sm:-top-6 sm:-right-6 w-14 h-14 sm:w-18 sm:h-18">
                    <svg class="w-full h-full gear-small" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M27,2 L33,2 L35,10 C37,11 39,12 41,13 L49,9 L55,15 L51,23 C52,25 53,27 53,29 L61,31 L61,37 L53,39 C53,41 52,43 51,45 L55,53 L49,59 L41,55 C39,56 37,57 35,58 L33,66 L27,66 L25,58 C23,57 21,56 19,55 L11,59 L5,53 L9,45 C8,43 7,41 7,39 L-1,37 L-1,31 L7,29 C7,27 8,25 9,23 L5,15 L11,9 L19,13 C21,12 23,11 25,10 Z"
                              transform="translate(-2, -4) scale(1.05)"
                              fill="#1c3115" stroke="#e67e22" stroke-width="1.5" opacity="0.9"/>
                        <circle cx="30" cy="30" r="10" fill="#2d4a22" stroke="#a3c585" stroke-width="1.5"/>
                        <circle cx="30" cy="30" r="4" fill="#e67e22" opacity="0.7"/>
                    </svg>
                </div>

                <!-- Wrench Icon overlay -->
                <div class="absolute -bottom-3 -left-3 sm:-bottom-4 sm:-left-4 w-10 h-10 bg-sqr-orange rounded-2xl flex items-center justify-center shadow-lg pulse-ring">
                    <i class="fa-solid fa-wrench text-white text-sm"></i>
                </div>
            </div>
        </div>

        <!-- Error Code -->
        <div class="slide-up d2 mb-3">
            <h1 data-text="503" class="font-title font-black text-[90px] sm:text-[140px] leading-none text-transparent bg-clip-text bg-gradient-to-b from-sqr-orange via-amber-400 to-sqr-orange glitch-text select-none drop-shadow-2xl">
                503
            </h1>
        </div>

        <!-- Title -->
        <div class="slide-up d2 flex items-center gap-3 justify-center mb-6">
            <div class="flex-1 h-px bg-gradient-to-r from-transparent to-sqr-orange/50 max-w-[60px] sm:max-w-[120px]"></div>
            <h2 class="font-title font-bold text-lg sm:text-2xl text-white tracking-wide text-center">Mode Pemeliharaan</h2>
            <div class="flex-1 h-px bg-gradient-to-l from-transparent to-sqr-orange/50 max-w-[60px] sm:max-w-[120px]"></div>
        </div>

        <!-- Description Card -->
        <div class="slide-up d3 mb-8 max-w-xl w-full mx-auto">
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-6 sm:p-8 text-center space-y-4">

                <!-- Status Badge -->
                <div class="inline-flex items-center gap-2 bg-amber-500/20 border border-amber-500/30 text-amber-300 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider">
                    <span class="w-2 h-2 bg-amber-400 rounded-full animate-pulse"></span>
                    Sedang Dalam Perbaikan
                </div>

                <p class="text-white/80 text-sm sm:text-base leading-relaxed">
                    Website <strong class="text-sqr-light-green">Saung Quran Rabbani</strong> sedang dalam masa pemeliharaan untuk meningkatkan layanan kami kepada seluruh santri, ustadz, dan wali santri.
                </p>

                <!-- Custom Message from Admin -->
                @if(isset($maintenance_message) && $maintenance_message)
                <div class="bg-sqr-green/30 border border-sqr-light-green/20 rounded-2xl px-4 py-3 text-left">
                    <p class="text-sqr-light-green text-xs font-bold mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-comment-dots"></i> Pesan dari Administrator:
                    </p>
                    <p class="text-white/70 text-sm leading-relaxed">{{ $maintenance_message }}</p>
                </div>
                @else
                <div class="bg-sqr-green/30 border border-sqr-light-green/20 rounded-2xl px-4 py-3 text-left">
                    <p class="text-sqr-light-green text-xs font-bold mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-comment-dots"></i> Pesan dari Administrator:
                    </p>
                    <p class="text-white/70 text-sm leading-relaxed">
                        Kami mohon maaf atas ketidaknyamanan ini. Pemeliharaan dijadwalkan selesai secepatnya. Terima kasih atas kesabaran Anda.
                    </p>
                </div>
                @endif

                <!-- What's being done -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                    <div class="bg-white/5 rounded-2xl p-3 text-center">
                        <i class="fa-solid fa-database text-sqr-orange text-xl mb-2"></i>
                        <p class="text-white/60 text-[11px] font-semibold">Optimasi Database</p>
                    </div>
                    <div class="bg-white/5 rounded-2xl p-3 text-center">
                        <i class="fa-solid fa-shield-halved text-sqr-light-green text-xl mb-2"></i>
                        <p class="text-white/60 text-[11px] font-semibold">Update Keamanan</p>
                    </div>
                    <div class="bg-white/5 rounded-2xl p-3 text-center">
                        <i class="fa-solid fa-rocket text-sqr-orange text-xl mb-2"></i>
                        <p class="text-white/60 text-[11px] font-semibold">Peningkatan Fitur</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="slide-up d4 max-w-md w-full mx-auto mb-8">
            <div class="flex items-center justify-between text-xs text-white/50 font-semibold mb-2">
                <span class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-sqr-orange rounded-full animate-pulse"></span>
                    Sedang berlangsung...
                </span>
                <span class="font-mono text-sqr-orange" id="progressPct">0%</span>
            </div>
            <div class="h-2.5 bg-white/10 rounded-full overflow-hidden">
                <div id="maintenanceBar" class="h-full rounded-full progress-wave transition-all duration-1000" style="width: 0%"></div>
            </div>
        </div>

        <!-- Terminal Console -->
        <div class="slide-up d4 max-w-xl w-full mx-auto mb-8">
            <div class="bg-black/40 backdrop-blur border border-white/10 rounded-2xl p-4 font-mono text-xs">
                <div class="flex items-center gap-2 mb-3 border-b border-white/10 pb-2.5">
                    <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                    <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                    <span class="text-white/40 text-[10px] ml-2">maintenance.log</span>
                </div>
                <div class="space-y-1.5 text-[11px]" id="terminalOutput">
                    <p><span class="text-sqr-light-green">$</span> <span class="text-white/70">php artisan down --message="Pemeliharaan sistem..."</span></p>
                    <p><span class="text-white/40">[{{ now()->format('H:i:s') }}]</span> <span class="text-yellow-400">INFO: Application is now in maintenance mode.</span></p>
                    <p><span class="text-sqr-light-green">$</span> <span class="text-white/70">php artisan optimize:clear</span></p>
                    <p id="typingLine"><span class="text-white/40">[{{ now()->format('H:i:s') }}]</span> <span class="text-sqr-light-green" id="typingText"></span><span class="blink text-white">|</span></p>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="slide-up d5 flex flex-col sm:flex-row items-center justify-center gap-3 mb-10">
            <a href="https://wa.me/6289677082002" target="_blank"
               class="flex items-center gap-2 px-5 py-3 bg-emerald-600/20 hover:bg-emerald-600/30 border border-emerald-500/30 text-emerald-300 font-bold text-sm rounded-2xl transition-all duration-300 hover:-translate-y-1">
                <i class="fa-brands fa-whatsapp text-lg"></i>
                WhatsApp Admin SQR
            </a>
            <span class="text-white/30 text-xs hidden sm:block">atau</span>
            <a href="mailto:info@sqr.id"
               class="flex items-center gap-2 px-5 py-3 bg-white/5 hover:bg-white/10 border border-white/10 text-white/70 hover:text-white font-bold text-sm rounded-2xl transition-all duration-300 hover:-translate-y-1">
                <i class="fa-solid fa-envelope text-sqr-orange"></i>
                info@sqr.id
            </a>
        </div>

        <!-- Footer -->
        <div class="slide-up d5 text-center">
            <p class="text-white/30 text-xs font-semibold">
                © {{ date('Y') }} Saung Quran Rabbani · Yayasan Bina Cahaya Ilmu Rabbani
            </p>
        </div>
    </div>

    <script>
        // Floating Particles
        (function() {
            var container = document.getElementById('particleArea');
            if (!container) return;
            var symbols = ['☪', '✦', '◆', '★', '❋', '✿', '❀', '◈', '⚙', '🔧'];
            var count = window.innerWidth < 640 ? 6 : 12;
            for (var i = 0; i < count; i++) {
                var el = document.createElement('div');
                el.className = 'particle-float';
                el.style.position = 'absolute';
                el.style.left = Math.random() * 95 + '%';
                el.style.top = Math.random() * 90 + '%';
                el.style.fontSize = (Math.random() * 20 + 10) + 'px';
                el.style.color = Math.random() > 0.5 ? 'rgba(163,197,133,0.12)' : 'rgba(230,126,34,0.12)';
                el.style.animationDuration = (Math.random() * 8 + 5) + 's';
                el.style.animationDelay = (Math.random() * -10) + 's';
                el.textContent = symbols[Math.floor(Math.random() * symbols.length)];
                container.appendChild(el);
            }
        })();

        // Progress Bar Animation
        var targetPct = Math.floor(Math.random() * 30) + 45; // 45–75%
        var currentPct = 0;
        var bar = document.getElementById('maintenanceBar');
        var pctEl = document.getElementById('progressPct');
        var interval = setInterval(function() {
            if (currentPct < targetPct) {
                currentPct++;
                if (bar) bar.style.width = currentPct + '%';
                if (pctEl) pctEl.textContent = currentPct + '%';
            } else {
                clearInterval(interval);
            }
        }, 40);

        // Typing Terminal Animation
        var lines = [
            'Clearing compiled views...',
            'Clearing route cache...',
            'Running database migrations...',
            'Optimizing application...',
            'Selesai. Sistem akan segera kembali aktif.'
        ];
        var lineIdx = 0;
        var charIdx = 0;
        var typingEl = document.getElementById('typingText');

        function typeNext() {
            if (!typingEl) return;
            if (lineIdx >= lines.length) {
                typingEl.textContent = '✓ Pemeliharaan selesai. Silakan refresh halaman.';
                typingEl.style.color = '#a3c585';
                return;
            }
            var currentLine = lines[lineIdx];
            if (charIdx < currentLine.length) {
                typingEl.textContent += currentLine[charIdx];
                charIdx++;
                setTimeout(typeNext, 60);
            } else {
                // Line done – add new line
                var terminalOutput = document.getElementById('terminalOutput');
                if (terminalOutput) {
                    var newLine = document.createElement('p');
                    newLine.innerHTML = '<span style="color:rgba(163,197,133,0.5)">▶</span> <span style="color:rgba(255,255,255,0.7)">' + currentLine + '</span>';
                    var typingLine = document.getElementById('typingLine');
                    if (typingLine) terminalOutput.insertBefore(newLine, typingLine);
                    typingEl.textContent = '';
                }
                charIdx = 0;
                lineIdx++;
                setTimeout(typeNext, 800);
            }
        }
        setTimeout(typeNext, 2000);
    </script>
</body>
</html>
