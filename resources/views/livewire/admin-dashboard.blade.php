<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-purple-600/10 via-purple-500/5 to-transparent border border-purple-500/20 rounded-xl p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center shadow-lg shadow-purple-500/25">
                    <span class="text-white font-bold text-lg">
                        {{ strtoupper(substr($adminName, 0, 2)) }}
                    </span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">Welcome back, {{ $adminName }}! 👋</h2>
                    <p class="text-gray-400 mt-1">Here's what's happening with your platform today.</p>
                </div>
            </div>
            <div class="hidden md:flex items-center gap-2 text-sm text-gray-400">
                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Total Users -->
        <div class="bg-[#13141F] border border-[#1C1C1E] rounded-xl p-5 hover:border-purple-500/30 transition-all duration-300 group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Total Users</p>
                    <p class="text-2xl font-bold text-white mt-2 group-hover:text-purple-400 transition-colors">{{ number_format($totalUsers) }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-purple-500/20 to-purple-700/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-[#13141F] border border-[#1C1C1E] rounded-xl p-5 hover:border-amber-500/30 transition-all duration-300 group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Pending Approval</p>
                    <p class="text-2xl font-bold text-amber-400 mt-2">{{ number_format($pendingUsers) }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-500/20 to-amber-700/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            @if($pendingUsers > 0)
                <div class="mt-3">
                    <a href="{{ route('admin.users') }}" class="text-xs text-amber-400 hover:text-amber-300 underline underline-offset-2">
                        Review pending users →
                    </a>
                </div>
            @endif
        </div>

        <!-- Work Histories -->
        <div class="bg-[#13141F] border border-[#1C1C1E] rounded-xl p-5 hover:border-emerald-500/30 transition-all duration-300 group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Work Histories</p>
                    <p class="text-2xl font-bold text-white mt-2 group-hover:text-emerald-400 transition-colors">{{ number_format($totalWorkHistories) }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500/20 to-emerald-700/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9.1-1.645M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- CV Optimizations -->
        <div class="bg-[#13141F] border border-[#1C1C1E] rounded-xl p-5 hover:border-blue-500/30 transition-all duration-300 group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">CV Optimizations</p>
                    <p class="text-2xl font-bold text-white mt-2 group-hover:text-blue-400 transition-colors">{{ number_format($totalCvOptimizations) }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-700/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Cover Letters -->
        <div class="bg-[#13141F] border border-[#1C1C1E] rounded-xl p-5 hover:border-cyan-500/30 transition-all duration-300 group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Cover Letters</p>
                    <p class="text-2xl font-bold text-white mt-2 group-hover:text-cyan-400 transition-colors">{{ number_format($totalCoverLetters) }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-cyan-500/20 to-cyan-700/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions + Recent Users -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Quick Actions -->
        <div class="lg:col-span-1 space-y-4">
            <h3 class="text-lg font-semibold text-white">Quick Actions</h3>

            <a href="{{ route('admin.users') }}"
               class="flex items-center gap-4 bg-[#13141F] border border-[#1C1C1E] rounded-xl p-5 hover:border-purple-500/30 hover:bg-purple-500/5 transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-white font-semibold group-hover:text-purple-400 transition-colors">Manage Users</h4>
                    <p class="text-sm text-gray-400">Approve, reject, and manage users</p>
                </div>
                <svg class="w-5 h-5 text-gray-500 group-hover:text-purple-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <a href="{{ route('settings') }}"
               class="flex items-center gap-4 bg-[#13141F] border border-[#1C1C1E] rounded-xl p-5 hover:border-amber-500/30 hover:bg-amber-500/5 transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-white font-semibold group-hover:text-amber-400 transition-colors">Profile Settings</h4>
                    <p class="text-sm text-gray-400">Update your admin profile and password</p>
                </div>
                <svg class="w-5 h-5 text-gray-500 group-hover:text-amber-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <a href="{{ route('admin.system') }}"
               class="flex items-center gap-4 bg-[#13141F] border border-[#1C1C1E] rounded-xl p-5 hover:border-emerald-500/30 hover:bg-emerald-500/5 transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-white font-semibold group-hover:text-emerald-400 transition-colors">System Settings</h4>
                    <p class="text-sm text-gray-400">Clear caches and manage system</p>
                </div>
                <svg class="w-5 h-5 text-gray-500 group-hover:text-emerald-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-4 bg-[#13141F] border border-[#1C1C1E] rounded-xl p-5 hover:border-cyan-500/30 hover:bg-cyan-500/5 transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-cyan-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z M14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z M4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z M14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-white font-semibold group-hover:text-cyan-400 transition-colors">User Dashboard</h4>
                    <p class="text-sm text-gray-400">Return to your personal dashboard</p>
                </div>
                <svg class="w-5 h-5 text-gray-500 group-hover:text-cyan-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <!-- Recent Users -->
        <div class="lg:col-span-2">
            <div class="bg-[#13141F] border border-[#1C1C1E] rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-[#1C1C1E] flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-white">Recent Registrations</h3>
                        <p class="text-sm text-gray-400">Latest users who joined the platform</p>
                    </div>
                    <a href="{{ route('admin.users') }}"
                       class="text-sm text-purple-400 hover:text-purple-300 transition-colors flex items-center gap-1">
                        View all
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="divide-y divide-[#1C1C1E]">
                    @forelse($recentUsers as $user)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-white/[0.02] transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500/20 to-purple-700/20 flex items-center justify-center border border-purple-500/20">
                                    <span class="text-purple-400 font-semibold text-sm">
                                        {{ strtoupper(substr($user['name'] ?? 'U', 0, 2)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-white">{{ $user['name'] ?? 'Unknown' }}</p>
                                    <p class="text-xs text-gray-400">{{ $user['email'] ?? '' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($user['created_at'])->diffForHumans() }}
                                </span>
                                @if($user['is_approved'] ?? false)
                                    <span class="px-2.5 py-1 text-xs font-medium bg-emerald-500/10 text-emerald-400 rounded-full border border-emerald-500/20">
                                        Approved
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-medium bg-amber-500/10 text-amber-400 rounded-full border border-amber-500/20">
                                        Pending
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center">
                            <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            <p class="text-gray-400 text-sm">No users registered yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
