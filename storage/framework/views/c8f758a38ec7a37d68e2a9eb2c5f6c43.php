<?php $__env->startSection('title', 'Hasil Inspeksi'); ?>
<?php $__env->startSection('page-title', 'Hasil Inspeksi'); ?>

<?php $__env->startSection('content'); ?>

<div class="flex items-center justify-between mb-5 flex-wrap gap-3">
    <p class="text-sm text-gray-500">
        Total <span class="font-semibold text-gray-900"><?php echo e($results->total()); ?></span> laporan inspeksi
        <?php if(request()->hasAny(['search','date'])): ?>
            <a href="<?php echo e(route('admin.results.index')); ?>" class="ml-2 text-blue-600 hover:underline text-xs">(reset filter)</a>
        <?php endif; ?>
    </p>
</div>


<div class="card p-4 mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="form-label">Cari</label>
            <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                   class="form-input" placeholder="Kode booking, nama pelanggan, plat...">
        </div>
        <div class="min-w-[160px]">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" name="date" value="<?php echo e(request('date')); ?>" class="form-input">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn-primary btn-sm h-9">Filter</button>
            <?php if(request()->hasAny(['search','date'])): ?>
            <a href="<?php echo e(route('admin.results.index')); ?>" class="btn-secondary btn-sm h-9">Reset</a>
            <?php endif; ?>
        </div>
    </form>
</div>


<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="table-th">Booking</th>
                    <th class="table-th">Pelanggan</th>
                    <th class="table-th">Kendaraan</th>
                    <th class="table-th">Paket</th>
                    <th class="table-th">Inspektor</th>
                    <th class="table-th text-center">Hasil</th>
                    <th class="table-th">Tgl Selesai</th>
                    <th class="table-th text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php $booking = $result->booking; ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="table-td">
                        <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>"
                           class="font-mono text-xs font-semibold text-blue-600 hover:underline">
                            <?php echo e($booking->booking_code); ?>

                        </a>
                    </td>
                    <td class="table-td text-sm">
                        <p class="font-medium text-gray-900"><?php echo e($booking->user->name); ?></p>
                        <p class="text-xs text-gray-400"><?php echo e($booking->user->phone ?? $booking->user->email); ?></p>
                    </td>
                    <td class="table-td text-sm">
                        <p class="text-gray-900"><?php echo e($booking->vehicle->brand); ?> <?php echo e($booking->vehicle->model); ?></p>
                        <p class="text-xs font-mono text-gray-400"><?php echo e($booking->vehicle->plate_number); ?></p>
                    </td>
                    <td class="table-td text-sm text-gray-700">
                        <?php echo e($booking->package->name); ?>

                    </td>
                    <td class="table-td text-sm text-gray-700">
                        <?php echo e($booking->inspector?->name ?? '—'); ?>

                    </td>
                    
                    <td class="table-td">
                        <div class="flex items-center justify-center gap-2 text-xs font-semibold">
                            <span class="flex items-center gap-1 text-green-700 bg-green-50 px-2 py-0.5 rounded-full">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                <?php echo e($result->ok_count); ?>

                            </span>
                            <span class="flex items-center gap-1 text-yellow-700 bg-yellow-50 px-2 py-0.5 rounded-full">
                                <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full"></span>
                                <?php echo e($result->warning_count); ?>

                            </span>
                            <span class="flex items-center gap-1 text-red-700 bg-red-50 px-2 py-0.5 rounded-full">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                <?php echo e($result->bad_count); ?>

                            </span>
                        </div>
                    </td>
                    <td class="table-td text-sm text-gray-600 whitespace-nowrap">
                        <?php echo e($result->completed_at?->format('d M Y') ?? '-'); ?>

                    </td>
                    <td class="table-td text-center">
                        <a href="<?php echo e(route('admin.results.show', $booking)); ?>"
                           class="btn-primary btn-sm py-1 px-3 text-xs inline-flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Lihat Laporan
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="py-16 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-400 text-sm font-medium">Belum ada hasil inspeksi</p>
                        <p class="text-gray-400 text-xs mt-1">Hasil inspeksi akan muncul di sini setelah diinput dari halaman detail booking.</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($results->hasPages()): ?>
    <div class="px-5 py-4 border-t border-gray-100">
        <?php echo e($results->links()); ?>

    </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web-inspeksi\web-inspeksi\resources\views/admin/results/index.blade.php ENDPATH**/ ?>