
<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>


<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Halo, <?php echo e(Auth::user()->name); ?>! 👋</h1>
        <p class="text-sm text-gray-500 mt-0.5">Pantau status inspeksi kendaraan Anda di sini.</p>
    </div>
    <a href="<?php echo e(route('booking.create')); ?>" class="btn-primary btn-sm hidden sm:inline-flex">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Booking Baru
    </a>
</div>


<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
    <?php $__currentLoopData = [
        ['Total Booking',  $stats['total'],       'bg-blue-50   text-blue-600',   '🗓'],
        ['Berlangsung',    $stats['on_progress'],  'bg-indigo-50 text-indigo-600', '🔧'],
        ['Menunggu',       $stats['pending'],      'bg-yellow-50 text-yellow-600', '⏳'],
        ['Selesai',        $stats['completed'],    'bg-green-50  text-green-600',  '✅'],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $val, $cls, $icon]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card p-4">
        <div class="text-2xl mb-1"><?php echo e($icon); ?></div>
        <p class="text-2xl font-bold text-gray-900"><?php echo e($val); ?></p>
        <p class="text-xs text-gray-500"><?php echo e($label); ?></p>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<?php if($activeBookings->isNotEmpty()): ?>
<div class="mb-6">
    <h2 class="text-base font-semibold text-gray-900 mb-3">Booking Aktif</h2>
    <div class="space-y-4">
        <?php $__currentLoopData = $activeBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card p-5">
            
            <div class="flex items-start justify-between gap-3 mb-4">
                <div>
                    <p class="font-mono text-xs text-gray-400"><?php echo e($booking->booking_code); ?></p>
                    <p class="font-semibold text-gray-900 mt-0.5"><?php echo e($booking->vehicle->brand); ?> <?php echo e($booking->vehicle->model); ?></p>
                    <p class="text-xs text-gray-500"><?php echo e($booking->vehicle->plate_number); ?> · <?php echo e($booking->package->name); ?></p>
                </div>
                <span class="badge-<?php echo e($booking->status_color); ?> shrink-0"><?php echo e($booking->status_label); ?></span>
            </div>

            
            <div class="mb-4">
                <?php
                    $steps = ['pending' => 0, 'confirmed' => 1, 'on_progress' => 2, 'completed' => 3];
                    $current = $steps[$booking->status] ?? 0;
                    $labels  = ['Booking', 'Dikonfirmasi', 'Dikerjakan', 'Selesai'];
                ?>
                <div class="flex items-center">
                    <?php $__currentLoopData = $labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center <?php echo e($i < count($labels) - 1 ? 'flex-1' : ''); ?>">
                        <div class="flex flex-col items-center">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold
                                        <?php echo e($i <= $current ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-400'); ?>">
                                <?php if($i < $current): ?>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                <?php else: ?>
                                    <?php echo e($i + 1); ?>

                                <?php endif; ?>
                            </div>
                            <p class="text-[10px] text-gray-500 mt-1 whitespace-nowrap"><?php echo e($label); ?></p>
                        </div>
                        <?php if($i < count($labels) - 1): ?>
                        <div class="flex-1 h-0.5 mx-1 mb-3 <?php echo e($i < $current ? 'bg-blue-500' : 'bg-gray-200'); ?>"></div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="flex flex-wrap gap-4 text-xs text-gray-500 mb-4">
                <span>📅 <?php echo e($booking->booking_date->format('d M Y')); ?> · <?php echo e(substr($booking->booking_time, 0, 5)); ?> WIB</span>
                <?php if($booking->inspector): ?>
                <span>👨‍🔧 <?php echo e($booking->inspector->name); ?></span>
                <?php else: ?>
                <span class="text-yellow-500">⏳ Menunggu assign inspektor</span>
                <?php endif; ?>
            </div>

            <div class="flex gap-2">
                <a href="<?php echo e(route('user.bookings.show', $booking)); ?>" class="btn-secondary btn-sm">Lihat Detail</a>
                <?php if(in_array($booking->status, ['pending', 'confirmed'])): ?>
                <form method="POST" action="<?php echo e(route('user.bookings.cancel', $booking)); ?>"
                      onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-danger btn-sm">Batalkan</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php else: ?>

<div class="card p-10 text-center mb-6">
    <div class="text-5xl mb-3">🚗</div>
    <h3 class="font-semibold text-gray-900 mb-1">Belum ada booking aktif</h3>
    <p class="text-sm text-gray-500 mb-4">Yuk, jadwalkan inspeksi kendaraan Anda sekarang!</p>
    <a href="<?php echo e(route('booking.create')); ?>" class="btn-primary">
        Booking Sekarang
    </a>
</div>
<?php endif; ?>


<?php if($recentCompleted->isNotEmpty()): ?>
<div>
    <div class="flex items-center justify-between mb-3">
        <h2 class="text-base font-semibold text-gray-900">Riwayat Terakhir</h2>
        <a href="<?php echo e(route('user.bookings')); ?>" class="text-xs text-blue-600 hover:underline">Lihat semua →</a>
    </div>
    <div class="card divide-y divide-gray-50">
        <?php $__currentLoopData = $recentCompleted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('user.bookings.show', $booking)); ?>"
           class="flex items-center justify-between px-5 py-3.5 hover:bg-gray-50 transition-colors">
            <div>
                <p class="text-sm font-medium text-gray-900"><?php echo e($booking->vehicle->brand); ?> <?php echo e($booking->vehicle->model); ?></p>
                <p class="text-xs text-gray-500"><?php echo e($booking->package->name); ?> · <?php echo e($booking->booking_date->format('d M Y')); ?></p>
            </div>
            <div class="flex items-center gap-2">
                <span class="badge-<?php echo e($booking->status_color); ?>"><?php echo e($booking->status_label); ?></span>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>


<div class="sm:hidden fixed bottom-6 right-6">
    <a href="<?php echo e(route('booking.create')); ?>"
       class="flex items-center justify-center w-14 h-14 bg-blue-600 rounded-full shadow-xl text-white hover:bg-blue-700 transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
    </a>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web-inspeksi\web-inspeksi\resources\views/user/dashboard.blade.php ENDPATH**/ ?>