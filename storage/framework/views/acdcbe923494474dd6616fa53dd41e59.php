<?php $__env->startSection('title', 'Halaman Tidak Ditemukan'); ?>
<?php $__env->startSection('content'); ?>
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="text-center">
        <p class="text-6xl font-black text-gray-200 mb-4">404</p>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Halaman Tidak Ditemukan</h1>
        <p class="text-gray-500 mb-6">Halaman yang Anda cari tidak ada atau telah dipindahkan.</p>
        <a href="<?php echo e(route('home')); ?>" class="btn-primary">Kembali ke Beranda</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\inspeksi\resources\views/errors/404.blade.php ENDPATH**/ ?>