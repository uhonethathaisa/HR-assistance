<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HR Assistance - Smart HR Solutions for South African Professionals</title>
    <meta name="description" content="Professional CV optimization, cover letter generation, and ATS scoring – tailored for South African job seekers. Smart HR solutions to land your dream job.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900" rel="stylesheet" />

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/app.css'])
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

        /* ─── Floating Particles ─── */
        .particle {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
            opacity: 0.12;
        }

        /* ─── Hero Gradient Orb ─── */
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
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ─── Glow Effects ─── */
        .glow-purple {
            box-shadow: 0 0 20px rgba(124, 58, 237, 0.15), 0 0 60px rgba(124, 58, 237, 0.05);
        }
        .glow-purple:hover {
            box-shadow: 0 0 30px rgba(124, 58, 237, 0.25), 0 0 80px rgba(124, 58, 237, 0.1);
        }

        /* ─── Step Connector ─── */
        .step-connector {
            position: absolute;
            top: 3rem;
            left: calc(16.67% + 2rem);
            right: calc(16.67% + 2rem);
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(124, 58, 237, 0.5), rgba(124, 58, 237, 0.8), rgba(124, 58, 237, 0.5), transparent);
        }

        /* ─── Floating Shapes ─── */
        .float-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.06;
            pointer-events: none;
            animation: floatShape 15s ease-in-out infinite;
        }
        @keyframes floatShape {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(90deg); }
            50% { transform: translateY(-10px) rotate(180deg); }
            75% { transform: translateY(-30px) rotate(270deg); }
        }

        /* ─── Navbar Scroll Effect ─── */
        .navbar-scrolled {
            background: rgba(10, 11, 20, 0.85) !important;
            backdrop-filter: blur(20px) !important;
            border-bottom: 1px solid rgba(45, 58, 79, 0.3) !important;
        }

        /* ─── Pricing Card ─── */
        .pricing-featured {
            border: 1px solid rgba(124, 58, 237, 0.3);
            transform: scale(1.02);
        }
        .pricing-featured .pricing-badge {
            background: linear-gradient(135deg, #7C3AED, #6D28D9);
        }

        /* ─── Testimonial Card ─── */
        .testimonial-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .testimonial-card:hover {
            transform: translateY(-8px) scale(1.01);
        }

        /* ─── Marquee for logos ─── */
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .marquee-track {
            animation: marquee 30s linear infinite;
        }
        .marquee-track:hover {
            animation-play-state: paused;
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
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
        }

        /* ─── Responsive ─── */
        @media (max-width: 768px) {
            .hero-orb { width: 300px; height: 300px; }
            .hero-orb-2 { width: 200px; height: 200px; }
            .pricing-featured { transform: none; }
        }
    </style>
</head>
<body>

    <!-- ─── Floating Particles ─── -->
    <div id="particles-container" aria-hidden="true"></div>

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
                    <a href="#features" class="text-sm font-medium text-gray-400 hover:text-white transition-colors relative group">
                        Features
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-purple-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#how-it-works" class="text-sm font-medium text-gray-400 hover:text-white transition-colors relative group">
                        How It Works
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-purple-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#testimonials" class="text-sm font-medium text-gray-400 hover:text-white transition-colors relative group">
                        Testimonials
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-purple-500 transition-all duration-300 group-hover:w-full"></span>
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

    <!-- ─── HERO SECTION ─── -->
    <section class="relative min-h-screen flex items-center overflow-hidden pt-20">
        <!-- Background orbs -->
        <div class="hero-orb" style="top: 10%; left: -10%;"></div>
        <div class="hero-orb hero-orb-2" style="top: 50%; left: 70%;"></div>
        <div class="hero-orb" style="width: 300px; height: 300px; top: 70%; left: 20%; background: radial-gradient(circle at center, rgba(16, 185, 129, 0.08), transparent 70%); animation-delay: 4s;"></div>

        <!-- Grid overlay -->
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: linear-gradient(rgba(124, 58, 237, 0.3) 1px, transparent 1px), linear-gradient(90deg, rgba(124, 58, 237, 0.3) 1px, transparent 1px); background-size: 60px 60px;"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Left: Text Content -->
                <div data-aos="fade-right" data-aos-duration="1000">
                    <!-- Trust badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-purple-500/10 border border-purple-500/20 rounded-full mb-8 hover:bg-purple-500/15 transition-colors">
                        <div class="sa-flag">
                            <div class="sa-flag-bar"></div>
                        </div>
                        <span class="text-sm text-purple-300 font-medium">Proudly South African — Trusted by <span class="text-white font-semibold">5,000+</span> job seekers</span>
                    </div>

                    <!-- Headline -->
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold text-white leading-[1.1] mb-6">
                        Your Career,
                        <span class="gradient-text">Our HR Expertise</span>
                    </h1>

                    <!-- Sub-headline -->
                    <p class="text-lg sm:text-xl text-gray-400 leading-relaxed max-w-xl mb-8">
                        Smart HR solutions for CV optimization, professional cover letters, and ATS scoring — tailored for South African professionals. <span class="text-white font-medium">Get noticed. Get hired.</span>
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap gap-4 mb-10">
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center gap-2 px-8 py-4 text-white font-semibold rounded-xl btn-primary glow-purple text-lg">
                            Get HR Assistance
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        <a href="#how-it-works"
                           class="inline-flex items-center gap-2 px-8 py-4 text-gray-300 font-semibold rounded-xl btn-outline">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Learn More
                        </a>
                    </div>

                    <!-- Trust metrics row -->
                    <div class="flex flex-wrap gap-8 pt-4 border-t border-[#1C1C1E]">
                        <div>
                            <p class="text-2xl font-bold text-white">5,000+</p>
                            <p class="text-sm text-gray-500">CVs Optimized</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-white">96%</p>
                            <p class="text-sm text-gray-500">Success Rate</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-white">4.8/5</p>
                            <p class="text-sm text-gray-500">User Rating</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-white">30+</p>
                            <p class="text-sm text-gray-500">HR Experts</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Hero Visual -->
                <div class="hidden lg:flex justify-center" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="relative">
                        <!-- Main card mockup -->
                        <div class="w-[420px] glass-card rounded-2xl p-8 shadow-2xl glow-purple">
                            <!-- CV Preview Header -->
                            <div class="flex items-center gap-4 pb-5 border-b border-[#2D3A4F]">
                                <div class="w-14 h-14 bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white font-semibold text-lg">Thabo Mokoena</p>
                                    <p class="text-sm text-gray-400">Senior Software Engineer</p>
                                </div>
                                <div class="ml-auto">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 rounded-full text-xs text-emerald-400 font-medium">
                                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                                        HR Analyzed
                                    </span>
                                </div>
                            </div>

                            <!-- Score bars -->
                            <div class="space-y-4 mt-5">
                                <div>
                                    <div class="flex justify-between text-sm mb-1.5">
                                        <span class="text-gray-400">ATS Compatibility</span>
                                        <span class="text-emerald-400 font-semibold">92%</span>
                                    </div>
                                    <div class="h-2.5 bg-[#2D3A4F] rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-400 rounded-full transition-all duration-1000" style="width: 92%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-1.5">
                                        <span class="text-gray-400">Keyword Optimization</span>
                                        <span class="text-purple-400 font-semibold">88%</span>
                                    </div>
                                    <div class="h-2.5 bg-[#2D3A4F] rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-purple-500 to-purple-400 rounded-full transition-all duration-1000" style="width: 88%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-1.5">
                                        <span class="text-gray-400">Impact Score</span>
                                        <span class="text-amber-400 font-semibold">76%</span>
                                    </div>
                                    <div class="h-2.5 bg-[#2D3A4F] rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-amber-500 to-amber-400 rounded-full transition-all duration-1000" style="width: 76%"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Improvement suggestions -->
                            <div class="mt-6 pt-5 border-t border-[#2D3A4F]">
                                <p class="text-sm text-gray-400 mb-3 font-medium">✨ Suggested Improvements:</p>
                                <div class="space-y-2.5">
                                    <div class="flex items-center gap-2.5 text-sm group cursor-pointer">
                                        <div class="w-6 h-6 rounded-full bg-emerald-500/10 flex items-center justify-center group-hover:bg-emerald-500/20 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <span class="text-gray-300 group-hover:text-white transition-colors">Add SA-specific keywords</span>
                                    </div>
                                    <div class="flex items-center gap-2.5 text-sm group cursor-pointer">
                                        <div class="w-6 h-6 rounded-full bg-emerald-500/10 flex items-center justify-center group-hover:bg-emerald-500/20 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <span class="text-gray-300 group-hover:text-white transition-colors">Quantify achievements with metrics</span>
                                    </div>
                                    <div class="flex items-center gap-2.5 text-sm group cursor-pointer">
                                        <div class="w-6 h-6 rounded-full bg-emerald-500/10 flex items-center justify-center group-hover:bg-emerald-500/20 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <span class="text-gray-300 group-hover:text-white transition-colors">Align with local market trends</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating badges -->
                        <div class="absolute -top-4 -right-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg animate-pulse">
                            HR Powered ✨
                        </div>
                        <div class="absolute -bottom-4 -left-4 glass px-4 py-2 rounded-full text-xs text-gray-300 shadow-lg">
                            ⚡ Optimized in 30 seconds
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 animate-bounce">
            <span class="text-xs text-gray-600">Scroll to explore</span>
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    <!-- ─── FEATURES SECTION ─── -->
    <section id="features" class="relative py-28 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-[#0A0B14] via-[#0E0F1A] to-[#0A0B14]"></div>
        <div class="float-shape" style="width: 400px; height: 400px; top: -100px; right: -100px; background: radial-gradient(circle, rgba(124, 58, 237, 0.08), transparent);"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-purple-500/10 border border-purple-500/20 rounded-full text-sm text-purple-300 font-medium mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Powerful Features
                </span>
                <h2 class="text-4xl sm:text-5xl font-bold text-white mb-4">
                    Smart HR Solutions for
                    <span class="gradient-text">South African Professionals</span>
                </h2>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                    Expert HR tools to optimize your CV, craft compelling cover letters, and understand the local job market — all tailored for South Africa.
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Feature 1 -->
                <div class="group relative glass-card rounded-2xl p-8 transition-all duration-500 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="0">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500/20 to-purple-700/20 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300" style="border: 1px solid rgba(124, 58, 237, 0.2);">
                            <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-3">Expert CV Analysis</h3>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            Get professional HR feedback on your CV. Understand what South African recruiters are looking for and how to stand out in the local market.
                        </p>
                        <div class="mt-4 flex items-center gap-1 text-sm text-purple-400 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span>Learn more</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="group relative glass-card rounded-2xl p-8 transition-all duration-500 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-500/20 to-emerald-700/20 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300" style="border: 1px solid rgba(16, 185, 129, 0.2);">
                            <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-3">Professional Cover Letters</h3>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            Generate tailored cover letters that speak to South African employers. Highlight your unique value and align with local industry expectations.
                        </p>
                        <div class="mt-4 flex items-center gap-1 text-sm text-emerald-400 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span>Learn more</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="group relative glass-card rounded-2xl p-8 transition-all duration-500 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative">
                        <div class="w-14 h-14 bg-gradient-to-br from-amber-500/20 to-amber-700/20 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300" style="border: 1px solid rgba(245, 158, 11, 0.2);">
                            <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-3">ATS-Friendly Formatting</h3>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            Beat Applicant Tracking Systems with smart keyword analysis. Ensure your CV meets South African recruitment standards and gets seen by real hiring managers.
                        </p>
                        <div class="mt-4 flex items-center gap-1 text-sm text-amber-400 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span>Learn more</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="group relative glass-card rounded-2xl p-8 transition-all duration-500 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative">
                        <div class="w-14 h-14 bg-gradient-to-br from-cyan-500/20 to-cyan-700/20 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300" style="border: 1px solid rgba(6, 182, 212, 0.2);">
                            <svg class="w-7 h-7 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-3">Local HR Expertise</h3>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            Get insights from HR professionals who understand the South African job market. Tailored advice for local industries from finance to tech.
                        </p>
                        <div class="mt-4 flex items-center gap-1 text-sm text-cyan-400 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span>Learn more</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── HOW IT WORKS ─── -->
    <section id="how-it-works" class="relative py-28 overflow-hidden">
        <div class="float-shape" style="width: 300px; height: 300px; bottom: -100px; left: -100px; background: radial-gradient(circle, rgba(124, 58, 237, 0.06), transparent);"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-purple-500/10 border border-purple-500/20 rounded-full text-sm text-purple-300 font-medium mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Simple Process
                </span>
                <h2 class="text-4xl sm:text-5xl font-bold text-white mb-4">
                    Get Started in <span class="gradient-text">3 Simple Steps</span>
                </h2>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                    From sign-up to optimized CV in minutes. No fluff, just results.
                </p>
            </div>

            <!-- Steps -->
            <div class="grid md:grid-cols-3 gap-12 relative">
                <!-- Connecting line (desktop) -->
                <div class="hidden md:block step-connector"></div>

                <!-- Step 1 -->
                <div class="relative text-center" data-aos="fade-up" data-aos-delay="0">
                    <div class="relative z-10 w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-purple-600 to-purple-800 rounded-2xl flex items-center justify-center shadow-xl shadow-purple-500/25 group hover:scale-110 transition-transform duration-300">
                        <span class="text-3xl font-bold text-white">1</span>
                    </div>
                    <div class="glass-card rounded-2xl p-6">
                        <div class="w-12 h-12 mx-auto mb-4 bg-purple-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-3">Create Your Profile</h3>
                        <p class="text-gray-400 leading-relaxed text-sm">
                            Sign up in seconds and tell us about your career goals, experience, and target role. Your personalized HR dashboard awaits.
                        </p>
                        <div class="mt-4 inline-flex items-center gap-1.5 text-sm text-purple-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Takes 2 minutes</span>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative text-center" data-aos="fade-up" data-aos-delay="150">
                    <div class="relative z-10 w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-purple-600 to-purple-800 rounded-2xl flex items-center justify-center shadow-xl shadow-purple-500/25 group hover:scale-110 transition-transform duration-300">
                        <span class="text-3xl font-bold text-white">2</span>
                    </div>
                    <div class="glass-card rounded-2xl p-6">
                        <div class="w-12 h-12 mx-auto mb-4 bg-purple-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h14a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-3">Upload Your CV</h3>
                        <p class="text-gray-400 leading-relaxed text-sm">
                            Upload your existing CV. Our HR system instantly analyzes it for ATS compatibility, keyword density, and local market alignment.
                        </p>
                        <div class="mt-4 inline-flex items-center gap-1.5 text-sm text-purple-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span>Instant analysis</span>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="relative z-10 w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-purple-600 to-purple-800 rounded-2xl flex items-center justify-center shadow-xl shadow-purple-500/25 group hover:scale-110 transition-transform duration-300">
                        <span class="text-3xl font-bold text-white">3</span>
                    </div>
                    <div class="glass-card rounded-2xl p-6">
                        <div class="w-12 h-12 mx-auto mb-4 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-3">Get HR Optimized</h3>
                        <p class="text-gray-400 leading-relaxed text-sm">
                            Receive detailed HR feedback, suggested improvements, and a tailored cover letter. Apply with confidence and land more interviews.
                        </p>
                        <div class="mt-4 inline-flex items-center gap-1.5 text-sm text-emerald-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Land more interviews</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── STATS / SOCIAL PROOF ─── -->
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-900/10 via-[#0A0B14] to-purple-900/10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-6" data-aos="fade-up">
                <div class="text-center p-8 glass-card rounded-2xl hover:border-purple-500/30 transition-all duration-300">
                    <p class="text-5xl font-bold gradient-text mb-2">5,000+</p>
                    <p class="text-gray-400">CVs Optimized</p>
                </div>
                <div class="text-center p-8 glass-card rounded-2xl hover:border-purple-500/30 transition-all duration-300">
                    <p class="text-5xl font-bold gradient-text mb-2">96%</p>
                    <p class="text-gray-400">Success Rate</p>
                </div>
                <div class="text-center p-8 glass-card rounded-2xl hover:border-purple-500/30 transition-all duration-300">
                    <p class="text-5xl font-bold gradient-text mb-2">4.8/5</p>
                    <p class="text-gray-400">Average Rating</p>
                </div>
                <div class="text-center p-8 glass-card rounded-2xl hover:border-purple-500/30 transition-all duration-300">
                    <p class="text-5xl font-bold gradient-text mb-2">30+</p>
                    <p class="text-gray-400">HR Experts</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── TESTIMONIALS ─── -->
    <section id="testimonials" class="relative py-28 overflow-hidden">
        <div class="float-shape" style="width: 500px; height: 500px; top: -200px; right: -200px; background: radial-gradient(circle, rgba(124, 58, 237, 0.05), transparent);"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-purple-500/10 border border-purple-500/20 rounded-full text-sm text-purple-300 font-medium mb-6">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    Testimonials
                </span>
                <h2 class="text-4xl sm:text-5xl font-bold text-white mb-4">
                    What Our <span class="gradient-text">Users Say</span>
                </h2>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                    Join thousands of South African professionals who've transformed their careers with HR Assistance.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <!-- Testimonial 1 -->
                <div class="testimonial-card glass-card rounded-2xl p-8" data-aos="fade-up" data-aos-delay="0">
                    <div class="flex gap-1 mb-4">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-gray-300 leading-relaxed mb-6">
                        "The HR analysis was a game-changer. My CV went from getting no responses to landing interviews at top companies in Johannesburg. The local market insights were invaluable!"
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-700 rounded-full flex items-center justify-center text-white font-bold text-lg">TM</div>
                        <div>
                            <p class="text-white font-semibold">Thabo Mokoena</p>
                            <p class="text-sm text-gray-400">Software Engineer, Johannesburg</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="testimonial-card glass-card rounded-2xl p-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex gap-1 mb-4">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-gray-300 leading-relaxed mb-6">
                        "The cover letter generator is incredible. It saved me hours of writing and the results were perfectly tailored for the South African market. Landed my dream role in Cape Town!"
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-full flex items-center justify-center text-white font-bold text-lg">LN</div>
                        <div>
                            <p class="text-white font-semibold">Lerato Ndlovu</p>
                            <p class="text-sm text-gray-400">Marketing Manager, Cape Town</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="testimonial-card glass-card rounded-2xl p-8" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex gap-1 mb-4">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-gray-300 leading-relaxed mb-6">
                        "I had no idea my CV was being filtered out by ATS systems. After HR Assistance optimized it, I got 5 interview requests in the first week. Highly recommend for any SA job seeker!"
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-amber-700 rounded-full flex items-center justify-center text-white font-bold text-lg">DP</div>
                        <div>
                            <p class="text-white font-semibold">David Pretorius</p>
                            <p class="text-sm text-gray-400">Financial Analyst, Durban</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Company logos -->
            <div class="mt-20 text-center" data-aos="fade-up">
                <p class="text-sm text-gray-500 mb-8 uppercase tracking-widest font-medium">Trusted by professionals from</p>
                <div class="overflow-hidden">
                    <div class="flex marquee-track gap-16 items-center">
                        @foreach(['Standard Bank', 'Discovery', 'MTN', 'Vodacom', 'Naspers', 'Shoprite', 'Old Mutual', 'Sasol'] as $company)
                            <div class="flex items-center gap-3 text-gray-500">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-gray-600 to-gray-700 flex items-center justify-center text-xs font-bold text-gray-300">
                                    {{ substr($company, 0, 1) }}
                                </div>
                                <span class="text-lg font-semibold">{{ $company }}</span>
                            </div>
                        @endforeach
                        @foreach(['Standard Bank', 'Discovery', 'MTN', 'Vodacom', 'Naspers', 'Shoprite', 'Old Mutual', 'Sasol'] as $company)
                            <div class="flex items-center gap-3 text-gray-500">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-gray-600 to-gray-700 flex items-center justify-center text-xs font-bold text-gray-300">
                                    {{ substr($company, 0, 1) }}
                                </div>
                                <span class="text-lg font-semibold">{{ $company }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── FINAL CTA ─── -->
    <section class="relative py-28 overflow-hidden">
        <div class="absolute inset-0">
            <div class="hero-orb" style="width: 500px; height: 500px; top: 50%; left: 50%; transform: translate(-50%, -50%);"></div>
        </div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-up">
            <h2 class="text-4xl sm:text-5xl font-bold text-white mb-6">
                Ready to Transform Your Career?
            </h2>
            <p class="text-xl text-gray-400 mb-10 max-w-2xl mx-auto">
                Join <span class="text-white font-semibold">5,000+ South African professionals</span> who've optimized their CVs and landed their dream jobs.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-2 px-10 py-5 text-lg text-white font-bold rounded-xl btn-primary glow-purple">
                    Get HR Assistance
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                <a href="#features"
                   class="inline-flex items-center gap-2 px-10 py-5 text-lg text-gray-300 font-semibold rounded-xl btn-outline">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    </svg>
                    Explore Features
                </a>
            </div>
            <div class="mt-12 flex flex-wrap justify-center gap-8 text-sm text-gray-500">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    No credit card required
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    Cancel anytime
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    POPIA compliant
                </span>
            </div>
        </div>
    </section>

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
                        Smart HR solutions for CV optimization, cover letter generation, and ATS scoring — proudly serving South African professionals since 2024.
                    </p>
                    <div class="flex items-center gap-2 mt-4">
                        <div class="sa-flag">
                            <div class="sa-flag-bar"></div>
                        </div>
                        <span class="text-xs text-gray-500">Proudly South African</span>
                    </div>
                    <div class="flex gap-3 mt-6">
                        <a href="#" class="w-10 h-10 rounded-xl bg-[#1C1C1E] hover:bg-purple-500/20 border border-[#2D3A4F] flex items-center justify-center transition-all duration-300 group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-400 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.784 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-[#1C1C1E] hover:bg-purple-500/20 border border-[#2D3A4F] flex items-center justify-center transition-all duration-300 group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-400 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-[#1C1C1E] hover:bg-purple-500/20 border border-[#2D3A4F] flex items-center justify-center transition-all duration-300 group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-400 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Product</h4>
                    <ul class="space-y-3">
                        <li><a href="#features" class="text-sm text-gray-400 hover:text-purple-400 transition-colors">Features</a></li>
                        <li><a href="#how-it-works" class="text-sm text-gray-400 hover:text-purple-400 transition-colors">How It Works</a></li>
                        <li><a href="#testimonials" class="text-sm text-gray-400 hover:text-purple-400 transition-colors">Testimonials</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm text-gray-400 hover:text-purple-400 transition-colors">Get Started</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Company</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-gray-400 hover:text-purple-400 transition-colors">About Us</a></li>
                        <li><a href="#" class="text-sm text-gray-400 hover:text-purple-400 transition-colors">Blog</a></li>
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

    <!-- ─── SCRIPTS ─── -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // ─── AOS Initialization ───
        AOS.init({
            once: true,
            offset: 100,
            duration: 800,
            easing: 'ease-out-cubic',
        });

        // ─── Floating Particles ───
        (function createParticles() {
            const container = document.getElementById('particles-container');
            const colors = ['#7C3AED', '#A78BFA', '#EC4899', '#8B5CF6', '#6D28D9'];
            for (let i = 0; i < 30; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                const size = Math.random() * 4 + 2;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.background = colors[Math.floor(Math.random() * colors.length)];
                particle.style.animation = `floatParticle ${Math.random() * 20 + 10}s ease-in-out infinite`;
                particle.style.animationDelay = Math.random() * 10 + 's';
                container.appendChild(particle);
            }
        })();

        // ─── Particle Animation Keyframe ───
        const styleSheet = document.createElement('style');
        styleSheet.textContent = `
            @keyframes floatParticle {
                0%, 100% { transform: translateY(0) translateX(0); opacity: 0.12; }
                25% { transform: translateY(-30px) translateX(15px); opacity: 0.2; }
                50% { transform: translateY(-15px) translateX(-10px); opacity: 0.12; }
                75% { transform: translateY(-40px) translateX(20px); opacity: 0.18; }
            }
        `;
        document.head.appendChild(styleSheet);

        // ─── Navbar Scroll Effect ───
        const navbar = document.getElementById('navbar');
        let lastScroll = 0;

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            if (currentScroll > 80) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
            lastScroll = currentScroll;
        });

        // ─── Smooth Scroll for Anchor Links ───
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // ─── Counter Animation ───
        const observerOptions = { threshold: 0.5 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('.gradient-text');
                    counters.forEach(counter => {
                        const text = counter.textContent;
                        const num = parseInt(text.replace(/[^0-9]/g, ''));
                        if (num) {
                            let current = 0;
                            const increment = Math.ceil(num / 60);
                            const timer = setInterval(() => {
                                current += increment;
                                if (current >= num) {
                                    counter.textContent = text;
                                    clearInterval(timer);
                                } else {
                                    counter.textContent = current.toLocaleString() + (text.includes('%') ? '%' : text.includes('/') ? '/5' : '+');
                                }
                            }, 25);
                        }
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.grid.md\\:grid-cols-4').forEach(section => {
            observer.observe(section);
        });

        // ─── Console Easter Egg ───
        console.log('%c HR Assistance ', 'background: #7C3AED; color: white; font-size: 16px; font-weight: bold; padding: 8px 12px; border-radius: 4px;');
        console.log('%c Smart HR Solutions for South African Professionals ', 'color: #A78BFA; font-size: 12px;');
        console.log('%c 🚀 Ready to transform your career? Visit hr-assistance.co.za ', 'color: #F8FAFC; font-size: 11px;');
    </script>
</body>
</html>

