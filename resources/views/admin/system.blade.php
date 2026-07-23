<x-dashboard-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500/20 to-amber-600/10 flex items-center justify-center" style="border: 1px solid rgba(245, 158, 11, 0.2);">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white">System Settings</h3>
                <p class="text-sm text-gray-500">Application configuration and system information</p>
            </div>
        </div>

        <!-- System Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Application Info -->
            <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6">
                <h4 class="text-white font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Application Info
                </h4>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-[#1C1C1E]">
                        <span class="text-gray-400 text-sm">Laravel Version</span>
                        <span class="text-white text-sm font-mono">{{ app()->version() }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-[#1C1C1E]">
                        <span class="text-gray-400 text-sm">PHP Version</span>
                        <span class="text-white text-sm font-mono">{{ phpversion() }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-[#1C1C1E]">
                        <span class="text-gray-400 text-sm">Environment</span>
                        <span class="text-white text-sm font-mono">{{ app()->environment() }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-[#1C1C1E]">
                        <span class="text-gray-400 text-sm">Debug Mode</span>
                        <span class="text-white text-sm font-mono">{{ config('app.debug') ? 'Enabled' : 'Disabled' }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-400 text-sm">Cache Driver</span>
                        <span class="text-white text-sm font-mono">{{ config('cache.default') }}</span>
                    </div>
                </div>
            </div>

            <!-- Database Info -->
            <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6">
                <h4 class="text-white font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                    Database Info
                </h4>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-[#1C1C1E]">
                        <span class="text-gray-400 text-sm">Connection</span>
                        <span class="text-white text-sm font-mono">{{ config('database.default') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-[#1C1C1E]">
                        <span class="text-gray-400 text-sm">Database Name</span>
                        <span class="text-white text-sm font-mono">{{ config('database.connections.' . config('database.default') . '.database') }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-400 text-sm">Total Users</span>
                        <span class="text-white text-sm font-mono">{{ \App\Models\User::count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Services Status -->
            <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6">
                <h4 class="text-white font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                    </svg>
                    Services Status
                </h4>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-[#1C1C1E]">
                        <span class="text-gray-400 text-sm">Queue Driver</span>
                        <span class="text-white text-sm font-mono">{{ config('queue.default') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-[#1C1C1E]">
                        <span class="text-gray-400 text-sm">Session Driver</span>
                        <span class="text-white text-sm font-mono">{{ config('session.driver') }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-400 text-sm">Mail Driver</span>
                        <span class="text-white text-sm font-mono">{{ config('mail.default') }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6">
                <h4 class="text-white font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Quick Actions
                </h4>
                <div class="space-y-3">
                    <form action="{{ route('admin.system') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" name="action" value="cache"
                                class="w-full text-left px-4 py-3 rounded-lg bg-[#1C1C1E] hover:bg-[#2D2D30] transition-colors text-sm text-gray-300 hover:text-white">
                            Clear Application Cache
                        </button>
                    </form>
                    <form action="{{ route('admin.system') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" name="action" value="views"
                                class="w-full text-left px-4 py-3 rounded-lg bg-[#1C1C1E] hover:bg-[#2D2D30] transition-colors text-sm text-gray-300 hover:text-white">
                            Clear View Cache
                        </button>
                    </form>
                    <form action="{{ route('admin.system') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" name="action" value="config"
                                class="w-full text-left px-4 py-3 rounded-lg bg-[#1C1C1E] hover:bg-[#2D2D30] transition-colors text-sm text-gray-300 hover:text-white">
                            Clear Config Cache
                        </button>
                    </form>
                    <form action="{{ route('admin.system') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" name="action" value="routes"
                                class="w-full text-left px-4 py-3 rounded-lg bg-[#1C1C1E] hover:bg-[#2D2D30] transition-colors text-sm text-gray-300 hover:text-white">
                            Clear Route Cache
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
