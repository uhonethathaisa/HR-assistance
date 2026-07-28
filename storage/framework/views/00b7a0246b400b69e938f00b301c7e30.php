<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'HR Assistance')); ?> - <?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></title>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="font-sans antialiased bg-[#09090B] text-white">
    <div class="flex h-screen overflow-hidden">
        <!-- ============================================ -->
        <!-- SIDEBAR - Fixed Left Navigation -->
        <!-- ============================================ -->
        <aside class="w-[260px] bg-[#0C0C0E] border-r border-[#1C1C1E] flex flex-col flex-shrink-0">

            <!-- Logo -->
            <div class="flex items-center h-16 px-6 border-b border-[#1C1C1E]">
                <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center space-x-2 group">
                    <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center shadow-lg shadow-purple-500/25 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white group-hover:text-purple-400 transition-colors">HR Assistance</span>

                </a>
            </div>

            <!-- User Profile -->
            <div class="p-4 border-b border-[#1C1C1E]">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500/20 to-purple-700/20 flex items-center justify-center border border-purple-500/30">
                            <span class="text-purple-400 font-semibold text-sm">
                                <?php echo e(strtoupper(substr(auth()->user()->name ?? 'U', 0, 2))); ?>

                            </span>
                        </div>
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 rounded-full border-2 border-[#0C0C0E]"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate"><?php echo e(auth()->user()->name ?? 'User'); ?></p>
                        <p class="text-xs text-gray-400 truncate"><?php echo e(auth()->user()->email ?? 'user@example.com'); ?></p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
                <?php
                    $navItems = [
                        [
                            'route' => 'dashboard',
                            'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z M14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z M4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z M14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z',
                            'label' => 'Dashboard',
                            'badge' => null
                        ],
                        [
                            'route' => 'work-history',
                            'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9.1-1.645M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                            'label' => 'Work History',
                            'badge' => null
                        ],
                        // Career History removed - using Work History only
                        [
                            'route' => 'cv-optimizer',
                            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                            'label' => 'CV Optimizer',
                            'badge' => null
                        ],
                        [
                            'route' => 'cover-letters',
                            'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                            'label' => 'Cover Letters',
                            'badge' => null
                        ],
                        [
                            'route' => 'settings',
                            'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
                            'label' => 'Settings',
                            'badge' => null
                        ],
                    ];

                    // Admin-only navigation items
                    if (auth()->check() && auth()->user()->role === 'admin') {
                        $adminNavItems = [
                            [
                                'route' => 'admin.dashboard',
                                'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
                                'label' => 'Admin Panel',
                                'badge' => null
                            ],
                            [
                                'route' => 'admin.users',
                                'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z',
                                'label' => 'User Management',
                                'badge' => null
                            ],
                            [
                                'route' => 'admin.system',
                                'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
                                'label' => 'System Settings',
                                'badge' => null
                            ],
                        ];

                        // Insert admin section with a divider
                        $navItems = array_merge($navItems, [[
                            'route' => null,
                            'icon' => null,
                            'label' => 'divider',
                            'badge' => null
                        ]], $adminNavItems);
                    }
                ?>


                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['label'] === 'divider'): ?>
                        <div class="pt-3 pb-1">
                            <div class="border-t border-[#1C1C1E]"></div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route($item['route'])); ?>"
                           class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group
                                  <?php echo e(request()->routeIs($item['route']) ? 'bg-purple-500/10 text-purple-400' : 'text-gray-400 hover:text-white hover:bg-[#1C1C1E]'); ?>">
                            <div class="relative">
                                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($item['icon']); ?>"/>
                                </svg>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->routeIs($item['route'])): ?>
                                    <span class="absolute -left-3 top-1/2 -translate-y-1/2 w-0.5 h-6 bg-purple-500 rounded-full"></span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <span class="flex-1"><?php echo e($item['label']); ?></span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['badge']): ?>
                                <span class="px-2 py-0.5 text-xs font-medium bg-purple-500/20 text-purple-400 rounded-full animate-pulse">
                                    <?php echo e($item['badge']); ?>

                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

            </nav>

            <!-- Logout -->
            <div class="p-3 border-t border-[#1C1C1E]">
                <form method="POST" action="<?php echo e(route('logout')); ?>" id="logout-form">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                            class="flex items-center w-full px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:text-red-400 hover:bg-red-500/10 transition-all duration-200 group">
                        <svg class="w-5 h-5 mr-3 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- ============================================ -->
        <!-- MAIN CONTENT AREA -->
        <!-- ============================================ -->
        <main class="flex-1 overflow-y-auto bg-[#09090B]">

            <!-- Header -->
            <header class="sticky top-0 z-10 bg-[#09090B]/80 backdrop-blur-lg border-b border-[#1C1C1E]">
                <div class="flex items-center justify-between px-8 py-4">
                    <div>
                        <h1 class="text-xl font-semibold text-white">
                            <?php echo $__env->yieldContent('page-title', 'Dashboard'); ?>
                        </h1>
                        <p class="text-sm text-gray-400"><?php echo $__env->yieldContent('page-subtitle', 'Overview of your career tools'); ?></p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Search (optional) -->
                        <div class="hidden md:flex items-center bg-[#1A1A1E] rounded-lg px-3 py-2 border border-[#1C1C1E] focus-within:border-purple-500/50 transition-colors">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text"
                                   wire:model.debounce.300ms="search"
                                   placeholder="Search activity..."
                                   class="bg-transparent border-none text-white text-sm ml-2 focus:outline-none w-40 placeholder-gray-500">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(strlen($search ?? '') > 0): ?>
                                <button wire:click="$set('search', '')" class="text-gray-500 hover:text-white transition-colors ml-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>


                        <!-- Notification Bell -->
                        <button class="relative text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-purple-500 rounded-full animate-pulse"></span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="px-8 py-6">
                <?php echo e($slot); ?>

            </div>
        </main>
    </div>

    <!-- Toast Notifications -->
    <div x-data="{ show: false, message: '', type: 'success' }"
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 3000)"
         x-show="show"
         x-transition.duration.300ms
         class="fixed bottom-4 right-4 z-50">
        <div class="bg-[#1C1C1E] border border-[#2D2D30] rounded-lg shadow-2xl px-6 py-4 max-w-sm backdrop-blur-lg"
             :class="{
                 'border-emerald-500/30': type === 'success',
                 'border-red-500/30': type === 'error',
                 'border-amber-500/30': type === 'warning'
             }">
            <div class="flex items-center space-x-3">
                <div class="w-2 h-2 rounded-full"
                     :class="{
                         'bg-emerald-400': type === 'success',
                         'bg-red-400': type === 'error',
                         'bg-amber-400': type === 'warning'
                     }">
                </div>
                <p class="text-white text-sm" x-text="message"></p>
                <button @click="show = false" class="text-gray-400 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div wire:loading wire:target="save, delete, upload"
         class="fixed inset-0 bg-black/60 flex items-center justify-center z-50">
        <div class="bg-[#13141F] border border-[#1C1C1E] rounded-xl p-6 flex flex-col items-center space-y-4">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-purple-500/30 border-t-purple-500"></div>
            <p class="text-white font-medium">Processing...</p>
        </div>
    </div>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /home/u952164533/domains/green-alligator-418959.hostingersite.com/public_html/resources/views/layouts/dashboard.blade.php ENDPATH**/ ?>