<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Inspeksi Kendaraan'); ?> — InspeksiKu</title>
    <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="h-full bg-gray-50">


<nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <div class="flex items-center">
                <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-gray-900">InspeksiKu</span>
                </a>
            </div>

            
            <div class="hidden md:flex items-center gap-6">
                <a href="<?php echo e(route('home')); ?>"
                   class="text-sm font-medium <?php echo e(request()->routeIs('home') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-900'); ?> transition-colors">
                    Beranda
                </a>
                <a href="<?php echo e(route('packages')); ?>"
                   class="text-sm font-medium <?php echo e(request()->routeIs('packages') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-900'); ?> transition-colors">
                    Paket
                </a>

                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->isCustomer()): ?>
                        <a href="<?php echo e(route('user.dashboard')); ?>"
                           class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                            Dashboard
                        </a>
                    <?php elseif(Auth::user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>"
                           class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                            Admin Panel
                        </a>
                    <?php elseif(Auth::user()->isInspector()): ?>
                        <a href="<?php echo e(route('inspector.dashboard')); ?>"
                           class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                            Dashboard
                        </a>
                    <?php endif; ?>

                    <div class="flex items-center gap-3" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-gray-900">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-bold text-xs">
                                <?php echo e(strtoupper(substr(Auth::user()->name, 0, 2))); ?>

                            </div>
                            <span class="hidden lg:block"><?php echo e(Auth::user()->name); ?></span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute right-4 top-14 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                            <?php if(Auth::user()->isCustomer()): ?>
                                <a href="<?php echo e(route('user.profile')); ?>"
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Profil Saya
                                </a>
                            <?php endif; ?>
                            <hr class="my-1">
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                        class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn-secondary btn-sm">Masuk</a>
                    <a href="<?php echo e(route('register')); ?>" class="btn-primary btn-sm">Daftar</a>
                <?php endif; ?>
            </div>

            
            <div class="md:hidden flex items-center">
                <button @click="mobileOpen = !mobileOpen" class="text-gray-600 hover:text-gray-900 p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileOpen"  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    
    <div x-show="mobileOpen" x-transition class="md:hidden border-t border-gray-100 bg-white px-4 py-3 space-y-1">
        <a href="<?php echo e(route('home')); ?>" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Beranda</a>
        <a href="<?php echo e(route('packages')); ?>" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Paket</a>
        <?php if(auth()->guard()->check()): ?>
            <?php if(Auth::user()->isCustomer()): ?>
                <a href="<?php echo e(route('user.dashboard')); ?>" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Dashboard</a>
                <a href="<?php echo e(route('user.profile')); ?>" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Profil</a>
            <?php elseif(Auth::user()->isAdmin()): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Admin Panel</a>
            <?php endif; ?>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="block w-full text-left px-3 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50">Keluar</button>
            </form>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Masuk</a>
            <a href="<?php echo e(route('register')); ?>" class="block px-3 py-2 rounded-lg text-sm font-medium text-blue-600 hover:bg-blue-50">Daftar</a>
        <?php endif; ?>
    </div>
</nav>


<?php if(session('success')): ?>
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         class="fixed top-20 right-4 z-50 max-w-sm w-full" x-transition>
        <div class="flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 shadow-lg">
            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-medium"><?php echo e(session('success')); ?></p>
            <button @click="show = false" class="ml-auto text-green-500 hover:text-green-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
         class="fixed top-20 right-4 z-50 max-w-sm w-full" x-transition>
        <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 shadow-lg">
            <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-medium"><?php echo e(session('error')); ?></p>
            <button @click="show = false" class="ml-auto text-red-500 hover:text-red-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
<?php endif; ?>


<main>
    <?php echo $__env->yieldContent('content'); ?>
</main>


<?php
    $footerCms  = \App\Models\SiteContent::section('footer');
    $contactCms = \App\Models\SiteContent::section('contact');
?>
<footer class="bg-gray-900 text-gray-400 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-white font-bold"><?php echo e($footerCms['brand_name'] ?? 'InspeksiKu'); ?></span>
                </div>
                <p class="text-sm leading-relaxed"><?php echo e($footerCms['tagline'] ?? ''); ?></p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3 text-sm">Layanan</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?php echo e(route('packages')); ?>" class="hover:text-white transition-colors">Paket Inspeksi</a></li>
                    <li><a href="<?php echo e(route('booking.create')); ?>" class="hover:text-white transition-colors">Booking Sekarang</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3 text-sm">Kontak</h4>
                <ul class="space-y-2 text-sm">
                    <?php if(!empty($contactCms['phone'])): ?>
                    <li>📞 <?php echo e($contactCms['phone']); ?></li>
                    <?php endif; ?>
                    <?php if(!empty($contactCms['email'])): ?>
                    <li>📧 <?php echo e($contactCms['email']); ?></li>
                    <?php endif; ?>
                    <?php if(!empty($contactCms['address'])): ?>
                    <li>📍 <?php echo e($contactCms['address']); ?></li>
                    <?php endif; ?>
                    <?php if(!empty($contactCms['open_hours'])): ?>
                    <li>🕐 <?php echo e($contactCms['open_hours']); ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <hr class="border-gray-700 mt-8 mb-4">
        <p class="text-center text-xs">© <?php echo e(date('Y')); ?> <?php echo e($footerCms['copyright'] ?? 'InspeksiKu.'); ?></p>
    </div>
</footer>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\laragon\www\inspeksi\resources\views/layouts/app.blade.php ENDPATH**/ ?>