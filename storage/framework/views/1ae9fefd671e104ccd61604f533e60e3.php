<?php $__env->startSection('title', 'Item Checklist'); ?>
<?php $__env->startSection('page-title', 'Kelola Item Checklist'); ?>

<?php $__env->startSection('content'); ?>
<div class="grid lg:grid-cols-3 gap-6">

    
    <div class="card p-5">
        <h2 class="font-semibold text-gray-900 mb-4">Tambah Item Baru</h2>
        <form method="POST" action="<?php echo e(route('admin.checklist.store')); ?>" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <label class="form-label">Paket <span class="text-red-500">*</span></label>
                <select name="package_id" class="form-input <?php $__errorArgs = ['package_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <option value="">Pilih Paket</option>
                    <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($pkg->id); ?>" <?php echo e(old('package_id') == $pkg->id ? 'selected' : ''); ?>>
                        <?php echo e($pkg->name); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['package_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="form-label">Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="category" value="<?php echo e(old('category')); ?>"
                       class="form-input <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       placeholder="mis. Mesin, Rem, Ban..." list="categories" required>
                <datalist id="categories">
                    <option value="Mesin"><option value="Rem"><option value="Ban">
                    <option value="Transmisi"><option value="Kelistrikan"><option value="AC">
                    <option value="Kaki-Kaki"><option value="Body & Cat"><option value="Interior">
                    <option value="Kolong"><option value="Diagnostik">
                </datalist>
                <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="form-label">Nama Item <span class="text-red-500">*</span></label>
                <input type="text" name="item_name" value="<?php echo e(old('item_name')); ?>"
                       class="form-input <?php $__errorArgs = ['item_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       placeholder="mis. Kampas Rem Depan" required>
                <?php $__errorArgs = ['item_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="form-label">Urutan</label>
                <input type="number" name="sort_order" value="<?php echo e(old('sort_order', 0)); ?>"
                       class="form-input" min="0">
            </div>
            <button type="submit" class="btn-primary w-full justify-center">Tambah Item</button>
        </form>
    </div>

    
    <div class="lg:col-span-2 space-y-5">
        <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card overflow-hidden">
            <div class="px-5 py-3 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-900"><?php echo e($package->name); ?></h3>
                    <p class="text-xs text-gray-400"><?php echo e($package->checklistItems->count()); ?> item</p>
                </div>
            </div>

            <?php if($package->checklistItems->isEmpty()): ?>
            <p class="px-5 py-4 text-sm text-gray-400">Belum ada item untuk paket ini.</p>
            <?php else: ?>
            <div class="divide-y divide-gray-50">
                <?php $__currentLoopData = $package->checklistItems->groupBy('category'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="px-5 py-3">
                    <p class="text-xs font-bold text-gray-400 uppercase mb-2"><?php echo e($category); ?></p>
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center gap-3 py-1.5 group"
                         x-data="{ editing: false }">
                        <span class="text-gray-400 text-xs w-5"><?php echo e($item->sort_order); ?></span>

                        <div x-show="!editing" class="flex-1 text-sm text-gray-700"><?php echo e($item->item_name); ?></div>

                        <form x-show="editing" method="POST"
                              action="<?php echo e(route('admin.checklist.update', $item)); ?>"
                              class="flex-1 flex gap-2 items-center">
                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                            <input type="text" name="item_name" value="<?php echo e($item->item_name); ?>"
                                   class="form-input text-xs py-1 flex-1">
                            <input type="text" name="category" value="<?php echo e($item->category); ?>"
                                   class="form-input text-xs py-1 w-28">
                            <input type="number" name="sort_order" value="<?php echo e($item->sort_order); ?>"
                                   class="form-input text-xs py-1 w-14">
                            <button type="submit" class="text-green-600 hover:text-green-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        </form>

                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="editing = !editing" class="text-blue-500 hover:text-blue-700">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <form method="POST" action="<?php echo e(route('admin.checklist.destroy', $item)); ?>"
                                  onsubmit="return confirm('Hapus item ini?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-400 hover:text-red-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\inspeksi\resources\views/admin/checklist/index.blade.php ENDPATH**/ ?>