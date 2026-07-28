{{-- resources/views/livewire/work-history.blade.php --}}
<div>
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Work History</h1>
            <p class="text-sm text-gray-400 mt-0.5">Manage your professional experience</p>
        </div>
        <div class="flex items-center gap-3">
            @if(!$showForm && !$showImportForm && !$showPreview)
                <button wire:click="showImport"
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white text-sm font-medium rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Import with AI
                </button>
            @endif
            @if(!$showForm && !$showImportForm && !$showPreview)
                <button wire:click="create"
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white text-sm font-medium rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Experience
                </button>
            @endif
        </div>
    </div>

    <!-- ==== AI IMPORT SECTION (Standard HTTP Upload) ==== -->
    @if($showImportForm && !$showPreview)
    <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-white font-semibold">🤖 Import with AI</h3>
                <p class="text-sm text-gray-400">Upload your CV or resume to auto-fill work history</p>
            </div>
            <span class="text-xs text-purple-400 bg-purple-500/10 px-3 py-1 rounded-full border border-purple-500/20">Powered by DeepSeek</span>
        </div>

        <form id="import-form" enctype="multipart/form-data">
            @csrf
            <div class="border-2 border-dashed border-[#2D2D30] rounded-lg p-8 text-center hover:border-purple-500/50 transition-all duration-300 cursor-pointer"
                 onclick="document.getElementById('file-upload').click()"
                 ondrop="handleFileDrop(event)"
                 ondragover="event.preventDefault(); this.classList.add('border-purple-500', 'bg-purple-500/5')"
                 ondragleave="event.preventDefault(); this.classList.remove('border-purple-500', 'bg-purple-500/5')">

                <input type="file" name="file" id="file-upload" class="hidden" accept=".pdf,.doc,.docx">

                <div class="space-y-3">
                    <div class="w-16 h-16 mx-auto bg-purple-500/10 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-medium">Click to upload or drag and drop</p>
                        <p class="text-sm text-gray-400 mt-1">Supports PDF, DOCX, DOC (Max 5MB)</p>
                    </div>
                </div>
            </div>

            <div id="file-info" class="mt-4 hidden">
                <div class="flex items-center justify-between bg-[#1C1C1E] rounded-lg px-4 py-3">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span id="file-name" class="text-white text-sm"></span>
                        <span id="file-size" class="text-xs text-gray-400"></span>
                    </div>
                    <button type="button" onclick="resetFile()" class="text-gray-400 hover:text-red-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="button" id="import-btn" data-route="{{ route('import.cv') }}"
                    class="mt-4 w-full bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white font-medium py-3 rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40 disabled:opacity-50 inline-flex items-center justify-center">
                <span id="btn-text">🚀 Import with AI</span>
                <svg id="btn-spinner" class="hidden animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </form>

        <!-- Loading / Progress -->
        <div id="import-loading" class="hidden mt-4">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-400" id="loading-status">Processing...</span>
                <span class="text-purple-400" id="loading-progress">0%</span>
            </div>
            <div class="w-full bg-[#1C1C1E] rounded-full h-2 mt-2 overflow-hidden">
                <div id="loading-bar" class="bg-gradient-to-r from-purple-500 to-purple-700 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
            </div>
        </div>

        <div class="mt-4 flex justify-end">
            <button wire:click="resetForm"
                    class="px-4 py-2 border border-[#2D2D30] text-gray-400 hover:text-white hover:border-purple-500 rounded-lg text-sm transition-all duration-300">
                Cancel
            </button>
        </div>
    </div>
    @endif

    <!-- Preview Extracted Data -->
    @if($showPreview && count($extractedData) > 0)
    <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-white font-semibold">✨ Extracted Work History</h3>
                <p class="text-sm text-gray-400">{{ count($extractedData) }} entries found</p>
            </div>
            <div class="flex space-x-2">
                <button wire:click="saveAllExtracted"
                        class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 text-white text-sm font-medium rounded-lg transition-all duration-300">
                    Save All
                </button>
                <button wire:click="cancelExtracted"
                        class="px-4 py-2 border border-[#2D2D30] text-gray-400 hover:text-white hover:border-red-500 rounded-lg text-sm transition-all duration-300">
                    Cancel
                </button>
            </div>
        </div>

        <div class="space-y-4">
            @foreach($extractedData as $index => $entry)
            <div class="bg-[#1C1C1E] rounded-lg p-4 border border-[#2D2D30] hover:border-purple-500/30 transition-all duration-300">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3">
                            <span class="text-lg font-semibold text-white">{{ $entry['company_name'] ?? 'Unknown Company' }}</span>
                            <span class="text-sm text-purple-400">{{ $entry['job_title'] ?? 'Position' }}</span>
                            @if($entry['is_current'] ?? false)
                                <span class="px-2 py-0.5 text-xs bg-emerald-500/20 text-emerald-400 rounded-full">Current</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-400 mt-1">
                            {{ $entry['location'] ?? '' }}
                            {{ $entry['start_date'] ?? '' }}
                            @if(!empty($entry['start_date']) && !($entry['is_current'] ?? false))
                                → {{ $entry['end_date'] ?? '' }}
                            @endif
                            @if($entry['is_current'] ?? false)
                                → Present
                            @endif
                        </p>
                        <p class="text-sm text-gray-300 mt-2">{{ $entry['description'] ?? '' }}</p>
                    </div>
                    <button wire:click="saveExtractedEntry({{ $index }})"
                            class="ml-4 px-3 py-1.5 bg-purple-500/20 hover:bg-purple-500/30 text-purple-400 text-sm rounded-lg transition-all duration-300 flex-shrink-0">
                        Save Entry
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Manual Entry Form -->
    @if($showForm)
    <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-white font-semibold">{{ $editingId ? 'Edit Experience' : 'Add Experience' }}</h3>
                <p class="text-sm text-gray-400">Enter your work history details</p>
            </div>
        </div>

        <form wire:submit.prevent="save" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Company Name *</label>
                    <input type="text" wire:model="company_name"
                           class="w-full bg-[#1C1C1E] border border-[#2D2D30] rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors"
                           placeholder="e.g. Acme Corp">
                    @error('company_name') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Job Title *</label>
                    <input type="text" wire:model="job_title"
                           class="w-full bg-[#1C1C1E] border border-[#2D2D30] rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors"
                           placeholder="e.g. Software Engineer">
                    @error('job_title') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Location</label>
                    <input type="text" wire:model="location"
                           class="w-full bg-[#1C1C1E] border border-[#2D2D30] rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors"
                           placeholder="e.g. San Francisco, CA">
                </div>
                <div class="flex items-end">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" wire:model="is_current"
                               class="rounded bg-[#1C1C1E] border-[#2D2D30] text-purple-500 focus:ring-purple-500">
                        <span class="text-sm text-gray-300">I currently work here</span>
                    </label>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Start Date *</label>
                    <input type="date" wire:model="start_date"
                           class="w-full bg-[#1C1C1E] border border-[#2D2D30] rounded-lg px-4 py-2.5 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors">
                    @error('start_date') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">End Date</label>
                    <input type="date" wire:model="end_date"
                           class="w-full bg-[#1C1C1E] border border-[#2D2D30] rounded-lg px-4 py-2.5 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors"
                           @if($is_current) disabled @endif>
                    @error('end_date') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Description</label>
                <textarea wire:model="description" rows="4"
                          class="w-full bg-[#1C1C1E] border border-[#2D2D30] rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors resize-none"
                          placeholder="Describe your responsibilities and achievements..."></textarea>
                @error('description') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-2">
                <button type="button" wire:click="resetForm"
                        class="px-4 py-2 border border-[#2D2D30] text-gray-400 hover:text-white hover:border-purple-500 rounded-lg text-sm transition-all duration-300">
                    Cancel
                </button>
                <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white text-sm font-medium rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40">
                    {{ $editingId ? 'Update' : 'Save' }}
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Work History List -->
    <div class="space-y-3">
        @forelse($workHistory as $work)
        <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-5 hover:border-purple-500/30 transition-all duration-300 group">
            <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm">{{ substr($work->company_name, 0, 1) }}</span>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-white font-semibold truncate">{{ $work->company_name }}</h3>
                            <p class="text-sm text-purple-400">{{ $work->job_title }}</p>
                        </div>
                        @if($work->is_current)
                            <span class="px-2 py-0.5 text-xs bg-emerald-500/20 text-emerald-400 rounded-full flex-shrink-0">Current</span>
                        @endif
                    </div>
                    <div class="mt-2 flex items-center space-x-4 text-sm text-gray-400">
                        @if($work->location)
                            <span class="flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $work->location }}
                            </span>
                        @endif
                        <span class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $work->start_date->format('M Y') }} - {{ $work->is_current ? 'Present' : ($work->end_date ? $work->end_date->format('M Y') : '') }}
                        </span>
                    </div>
                    @if($work->description)
                        <p class="mt-2 text-sm text-gray-300 line-clamp-2">{{ $work->description }}</p>
                    @endif
                </div>
                <div class="flex items-center space-x-2 ml-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <button wire:click="edit({{ $work->id }})"
                            class="p-2 text-gray-400 hover:text-purple-400 hover:bg-purple-500/10 rounded-lg transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <button wire:click="delete({{ $work->id }})"
                            wire:confirm="Are you sure you want to delete this entry?"
                            class="p-2 text-gray-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @empty
            <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-12 text-center">
                <div class="w-20 h-20 bg-[#1C1C1E] rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9.1-1.645M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">No work history added yet</h3>
                <p class="text-gray-400 mb-6">Start building your professional profile</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <button wire:click="showImport"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white font-medium rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Import from CV
                    </button>
                    <button wire:click="create"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white font-medium rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Your First Entry
                    </button>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Drag & Drop handler + Livewire event listener -->
    @push('scripts')
    <script>
        // 1. Handle File Selection via Event Delegation
        document.addEventListener('change', function(e) {
            if (e.target && e.target.id === 'file-upload') {
                const file = e.target.files[0];
                if (file) {
                    document.getElementById('file-name').textContent = file.name;
                    document.getElementById('file-size').textContent = (file.size / 1024).toFixed(0) + ' KB';
                    document.getElementById('file-info').classList.remove('hidden');
                }
            }
        });

        // 2. Handle the Import Button Click via Event Delegation
        document.addEventListener('click', function(e) {
            // Check if the click happened on or inside the import button
            const importBtn = e.target.closest('#import-btn');

            if (importBtn) {
                e.preventDefault();

                const fileInput = document.getElementById('file-upload');
                if (!fileInput || !fileInput.files || !fileInput.files.length) {
                    alert('Please select a file first.');
                    return;
                }

                const file = fileInput.files[0];
                if (file.size > 5 * 1024 * 1024) {
                    alert('File is too large. Maximum allowed size is 5MB.');
                    return;
                }

                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    alert('CSRF token not found. Please refresh the page.');
                    return;
                }

                // Grab dynamic DOM elements right when the button is clicked
                const btnText = document.getElementById('btn-text');
                const btnSpinner = document.getElementById('btn-spinner');
                const loadingEl = document.getElementById('import-loading');
                const loadingStatus = document.getElementById('loading-status');
                const loadingProgress = document.getElementById('loading-progress');
                const loadingBar = document.getElementById('loading-bar');

                function updateProgress(pct, status) {
                    if (loadingProgress) loadingProgress.textContent = pct + '%';
                    if (loadingBar) loadingBar.style.width = pct + '%';
                    if (loadingStatus) loadingStatus.textContent = status;
                }

                function showLoading() {
                    importBtn.disabled = true;
                    if (btnText) btnText.classList.add('hidden');
                    if (btnSpinner) btnSpinner.classList.remove('hidden');
                    if (loadingEl) loadingEl.classList.remove('hidden');
                    updateProgress(0, 'Uploading file...');
                }

                function hideLoading() {
                    importBtn.disabled = false;
                    if (btnText) btnText.classList.remove('hidden');
                    if (btnSpinner) btnSpinner.classList.add('hidden');
                    setTimeout(function() {
                        if (loadingEl) loadingEl.classList.add('hidden');
                        updateProgress(0, 'Processing...');
                    }, 2000);
                }

                function simulateProgress(startPct, endPct, duration, statusPrefix, onComplete) {
                    const startTime = Date.now();
                    const tick = function() {
                        const elapsed = Date.now() - startTime;
                        const fraction = Math.min(elapsed / duration, 1);
                        const pct = startPct + Math.round((endPct - startPct) * fraction);
                        updateProgress(pct, statusPrefix + (fraction < 1 ? '...' : ''));
                        if (fraction < 1) {
                            requestAnimationFrame(tick);
                        } else if (onComplete) {
                            onComplete();
                        }
                    };
                    requestAnimationFrame(tick);
                }

                const formData = new FormData();
                formData.append('file', file);

                // Start the UI simulation
                showLoading();

                simulateProgress(0, 40, 2000, '📤 Uploading', function() {
                    updateProgress(40, '📄 Extracting text from document...');

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', importBtn.dataset.route, true);
                    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken.content);
                    xhr.setRequestHeader('Accept', 'application/json');

                    xhr.onload = function() {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            try {
                                const data = JSON.parse(xhr.responseText);

                                simulateProgress(40, 90, 1500, '🤖 AI parsing', function() {
                                    updateProgress(95, '✅ Finalizing...');

                                    setTimeout(function() {
                                        if (data.success) {
                                            updateProgress(100, '✅ Import complete!');
                                            if (window.Livewire) {
                                                Livewire.dispatch('importCompleted', { data: data.data });
                                            } else {
                                                alert('✅ ' + data.message);
                                                location.reload();
                                            }
                                        } else {
                                            updateProgress(100, '❌ Import failed');
                                            alert('❌ ' + data.message);
                                        }
                                        hideLoading();
                                    }, 500);
                                });
                            } catch (error) {
                                console.error('Error parsing JSON:', error);
                                if (loadingStatus) loadingStatus.textContent = '❌ Error parsing server response';
                                hideLoading();
                            }
                        } else {
                            console.error('Server error:', xhr.status);
                            if (loadingStatus) loadingStatus.textContent = '❌ Error: Server returned ' + xhr.status;
                            alert('❌ Request failed. Server returned an error.');
                            hideLoading();
                        }
                    };

                    xhr.onerror = function() {
                        console.error('Network error occurred');
                        if (loadingStatus) loadingStatus.textContent = '❌ Error: Network connection failed';
                        alert('❌ Request failed. Check console for details.');
                        hideLoading();
                    };

                    xhr.send(formData);
                });
            }
        });

        // 3. Reset file function (exposed globally for inline onclick)
        window.resetFile = function() {
            const fileInput = document.getElementById('file-upload');
            if (fileInput) {
                fileInput.value = '';
                const fileInfo = document.getElementById('file-info');
                if (fileInfo) fileInfo.classList.add('hidden');
            }
        };

        // 4. Drag and drop handler (exposed globally for inline ondrop)
        window.handleFileDrop = function(event) {
            event.preventDefault();
            const zone = event.currentTarget;
            zone.classList.remove('border-purple-500', 'bg-purple-500/5');

            const file = event.dataTransfer.files[0];
            if (file) {
                const dt = new DataTransfer();
                dt.items.add(file);

                const fileInput = document.getElementById('file-upload');
                if (fileInput) {
                    fileInput.files = dt.files;
                    // Dispatch change event with bubbling so our document listener catches it
                    fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }
        };
    </script>
    @endpush
</div>
