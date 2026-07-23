{{-- resources/views/livewire/cv-optimizer.blade.php --}}
<div>
    <!-- Flash Messages -->
    @if(session()->has('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-lg mb-4 flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-300">×</button>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-4 flex items-center justify-between">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-300">×</button>
        </div>
    @endif

    @if(session()->has('message'))
        <div class="bg-blue-500/10 border border-blue-500/30 text-blue-400 px-4 py-3 rounded-lg mb-4 flex items-center justify-between">
            <span>{{ session('message') }}</span>
            <button onclick="this.parentElement.remove()" class="text-blue-400 hover:text-blue-300">×</button>
        </div>
    @endif

    <!-- No Work History Warning -->
    @if(empty($experiences))
    <div class="bg-amber-500/10 border border-amber-500/30 rounded-xl p-6 mb-6">
        <div class="flex items-start space-x-4">
            <svg class="w-6 h-6 text-amber-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <h4 class="text-amber-400 font-medium">No Work History Found</h4>
                <p class="text-gray-400 text-sm mt-1">Please add your work history first before optimizing your CV.</p>
                <a href="{{ route('work-history') }}" class="inline-block mt-3 px-4 py-2 bg-amber-500/20 hover:bg-amber-500/30 text-amber-400 rounded-lg text-sm transition-colors">
                    Go to Work History →
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Form -->
    <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6 mb-6">
        <form wire:submit.prevent="analyzeAndOptimize" class="space-y-4">
            <!-- Job Title -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Job Title *</label>
                <input type="text"
                       wire:model="jobTitle"
                       placeholder="e.g., Senior Software Engineer"
                       class="w-full bg-[#1A1A1E] border border-[#2D2D30] text-white rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                @error('jobTitle') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <!-- Company Name -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Company Name *</label>
                <input type="text"
                       wire:model="companyName"
                       placeholder="e.g., Google"
                       class="w-full bg-[#1A1A1E] border border-[#2D2D30] text-white rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                @error('companyName') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <!-- Job Description -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Job Description *</label>
                <textarea wire:model="jobDescription"
                          rows="8"
                          placeholder="Paste the job description here..."
                          class="w-full bg-[#1A1A1E] border border-[#2D2D30] text-white rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"></textarea>
                @error('jobDescription') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <!-- File Upload -->
            <div>
                <p class="text-sm text-gray-400 mb-2">or upload a file</p>
                <div class="border-2 border-dashed border-[#2D2D30] rounded-lg p-4 text-center hover:border-purple-500/50 transition-all duration-300 cursor-pointer"
                     onclick="document.getElementById('file-upload').click()"
                     ondrop="handleDrop(event)"
                     ondragover="event.preventDefault(); this.classList.add('border-purple-500', 'bg-purple-500/5')"
                     ondragleave="event.preventDefault(); this.classList.remove('border-purple-500', 'bg-purple-500/5')">

                    <input type="file"
                           id="file-upload"
                           wire:model="jobDescriptionFile"
                           class="hidden"
                           accept=".pdf,.txt">

                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <span class="text-gray-400 text-sm">Click to upload PDF or TXT</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Max 5MB</p>
                </div>
                @error('jobDescriptionFile') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror

                @if($jobDescriptionFile)
                    <div class="mt-2 flex items-center space-x-2 text-emerald-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm">{{ $jobDescriptionFile->getClientOriginalName() }}</span>
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="flex items-center space-x-4 pt-4">
                <button type="submit"
                        wire:loading.attr="disabled"
                        class="px-6 py-2.5 bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white font-medium rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove>🚀 Analyze & Optimize CV</span>
                    <span wire:loading>⏳ Processing...</span>
                </button>
                <button type="button"
                        wire:click="resetForm"
                        class="px-6 py-2.5 border border-[#2D2D30] text-gray-400 hover:text-white hover:border-purple-500 rounded-lg transition-all duration-300">
                    Clear All
                </button>
            </div>
        </form>
    </div>

    <!-- Results Section -->
    @if($showResults && $atsScore !== null)
    <div class="space-y-6">
        <!-- ATS Score Summary -->
        <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6">
            <h3 class="text-white font-semibold text-lg mb-4">📊 ATS Score Summary</h3>
            <div class="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-8">
                <div class="text-center">
                    <div class="text-5xl font-bold text-white">{{ $atsScore }}%</div>
                    <div class="text-sm text-gray-400">Overall Score</div>
                    <div class="mt-2 text-xl">
                        @php
                            $score = $atsScore;
                            if ($score >= 80) echo '🌟 Excellent';
                            elseif ($score >= 60) echo '⭐ Good';
                            elseif ($score >= 40) echo '⚡ Fair';
                            else echo '📈 Needs Improvement';
                        @endphp
                    </div>
                </div>
                <div class="flex-1 w-full space-y-2">
                    @foreach($atsBreakdown as $category => $score)
                    <div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-300">{{ ucfirst($category) }}</span>
                            <span class="text-white">{{ round($score) }}%</span>
                        </div>
                        <div class="w-full bg-[#1C1C1E] rounded-full h-2">
                            <div class="bg-gradient-to-r from-purple-500 to-purple-700 h-2 rounded-full transition-all duration-1000"
                                 style="width: {{ min($score, 100) }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Optimized Content -->
        <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-white font-semibold text-lg">✨ Optimized CV Preview</h3>
                <button wire:click="downloadOptimizedCV"
                        wire:loading.attr="disabled"
                        class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 text-white text-sm font-medium rounded-lg transition-all duration-300 shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove>📥 Download PDF</span>
                    <span wire:loading>⏳ Preparing PDF...</span>
                </button>
            </div>

            <!-- Template Selector -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Select CV Template</label>
                <div class="grid grid-cols-3 gap-3">
                    @php
                        $templates = [
                            'professional' => ['name' => 'Professional', 'icon' => '💼', 'desc' => 'Modern with purple accents'],
                            'minimal' => ['name' => 'Minimal', 'icon' => '✨', 'desc' => 'Clean and simple'],
                            'classic' => ['name' => 'Classic', 'icon' => '📜', 'desc' => 'Traditional layout'],
                        ];
                    @endphp
                    @foreach($templates as $key => $template)
                    <div wire:click="$set('selectedTemplate', '{{ $key }}')"
                         class="cursor-pointer border-2 rounded-lg p-3 text-center transition-all duration-200
                                {{ $selectedTemplate === $key ? 'border-purple-500 bg-purple-500/10' : 'border-[#2D2D30] hover:border-purple-500/50' }}">
                        <div class="text-2xl">{{ $template['icon'] }}</div>
                        <div class="text-white font-medium text-sm">{{ $template['name'] }}</div>
                        <div class="text-gray-400 text-xs">{{ $template['desc'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            @if(!empty($optimizedExperiences))
                @foreach($optimizedExperiences as $exp)
                <div class="bg-[#1C1C1E] rounded-lg p-4 mb-3 border border-[#2D2D30] hover:border-purple-500/30 transition-all">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-white font-medium">{{ $exp['job_title'] ?? 'Position' }}</h4>
                            <p class="text-purple-400 text-sm">{{ $exp['company_name'] ?? 'Company' }}</p>
                        </div>
                        <span class="text-xs text-gray-400">
                            {{ $exp['start_date'] ?? '' }} - {{ $exp['end_date'] ?? 'Present' }}
                        </span>
                    </div>
                    @if(!empty($exp['optimized_bullets']))
                        <ul class="mt-2 space-y-1">
                            @foreach($exp['optimized_bullets'] as $bullet)
                            <li class="text-sm text-gray-300 flex items-start">
                                <span class="text-purple-400 mr-2">•</span>
                                {{ $bullet }}
                            </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                @endforeach
            @else
                <div class="text-center text-gray-400 py-8">
                    <p>No optimized content available yet.</p>
                </div>
            @endif

            <!-- Skills -->
            @if(!empty($optimizedSkills))
            <div class="bg-[#1C1C1E] rounded-lg p-4 border border-[#2D2D30] mt-3">
                <h4 class="text-white font-medium mb-2">Optimized Skills</h4>
                <div class="flex flex-wrap gap-2">
                    @foreach($optimizedSkills as $skill)
                    <span class="px-3 py-1 text-xs bg-purple-500/20 text-purple-400 rounded-full border border-purple-500/30">
                        {{ is_array($skill) ? ($skill['name'] ?? '') : $skill }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Suggestions -->
            @if(!empty($suggestions))
            <div class="bg-amber-500/10 border border-amber-500/30 rounded-lg p-4 mt-3">
                <h4 class="text-amber-400 font-medium mb-2">💡 Suggestions</h4>
                <ul class="space-y-1">
                    @foreach($suggestions as $suggestion)
                    <li class="text-sm text-gray-300 flex items-start">
                        <span class="text-amber-400 mr-2">•</span>
                        {{ $suggestion }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Missing Keywords -->
            @if(!empty($missingKeywords))
            <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4 mt-3">
                <h4 class="text-red-400 font-medium mb-2">Missing Keywords to Add</h4>
                <div class="flex flex-wrap gap-1">
                    @foreach($missingKeywords as $keyword)
                    <span class="px-2 py-0.5 text-xs bg-red-500/20 text-red-400 rounded-full">{{ $keyword }}</span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    @push('scripts')
    <script>
        function handleDrop(event) {
            event.preventDefault();
            const zone = event.currentTarget;
            zone.classList.remove('border-purple-500', 'bg-purple-500/5');

            const file = event.dataTransfer.files[0];
            if (file) {
                const input = document.getElementById('file-upload');
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                input.dispatchEvent(new Event('change'));
            }
        }
    </script>
    @endpush
</div>
