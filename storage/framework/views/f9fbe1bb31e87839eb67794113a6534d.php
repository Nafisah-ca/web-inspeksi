
<?php $__env->startSection('title', 'Dashboard Admin'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>


<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
    <?php $__currentLoopData = [
        ['Menunggu Konfirmasi', $stats['pending'],     'yellow', 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',    'pending'],
        ['Dikonfirmasi',        $stats['confirmed'],   'blue',   'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',           'confirmed'],
        ['Sedang Dilayani',     $stats['on_progress'], 'indigo', 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'on_progress'],
        ['Selesai',             $stats['completed'],   'green',  'M5 13l4 4L19 7',                                           'completed'],
        ['Dibatalkan',          $stats['cancelled'],   'red',    'M6 18L18 6M6 6l12 12',                                     'cancelled'],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $count, $color, $icon, $status]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="<?php echo e(route('admin.bookings.index', ['status' => $status])); ?>"
       class="card p-4 hover:shadow-md transition-shadow group">
        <div class="flex items-center justify-between mb-2">
            <p class="text-xs font-medium text-gray-500 leading-tight"><?php echo e($label); ?></p>
            <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-<?php echo e($color); ?>-100 group-hover:scale-110 transition-transform shrink-0">
                <svg class="w-4 h-4 text-<?php echo e($color); ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($icon); ?>"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900"><?php echo e($count); ?></p>
        <p class="text-xs text-gray-400 mt-0.5">booking</p>
    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="grid lg:grid-cols-3 gap-6 mb-6">
    
    <div class="card p-5 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-gray-900">Booking 7 Hari Terakhir</h2>
            <span class="text-xs text-gray-400"><?php echo e(now()->subDays(6)->format('d M')); ?> – <?php echo e(now()->format('d M Y')); ?></span>
        </div>
        <div class="flex items-end gap-2 h-36">
            <?php $maxCount = max(array_column($chartData, 'count') ?: [1]); ?>
            <?php $__currentLoopData = $chartData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $height = $maxCount > 0 ? round(($day['count'] / $maxCount) * 100) : 0; ?>
            <div class="flex-1 flex flex-col items-center gap-1">
                <span class="text-xs text-gray-500 font-medium"><?php echo e($day['count'] ?: ''); ?></span>
                <div class="w-full rounded-t-md transition-all bg-blue-100" style="height: <?php echo e(max($height, 4)); ?>%">
                    <div class="w-full h-full bg-blue-500 rounded-t-md opacity-80 hover:opacity-100 transition-opacity"></div>
                </div>
                <span class="text-xs text-gray-400"><?php echo e($day['date']); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div class="card p-5">
        <h2 class="font-semibold text-gray-900 mb-4">Ringkasan</h2>
        <div class="space-y-2.5">
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-600">Total Booking</span>
                <span class="font-bold text-gray-900"><?php echo e($stats['total']); ?></span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-600">Booking Hari Ini</span>
                <span class="font-bold text-blue-600"><?php echo e($stats['today']); ?></span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-600">Total Customer</span>
                <span class="font-bold text-gray-900"><?php echo e($stats['customers']); ?></span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-600">Total Inspektor</span>
                <span class="font-bold text-gray-900"><?php echo e($stats['inspectors']); ?></span>
            </div>
            <div class="flex justify-between items-center py-2">
                <span class="text-sm text-gray-600">Dibatalkan</span>
                <span class="font-bold text-red-500"><?php echo e($stats['cancelled']); ?></span>
            </div>
        </div>
        <a href="<?php echo e(route('admin.bookings.index')); ?>" class="btn-primary w-full justify-center mt-4 btn-sm">
            Lihat Semua Booking
        </a>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    
    <div class="card">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">Jadwal Hari Ini</h2>
            <span class="badge-blue"><?php echo e($todayBookings->count()); ?> booking</span>
        </div>
        <?php if($todayBookings->isEmpty()): ?>
        <div class="px-5 py-10 text-center text-gray-400 text-sm">
            <svg class="w-10 h-10 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Tidak ada booking hari ini
        </div>
        <?php else: ?>
        <div class="divide-y divide-gray-50">
            <?php $__currentLoopData = $todayBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>"
               class="flex items-center justify-between px-5 py-3 hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 text-xs font-bold shrink-0">
                        <?php echo e(substr($booking->booking_time, 0, 5)); ?>

                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate"><?php echo e($booking->user->name); ?></p>
                        <p class="text-xs text-gray-500 truncate"><?php echo e($booking->vehicle->brand); ?> <?php echo e($booking->vehicle->model); ?> · <?php echo e($booking->package->name); ?></p>
                    </div>
                </div>
                <div class="ml-2 shrink-0 text-right">
                    <span class="badge-<?php echo e($booking->status_color); ?>"><?php echo e($booking->status_label); ?></span>
                    <?php if($booking->inspector): ?>
                    <p class="text-xs text-gray-400 mt-0.5"><?php echo e($booking->inspector->name); ?></p>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="card">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">Booking Terbaru</h2>
            <a href="<?php echo e(route('admin.bookings.index')); ?>" class="text-xs text-blue-600 hover:underline">Lihat semua →</a>
        </div>
        <?php if($recentBookings->isEmpty()): ?>
        <div class="px-5 py-10 text-center text-gray-400 text-sm">Belum ada booking</div>
        <?php else: ?>
        <div class="divide-y divide-gray-50">
            <?php $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>"
               class="flex items-center justify-between px-5 py-3 hover:bg-gray-50 transition-colors">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 font-mono"><?php echo e($booking->booking_code); ?></p>
                    <p class="text-xs text-gray-500 truncate"><?php echo e($booking->user->name); ?> · <?php echo e($booking->booking_date->format('d M Y')); ?></p>
                </div>
                <span class="badge-<?php echo e($booking->status_color); ?> ml-2 shrink-0"><?php echo e($booking->status_label); ?></span>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>
</div>


<div class="mt-6">
    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Aksi Cepat</h2>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <?php $__currentLoopData = [
            ['Tambah Booking',  'admin.bookings.create',   'bg-blue-50 text-blue-600',    'M12 4v16m8-8H4'],
            ['Paket Inspeksi',  'admin.packages.index',    'bg-purple-50 text-purple-600','M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
            ['Item Checklist',  'admin.checklist.index',   'bg-green-50 text-green-600',  'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
            ['Kelola Inspektor','admin.inspectors.index',  'bg-orange-50 text-orange-600','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $route, $cls, $path]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route($route)); ?>"
           class="card p-4 hover:shadow-md transition-shadow flex items-center gap-3 group">
            <div class="w-9 h-9 <?php echo e($cls); ?> rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($path); ?>"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700"><?php echo e($label); ?></span>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        <a href="<?php echo e(route('admin.bookings.index')); ?>"
           class="card p-4 hover:shadow-md transition-shadow flex items-center gap-3 group">
            <div class="w-9 h-9 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700">Semua Booking</span>
        </a>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web-inspeksi\web-inspeksi\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>