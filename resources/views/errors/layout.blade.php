<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Error') – Saung Quran Rabbani</title>

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
                        'title':  ['Montserrat', 'sans-serif'],
                        'body':   ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-title { font-family: 'Montserrat', sans-serif; }

        /* Floating Particle Animation */
        @keyframes float-up {
            0%   { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10%  { opacity: 0.6; }
            90%  { opacity: 0.4; }
            100% { transform: translateY(-100px) rotate(720deg); opacity: 0; }
        }
        .particle {
            position: absolute;
            border-radius: 50%;
            animation: float-up linear infinite;
            pointer-events: none;
        }

        /* Glowing pulse */
        @keyframes glow-pulse {
            0%, 100% { box-shadow: 0 0 20px rgba(230,126,34,0.4), 0 0 60px rgba(230,126,34,0.2); }
            50%       { box-shadow: 0 0 40px rgba(230,126,34,0.8), 0 0 100px rgba(230,126,34,0.4); }
        }
        .glow-pulse { animation: glow-pulse 2.5s ease-in-out infinite; }

        /* Float bob */
        @keyframes float-bob {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-18px); }
        }
        .float-bob { animation: float-bob 3.5s ease-in-out infinite; }

        /* Code Rain */
        @keyframes code-rain {
            0%   { transform: translateY(-100%); opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 0.5; }
            100% { transform: translateY(100vh); opacity: 0; }
        }
        .code-drop {
            position: absolute;
            font-family: 'Courier New', monospace;
            font-size: 11px;
            color: rgba(163, 197, 133, 0.4);
            animation: code-rain linear infinite;
            pointer-events: none;
        }

        /* Shake animation for error number */
        @keyframes error-shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-8px) rotate(-1deg); }
            20%, 40%, 60%, 80%      { transform: translateX(8px) rotate(1deg); }
        }
        .error-shake { animation: error-shake 0.8s ease-in-out; }

        /* Rotate islamic pattern */
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }
        .spin-slow { animation: spin-slow 25s linear infinite; }

        /* Fade + slide in */
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .slide-up { animation: slide-up 0.7s ease-out forwards; }
        .slide-up-d1 { animation-delay: 0.1s; opacity: 0; }
        .slide-up-d2 { animation-delay: 0.25s; opacity: 0; }
        .slide-up-d3 { animation-delay: 0.4s; opacity: 0; }
        .slide-up-d4 { animation-delay: 0.55s; opacity: 0; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-sqr-dark via-sqr-green to-[#1a3510] overflow-x-hidden relative" id="errorBody">

    <!-- Animated Background Particles -->
    <div id="particleContainer" class="absolute inset-0 overflow-hidden pointer-events-none z-0"></div>

    <!-- Code Rain Background (for 500) -->
    @yield('code-rain')

    <!-- Islamic Geometric Background Ornament -->
    <div class="absolute top-0 right-0 w-96 h-96 opacity-5 pointer-events-none z-0 overflow-hidden">
        <svg viewBox="0 0 400 400" class="w-full h-full spin-slow" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g fill="#a3c585">
                @for ($i = 0; $i < 12; $i++)
                    <polygon points="200,60 220,140 300,140 235,190 260,270 200,220 140,270 165,190 100,140 180,140" opacity="0.3" transform="rotate({{ $i * 30 }}, 200, 200)" />
                @endfor
            </g>
        </svg>
    </div>
    <div class="absolute bottom-0 left-0 w-72 h-72 opacity-5 pointer-events-none z-0 overflow-hidden">
        <svg viewBox="0 0 300 300" class="w-full h-full" style="animation: spin-slow 20s linear infinite reverse;" fill="none">
            <g fill="#e67e22">
                @for ($i = 0; $i < 8; $i++)
                    <polygon points="150,30 175,100 245,100 190,145 215,215 150,170 85,215 110,145 55,100 125,100" opacity="0.4" transform="rotate({{ $i * 45 }}, 150, 150)" />
                @endfor
            </g>
        </svg>
    </div>

    <!-- Ambient glow blobs -->
    <div class="absolute top-1/4 -left-32 w-80 h-80 bg-sqr-orange/10 rounded-full blur-[120px] pointer-events-none z-0"></div>
    <div class="absolute bottom-1/4 -right-32 w-80 h-80 bg-sqr-light-green/10 rounded-full blur-[120px] pointer-events-none z-0"></div>

    <!-- Main Content -->
    <div class="relative z-10 min-h-screen flex flex-col items-center justify-center px-4 py-12">
        @yield('content')
    </div>

    <!-- Footer Branding -->
    <div class="relative z-10 pb-6 text-center">
        <a href="/" class="inline-flex items-center gap-2.5 opacity-70 hover:opacity-100 transition-opacity duration-300 group">
            <div class="w-8 h-8 bg-white rounded-xl p-1 shadow-md flex items-center justify-center overflow-hidden group-hover:scale-110 transition-transform">
                <img src="/logo_sqr.png" alt="SQR" class="w-full h-full object-contain">
            </div>
            <span class="text-sqr-light-green font-title font-bold text-xs tracking-wider uppercase">Saung Quran Rabbani</span>
        </a>
    </div>

    <script>
        // Generate floating particles
        (function() {
            var container = document.getElementById('particleContainer');
            if (!container) return;
            var chars = ['☪', '✦', '◆', '★', '❋', '✿', '❀', '◈'];
            var count = window.innerWidth < 640 ? 8 : 15;
            for (var i = 0; i < count; i++) {
                var el = document.createElement('div');
                el.className = 'particle';
                el.style.left = Math.random() * 100 + '%';
                el.style.width = (Math.random() * 12 + 6) + 'px';
                el.style.height = el.style.width;
                el.style.background = Math.random() > 0.5
                    ? 'rgba(163,197,133,' + (Math.random() * 0.3 + 0.05) + ')'
                    : 'rgba(230,126,34,' + (Math.random() * 0.2 + 0.05) + ')';
                el.style.animationDuration = (Math.random() * 15 + 10) + 's';
                el.style.animationDelay = (Math.random() * -20) + 's';
                el.style.fontSize = (Math.random() * 14 + 8) + 'px';
                el.style.color = 'rgba(163,197,133,0.2)';
                if (Math.random() > 0.6) el.textContent = chars[Math.floor(Math.random() * chars.length)];
                container.appendChild(el);
            }
        })();

        // Add shake on click for error number
        var errNum = document.getElementById('errorNumber');
        if (errNum) {
            errNum.addEventListener('click', function() {
                this.classList.remove('error-shake');
                void this.offsetWidth; // reflow
                this.classList.add('error-shake');
            });
        }
    </script>
</body>
</html>
