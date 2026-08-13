<div class="space-y-6">
    <!-- Flash Messages -->
    @if (session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-lg">
            <p class="text-sm text-emerald-400">{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg">
            <p class="text-sm text-red-400">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500/20 to-purple-600/10 flex items-center justify-center" style="border: 1px solid rgba(168, 85, 247, 0.2);">
                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9.1-1.645M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white">Job Market Management</h3>
                <p class="text-sm text-gray-500">Create, manage, and monitor job postings</p>
            </div>
        </div>
        <div class="text-sm text-gray-400 bg-[#13131A] border border-[#1C1C1E] rounded-lg px-4 py-2">
            {{ $stats['total'] }} total jobs
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total Jobs</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-purple-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9.1-1.645M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Active Jobs</p>
                    <p class="text-2xl font-bold text-emerald-400 mt-1">{{ $stats['active'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Inactive Jobs</p>
                    <p class="text-2xl font-bold text-gray-400 mt-1">{{ $stats['inactive'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-gray-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Job Form -->
    <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500/20 to-purple-700/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div>
                <h4 class="text-white font-semibold">Add New Job Posting</h4>
                <p class="text-sm text-gray-500">Publish a new job to the marketplace</p>
            </div>
        </div>

        <form wire:submit.prevent="createJob" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-400 mb-1.5">Job Title</label>
                    <input type="text" id="title" wire:model="title" placeholder="e.g. Senior Software Engineer"
                           class="w-full bg-[#1A1B2E] border border-[#2D3A4F] text-white rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all placeholder-gray-500 @error('title') border-red-500/50 @enderror">
                    @error('title') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Company Name -->
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-400 mb-1.5">Company Name</label>
                    <input type="text" id="company_name" wire:model="company_name" placeholder="e.g. Lulalend"
                           class="w-full bg-[#1A1B2E] border border-[#2D3A4F] text-white rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all placeholder-gray-500 @error('company_name') border-red-500/50 @enderror">
                    @error('company_name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-400 mb-1.5">Location</label>
                    <input type="text" id="location" wire:model="location" placeholder="e.g. Johannesburg, Gauteng"
                           class="w-full bg-[#1A1B2E] border border-[#2D3A4F] text-white rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all placeholder-gray-500 @error('location') border-red-500/50 @enderror">
                    @error('location') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Apply URL -->
                <div>
                    <label for="apply_url" class="block text-sm font-medium text-gray-400 mb-1.5">Apply URL</label>
                    <input type="url" id="apply_url" wire:model="apply_url" placeholder="https://linkedin.com/jobs/..."
                           class="w-full bg-[#1A1B2E] border border-[#2D3A4F] text-white rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all placeholder-gray-500 @error('apply_url') border-red-500/50 @enderror">
                    @error('apply_url') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-400 mb-1.5">Description</label>
                <textarea id="description" wire:model="description" rows="4" placeholder="Describe the role, responsibilities, and requirements..."
                          class="w-full bg-[#1A1B2E] border border-[#2D3A4F] text-white rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all placeholder-gray-500 resize-y @error('description') border-red-500/50 @enderror"></textarea>
                @error('description') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-purple-500 hover:bg-purple-600 text-white text-sm font-semibold rounded-lg transition-all duration-200 shadow-lg shadow-purple-500/20 hover:shadow-purple-500/30 active:scale-[0.98]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Job Posting
                </button>
            </div>
        </form>
    </div>

    <!-- Filters & Search -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <button wire:click="$set('filter', 'all')"
                    class="px-4 py-2 text-sm rounded-lg transition-all duration-200 {{ $filter === 'all' ? 'bg-purple-500/20 text-purple-400 border border-purple-500/30' : 'bg-[#1A1B2E] text-gray-400 border border-[#2D3A4F] hover:border-purple-500/30 hover:text-white' }}">
                All Jobs
            </button>
            <button wire:click="$set('filter', 'active')"
                    class="px-4 py-2 text-sm rounded-lg transition-all duration-200 {{ $filter === 'active' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-[#1A1B2E] text-gray-400 border border-[#2D3A4F] hover:border-emerald-500/30 hover:text-white' }}">
                Active
            </button>
            <button wire:click="$set('filter', 'inactive')"
                    class="px-4 py-2 text-sm rounded-lg transition-all duration-200 {{ $filter === 'inactive' ? 'bg-gray-500/20 text-gray-400 border border-gray-500/30' : 'bg-[#1A1B2E] text-gray-400 border border-[#2D3A4F] hover:border-gray-500/30 hover:text-white' }}">
                Inactive
            </button>
        </div>

        <div class="relative w-full sm:w-64">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" wire:model.debounce.300ms="search" placeholder="Search jobs..."
                   class="w-full bg-[#1A1B2E] border border-[#2D3A4F] text-white rounded-lg pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
        </div>
    </div>

    <!-- Jobs Table -->
    <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-[#1C1C1E]">
                        <th class="text-left px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">Job Title</th>
                        <th class="text-left px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">Company</th>
                        <th class="text-left px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">Location</th>
                        <th class="text-left px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">Apply URL</th>
                        <th class="text-left px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="text-left px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">Created</th>
                        <th class="text-left px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1C1C1E]">
                    @forelse($jobs as $job)
                        <tr class="hover:bg-[#1C1C1E]/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500/20 to-purple-700/20 flex items-center justify-center border border-purple-500/30 flex-shrink-0">
                                        <span class="text-purple-400 font-semibold text-xs">
                                            {{ strtoupper(substr($job->company_name ?? 'C', 0, 1)) }}
                                        </span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-white text-sm font-medium truncate">{{ $job->title }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ Str::limit($job->description, 60) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ $job->company_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-400">
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $job->location }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ $job->apply_url }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1 text-sm text-purple-400 hover:text-purple-300 transition-colors group">
                                    Apply
                                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                @if($job->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-1.5"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-500/20 text-gray-400 border border-gray-500/30">
                                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1.5"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ $job->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button wire:click="toggleActive({{ $job->id }})"
                                            wire:confirm="Are you sure you want to {{ $job->is_active ? 'deactivate' : 'activate' }} {{ $job->title }}?"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium {{ $job->is_active ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30 hover:bg-amber-500/30' : 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 hover:bg-emerald-500/30' }} rounded-lg transition-all duration-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($job->is_active)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            @endif
                                        </svg>
                                        {{ $job->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                    <button wire:click="deleteJob({{ $job->id }})"
                                            wire:confirm="Are you sure you want to delete {{ $job->title }}? This action cannot be undone."
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-red-500/20 text-red-400 border border-red-500/30 rounded-lg hover:bg-red-500/30 transition-all duration-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9.1-1.645M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-gray-400 text-sm">No job postings found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($jobs->hasPages())
            <div class="px-6 py-4 border-t border-[#1C1C1E]">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>
</div>
