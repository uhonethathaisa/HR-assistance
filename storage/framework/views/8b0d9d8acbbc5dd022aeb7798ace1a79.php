
<div>
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Work History</h1>
            <p class="text-sm text-gray-400 mt-0.5">Manage your professional experience</p>
        </div>
        <div class="flex items-center gap-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showForm && !$showImportForm && !$showPreview): ?>
                <button wire:click="showImport"
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white text-sm font-medium rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Import with AI
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showForm && !$showImportForm && !$showPreview): ?>
                <button wire:click="create"
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white text-sm font-medium rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Experience
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- ==== AI IMPORT SECTION (Standard HTTP Upload) ==== -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showImportForm && !$showPreview): ?>
    <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-white font-semibold">🤖 Import with AI</h3>
                <p class="text-sm text-gray-400">Upload your CV or resume to auto-fill work history</p>
            </div>
            <span class="text-xs text-purple-400 bg-purple-500/10 px-3 py-1 rounded-full border border-purple-500/20">Powered by DeepSeek</span>
        </div>

        <form id="import-form" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
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

            <button type="button" id="import-btn"
                    class="mt-4 w-full bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white font-medium py-3 rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40 disabled:opacity-50">
                🚀 Import with AI
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
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Preview Extracted Data -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showPreview && count($extractedData) > 0): ?>
    <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-white font-semibold">✨ Extracted Work History</h3>
                <p class="text-sm text-gray-400"><?php echo e(count($extractedData)); ?> entries found</p>
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
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $extractedData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="bg-[#1C1C1E] rounded-lg p-4 border border-[#2D2D30] hover:border-purple-500/30 transition-all duration-300">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3">
                            <span class="text-lg font-semibold text-white"><?php echo e($entry['company_name'] ?? 'Unknown Company'); ?></span>
                            <span class="text-sm text-purple-400"><?php echo e($entry['job_title'] ?? 'Position'); ?></span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($entry['is_current'] ?? false): ?>
                                <span class="px-2 py-0.5 text-xs bg-emerald-500/20 text-emerald-400 rounded-full">Current</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <p class="text-sm text-gray-400 mt-1">
                            <?php echo e($entry['location'] ?? ''); ?>

                            <?php echo e($entry['start_date'] ?? ''); ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($entry['start_date']) && !($entry['is_current'] ?? false)): ?>
                                → <?php echo e($entry['end_date'] ?? ''); ?>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($entry['is_current'] ?? false): ?>
                                → Present
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                        <p class="text-sm text-gray-300 mt-2"><?php echo e($entry['description'] ?? ''); ?></p>
                    </div>
                    <button wire:click="saveExtractedEntry(<?php echo e($index); ?>)"
                            class="ml-4 px-3 py-1.5 bg-purple-500/20 hover:bg-purple-500/30 text-purple-400 text-sm rounded-lg transition-all duration-300 flex-shrink-0">
                        Save Entry
                    </button>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Manual Entry Form -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showForm): ?>
    <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-white font-semibold"><?php echo e($editingId ? 'Edit Experience' : 'Add Experience'); ?></h3>
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Job Title *</label>
                    <input type="text" wire:model="job_title"
                           class="w-full bg-[#1C1C1E] border border-[#2D2D30] rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors"
                           placeholder="e.g. Software Engineer">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['job_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">End Date</label>
                    <input type="date" wire:model="end_date"
                           class="w-full bg-[#1C1C1E] border border-[#2D2D30] rounded-lg px-4 py-2.5 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors"
                           <?php if($is_current): ?> disabled <?php endif; ?>>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Description</label>
                <textarea wire:model="description" rows="4"
                          class="w-full bg-[#1C1C1E] border border-[#2D2D30] rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors resize-none"
                          placeholder="Describe your responsibilities and achievements..."></textarea>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="flex justify-end space-x-3 pt-2">
                <button type="button" wire:click="resetForm"
                        class="px-4 py-2 border border-[#2D2D30] text-gray-400 hover:text-white hover:border-purple-500 rounded-lg text-sm transition-all duration-300">
                    Cancel
                </button>
                <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white text-sm font-medium rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40">
                    <?php echo e($editingId ? 'Update' : 'Save'); ?>

                </button>
            </div>
        </form>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Work History List -->
    <div class="space-y-3">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $workHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $work): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-5 hover:border-purple-500/30 transition-all duration-300 group">
            <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm"><?php echo e(substr($work->company_name, 0, 1)); ?></span>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-white font-semibold truncate"><?php echo e($work->company_name); ?></h3>
                            <p class="text-sm text-purple-400"><?php echo e($work->job_title); ?></p>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($work->is_current): ?>
                            <span class="px-2 py-0.5 text-xs bg-emerald-500/20 text-emerald-400 rounded-full flex-shrink-0">Current</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="mt-2 flex items-center space-x-4 text-sm text-gray-400">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($work->location): ?>
                            <span class="flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <?php echo e($work->location); ?>

                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <span class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <?php echo e($work->start_date->format('M Y')); ?> - <?php echo e($work->is_current ? 'Present' : ($work->end_date ? $work->end_date->format('M Y') : '')); ?>

                        </span>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($work->description): ?>
                        <p class="mt-2 text-sm text-gray-300 line-clamp-2"><?php echo e($work->description); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="flex items-center space-x-2 ml-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <button wire:click="edit(<?php echo e($work->id); ?>)"
                            class="p-2 text-gray-400 hover:text-purple-400 hover:bg-purple-500/10 rounded-lg transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <button wire:click="delete(<?php echo e($work->id); ?>)"
                            wire:confirm="Are you sure you want to delete this entry?"
                            class="p-2 text-gray-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
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
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- Drag & Drop handler + Livewire event listener -->
    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file-upload');
            const importBtn = document.getElementById('import-btn');

            // Show file info when selected
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        document.getElementById('file-name').textContent = file.name;
                        document.getElementById('file-size').textContent = (file.size / 1024).toFixed(0) + ' KB';
                        document.getElementById('file-info').classList.remove('hidden');
                    }
                });
            }

            // Handle import button click
            if (importBtn) {
                importBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    if (!fileInput || !fileInput.files || !fileInput.files.length) {
                        alert('Please select a file first.');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('file', fileInput.files[0]);

                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (!csrfToken) {
                        alert('CSRF token not found. Please refresh the page.');
                        return;
                    }

                    // Show loading
                    importBtn.disabled = true;
                    importBtn.textContent = 'Processing...';
                    document.getElementById('import-loading').classList.remove('hidden');

                    fetch('<?php echo e(route('import.cv')); ?>', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken.content,
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Server error: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('loading-status').textContent = '✅ Import complete!';
                        if (data.success) {
                            // If Livewire is available, emit the event
                            if (window.Livewire) {
                                Livewire.emit('importCompleted', data.data);
                            } else {
                                // Fallback: reload page after a delay
                                alert('✅ ' + data.message + '\nReloading to show data.');
                                location.reload();
                            }
                        } else {
                            alert('❌ ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('loading-status').textContent = '❌ Error: ' + error.message;
                        alert('❌ Request failed. Check console for details.');
                    })
                    .finally(() => {
                        importBtn.disabled = false;
                        importBtn.textContent = '🚀 Import with AI';
                        // Hide loading after 2 seconds
                        setTimeout(() => {
                            document.getElementById('import-loading').classList.add('hidden');
                        }, 2000);
                    });
                });
            }

            // Reset file function (exposed globally)
            window.resetFile = function() {
                const fileInput = document.getElementById('file-upload');
                if (fileInput) {
                    fileInput.value = '';
                    document.getElementById('file-info').classList.add('hidden');
                }
            };

            // Drag and drop handler
            window.handleFileDrop = function(event) {
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
            };
        });
    </script>
    <?php $__env->stopPush(); ?>
</div><?php /**PATH /home/u952164533/domains/green-alligator-418959.hostingersite.com/public_html/resources/views/livewire/work-history.blade.php ENDPATH**/ ?>