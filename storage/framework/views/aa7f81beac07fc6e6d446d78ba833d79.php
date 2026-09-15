<?php $__env->startSection('title', 'Kelola Booking'); ?>
<?php $__env->startSection('page-title', 'Kelola Booking'); ?>

<?php $__env->startSection('content'); ?>

<div class="card p-4 mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="form-label">Cari</label>
            <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                   class="form-input" placeholder="Kode booking, nama, plat...">
        </div>
        <div class="min-w-[160px]">
            <label class="form-label">Status</label>
            <select name="status" class="form-input">
                <option value="">Semua Status</option>
                <?php $__currentLoopData = \App\Models\Booking::$statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($val); ?>" <?php echo e(request('status') == $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="min-w-[160px]">
            <label class="form-label">Tanggal</label>
            <input type="date" name="date" value="<?php echo e(request('date')); ?>" class="form-input">
        </div>
        <button type="submit" class="btn-primary btn-sm h-9">Filter</button>
        <?php if(request()->hasAny(['search','status','date'])): ?>
        <a href="<?php echo e(route('admin.bookings.index')); ?>" class="btn-secondary btn-sm h-9">Reset</a>
        <?php endif; ?>
    </form>
</div>


<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="table-th">Kode</th>
                    <th class="table-th">Customer</th>
                    <th class="table-th">Kendaraan</th>
                    <th class="table-th">Paket</th>
                    <th class="table-th">Jadwal</th>
                    <th class="table-th">Inspektor</th>
                    <th class="table-th">Status</th>
                    <th class="table-th">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="table-td">
                        <span class="font-mono text-xs font-semibold text-gray-900"><?php echo e($booking->booking_code); ?></span>
                    </td>
                    <td class="table-td">
                        <p class="font-medium text-gray-900 text-sm"><?php echo e($booking->user->name); ?></p>
                        <p class="text-xs text-gray-400"><?php echo e($booking->user->phone); ?></p>
                    </td>
                    <td class="table-td">
                        <p class="text-sm text-gray-900"><?php echo e($booking->vehicle->brand); ?> <?php echo e($booking->vehicle->model); ?></p>
                        <p class="text-xs text-gray-400"><?php echo e($booking->vehicle->plate_number); ?></p>
                    </td>
                    <td class="table-td text-sm"><?php echo e($booking->package->name); ?></td>
                    <td class="table-td">
                        <p class="text-sm font-medium"><?php echo e($booking->booking_date->format('d M Y')); ?></p>
                        <p class="text-xs text-gray-400"><?php echo e(substr($booking->booking_time, 0, 5)); ?> WIB</p>
                    </td>
                    <td class="table-td text-sm text-gray-500">
                        <?php echo e($booking->inspector?->name ?? '—'); ?>

                    </td>
                    <td class="table-td">
                        <span class="badge-<?php echo e($booking->status_color); ?>"><?php echo e($booking->status_label); ?></span>
                    </td>
                    <td class="table-td">
                        <div class="flex items-center gap-1">
                            <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>"
                               class="btn-secondary btn-sm py-1 px-2.5">Detail</a>

                            <?php if($booking->status === 'pending'): ?>
                            <form method="POST" action="<?php echo e(route('admin.bookings.confirm', $booking)); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn-success btn-sm py-1 px-2.5" title="Konfirmasi">✓</button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="table-td text-center text-gray-400 py-10">
                        Tidak ada booking ditemukan.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($bookings->hasPages()): ?>
    <div class="px-5 py-4 border-t border-gray-100">
        <?php echo e($bookings->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\inspeksi\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>