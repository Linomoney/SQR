<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="description" content="@yield('meta_description', 'Saung Quran Rabbani - Sistem Manajemen Lembaga Pendidikan Quran')">
    <title>@yield('title', 'SQR') – Saung Quran Rabbani</title>

    <!-- PWA Manifest & App Icons -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#2d4a22">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="SQR App">
    <link rel="apple-touch-icon" href="/logo_sqr.png">
    <link rel="icon" type="image/png" href="/logo_sqr.png">

    <!-- Google Fonts: Montserrat & Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

    <!-- Tailwind Config Script -->
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
                        'sqr-dark':        '#1c3115'
                    },
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                        'poppins':    ['Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --sqr-green:  #2d4a22;
            --sqr-dark:   #1c3115;
            --sqr-orange: #e67e22;
            --sqr-bg:     #f0f8d3;
            --sqr-light:  #a3c585;
        }
        body { font-family: 'Poppins', sans-serif; background-color: #f0f8d3; }
        .font-title { font-family: 'Montserrat', sans-serif; }

        /* Premium Form Controls */
        .form-input {
            width: 100%; background-color: rgba(249, 250, 251, 0.9);
            border: 1.5px solid #e5e7eb; border-radius: 0.875rem;
            padding: 0.65rem 0.875rem; font-size: 0.8125rem; font-weight: 500;
            color: #1f2937; outline: none; transition: all 0.2s ease;
        }
        .form-input:focus {
            background-color: #ffffff;
            border-color: #2d4a22;
            box-shadow: 0 0 0 3.5px rgba(45, 74, 34, 0.15);
        }
        .form-label {
            display: block; font-size: 0.75rem; font-weight: 700;
            color: #374151; margin-bottom: 0.35rem;
        }

        /* Mobile Drawer Styling */
        #mobileSidebarOverlay {
            position: fixed; inset: 0; z-index: 90;
            background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);
            opacity: 0; pointer-events: none; transition: opacity 0.3s ease;
        }
        #mobileSidebarOverlay.open { opacity: 1; pointer-events: auto; }
        #mobileSidebarPanel {
            position: fixed; top: 0; right: 0; height: 100vh; height: 100dvh;
            background: #1c3115 !important; color: #ffffff !important;
            width: 80vw; max-width: 320px; padding: 1.25rem;
            transform: translateX(100%); transition: transform 0.35s cubic-bezier(.4,0,.2,1);
            display: flex; flex-direction: column; justify-content: space-between;
            box-shadow: -8px 0 40px rgba(0,0,0,0.35); z-index: 91; overflow-y: auto;
        }
        #mobileSidebarPanel.open, #mobileSidebarPanel:not(.translate-x-full) { transform: translateX(0); }

        /* Left Floating Article Sidebar */
        #artikelSidebarOverlay {
            position: fixed; inset: 0; z-index: 100;
            background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);
            opacity: 0; pointer-events: none; transition: opacity 0.3s ease;
        }
        #artikelSidebarOverlay.open { opacity: 1; pointer-events: auto; }
        #artikelSidebarPanel {
            position: fixed; top: 0; left: 0; height: 100vh; height: 100dvh;
            background: #1c3115 !important; color: #ffffff !important;
            width: 85vw; max-width: 360px; padding: 1.25rem;
            transform: translateX(-100%); transition: transform 0.35s cubic-bezier(.4,0,.2,1);
            display: flex; flex-direction: column; justify-content: space-between;
            box-shadow: 8px 0 40px rgba(0,0,0,0.35); z-index: 101; overflow-y: auto;
        }
        #artikelSidebarPanel.open { transform: translateX(0) !important; }
    </style>

    @stack('styles')
</head>
<body class="h-full bg-sqr-bg font-poppins text-gray-800">

    @unless(request()->routeIs('artikel*'))
        @include('partials.artikel-sidebar')
    @endunless

    @yield('content')

    <!-- Toast notifications -->
    @if(session('success'))
    <div id="toast-success" class="fixed bottom-6 right-6 z-[9999] flex items-center gap-3 bg-sqr-green text-white px-5 py-4 rounded-2xl shadow-2xl max-w-sm text-sm font-semibold">
        <i class="fa-solid fa-circle-check text-sqr-light-green text-lg flex-shrink-0"></i>
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="ml-auto text-white/70 hover:text-white">×</button>
    </div>
    <script>setTimeout(() => document.getElementById('toast-success')?.remove(), 4000);</script>
    @endif

    @if(session('error') || $errors->any())
    <div id="toast-error" class="fixed bottom-6 right-6 z-[9999] flex items-center gap-3 bg-red-600 text-white px-5 py-4 rounded-2xl shadow-2xl max-w-sm text-sm font-semibold">
        <i class="fa-solid fa-circle-exclamation text-lg flex-shrink-0"></i>
        <span>{{ session('error') ?? $errors->first() }}</span>
        <button onclick="this.parentElement.remove()" class="ml-auto text-white/70 hover:text-white">×</button>
    </div>
    <script>setTimeout(() => document.getElementById('toast-error')?.remove(), 5000);</script>
    @endif

    <!-- Tom Select JS -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <!-- PWA Service Worker & Installation Handler -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').then(function(reg) {
                    console.log('SQR PWA ServiceWorker active:', reg.scope);
                }).catch(function(err) {
                    console.log('SQR PWA ServiceWorker error:', err);
                });
            });
        }

        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            const btnList = document.querySelectorAll('.btn-pwa-install');
            btnList.forEach(btn => btn.classList.remove('hidden'));
        });

        function installPWA() {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted PWA install');
                    }
                    deferredPrompt = null;
                });
            } else {
                alert('Aplikasi Saung Quran Rabbani dapat ditambahkan ke layar utama hp/laptop Anda melalui menu browser (Pilih "Tambahkan ke Layar Utama" / "Install App").');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
