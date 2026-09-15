<?php $__env->startSection('title', 'Inspektor'); ?>
<?php $__env->startSection('page-title', 'Kelola Inspektor'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-5">
    <p class="text-sm text-gray-500"><?php echo e($inspectors->count()); ?> inspektor terdaftar</p>
    <a href="<?php echo e(route('admin.inspectors.create')); ?>" class="btn-primary btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Inspektor
    </a>
</div>

<div class="card overflow-hidden">
    <table class="w-full">
        <thead>
            <tr>
                <th class="table-th">Nama</th>
                <th class="table-th">Email</th>
                <th class="table-th">No. HP</th>
                <th class="table-th text-center">Total Tugas</th>
                <th class="table-th text-center">Selesai</th>
                <th class="table-th">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php $__empty_1 = true; $__currentLoopData = $inspectors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inspector): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="table-td">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm">
                            <?php echo e(strtoupper(substr($inspector->name, 0, 2))); ?>

                        </div>
                        <span class="font-medium text-gray-900"><?php echo e($inspector->name); ?></span>
                    </div>
                </td>
                <td class="table-td text-gray-500"><?php echo e($inspector->email); ?></td>
                <td class="table-td text-gray-500"><?php echo e($inspector->phone ?? '—'); ?></td>
                <td class="table-td text-center font-semibold"><?php echo e($inspector->assigned_bookings_count); ?></td>
                <td class="table-td text-center">
                    <span class="badge-green"><?php echo e($inspector->completed_count); ?></span>
                </td>
                <td class="table-td">
                    <div class="flex gap-2">
                        <a href="<?php echo e(route('admin.inspectors.edit', $inspector)); ?>" class="btn-secondary btn-sm">Edit</a>
                        <form method="POST" action="<?php echo e(route('admin.inspectors.destroy', $inspector)); ?>"
                              onsubmit="return confirm('Hapus inspektor ini?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" class="table-td text-center py-10 text-gray-400">
                    Belum ada inspektor.
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\inspeksi\resources\views/admin/inspectors/index.blade.php ENDPATH**/ ?>