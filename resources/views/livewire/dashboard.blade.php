<div>
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Stat Card 1: Work History -->
        <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6 hover:border-purple-500/30 transition-all duration-300 hover:shadow-lg hover:shadow-purple-500/5 group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Work History</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ $workCount ?? 0 }}</p>
                    <p class="text-xs text-emerald-400 mt-1 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                        </svg>
                        +{{ $workGrowth ?? 0 }}% from last month
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-gradient-to-br from-purple-500/20 to-purple-700/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9.1-1.645M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Stat Card 2: CV Optimizations -->
        <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6 hover:border-emerald-500/30 transition-all duration-300 hover:shadow-lg hover:shadow-emerald-500/5 group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">CV Optimizations</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ $cvCount ?? 0 }}</p>
                    <p class="text-xs text-emerald-400 mt-1 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                        </svg>
                        +{{ $cvGrowth ?? 0 }}% from last month
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-gradient-to-br from-emerald-500/20 to-emerald-700/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Stat Card 3: Cover Letters -->
        <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6 hover:border-blue-500/30 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/5 group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Cover Letters</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ $coverLetterCount ?? 0 }}</p>
                    <p class="text-xs text-emerald-400 mt-1 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                        </svg>
                        +{{ $coverGrowth ?? 0 }}% from last month
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-gradient-to-br from-blue-500/20 to-blue-700/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Stat Card 4: ATS Score -->
        <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6 hover:border-amber-500/30 transition-all duration-300 hover:shadow-lg hover:shadow-amber-500/5 group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">ATS Score</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ $avgAtsScore ?? 0 }}%</p>
                    <div class="w-full bg-[#1C1C1E] rounded-full h-1.5 mt-2">
                        <div class="bg-gradient-to-r from-amber-500 to-emerald-500 h-1.5 rounded-full transition-all duration-500"
                             style="width: {{ $avgAtsScore ?? 0 }}%"></div>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-gradient-to-br from-amber-500/20 to-amber-700/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-white">Quick Actions</h2>
            <span class="text-xs text-gray-400">Jump to your most used tools</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('work-history') }}"
               class="group bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6 hover:border-purple-500/30 transition-all duration-300 hover:shadow-lg hover:shadow-purple-500/5">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9.1-1.645M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold group-hover:text-purple-400 transition-colors">Add Work History</h3>
                        <p class="text-sm text-gray-400 mt-0.5">Track your professional experience</p>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500 group-hover:text-gray-300 transition-colors">
                    <span>Click to add</span>
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </div>
            </a>

            <a href="{{ route('cv-optimizer') }}"
               class="group bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6 hover:border-emerald-500/30 transition-all duration-300 hover:shadow-lg hover:shadow-emerald-500/5">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold group-hover:text-emerald-400 transition-colors">Optimize CV</h3>
                        <p class="text-sm text-gray-400 mt-0.5">Get ATS score and suggestions</p>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500 group-hover:text-gray-300 transition-colors">
                    <span>Upload your CV</span>
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </div>
            </a>

            <a href="{{ route('cover-letters') }}"
               class="group bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6 hover:border-blue-500/30 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/5">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold group-hover:text-blue-400 transition-colors">Generate Cover Letter</h3>
                        <p class="text-sm text-gray-400 mt-0.5">Create tailored cover letters</p>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500 group-hover:text-gray-300 transition-colors">
                    <span>Get started</span>
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-[#1C1C1E]">
            <div class="flex items-center space-x-3">
                <h2 class="text-sm font-semibold text-white uppercase tracking-wider">Recent Activity</h2>
                @if(strlen($search) > 0)
                    <span class="text-xs text-purple-400 bg-purple-500/10 px-2 py-1 rounded-full">
                        {{ count($recentActivity) }} result{{ count($recentActivity) !== 1 ? 's' : '' }}
                    </span>
                @else
                    <span class="text-xs text-gray-500 bg-[#1C1C1E] px-2 py-1 rounded-full">Today</span>
                @endif
            </div>
            @if(strlen($search) > 0)
                <button wire:click="$set('search', '')" class="text-sm text-gray-400 hover:text-white transition-colors flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Clear
                </button>
            @else
                <a href="#" class="text-sm text-purple-400 hover:text-purple-300 transition-colors">View all</a>
            @endif
        </div>

        <div class="divide-y divide-[#1C1C1E] max-h-[400px] overflow-y-auto">
            @forelse($recentActivity ?? [] as $activity)
                <div class="flex items-start px-6 py-4 hover:bg-[#1A1A1E] transition-colors group">
                    <!-- Timeline dot -->
                    <div class="relative flex-shrink-0 mr-4">
                        <div class="w-2.5 h-2.5 mt-2 rounded-full
                            @if($activity->type === 'work') bg-purple-400
                            @elseif($activity->type === 'cv') bg-emerald-400
                            @else bg-blue-400 @endif">
                        </div>
                        @if(!$loop->last)
                            <div class="absolute top-4 left-1/2 w-0.5 h-full -translate-x-1/2 bg-[#1C1C1E]"></div>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                @if($activity->type === 'work') bg-purple-500/10 text-purple-400
                                @elseif($activity->type === 'cv') bg-emerald-500/10 text-emerald-400
                                @else bg-blue-500/10 text-blue-400 @endif">
                                {{ ucfirst($activity->type) }}
                            </span>
                            <span class="text-sm text-gray-300 truncate">{{ $activity->title }}</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $activity->description ?? '' }}</p>
                    </div>
                    <span class="text-xs text-gray-500 ml-4 flex-shrink-0">{{ $activity->time ?? 'Just now' }}</span>
                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    @if(strlen($search) > 0)
                        <div class="w-16 h-16 bg-[#1C1C1E] rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <p class="text-gray-400 font-medium">No results found</p>
                        <p class="text-sm text-gray-500 mt-1">No activity matches "{{ $search }}"</p>
                        <button wire:click="$set('search', '')" class="mt-3 text-sm text-purple-400 hover:text-purple-300 transition-colors">
                            Clear search
                        </button>
                    @else
                        <div class="w-16 h-16 bg-[#1C1C1E] rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-gray-400 font-medium">No recent activity</p>
                        <p class="text-sm text-gray-500 mt-1">Start by adding your work history or optimizing your CV</p>
                    @endif
                </div>
            @endforelse
        </div>
    </div>

</div>
