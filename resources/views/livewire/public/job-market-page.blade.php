<div>
    <!-- ─── HERO / SEARCH ─── -->
    <section class="relative pt-40 pb-20 overflow-hidden">
        <!-- Background orbs -->
        <div class="hero-orb" style="top: 10%; left: -10%;"></div>
        <div class="hero-orb hero-orb-2" style="top: 30%; left: 70%;"></div>
        <div class="hero-orb" style="width: 300px; height: 300px; top: 70%; left: 15%; background: radial-gradient(circle at center, rgba(16, 185, 129, 0.08), transparent 70%); animation-delay: 4s;"></div>

        <!-- Grid overlay -->
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: linear-gradient(rgba(124, 58, 237, 0.3) 1px, transparent 1px), linear-gradient(90deg, rgba(124, 58, 237, 0.3) 1px, transparent 1px); background-size: 60px 60px;"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-purple-500/10 border border-purple-500/20 rounded-full mb-6 hover:bg-purple-500/15 transition-colors">
                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9.1-1.645M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm text-purple-300 font-medium">
                        <span class="text-white font-semibold">{{ number_format($jobs->total()) }}</span> open roles across South Africa
                    </span>
                </div>

                <!-- Headline -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-[1.1] mb-6">
                    Explore <span class="gradient-text">Open Roles</span>
                </h1>

                <!-- Sub-headline -->
                <p class="text-lg text-gray-400 leading-relaxed max-w-2xl mx-auto mb-10">
                    Browse hand-picked opportunities from leading employers and apply directly on the external job board — no account required.
                </p>

                <!-- Search -->
                <div class="relative max-w-2xl mx-auto">
                    <div class="glass rounded-2xl p-2 flex items-center shadow-2xl shadow-purple-500/5 focus-within:border-purple-500/40 transition-all duration-300">
                        <svg class="w-5 h-5 text-gray-500 ml-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input
                            type="text"
                            wire:model.live="searchQuery"
                            placeholder="Search by job title or location…"
                            aria-label="Search open roles"
                            class="w-full bg-transparent border-0 outline-none text-white placeholder-gray-500 px-4 py-3 text-base"
                        />
                        @if ($searchQuery !== '')
                            <button
                                wire:click="$set('searchQuery', '')"
                                type="button"
                                class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center text-gray-500 hover:text-white hover:bg-white/5 transition-colors"
                                aria-label="Clear search"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── JOB LISTINGS ─── -->
    <section class="relative pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Results header -->
            <div class="flex items-center justify-between mb-8">
                <p class="text-sm text-gray-400">
                    @if ($jobs->total() > 0)
                        Showing <span class="text-white font-semibold">{{ $jobs->firstItem() ?? 0 }}–{{ $jobs->lastItem() ?? 0 }}</span>
                        of <span class="text-white font-semibold">{{ $jobs->total() }}</span> roles
                        @if ($searchQuery !== '')
                            matching “<span class="text-purple-400 font-medium">{{ trim($searchQuery) }}</span>”
                        @endif
                    @else
                        No roles found
                    @endif
                </p>

                <div wire:loading wire:target="searchQuery" class="inline-flex items-center gap-2 text-sm text-purple-400">
                    <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Searching…
                </div>
            </div>

            @if ($jobs->count())
                <!-- Job Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($jobs as $job)
                        <div class="glass-card rounded-2xl p-6 flex flex-col transition-all duration-300 hover:-translate-y-1 group" wire:key="job-{{ $job->id }}">
                            <!-- Company avatar + status -->
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-purple-500/20 to-purple-700/10 border border-purple-500/20 flex items-center justify-center flex-shrink-0">
                                    <span class="text-purple-400 font-bold text-sm">{{ strtoupper(substr($job->company_name, 0, 1)) }}</span>
                                </div>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-full">
                                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                                    Open
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="text-lg font-semibold text-white leading-snug mb-2 group-hover:text-purple-300 transition-colors">
                                {{ $job->title }}
                            </h3>

                            <!-- Company -->
                            <p class="text-sm font-medium text-gray-300 mb-1.5">{{ $job->company_name }}</p>

                            <!-- Location -->
                            <p class="inline-flex items-center gap-1.5 text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $job->location }}
                            </p>

                            <!-- Truncated description -->
                            <p class="text-sm text-gray-400 leading-relaxed mb-6">
                                {{ \Illuminate\Support\Str::limit($job->description, 160) }}
                            </p>

                            <!-- Actions -->
                            <div class="mt-auto pt-4 border-t border-[#1C1C1E] space-y-2">
                                <!-- External apply -->
                                <a href="{{ $job->apply_url }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="inline-flex w-full items-center justify-center gap-2 px-5 py-3 text-sm font-semibold text-purple-300 rounded-xl btn-outline">
                                    Apply Now
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>

                                <!-- Conversion CTA: register & optimize CV for this role -->
                                <a href="{{ route('register', ['target_job' => $job->id]) }}"
                                   class="inline-flex w-full items-center justify-center gap-2 px-5 py-3 text-sm font-semibold text-white rounded-xl btn-primary glow-purple">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M12 1.5a.75.75 0 01.75.75V4.5a.75.75 0 01-1.5 0V2.25A.75.75 0 0112 1.5zM5.636 5.636a.75.75 0 011.06 0l1.592 1.591a.75.75 0 01-1.06 1.061L5.636 6.697a.75.75 0 010-1.06zm12.728 0a.75.75 0 010 1.06l-1.591 1.592a.75.75 0 11-1.061-1.06l1.591-1.592a.75.75 0 011.06 0zM12 7.5a4.5 4.5 0 014.5 4.5c0 1.6-.836 3.008-2.1 3.836a.75.75 0 01-.412.132H9.987a.75.75 0 01-.412-.132A4.502 4.502 0 017.5 12a4.5 4.5 0 014.5-4.5zm-5.25 6.75a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V15a.75.75 0 01.75-.75zm10.5 0a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V15a.75.75 0 01.75-.75zM12 18a.75.75 0 01.75.75v.75a.75.75 0 01-1.5 0v-.75A.75.75 0 0112 18zm-7.5 2.25a.75.75 0 01.75-.75h13.5a.75.75 0 010 1.5H5.25a.75.75 0 01-.75-.75z" clip-rule="evenodd"/>
                                    </svg>
                                    Optimize CV for this role
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($jobs->hasPages())
                    <div class="mt-12">
                        {{ $jobs->links('pagination.dark') }}
                    </div>
                @endif
            @else
                <!-- Empty state -->
                <div class="glass-card rounded-2xl p-16 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 bg-purple-500/10 border border-purple-500/20 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">No roles found</h3>
                    <p class="text-gray-400 max-w-md mx-auto">
                        We couldn't find any open roles matching “{{ trim($searchQuery) }}”.
                        Try a different job title or location.
                    </p>
                    <button
                        wire:click="$set('searchQuery', '')"
                        type="button"
                        class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white rounded-xl btn-primary glow-purple">
                        Clear search
                    </button>
                </div>
            @endif
        </div>
    </section>
</div>

