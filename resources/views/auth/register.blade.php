{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HR Assistance') }} - Professional CV Optimization & Cover Letter Service</title>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900|dm-sans:400,500,600,700,800" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#0A0B14] text-white">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-6xl">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Column: Content -->
                <div class="space-y-8">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="inline-flex items-center space-x-2 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/25 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-white group-hover:text-purple-400 transition-colors">HR Assistance</span>

                    </a>


                    <!-- Badge -->
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-purple-500/10 border border-purple-500/30 text-purple-400">
                        <span class="w-2 h-2 bg-purple-400 rounded-full mr-2 animate-pulse"></span>
                        AI-Powered Career Optimization
                    </div>

                    <!-- Main Headline -->
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                        Turn Your CV Into a
                        <span class="bg-gradient-to-r from-purple-400 via-purple-500 to-pink-500 bg-clip-text text-transparent">
                            Career Catalyst
                        </span>
                    </h1>

                    <p class="text-xl text-gray-400">
                        AI-powered analysis and professional guidance to make your application stand out. Join thousands of professionals who've transformed their careers.
                    </p>

                    <!-- Trust Badges -->
                    <div class="flex flex-wrap items-center gap-6 pt-4">
                        <div class="flex items-center space-x-2">
                            <div class="flex -space-x-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-400 to-purple-600 flex items-center justify-center text-xs font-bold">JD</div>
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center text-xs font-bold">SM</div>
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-emerald-400 to-emerald-600 flex items-center justify-center text-xs font-bold">AK</div>
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-pink-400 to-pink-600 flex items-center justify-center text-xs font-bold">TR</div>
                            </div>
                            <span class="text-sm text-gray-400">Join <span class="text-white font-semibold">10,000+</span> professionals</span>
                        </div>
                        <div class="flex items-center text-emerald-400">
                            <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm">98% satisfaction rate</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Registration Form -->
                <div class="relative">
                    <div class="bg-[#13141F] border border-[#1C1C1E] rounded-2xl p-8 shadow-2xl">
                        <div class="text-center mb-6">
                            <h2 class="text-2xl font-bold text-white">Create Your Account</h2>
                            <p class="text-gray-400 text-sm mt-1">Start optimizing your career today</p>
                        </div>

                        <!-- Social Login Buttons -->
                        <div class="space-y-3 mb-6">
                            <p class="text-center text-sm text-gray-400">Continue with</p>
                            <div class="grid grid-cols-3 gap-3">
                                <!-- Google -->
                                <a href="{{ route('social.redirect', 'google') }}"
                                   class="flex items-center justify-center gap-2 px-4 py-3 bg-[#1A1B2E] border border-[#2D3A4F] rounded-xl hover:bg-[#2D3A4F] hover:border-purple-500/30 transition-all duration-300 group">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                    </svg>
                                    <span class="text-sm text-gray-300 group-hover:text-white transition-colors">Google</span>
                                </a>

                                <!-- LinkedIn -->
                                <a href="{{ route('social.redirect', 'linkedin') }}"
                                   class="flex items-center justify-center gap-2 px-4 py-3 bg-[#1A1B2E] border border-[#2D3A4F] rounded-xl hover:bg-[#2D3A4F] hover:border-purple-500/30 transition-all duration-300 group">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="#0A66C2">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                    <span class="text-sm text-gray-300 group-hover:text-white transition-colors">LinkedIn</span>
                                </a>

                                <!-- Apple -->
                                <a href="{{ route('social.redirect', 'apple') }}"
                                   class="flex items-center justify-center gap-2 px-4 py-3 bg-[#1A1B2E] border border-[#2D3A4F] rounded-xl hover:bg-[#2D3A4F] hover:border-purple-500/30 transition-all duration-300 group">
                                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/>
                                    </svg>
                                    <span class="text-sm text-gray-300 group-hover:text-white transition-colors">Apple</span>
                                </a>
                            </div>

                            <!-- Divider -->
                            <div class="relative my-6">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-[#2D3A4F]"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-4 bg-[#13141F] text-gray-500">or continue with email</span>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('register') }}" class="space-y-4">
                            @csrf


                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300 mb-1.5">Full Name</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                       placeholder="John Doe"
                                       class="w-full bg-[#1A1B2E] border border-[#2D3A4F] text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror">
                                @error('name') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300 mb-1.5">Email Address</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                       placeholder="you@example.com"
                                       class="w-full bg-[#1A1B2E] border border-[#2D3A4F] text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror">
                                @error('email') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-300 mb-1.5">Password</label>
                                <input id="password" type="password" name="password" required
                                       placeholder="••••••••"
                                       class="w-full bg-[#1A1B2E] border border-[#2D3A4F] text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror">
                                @error('password') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-1.5">Confirm Password</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                       placeholder="••••••••"
                                       class="w-full bg-[#1A1B2E] border border-[#2D3A4F] text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            </div>

                            <!-- Register Button -->
                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white font-medium py-3 rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40 transform hover:-translate-y-0.5">
                                Continue to Profile →
                            </button>

                            <!-- Login Link -->
                            <p class="text-center text-sm text-gray-400 mt-4">
                                Already registered?
                                <a href="{{ route('login') }}" class="text-purple-400 hover:text-purple-300 font-medium transition-colors">
                                    Sign in
                                </a>
                            </p>

                            <!-- Terms -->
                            <p class="text-xs text-gray-500 text-center">
                                By signing up, you agree to our
                                <a href="#" class="text-purple-400 hover:text-purple-300">Terms of Service</a>
                                and
                                <a href="#" class="text-purple-400 hover:text-purple-300">Privacy Policy</a>
                            </p>
                        </form>
                    </div>

                    <!-- Floating Badge -->
                    <div class="absolute -bottom-4 -right-4 hidden lg:block">
                        <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-lg px-4 py-2 backdrop-blur-sm">
                            <div class="flex items-center space-x-2">
                                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                                <span class="text-sm text-emerald-400">100% Free Trial</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
