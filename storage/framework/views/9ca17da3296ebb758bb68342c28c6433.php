<div>
    <div class="max-w-4xl mx-auto">
        <!-- Flash Messages -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($successMessage): ?>
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-lg mb-6 flex items-center justify-between animate-slideDown">
                <span><?php echo e($successMessage); ?></span>
                <button wire:click="$set('successMessage', '')" class="text-emerald-400 hover:text-emerald-300">×</button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errorMessage): ?>
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6 flex items-center justify-between animate-slideDown">
                <span><?php echo e($errorMessage); ?></span>
                <button wire:click="$set('errorMessage', '')" class="text-red-400 hover:text-red-300">×</button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Account Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500/20 to-purple-700/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Account Status</p>
                        <p class="text-sm font-semibold text-emerald-400">Active</p>
                    </div>
                </div>
            </div>
            <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-700/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Email</p>
                        <p class="text-sm font-semibold text-white">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasVerifiedEmail()): ?>
                                <span class="text-emerald-400">Verified</span>
                            <?php else: ?>
                                <span class="text-amber-400">Unverified</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-500/20 to-cyan-700/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Member Since</p>
                        <p class="text-sm font-semibold text-white"><?php echo e(auth()->user()->created_at->format('M Y')); ?></p>
                    </div>
                </div>
            </div>
            <div class="bg-[#13131A] border border-[#1C1C1E] rounded-xl p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500/20 to-amber-700/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Auth Method</p>
                        <p class="text-sm font-semibold text-white"><?php echo e(auth()->user()->provider ? ucfirst(auth()->user()->provider) : 'Email'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="flex flex-wrap gap-1 mb-8 p-1 rounded-xl" style="background: #13131A; border: 1px solid #1C1C1E;">
            <?php
                $tabs = [
                    'profile' => ['label' => 'Profile', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                    'security' => ['label' => 'Security', 'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
                    'notifications' => ['label' => 'Notifications', 'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
                    'preferences' => ['label' => 'Preferences', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                    'danger' => ['label' => 'Danger Zone', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z'],
                ];
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <button wire:click="switchTab('<?php echo e($key); ?>')"
                    class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                    <?php echo e($activeTab === $key ? 'bg-purple-500/15 text-purple-400 shadow-sm' : 'text-gray-400 hover:text-gray-300 hover:bg-[#1C1C1E]'); ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($tab['icon']); ?>"/>
                    </svg>
                    <?php echo e($tab['label']); ?>

                </button>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>


        <!-- ============================================ -->
        <!-- TAB 1: PROFILE SETTINGS -->
        <!-- ============================================ -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'profile'): ?>
            <div class="space-y-6">
                <!-- Avatar Section -->
                <div class="rounded-2xl p-6" style="background: linear-gradient(135deg, #13131A, #0C0C0E); border: 1px solid #1C1C1E;">
                    <h3 class="text-lg font-semibold text-white mb-6">Profile Photo</h3>
                    <div class="flex items-center gap-6">
                        <div class="relative group">
                            <div class="w-24 h-24 rounded-2xl overflow-hidden"
                                 style="background: #1A1A1E; border: 2px solid #2D2D30;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->avatar_url): ?>
                                    <img src="<?php echo e(auth()->user()->avatar_url); ?>" alt="Avatar"
                                         class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="text-3xl font-bold text-purple-400">
                                            <?php echo e(strtoupper(substr(auth()->user()->name, 0, 2))); ?>

                                        </span>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->avatar): ?>
                                <button wire:click="removeAvatar"
                                    class="absolute -top-2 -right-2 w-6 h-6 bg-red-500/80 rounded-full flex items-center justify-center hover:bg-red-500 transition-colors opacity-0 group-hover:opacity-100">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-300 mb-2">Upload a new photo</p>
                            <label class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium cursor-pointer transition-all duration-200 hover:-translate-y-0.5"
                                   style="background: linear-gradient(135deg, #8B5CF6, #7C3AED); color: white;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Choose Photo
                                <input type="file" wire:model="tempAvatar" class="hidden" accept="image/*">
                            </label>
                            <p class="text-xs text-gray-500 mt-2">JPG, PNG or GIF. Max 2MB.</p>
                            <div wire:loading wire:target="tempAvatar" class="text-xs text-purple-400 mt-1">Uploading...</div>
                        </div>
                    </div>
                </div>

                <!-- Profile Information -->
                <div class="rounded-2xl p-6" style="background: linear-gradient(135deg, #13131A, #0C0C0E); border: 1px solid #1C1C1E;">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500/20 to-purple-600/10 flex items-center justify-center" style="border: 1px solid rgba(139, 92, 246, 0.2);">
                            <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Profile Information</h3>
                            <p class="text-sm text-gray-500">Update your personal details</p>
                        </div>
                    </div>

                    <form wire:submit.prevent="updateProfile" class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Full Name *</label>
                                <input type="text" wire:model="name"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2"
                                    style="background: #1A1A1E; border: 1px solid #2D2D30; color: white; --tw-ring-color: rgba(139, 92, 246, 0.5);">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-400 mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Email *</label>
                                <input type="email" wire:model="email"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2"
                                    style="background: #1A1A1E; border: 1px solid #2D2D30; color: white; --tw-ring-color: rgba(139, 92, 246, 0.5);">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-400 mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Phone</label>
                                <input type="tel" wire:model="phone" placeholder="+1 (555) 123-4567"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2"
                                    style="background: #1A1A1E; border: 1px solid #2D2D30; color: white; --tw-ring-color: rgba(139, 92, 246, 0.5);">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Job Title</label>
                                <input type="text" wire:model="job_title" placeholder="e.g. Senior Software Engineer"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2"
                                    style="background: #1A1A1E; border: 1px solid #2D2D30; color: white; --tw-ring-color: rgba(139, 92, 246, 0.5);">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Company</label>
                                <input type="text" wire:model="company" placeholder="e.g. Acme Corp"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2"
                                    style="background: #1A1A1E; border: 1px solid #2D2D30; color: white; --tw-ring-color: rgba(139, 92, 246, 0.5);">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Location</label>
                                <input type="text" wire:model="location" placeholder="e.g. San Francisco, CA"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2"
                                    style="background: #1A1A1E; border: 1px solid #2D2D30; color: white; --tw-ring-color: rgba(139, 92, 246, 0.5);">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Professional Summary / Bio</label>
                            <textarea wire:model="bio" rows="4"
                                class="w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2 resize-none"
                                style="background: #1A1A1E; border: 1px solid #2D2D30; color: white; --tw-ring-color: rgba(139, 92, 246, 0.5);"
                                placeholder="Tell us about yourself..."></textarea>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-400 mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit"
                                wire:loading.attr="disabled"
                                class="px-6 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 hover:-translate-y-0.5 disabled:opacity-50"
                                style="background: linear-gradient(135deg, #8B5CF6, #7C3AED); color: white; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
                                <span wire:loading.remove>💾 Save Changes</span>
                                <span wire:loading>Saving...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        <!-- ============================================ -->
        <!-- TAB 2: ACCOUNT SECURITY -->
        <!-- ============================================ -->
        <?php elseif($activeTab === 'security'): ?>
            <div class="space-y-6">
                <!-- Change Password -->
                <div class="rounded-2xl p-6" style="background: linear-gradient(135deg, #13131A, #0C0C0E); border: 1px solid #1C1C1E;">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500/20 to-amber-600/10 flex items-center justify-center" style="border: 1px solid rgba(245, 158, 11, 0.2);">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Change Password</h3>
                            <p class="text-sm text-gray-500">Update your account password</p>
                        </div>
                    </div>

                    <form wire:submit.prevent="updatePassword" class="space-y-4 max-w-md">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Current Password</label>
                            <input type="password" wire:model="current_password"
                                class="w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2"
                                style="background: #1A1A1E; border: 1px solid #2D2D30; color: white; --tw-ring-color: rgba(139, 92, 246, 0.5);">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-400 mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">New Password</label>
                            <input type="password" wire:model="new_password"
                                class="w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2"
                                style="background: #1A1A1E; border: 1px solid #2D2D30; color: white; --tw-ring-color: rgba(139, 92, 246, 0.5);">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-400 mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Confirm New Password</label>
                            <input type="password" wire:model="new_password_confirmation"
                                class="w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2"
                                style="background: #1A1A1E; border: 1px solid #2D2D30; color: white; --tw-ring-color: rgba(139, 92, 246, 0.5);">
                        </div>
                        <button type="submit"
                            wire:loading.attr="disabled"
                            class="px-6 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 hover:-translate-y-0.5 disabled:opacity-50"
                            style="background: linear-gradient(135deg, #8B5CF6, #7C3AED); color: white; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
                            <span wire:loading.remove>🔒 Update Password</span>
                            <span wire:loading>Updating...</span>
                        </button>
                    </form>
                </div>

                <!-- Email Verification -->
                <div class="rounded-2xl p-6" style="background: linear-gradient(135deg, #13131A, #0C0C0E); border: 1px solid #1C1C1E;">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-600/10 flex items-center justify-center" style="border: 1px solid rgba(59, 130, 246, 0.2);">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Email Verification</h3>
                            <p class="text-sm text-gray-500">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasVerifiedEmail()): ?>
                                    <span class="text-emerald-400">✓ Your email is verified</span>
                                <?php else: ?>
                                    <span class="text-amber-400">⚠ Your email is not verified</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (! (auth()->user()->hasVerifiedEmail())): ?>
                        <button wire:click="resendVerification"
                            class="px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200"
                            style="background: #1A1A1E; border: 1px solid #2D2D30; color: #A1A1AA;">
                            Resend Verification Email
                        </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Active Sessions -->
                <div class="rounded-2xl p-6" style="background: linear-gradient(135deg, #13131A, #0C0C0E); border: 1px solid #1C1C1E;">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-500/20 to-cyan-600/10 flex items-center justify-center" style="border: 1px solid rgba(6, 182, 212, 0.2);">
                            <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Active Sessions</h3>
                            <p class="text-sm text-gray-500">Manage your active sessions</p>
                        </div>
                    </div>
                    <button wire:click="logoutOtherDevices"
                        class="px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200 hover:-translate-y-0.5"
                        style="background: linear-gradient(135deg, #F59E0B, #D97706); color: white;">
                        🚪 Logout Other Devices
                    </button>
                    <p class="text-xs text-gray-500 mt-2">This will log out all other sessions except this one.</p>
                </div>
            </div>

        <!-- ============================================ -->
        <!-- TAB 3: NOTIFICATIONS -->
        <!-- ============================================ -->
        <?php elseif($activeTab === 'notifications'): ?>
            <div class="rounded-2xl p-6" style="background: linear-gradient(135deg, #13131A, #0C0C0E); border: 1px solid #1C1C1E;">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500/20 to-emerald-600/10 flex items-center justify-center" style="border: 1px solid rgba(16, 185, 129, 0.2);">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Notification Preferences</h3>
                        <p class="text-sm text-gray-500">Choose what notifications you receive</p>
                    </div>
                </div>

                <form wire:submit.prevent="saveNotifications" class="space-y-4">
                    <?php
                        $notificationOptions = [
                            'notify_cv_updates' => ['label' => 'CV Optimization Updates', 'desc' => 'Get notified when your CV optimization is complete'],
                            'notify_cover_letters' => ['label' => 'Cover Letters', 'desc' => 'Receive updates about your generated cover letters'],
                            'notify_marketing' => ['label' => 'Marketing Emails', 'desc' => 'Tips, tricks, and product updates'],
                            'notify_security' => ['label' => 'Security Alerts', 'desc' => 'Important security notifications about your account'],
                            'notify_in_app' => ['label' => 'In-App Notifications', 'desc' => 'Notifications within the dashboard'],
                        ];
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $notificationOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="flex items-center justify-between py-3 px-4 rounded-xl" style="background: #1A1A1E; border: 1px solid #2D2D30;">
                            <div>
                                <p class="text-sm font-medium text-gray-200"><?php echo e($opt['label']); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e($opt['desc']); ?></p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="<?php echo e($field); ?>" class="sr-only peer">
                                <div class="w-11 h-6 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"
                                    style="background: #2D2D30; peer-checked:background: linear-gradient(135deg, #8B5CF6, #7C3AED);">
                                </div>
                            </label>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                    <button type="submit"
                        wire:loading.attr="disabled"
                        class="px-6 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 hover:-translate-y-0.5 disabled:opacity-50"
                        style="background: linear-gradient(135deg, #8B5CF6, #7C3AED); color: white; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
                        <span wire:loading.remove>💾 Save Notification Preferences</span>
                        <span wire:loading>Saving...</span>
                    </button>
                </form>
            </div>

        <!-- ============================================ -->
        <!-- TAB 4: PREFERENCES -->
        <!-- ============================================ -->
        <?php elseif($activeTab === 'preferences'): ?>
            <div class="space-y-6">
                <!-- Application Preferences -->
                <div class="rounded-2xl p-6" style="background: linear-gradient(135deg, #13131A, #0C0C0E); border: 1px solid #1C1C1E;">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500/20 to-purple-600/10 flex items-center justify-center" style="border: 1px solid rgba(139, 92, 246, 0.2);">
                            <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Application Preferences</h3>
                            <p class="text-sm text-gray-500">Customize your experience</p>
                        </div>
                    </div>

                    <form wire:submit.prevent="savePreferences" class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Theme</label>
                                <select wire:model="theme"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2"
                                    style="background: #1A1A1E; border: 1px solid #2D2D30; color: white; --tw-ring-color: rgba(139, 92, 246, 0.5);">
                                    <option value="dark">Dark</option>
                                    <option value="light">Light</option>
                                    <option value="system">System</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Timezone</label>
                                <select wire:model="timezone"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2"
                                    style="background: #1A1A1E; border: 1px solid #2D2D30; color: white; --tw-ring-color: rgba(139, 92, 246, 0.5);">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = timezone_identifiers_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <option value="<?php echo e($tz); ?>"><?php echo e($tz); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Language</label>
                                <select wire:model="locale"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2"
                                    style="background: #1A1A1E; border: 1px solid #2D2D30; color: white; --tw-ring-color: rgba(139, 92, 246, 0.5);">
                                    <option value="en">English</option>
                                    <option value="es">Español</option>
                                    <option value="fr">Français</option>
                                    <option value="de">Deutsch</option>
                                </select>
                            </div>
                        </div>

                        <!-- Privacy Settings -->
                        <div class="pt-4 border-t border-[#1C1C1E]">
                            <h4 class="text-sm font-semibold text-white mb-4">Privacy Settings</h4>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Profile Visibility</label>
                                    <select wire:model="profile_visibility"
                                        class="w-full px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2"
                                        style="background: #1A1A1E; border: 1px solid #2D2D30; color: white; --tw-ring-color: rgba(139, 92, 246, 0.5);">
                                    <option value="public">Public</option>
                                    <option value="private">Private</option>
                                    <option value="connections">Connections Only</option>
                                </select>
                            </div>
                            <div class="flex items-center justify-between py-3 px-4 rounded-xl" style="background: #1A1A1E; border: 1px solid #2D2D30;">
                                <div>
                                    <p class="text-sm font-medium text-gray-200">Data Sharing</p>
                                    <p class="text-xs text-gray-500">Allow us to use your data to improve our AI models</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="data_sharing" class="sr-only peer">
                                    <div class="w-11 h-6 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"
                                        style="background: #2D2D30; peer-checked:background: linear-gradient(135deg, #8B5CF6, #7C3AED);">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Data Export -->
                    <div class="pt-4 border-t border-[#1C1C1E]">
                        <h4 class="text-sm font-semibold text-white mb-4">Download Your Data</h4>
                        <p class="text-sm text-gray-400 mb-3">Export all your data in JSON format (GDPR compliant)</p>
                        <a href="<?php echo e(route('settings.export')); ?>"
                           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200 hover:-translate-y-0.5"
                           style="background: #1A1A1E; border: 1px solid #2D2D30; color: #A1A1AA;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Export My Data
                        </a>
                    </div>

                    <div class="flex items-center gap-3 pt-4">
                        <button type="submit"
                            wire:loading.attr="disabled"
                            class="px-6 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 hover:-translate-y-0.5 disabled:opacity-50"
                            style="background: linear-gradient(135deg, #8B5CF6, #7C3AED); color: white; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
                            <span wire:loading.remove>💾 Save Preferences</span>
                            <span wire:loading>Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- TAB 5: DANGER ZONE -->
        <!-- ============================================ -->
        <?php elseif($activeTab === 'danger'): ?>
            <div class="space-y-6">
                <!-- Deactivate Account -->
                <div class="rounded-2xl p-6" style="background: linear-gradient(135deg, #13131A, #0C0C0E); border: 1px solid rgba(239, 68, 68, 0.2);">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500/20 to-amber-600/10 flex items-center justify-center" style="border: 1px solid rgba(245, 158, 11, 0.2);">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 12H4m16 0l-4-4m4 4l-4 4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Deactivate Account</h3>
                            <p class="text-sm text-gray-500">Temporarily disable your account</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-400 mb-4">Your data will be preserved and you can reactivate by logging back in.</p>
                    <div class="flex items-center gap-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="deactivateConfirm" class="rounded bg-[#1A1A1E] border-[#2D2D30] text-purple-500 focus:ring-purple-500">
                            <span class="text-sm text-gray-300">I understand and want to deactivate</span>
                        </label>
                        <button wire:click="deactivateAccount"
                            wire:loading.attr="disabled"
                            class="px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200 disabled:opacity-50"
                            style="background: #1A1A1E; border: 1px solid #F59E0B; color: #F59E0B;">
                            Deactivate
                        </button>
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="rounded-2xl p-6" style="background: linear-gradient(135deg, #13131A, #0C0C0E); border: 1px solid rgba(239, 68, 68, 0.3);">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-500/20 to-red-600/10 flex items-center justify-center" style="border: 1px solid rgba(239, 68, 68, 0.2);">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-red-400">Delete Account</h3>
                            <p class="text-sm text-gray-500">Permanently delete your account and all data</p>
                        </div>
                    </div>
                    <div class="bg-red-500/5 border border-red-500/20 rounded-xl p-4 mb-4">
                        <p class="text-sm text-red-300">
                            <strong>Warning:</strong> This action is irreversible. All your data including work history,
                            CV optimizations, cover letters, and preferences will be permanently deleted.
                        </p>
                    </div>
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">
                            Type <span class="text-red-400 font-bold">DELETE</span> to confirm
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="text" wire:model="deleteConfirmText" placeholder="Type DELETE here"
                                class="flex-1 px-4 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2"
                                style="background: #1A1A1E; border: 1px solid rgba(239, 68, 68, 0.3); color: white; --tw-ring-color: rgba(239, 68, 68, 0.5);">
                            <button wire:click="deleteAccount"
                                wire:loading.attr="disabled"
                                class="px-6 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 hover:-translate-y-0.5 disabled:opacity-50"
                                style="background: linear-gradient(135deg, #EF4444, #DC2626); color: white; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);">
                                <span wire:loading.remove>🗑 Delete My Account</span>
                                <span wire:loading>Deleting...</span>
                            </button>
                        </div>
                    </div>
                </div>
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
        /* Custom toggle switch */
        .peer:checked ~ div {
            background: linear-gradient(135deg, #8B5CF6, #7C3AED) !important;
        }
    </style>
</div>
<?php /**PATH C:\Users\zee\Desktop\laravel-app\resources\views/livewire/settings.blade.php ENDPATH**/ ?>