<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> — InspeksiKu</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="h-full bg-gray-50" x-data="{ mobileNav: false }">


<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="flex justify-between h-14">
            <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2">
                <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="font-bold text-gray-900">InspeksiKu</span>
            </a>
            <div class="hidden sm:flex items-center gap-1">
                <a href="<?php echo e(route('user.dashboard')); ?>"
                   class="px-3 py-1.5 rounded-lg text-sm font-medium <?php echo e(request()->routeIs('user.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50'); ?>">
                    Dashboard
                </a>
                <a href="<?php echo e(route('user.bookings')); ?>"
                   class="px-3 py-1.5 rounded-lg text-sm font-medium <?php echo e(request()->routeIs('user.bookings*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50'); ?>">
                    Riwayat
                </a>
                <a href="<?php echo e(route('booking.create')); ?>"
                   class="px-3 py-1.5 rounded-lg text-sm font-medium <?php echo e(request()->routeIs('booking.create') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50'); ?>">
                    Booking Baru
                </a>
                <a href="<?php echo e(route('user.profile')); ?>"
                   class="px-3 py-1.5 rounded-lg text-sm font-medium <?php echo e(request()->routeIs('user.profile') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50'); ?>">
                    Profil
                </a>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="ml-2">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                            class="flex items-center gap-1.5 px-3 py-1.5 text-sm text-red-600 hover:bg-red-50 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
            <button @click="mobileNav = !mobileNav" class="sm:hidden p-2 text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>
    <div x-show="mobileNav" x-transition class="sm:hidden border-t border-gray-100 bg-white px-4 py-2 space-y-1">
        <a href="<?php echo e(route('user.dashboard')); ?>" class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Dashboard</a>
        <a href="<?php echo e(route('user.bookings')); ?>" class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Riwayat</a>
        <a href="<?php echo e(route('booking.create')); ?>" class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Booking Baru</a>
        <a href="<?php echo e(route('user.profile')); ?>" class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Profil</a>
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button class="block w-full text-left px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50">Keluar</button>
        </form>
    </div>
</nav>


<?php if(session('success')): ?>
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         class="fixed top-16 right-4 z-50 max-w-sm w-full" x-transition>
        <div class="flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 shadow-lg">
            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-medium"><?php echo e(session('success')); ?></p>
        </div>
    </div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
         class="fixed top-16 right-4 z-50 max-w-sm w-full" x-transition>
        <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 shadow-lg">
            <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-medium"><?php echo e(session('error')); ?></p>
        </div>
    </div>
<?php endif; ?>

<main class="max-w-5xl mx-auto px-4 sm:px-6 py-6">
    <?php echo $__env->yieldContent('content'); ?>
</main>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\web-inspeksi\web-inspeksi\resources\views/layouts/user.blade.php ENDPATH**/ ?>