
<?php $__env->startSection('title', 'Kelola Booking'); ?>
<?php $__env->startSection('page-title', 'Semua Booking'); ?>

<?php $__env->startSection('content'); ?>


<div class="flex items-center justify-between mb-5 flex-wrap gap-3">
    <div>
        <p class="text-sm text-gray-500">
            Total <span class="font-semibold text-gray-900"><?php echo e($bookings->total()); ?></span> booking ditemukan
            <?php if(request()->hasAny(['search','status','date'])): ?>
                <a href="<?php echo e(route('admin.bookings.index')); ?>" class="ml-2 text-blue-600 hover:underline text-xs">(reset filter)</a>
            <?php endif; ?>
        </p>
    </div>
    <a href="<?php echo e(route('admin.bookings.create')); ?>" class="btn-primary btn-sm flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Booking
    </a>
</div>


<div class="card p-4 mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[180px]">
            <label class="form-label">Cari</label>
            <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                   class="form-input" placeholder="Kode booking, nama pelanggan, plat...">
        </div>
        <div class="min-w-[170px]">
            <label class="form-label">Status</label>
            <select name="status" class="form-input">
                <option value="">Semua Status</option>
                <?php $__currentLoopData = \App\Models\Booking::$statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($val); ?>" <?php echo e(request('status') == $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="min-w-[150px]">
            <label class="form-label">Tanggal Booking</label>
            <input type="date" name="date" value="<?php echo e(request('date')); ?>" class="form-input">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn-primary btn-sm h-9">Filter</button>
            <?php if(request()->hasAny(['search','status','date'])): ?>
            <a href="<?php echo e(route('admin.bookings.index')); ?>" class="btn-secondary btn-sm h-9">Reset</a>
            <?php endif; ?>
        </div>
    </form>
</div>


<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="table-th">No. Booking</th>
                    <th class="table-th">Pelanggan</th>
                    <th class="table-th">Paket Inspeksi</th>
                    <th class="table-th">Tanggal & Waktu</th>
                    <th class="table-th">Inspektor</th>
                    <th class="table-th">Status</th>
                    <th class="table-th">Keterangan</th>
                    <th class="table-th text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    
                    <td class="table-td">
                        <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>"
                           class="font-mono text-xs font-semibold text-blue-600 hover:underline">
                            <?php echo e($booking->booking_code); ?>

                        </a>
                        <p class="text-xs text-gray-400 mt-0.5"><?php echo e($booking->created_at->format('d M Y')); ?></p>
                    </td>

                    
                    <td class="table-td">
                        <p class="text-sm font-medium text-gray-900"><?php echo e($booking->user->name); ?></p>
                        <p class="text-xs text-gray-400"><?php echo e($booking->user->phone ?? $booking->user->email); ?></p>
                    </td>

                    
                    <td class="table-td">
                        <p class="text-sm text-gray-900"><?php echo e($booking->package->name); ?></p>
                        <p class="text-xs text-gray-400"><?php echo e($booking->vehicle->brand); ?> <?php echo e($booking->vehicle->model); ?> · <?php echo e($booking->vehicle->plate_number); ?></p>
                    </td>

                    
                    <td class="table-td whitespace-nowrap">
                        <p class="text-sm font-medium text-gray-900"><?php echo e($booking->booking_date->format('d M Y')); ?></p>
                        <p class="text-xs text-gray-400"><?php echo e(substr($booking->booking_time, 0, 5)); ?> WIB</p>
                    </td>

                    
                    <td class="table-td text-sm">
                        <?php if($booking->inspector): ?>
                            <p class="text-gray-900"><?php echo e($booking->inspector->name); ?></p>
                        <?php else: ?>
                            <span class="text-gray-300">—</span>
                        <?php endif; ?>
                    </td>

                    
                    <td class="table-td">
                        <span class="badge-<?php echo e($booking->status_color); ?>"><?php echo e($booking->status_label); ?></span>
                    </td>

                    
                    <td class="table-td max-w-[160px]">
                        <?php if($booking->notes): ?>
                            <p class="text-xs text-gray-500 truncate" title="<?php echo e($booking->notes); ?>"><?php echo e($booking->notes); ?></p>
                        <?php elseif($booking->cancellation_reason): ?>
                            <p class="text-xs text-red-400 truncate" title="<?php echo e($booking->cancellation_reason); ?>">
                                <?php echo e($booking->cancellation_reason); ?>

                            </p>
                        <?php else: ?>
                            <span class="text-gray-300 text-xs">—</span>
                        <?php endif; ?>
                    </td>

                    
                    <td class="table-td">
                        <div class="flex items-center gap-1 justify-center flex-wrap">
                            <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>"
                               class="btn-secondary btn-sm py-1 px-2.5 text-xs">Detail</a>

                            <?php if($booking->status === 'pending'): ?>
                            <form method="POST" action="<?php echo e(route('admin.bookings.confirm', $booking)); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                        class="btn-sm py-1 px-2.5 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors"
                                        title="Konfirmasi Booking">
                                    Konfirmasi
                                </button>
                            </form>
                            <?php elseif($booking->status === 'confirmed'): ?>
                            <form method="POST" action="<?php echo e(route('admin.bookings.start', $booking)); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                        class="btn-sm py-1 px-2.5 text-xs bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors"
                                        title="Mulai Layanan">
                                    Mulai
                                </button>
                            </form>
                            <?php elseif($booking->status === 'on_progress'): ?>
                            <form method="POST" action="<?php echo e(route('admin.bookings.complete', $booking)); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                        class="btn-sm py-1 px-2.5 text-xs bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors"
                                        title="Selesaikan">
                                    Selesai
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="py-16 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-gray-400 text-sm font-medium">Tidak ada booking ditemukan</p>
                        <?php if(request()->hasAny(['search','status','date'])): ?>
                        <p class="text-gray-400 text-xs mt-1">Coba ubah filter pencarian</p>
                        <?php endif; ?>
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web-inspeksi\web-inspeksi\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>