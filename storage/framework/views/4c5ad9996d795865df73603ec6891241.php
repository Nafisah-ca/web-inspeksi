<?php $__env->startSection('title', 'Detail Booking'); ?>

<?php $__env->startSection('content'); ?>

<div class="mb-5">
    <a href="<?php echo e(route('user.bookings')); ?>" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Riwayat
    </a>
</div>


<div class="card p-5 mb-5">
    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold">Kode Booking</p>
            <p class="text-xl font-mono font-bold text-gray-900"><?php echo e($booking->booking_code); ?></p>
        </div>
        <span class="badge-<?php echo e($booking->status_color); ?> text-sm px-3 py-1"><?php echo e($booking->status_label); ?></span>
    </div>

    
    <?php if($booking->status !== 'cancelled'): ?>
    <?php
        $steps   = ['pending' => 0, 'confirmed' => 1, 'on_progress' => 2, 'completed' => 3];
        $current = $steps[$booking->status] ?? 0;
        $labels  = ['Booking', 'Dikonfirmasi', 'Dikerjakan', 'Selesai'];
    ?>
    <div class="flex items-center mb-4">
        <?php $__currentLoopData = $labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="flex items-center <?php echo e($i < count($labels) - 1 ? 'flex-1' : ''); ?>">
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                            <?php echo e($i < $current ? 'bg-blue-600 text-white' : ($i === $current ? 'bg-blue-600 text-white ring-4 ring-blue-100' : 'bg-gray-200 text-gray-400')); ?>">
                    <?php if($i < $current): ?>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    <?php else: ?>
                        <?php echo e($i + 1); ?>

                    <?php endif; ?>
                </div>
                <p class="text-[10px] text-center mt-1 <?php echo e($i <= $current ? 'text-blue-600 font-semibold' : 'text-gray-400'); ?>">
                    <?php echo e($label); ?>

                </p>
            </div>
            <?php if($i < count($labels) - 1): ?>
            <div class="flex-1 h-1 mx-1 mb-4 rounded-full <?php echo e($i < $current ? 'bg-blue-500' : 'bg-gray-200'); ?>"></div>
            <?php endif; ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php else: ?>
    <div class="bg-red-50 rounded-xl px-4 py-3 mb-4">
        <p class="text-sm font-semibold text-red-700">Booking Dibatalkan</p>
        <?php if($booking->cancellation_reason): ?>
        <p class="text-xs text-red-600 mt-1"><?php echo e($booking->cancellation_reason); ?></p>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
        <div><p class="text-gray-400 text-xs">Tanggal</p><p class="font-semibold"><?php echo e($booking->booking_date->format('d M Y')); ?></p></div>
        <div><p class="text-gray-400 text-xs">Waktu</p><p class="font-semibold"><?php echo e(substr($booking->booking_time, 0, 5)); ?> WIB</p></div>
        <div><p class="text-gray-400 text-xs">Paket</p><p class="font-semibold"><?php echo e($booking->package->name); ?></p></div>
        <div><p class="text-gray-400 text-xs">Harga</p><p class="font-bold text-blue-600"><?php echo e($booking->package->formatted_price); ?></p></div>
    </div>

    <?php if($booking->inspector): ?>
    <div class="mt-4 bg-indigo-50 rounded-xl px-4 py-3 flex items-center gap-3">
        <div class="w-9 h-9 bg-indigo-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
            <?php echo e(strtoupper(substr($booking->inspector->name, 0, 2))); ?>

        </div>
        <div>
            <p class="text-xs text-indigo-500 font-semibold">Inspektor</p>
            <p class="text-sm font-semibold text-indigo-900"><?php echo e($booking->inspector->name); ?></p>
        </div>
    </div>
    <?php endif; ?>
</div>


<div class="card p-5 mb-5">
    <h2 class="font-semibold text-gray-900 mb-3">Kendaraan</h2>
    <div class="grid grid-cols-2 gap-3 text-sm">
        <div><p class="text-gray-400 text-xs">Merek & Model</p><p class="font-medium"><?php echo e($booking->vehicle->year); ?> <?php echo e($booking->vehicle->brand); ?> <?php echo e($booking->vehicle->model); ?></p></div>
        <div><p class="text-gray-400 text-xs">No. Plat</p><p class="font-medium font-mono"><?php echo e($booking->vehicle->plate_number); ?></p></div>
        <div><p class="text-gray-400 text-xs">Tipe</p><p class="font-medium"><?php echo e($booking->vehicle->getTypeLabel()); ?></p></div>
    </div>
    <?php if($booking->notes): ?>
    <div class="mt-3 bg-gray-50 rounded-xl p-3">
        <p class="text-xs text-gray-500 font-semibold mb-1">Catatan</p>
        <p class="text-sm text-gray-700"><?php echo e($booking->notes); ?></p>
    </div>
    <?php endif; ?>
</div>


<?php if($booking->result && $booking->status === 'completed'): ?>
<div class="card p-5 mb-5">
    <h2 class="font-semibold text-gray-900 mb-4">🔍 Hasil Inspeksi</h2>

    
    <div class="grid grid-cols-3 gap-3 mb-5">
        <div class="bg-green-50 border border-green-100 rounded-xl p-3 text-center">
            <p class="text-3xl font-bold text-green-600"><?php echo e($booking->result->ok_count); ?></p>
            <p class="text-xs text-green-600 font-semibold mt-1">✅ OK</p>
        </div>
        <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-3 text-center">
            <p class="text-3xl font-bold text-yellow-600"><?php echo e($booking->result->warning_count); ?></p>
            <p class="text-xs text-yellow-600 font-semibold mt-1">⚠️ Perhatian</p>
        </div>
        <div class="bg-red-50 border border-red-100 rounded-xl p-3 text-center">
            <p class="text-3xl font-bold text-red-600"><?php echo e($booking->result->bad_count); ?></p>
            <p class="text-xs text-red-600 font-semibold mt-1">❌ Bermasalah</p>
        </div>
    </div>

    
    <?php if($booking->result->checklist_json): ?>
    <div class="mb-5">
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Detail Checklist</p>
        <?php $__currentLoopData = collect($booking->result->checklist_json)->groupBy('category'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="mb-4">
            <p class="text-xs font-bold text-gray-600 uppercase mb-2 bg-gray-100 px-3 py-1 rounded-lg inline-block"><?php echo e($category); ?></p>
            <div class="space-y-1.5">
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $bg   = ['ok' => 'bg-green-50 border-green-100',  'warning' => 'bg-yellow-50 border-yellow-100', 'bad' => 'bg-red-50 border-red-100'][$item['status']] ?? 'bg-gray-50 border-gray-100';
                    $icon = ['ok' => '✅', 'warning' => '⚠️', 'bad' => '❌'][$item['status']] ?? '•';
                ?>
                <div class="flex items-start gap-2.5 p-3 rounded-xl border <?php echo e($bg); ?>">
                    <span class="mt-0.5 text-sm"><?php echo e($icon); ?></span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800"><?php echo e($item['item_name']); ?></p>
                        <?php if(!empty($item['note'])): ?>
                        <p class="text-xs text-gray-500 mt-0.5"><?php echo e($item['note']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    
    <div class="space-y-4">
        <div>
            <p class="text-sm font-semibold text-gray-700 mb-2">📋 Ringkasan Kondisi</p>
            <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700 leading-relaxed">
                <?php echo e($booking->result->condition_summary); ?>

            </div>
        </div>
        <div>
            <p class="text-sm font-semibold text-gray-700 mb-2">💡 Rekomendasi</p>
            <div class="bg-blue-50 rounded-xl p-4 text-sm text-blue-800 leading-relaxed whitespace-pre-line">
                <?php echo e($booking->result->recommendation); ?>

            </div>
        </div>
        <?php if($booking->result->inspector_notes): ?>
        <div>
            <p class="text-sm font-semibold text-gray-700 mb-2">🔧 Catatan Inspektor</p>
            <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700">
                <?php echo e($booking->result->inspector_notes); ?>

            </div>
        </div>
        <?php endif; ?>
        <?php if($booking->result->completed_at): ?>
        <p class="text-xs text-gray-400 text-right">
            Inspeksi selesai: <?php echo e($booking->result->completed_at->format('d M Y, H:i')); ?> WIB
        </p>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>


<div class="flex gap-3">
    <?php if(in_array($booking->status, ['pending', 'confirmed'])): ?>
    <form method="POST" action="<?php echo e(route('user.bookings.cancel', $booking)); ?>"
          onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn-danger">Batalkan Booking</button>
    </form>
    <?php endif; ?>
    <?php if($booking->status === 'completed'): ?>
    <a href="<?php echo e(route('booking.create', ['package_id' => $booking->package_id])); ?>" class="btn-primary">
        Booking Ulang
    </a>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\inspeksi\resources\views/user/booking-detail.blade.php ENDPATH**/ ?>