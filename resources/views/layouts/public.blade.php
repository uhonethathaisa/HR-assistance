<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'HR Assistance') }}</title>
    <meta name="description" content="Browse and search open roles from leading South African employers. Apply directly to external job boards — no account required.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        /* ─── Base ─── */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0A0B14;
            color: #F8FAFC;
            overflow-x: hidden;
        }

        /* ─── Custom Scrollbar ─── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0A0B14; }
        ::-webkit-scrollbar-thumb { background: #2D3A4F; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #7C3AED; }

        /* ─── Hero Gradient Orbs ─── */
        .hero-orb {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle at center, rgba(124, 58, 237, 0.12), transparent 70%);
            filter: blur(80px);
            animation: orbFloat 8s ease-in-out infinite;
            pointer-events: none;
        }
        .hero-orb-2 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle at center, rgba(236, 72, 153, 0.08), transparent 70%);
            animation: orbFloat 12s ease-in-out infinite reverse;
            top: 60%;
            left: 60%;
        }

        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.95); }
        }

        /* ─── Glassmorphism ─── */
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }
        .glass-card {
            background: rgba(19, 20, 31, 0.8);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(45, 58, 79, 0.4);
        }
        .glass-card:hover {
            border-color: rgba(124, 58, 237, 0.3);
            box-shadow: 0 8px 32px rgba(124, 58, 237, 0.1);
        }

        /* ─── Gradient Text ─── */
        .gradient-text {
            background: linear-gradient(135deg, #A78BFA, #7C3AED, #EC4899);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* ─── Glow Effects ─── */
        .glow-purple {
            box-shadow: 0 0 20px rgba(124, 58, 237, 0.15), 0 0 60px rgba(124, 58, 237, 0.05);
        }
        .glow-purple:hover {
            box-shadow: 0 0 30px rgba(124, 58, 237, 0.25), 0 0 80px rgba(124, 58, 237, 0.1);
        }

        /* ─── Button Animations ─── */
        .btn-primary {
            background: linear-gradient(135deg, #7C3AED, #6D28D9);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .btn-primary:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 30px rgba(124, 58, 237, 0.35);
        }
        .btn-outline {
            border: 1px solid rgba(124, 58, 237, 0.3);
            transition: all 0.3s ease;
        }
        .btn-outline:hover {
            border-color: #7C3AED;
            background: rgba(124, 58, 237, 0.1);
            transform: translateY(-2px);
        }

        /* ─── Navbar Scroll Effect ─── */
        .navbar-scrolled {
            background: rgba(10, 11, 20, 0.85) !important;
            backdrop-filter: blur(20px) !important;
            border-bottom: 1px solid rgba(45, 58, 79, 0.3) !important;
        }

        /* ─── SA Flag Badge ─── */
        .sa-flag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .sa-flag-bar {
            width: 18px;
            height: 12px;
            border-radius: 2px;
            background: linear-gradient(180deg,
                #DE3831 0%, #DE3831 33%,
                #007A4D 33%, #007A4D 66%,
                #002395 66%, #002395 100%
            );
            position: relative;
            overflow: hidden;
        }
        .sa-flag-bar::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 6px;
            height: 100%;
            background: linear-gradient(180deg,
                #FFB612 0%, #FFB612 50%,
                #FFFFFF 50%, #FFFFFF 100%
            );
        }

        /* ─── Responsive ─── */
        @media (max-width: 768px) {
            .hero-orb { width: 300px; height: 300px; }
            .hero-orb-2 { width: 200px; height: 200px; }
        }
    </style>
</head>
<body class="font-sans antialiased">

    <!-- ─── NAVIGATION ─── -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500" style="background: transparent;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/25 group-hover:scale-110 transition-all duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9.1-1.645M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-bold text-white group-hover:text-purple-400 transition-colors leading-tight">HR Assistance</span>
                        <span class="text-[10px] text-gray-500 tracking-wider uppercase">Smart HR Solutions</span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ url('/') }}#features" class="text-sm font-medium text-gray-400 hover:text-white transition-colors relative group">
                        Features
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-purple-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ url('/') }}#how-it-works" class="text-sm font-medium text-gray-400 hover:text-white transition-colors relative group">
                        How It Works
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-purple-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ url('/jobs') }}" class="text-sm font-semibold text-purple-400 transition-colors relative group">
                        Job Market
                        <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-purple-500"></span>
                    </a>
                </div>

                <!-- CTA Buttons -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex text-sm font-medium text-gray-400 hover:text-white transition-colors px-4 py-2">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white rounded-xl btn-primary glow-purple">
                        Get Started
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ─── PAGE CONTENT ─── -->
    <main>
        {{ $slot }}
    </main>

    <!-- ─── FOOTER ─── -->
    <footer class="relative border-t border-[#1C1C1E] bg-[#0A0B14]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid md:grid-cols-4 gap-12">
                <!-- Brand -->
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9.1-1.645M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xl font-bold text-white leading-tight">HR Assistance</span>
                            <span class="text-[10px] text-gray-500 tracking-wider uppercase">Smart HR Solutions</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm max-w-md leading-relaxed">
                        Smart HR solutions for CV optimization, cover letter generation, and ATS scoring — proudly serving South African professionals.
                    </p>
                    <div class="flex items-center gap-2 mt-4">
                        <div class="sa-flag">
                            <div class="sa-flag-bar"></div>
                        </div>
                        <span class="text-xs text-gray-500">Proudly South African</span>
                    </div>
                </div>

                <!-- Product -->
                <div>
                    <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Product</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ url('/') }}#features" class="text-sm text-gray-400 hover:text-purple-400 transition-colors">Features</a></li>
                        <li><a href="{{ url('/') }}#how-it-works" class="text-sm text-gray-400 hover:text-purple-400 transition-colors">How It Works</a></li>
                        <li><a href="{{ url('/jobs') }}" class="text-sm text-gray-400 hover:text-purple-400 transition-colors">Job Market</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm text-gray-400 hover:text-purple-400 transition-colors">Get Started</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Company</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-gray-400 hover:text-purple-400 transition-colors">About Us</a></li>
                        <li><a href="#" class="text-sm text-gray-400 hover:text-purple-400 transition-colors">Careers</a></li>
                        <li><a href="#" class="text-sm text-gray-400 hover:text-purple-400 transition-colors">Contact</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom bar -->
            <div class="mt-12 pt-8 border-t border-[#1C1C1E] flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-sm text-gray-500">
                    &copy; {{ date('Y') }} HR Assistance. All rights reserved. Proudly South African.
                </p>
                <div class="flex gap-6">
                    <a href="#" class="text-sm text-gray-500 hover:text-gray-300 transition-colors">Privacy Policy</a>
                    <a href="#" class="text-sm text-gray-500 hover:text-gray-300 transition-colors">Terms of Service</a>
                    <a href="#" class="text-sm text-gray-500 hover:text-gray-300 transition-colors">POPIA Compliance</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
    @stack('scripts')

    <script>
        // ─── Navbar Scroll Effect ───
        const navbar = document.getElementById('navbar');

        if (navbar) {
            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 80) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            }, { passive: true });
        }
    </script>
</body>
</html>

