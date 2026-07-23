<div class="min-h-screen bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-white">Complete Your Profile</h2>
            <p class="mt-2 text-gray-400">Help us match you with the right opportunities</p>
        </div>

        <!-- Progress Bar -->
        <div class="bg-gray-800 rounded-lg p-6 mb-8 shadow-lg border border-gray-700">
            <div class="flex justify-between mb-2">
                <span class="text-sm font-medium text-purple-400">Step {{ $currentStep }} of 3</span>
                <span class="text-sm font-medium text-gray-400">{{ round(($currentStep / 3) * 100) }}% Complete</span>
            </div>
            <div class="w-full bg-gray-700 rounded-full h-2.5">
                <div class="bg-gradient-to-r from-purple-500 to-purple-700 h-2.5 rounded-full transition-all duration-500 ease-in-out"
                     style="width: {{ ($currentStep / 3) * 100 }}%">
                </div>
            </div>
            <!-- Step Labels -->
            <div class="flex justify-between mt-2 text-xs text-gray-500">
                <span class="{{ $currentStep >= 1 ? 'text-purple-400' : '' }}">Career Goals</span>
                <span class="{{ $currentStep >= 2 ? 'text-purple-400' : '' }}">Skills</span>
                <span class="{{ $currentStep >= 3 ? 'text-purple-400' : '' }}">Resume</span>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('error'))
            <div class="bg-red-500/10 border border-red-500/50 text-red-400 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if (session()->has('message'))
            <div class="bg-green-500/10 border border-green-500/50 text-green-400 px-4 py-3 rounded-lg mb-6">
                {{ session('message') }}
            </div>
        @endif

        <!-- Wizard Content -->
        <div class="bg-gray-800 rounded-lg p-8 shadow-lg border border-gray-700">
            <form wire:submit.prevent="saveProfile">
                @switch($currentStep)
                    @case(1)
                        {{-- Step 1: Career Goals --}}
                        <div class="space-y-6">
                            <h3 class="text-xl font-semibold text-white mb-4">Career Goals</h3>

                            <div>
                                <label for="targetJobTitle" class="block text-sm font-medium text-gray-300 mb-2">
                                    Target Job Title
                                </label>
                                <input type="text"
                                       wire:model="targetJobTitle"
                                       id="targetJobTitle"
                                       class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                       placeholder="e.g., Senior Software Engineer"
                                />
                                @error('targetJobTitle')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="industry" class="block text-sm font-medium text-gray-300 mb-2">
                                    Industry
                                </label>
                                <select wire:model="industry"
                                        id="industry"
                                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                    <option value="">Select an industry...</option>
                                    @foreach($industries as $ind)
                                        <option value="{{ $ind }}">{{ $ind }}</option>
                                    @endforeach
                                </select>
                                @error('industry')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="button"
                                        wire:click="nextStep"
                                        class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white font-medium py-3 px-8 rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/25">
                                    Next Step →
                                </button>
                            </div>
                        </div>
                        @break

                    @case(2)
                        {{-- Step 2: Skill Inventory --}}
                        <div class="space-y-6">
                            <h3 class="text-xl font-semibold text-white mb-4">Skill Inventory</h3>

                            <div>
                                <label for="yearsOfExperience" class="block text-sm font-medium text-gray-300 mb-2">
                                    Years of Experience
                                </label>
                                <input type="number"
                                       wire:model="yearsOfExperience"
                                       id="yearsOfExperience"
                                       min="0"
                                       max="60"
                                       class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                       placeholder="e.g., 5"
                                />
                                @error('yearsOfExperience')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    Tech Stack
                                </label>
                                <div class="flex gap-2">
                                    <input type="text"
                                           wire:model="currentSkill"
                                           wire:keydown.enter.prevent="addSkill"
                                           id="techStack"
                                           class="flex-1 bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                           placeholder="Type a skill and press Enter"
                                    />
                                    <button type="button"
                                            wire:click="addSkill"
                                            class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg transition-all duration-300">
                                        Add
                                    </button>
                                </div>
                                @error('currentSkill')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                                @error('techStack')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror

                                <!-- Suggested Skills -->
                                <div class="mt-3">
                                    <p class="text-xs text-gray-500 mb-2">Click to add suggested skills:</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($suggestedSkills as $skill)
                                            @if (!in_array($skill, $techStack))
                                                <button type="button"
                                                        wire:click="addSuggestedSkill('{{ $skill }}')"
                                                        class="text-xs bg-gray-700 hover:bg-gray-600 text-gray-300 hover:text-white px-3 py-1 rounded-full transition-all duration-200 border border-gray-600">
                                                    + {{ $skill }}
                                                </button>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Tags Display -->
                                @if(count($techStack) > 0)
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @foreach($techStack as $index => $skill)
                                            <span class="bg-purple-600/20 text-purple-300 px-3 py-1.5 rounded-full text-sm flex items-center gap-2 border border-purple-500/30">
                                                {{ $skill }}
                                                <button type="button"
                                                        wire:click="removeSkill({{ $index }})"
                                                        class="text-purple-300 hover:text-purple-100 transition-colors">
                                                    ×
                                                </button>
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="flex justify-between pt-4">
                                <button type="button"
                                        wire:click="previousStep"
                                        class="bg-gray-700 hover:bg-gray-600 text-white font-medium py-3 px-8 rounded-lg transition-all duration-300">
                                    ← Previous
                                </button>
                                <button type="button"
                                        wire:click="nextStep"
                                        class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white font-medium py-3 px-8 rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/25">
                                    Next Step →
                                </button>
                            </div>
                        </div>
                        @break

                    @case(3)
                        {{-- Step 3: Resume Upload --}}
                        <div class="space-y-6">
                            <h3 class="text-xl font-semibold text-white mb-4">Upload Your Resume</h3>

                            <div class="relative">
                                <div
                                    x-data="{
                                        isDragging: false,
                                        handleDrop(event) {
                                            event.preventDefault();
                                            this.isDragging = false;
                                            const file = event.dataTransfer.files[0];
                                            if (file) {
                                                if (file.type !== 'application/pdf') {
                                                    alert('Please upload a PDF file');
                                                    return;
                                                }
                                                if (file.size > 5 * 1024 * 1024) {
                                                    alert('File must be less than 5MB');
                                                    return;
                                                }
                                                @this.upload('resume', file);
                                            }
                                        }
                                    }"
                                    x-on:dragover.prevent="isDragging = true"
                                    x-on:dragleave.prevent="isDragging = false"
                                    x-on:drop.prevent="handleDrop"
                                    :class="{ 'border-purple-500 bg-purple-500/10': isDragging }"
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-600 border-dashed rounded-lg hover:border-purple-500 transition-all duration-300 cursor-pointer"
                                >
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-400">
                                            <label for="file-upload" class="relative cursor-pointer rounded-md font-medium text-purple-400 hover:text-purple-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-purple-500">
                                                <span>Upload a file</span>
                                                <input id="file-upload" type="file" class="sr-only" wire:model="resume" accept=".pdf">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PDF up to 5MB</p>
                                    </div>
                                </div>

                                <!-- Upload Progress -->
                                <div wire:loading wire:target="resume" class="mt-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 h-2 bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-purple-500 to-purple-700 rounded-full animate-pulse" style="width: 60%"></div>
                                        </div>
                                        <span class="text-sm text-gray-400">Uploading...</span>
                                    </div>
                                </div>

                                @if($resume)
                                    <div class="mt-4 p-4 bg-purple-500/10 border border-purple-500/30 rounded-lg flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span class="text-white">{{ $resume->getClientOriginalName() }}</span>
                                        </div>
                                        <span class="text-sm text-gray-400">{{ round($resume->getSize() / 1024) }} KB</span>
                                    </div>
                                @endif

                                @error('resume')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-between pt-4">
                                <button type="button"
                                        wire:click="previousStep"
                                        class="bg-gray-700 hover:bg-gray-600 text-white font-medium py-3 px-8 rounded-lg transition-all duration-300">
                                    ← Previous
                                </button>
                                <button type="submit"
                                        wire:loading.attr="disabled"
                                        class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white font-medium py-3 px-8 rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/25 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span wire:loading.remove wire:target="saveProfile">Complete Profile ✓</span>
                                    <span wire:loading wire:target="saveProfile" class="flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                        </svg>
                                        Saving...
                                    </span>
                                </button>
                            </div>
                        </div>
                        @break
                @endswitch
            </form>
        </div>
    </div>
</div>
