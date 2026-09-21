
<?php $__env->startSection('title', 'Booking Berhasil'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-xl mx-auto px-4 py-16 text-center">
    <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-6">
        <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>

    <h1 class="text-2xl font-bold text-gray-900 mb-2">Booking Berhasil!</h1>
    <p class="text-gray-500 mb-8">Kami telah menerima permintaan inspeksi Anda. Tim admin akan segera mengkonfirmasi jadwal.</p>

    <div class="card p-6 text-left mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-gray-900">Ringkasan Booking</h2>
            <span class="badge-yellow">Menunggu Konfirmasi</span>
        </div>

        <dl class="space-y-3 text-sm">
            <div class="flex justify-between">
                <dt class="text-gray-500">Kode Booking</dt>
                <dd class="font-mono font-semibold text-gray-900"><?php echo e($booking->booking_code); ?></dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Paket</dt>
                <dd class="font-medium text-gray-900"><?php echo e($booking->package->name); ?></dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Kendaraan</dt>
                <dd class="font-medium text-gray-900"><?php echo e($booking->vehicle->brand); ?> <?php echo e($booking->vehicle->model); ?></dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">No. Plat</dt>
                <dd class="font-medium text-gray-900"><?php echo e($booking->vehicle->plate_number); ?></dd>
            </div>
            <hr>
            <div class="flex justify-between">
                <dt class="text-gray-500">Tanggal</dt>
                <dd class="font-semibold text-gray-900"><?php echo e($booking->booking_date->format('d M Y')); ?></dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Waktu</dt>
                <dd class="font-semibold text-gray-900"><?php echo e(substr($booking->booking_time, 0, 5)); ?> WIB</dd>
            </div>
            <hr>
            <div class="flex justify-between">
                <dt class="text-gray-500">Total</dt>
                <dd class="font-bold text-lg text-blue-600"><?php echo e($booking->package->formatted_price); ?></dd>
            </div>
        </dl>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-700 mb-8 text-left">
        <p class="font-semibold mb-1">📱 Langkah berikutnya:</p>
        <ol class="list-decimal list-inside space-y-1 text-blue-600">
            <li>Admin kami akan mengkonfirmasi booking dalam 1×24 jam</li>
            <li>Anda akan mendapat notifikasi di dashboard</li>
            <li>Hadir sesuai jadwal yang telah ditentukan</li>
        </ol>
    </div>

    <div class="flex gap-3 justify-center">
        <a href="<?php echo e(route('user.dashboard')); ?>" class="btn-primary">
            Ke Dashboard Saya
        </a>
        <a href="<?php echo e(route('home')); ?>" class="btn-secondary">
            Kembali ke Beranda
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web-inspeksi\web-inspeksi\resources\views/booking/success.blade.php ENDPATH**/ ?>