
<div>
    <!-- Flash Messages -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
        <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-lg mb-4 flex items-center justify-between">
            <span><?php echo e(session('success')); ?></span>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-300">×</button>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('error')): ?>
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-4 flex items-center justify-between">
            <span><?php echo e(session('error')); ?></span>
            <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-300">×</button>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
        <div class="bg-blue-500/10 border border-blue-500/30 text-blue-400 px-4 py-3 rounded-lg mb-4 flex items-center justify-between">
            <span><?php echo e(session('message')); ?></span>
            <button onclick="this.parentElement.remove()" class="text-blue-400 hover:text-blue-300">×</button>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Work History & Skills Status -->
    <div class="rounded-2xl p-4 mb-6 flex items-start gap-4"
         style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.08), rgba(16, 185, 129, 0.02)); border: 1px solid rgba(16, 185, 129, 0.2);">
        <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center flex-shrink-0" style="border: 1px solid rgba(16, 185, 129, 0.2);">
            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-semibold text-emerald-400">
                        Profile Data: <?php echo e(count($experiences)); ?> Experiences, <?php echo e(count($skills)); ?> Skills
                    </h4>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Your work history and skills will be used to generate tailored cover letters
                    </p>
                </div>
                <a href="<?php echo e(route('work-history')); ?>"
                   class="text-xs text-purple-400 hover:text-purple-300 transition-colors underline underline-offset-2">
                    Manage Work History →
                </a>
            </div>
        </div>
    </div>

    <!-- Input Form -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showForm): ?>
        <div class="rounded-2xl p-6 mb-6 animate-slideDown" style="background: linear-gradient(135deg, #13131A, #0C0C0E); border: 1px solid #1C1C1E;">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-600/10 flex items-center justify-center" style="border: 1px solid rgba(59, 130, 246, 0.2);">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white"><?php echo e($editingId ? 'Edit Cover Letter' : 'Generate a New Cover Letter'); ?></h3>
                    <p class="text-sm text-gray-500"><?php echo e($editingId ? 'Update your cover letter' : 'Fill in the details to generate a tailored cover letter'); ?></p>
                </div>
            </div>

            <form wire:submit.prevent="generate" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Job Title *</label>
                        <input type="text" wire:model="jobTitle" placeholder="e.g. Senior Software Engineer"
                            class="w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2"
                            style="background: #1A1A1E; border: 1px solid #2D2D30; color: white; --tw-ring-color: rgba(139, 92, 246, 0.5);">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['jobTitle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-400 mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Company Name *</label>
                        <input type="text" wire:model="companyName" placeholder="e.g. Acme Corp"
                            class="w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2"
                            style="background: #1A1A1E; border: 1px solid #2D2D30; color: white; --tw-ring-color: rgba(139, 92, 246, 0.5);">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['companyName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-400 mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Job Description *</label>
                    <textarea wire:model="jobDescription" rows="6"
                        class="w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2 resize-none"
                        style="background: #1A1A1E; border: 1px solid #2D2D30; color: white; --tw-ring-color: rgba(139, 92, 246, 0.5);"
                        placeholder="Paste the full job description here..."></textarea>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['jobDescription'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-400 mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- File Upload -->
                <div>
                    <p class="text-sm text-gray-400 mb-2">or upload a job description file</p>
                    <div class="border-2 border-dashed border-[#2D2D30] rounded-lg p-4 text-center hover:border-purple-500/50 transition-all duration-300 cursor-pointer"
                         onclick="document.getElementById('cl-file-upload').click()"
                         ondrop="event.preventDefault(); this.classList.remove('border-purple-500', 'bg-purple-500/5')"
                         ondragover="event.preventDefault(); this.classList.add('border-purple-500', 'bg-purple-500/5')"
                         ondragleave="event.preventDefault(); this.classList.remove('border-purple-500', 'bg-purple-500/5')">

                        <input type="file"
                               id="cl-file-upload"
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['jobDescriptionFile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($jobDescriptionFile): ?>
                        <div class="mt-2 flex items-center space-x-2 text-emerald-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm"><?php echo e($jobDescriptionFile->getClientOriginalName()); ?></span>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Additional Notes -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Additional Notes (optional)</label>
                    <textarea wire:model="additionalNotes" rows="3"
                        class="w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2 resize-none"
                        style="background: #1A1A1E; border: 1px solid #2D2D30; color: white; --tw-ring-color: rgba(139, 92, 246, 0.5);"
                        placeholder="Any specific points you'd like to highlight..."></textarea>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                        wire:loading.attr="disabled"
                        class="px-6 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed"
                        style="background: linear-gradient(135deg, #8B5CF6, #7C3AED); color: white; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
                        <span wire:loading.remove>🚀 Generate Cover Letter</span>
                        <span wire:loading>⏳ Generating with AI...</span>
                    </button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($editingId): ?>
                        <button type="button" wire:click="resetForm"
                            class="px-6 py-2.5 text-sm font-medium rounded-xl transition-all duration-200"
                            style="background: #1A1A1E; border: 1px solid #2D2D30; color: #A1A1AA;">
                            Cancel
                        </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </form>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Generated Result -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showResult): ?>
        <div class="rounded-2xl p-6 mb-6 animate-slideDown" style="background: linear-gradient(135deg, #13131A, #0C0C0E); border: 1px solid #1C1C1E;">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500/20 to-emerald-600/10 flex items-center justify-center" style="border: 1px solid rgba(16, 185, 129, 0.2);">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Your Cover Letter</h3>
                        <p class="text-sm text-gray-500"><?php echo e($jobTitle); ?> at <?php echo e($companyName); ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button wire:click="save"
                        class="px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200 hover:-translate-y-0.5"
                        style="background: linear-gradient(135deg, #8B5CF6, #7C3AED); color: white; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
                        <?php echo e($editingId ? 'Update' : '💾 Save'); ?>

                    </button>
                    <button onclick="copyToClipboard()"
                        class="px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200 hover:-translate-y-0.5"
                        style="background: linear-gradient(135deg, #10B981, #059669); color: white; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                        📋 Copy
                    </button>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Customize your cover letter:</label>
                <textarea wire:model="customContent" rows="16" id="cover-letter-content"
                    class="w-full px-4 py-3 rounded-xl text-sm leading-relaxed transition-all duration-200 focus:outline-none focus:ring-2 resize-none"
                    style="background: #1A1A1E; border: 1px solid #2D2D30; color: #D4D4D8; font-family: 'SF Mono', 'Fira Code', monospace; --tw-ring-color: rgba(139, 92, 246, 0.5);"><?php echo e($customContent); ?></textarea>
            </div>

            <div class="flex items-center gap-3">
                <button wire:click="resetForm"
                    class="px-6 py-2.5 text-sm font-medium rounded-xl transition-all duration-200"
                    style="background: #1A1A1E; border: 1px solid #2D2D30; color: #A1A1AA;">
                    Start New
                </button>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Saved Cover Letters -->
    <div class="rounded-2xl p-6" style="background: linear-gradient(135deg, #13131A, #0C0C0E); border: 1px solid #1C1C1E;">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500/20 to-purple-600/10 flex items-center justify-center" style="border: 1px solid rgba(139, 92, 246, 0.2);">
                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white">Saved Cover Letters</h3>
                <p class="text-sm text-gray-500">Your generated and saved cover letters</p>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($coverLetters) > 0): ?>
            <div class="space-y-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $coverLetters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="flex items-center justify-between p-4 rounded-xl transition-all duration-200 hover:-translate-y-0.5"
                        style="background: #13131A; border: 1px solid #1C1C1E;">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm font-medium text-gray-300 truncate"><?php echo e($letter['job_title']); ?></p>
                                <span class="text-sm text-gray-500">at <?php echo e($letter['company_name']); ?></span>
                            </div>
                            <p class="text-xs text-gray-600 mt-1 ml-7"><?php echo e(\Carbon\Carbon::parse($letter['created_at'])->format('M d, Y H:i')); ?></p>
                        </div>
                        <div class="flex items-center gap-2 ml-4">
                            <span class="px-2.5 py-0.5 text-[10px] font-semibold rounded-full uppercase tracking-wider"
                                style="background: <?php echo e($letter['status'] === 'generated' ? 'rgba(16, 185, 129, 0.15)' : 'rgba(245, 158, 11, 0.15)'); ?>; color: <?php echo e($letter['status'] === 'generated' ? '#10B981' : '#F59E0B'); ?>; border: 1px solid <?php echo e($letter['status'] === 'generated' ? 'rgba(16, 185, 129, 0.2)' : 'rgba(245, 158, 11, 0.2)'); ?>;">
                                <?php echo e($letter['status']); ?>

                            </span>
                            <button wire:click="view(<?php echo e($letter['id']); ?>)"
                                class="p-2 rounded-lg transition-all duration-200 hover:scale-110"
                                style="color: #71717A;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                            <button wire:click="delete(<?php echo e($letter['id']); ?>)"
                                wire:confirm="Are you sure you want to delete this cover letter?"
                                class="p-2 rounded-lg transition-all duration-200 hover:scale-110"
                                style="color: #71717A;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500/10 to-blue-500/10 flex items-center justify-center mx-auto mb-4" style="border: 1px solid rgba(139, 92, 246, 0.1);">
                    <svg class="w-8 h-8 text-purple-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-gray-400 font-medium">No cover letters saved yet</p>
                <p class="text-sm text-gray-600 mt-1">Generate your first cover letter</p>
                <button wire:click="resetForm"
                    class="mt-4 px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200"
                    style="background: linear-gradient(135deg, #8B5CF6, #7C3AED); color: white;">
                    Generate Your First Letter
                </button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <style>
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
        }
    </style>

    <script>
        function copyToClipboard() {
            const textarea = document.getElementById('cover-letter-content');
            if (textarea) {
                textarea.select();
                navigator.clipboard.writeText(textarea.value).then(() => {
                    // Show a brief flash message
                    const btn = event.currentTarget;
                    const originalText = btn.textContent;
                    btn.textContent = '✅ Copied!';
                    setTimeout(() => { btn.textContent = originalText; }, 2000);
                });
            }
        }
    </script>
</div>
<?php /**PATH C:\Users\zee\Desktop\laravel-app\resources\views/livewire/cover-letter-optimizer.blade.php ENDPATH**/ ?>