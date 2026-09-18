<?php $__env->startSection('title', 'Beranda'); ?>

<?php $__env->startSection('content'); ?>


<section class="bg-gradient-to-br from-blue-700 via-blue-600 to-blue-500 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <?php if(!empty($hero['badge'])): ?>
                <span class="inline-flex items-center gap-1.5 bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full mb-5">
                    ⭐ <?php echo e($hero['badge']); ?>

                </span>
                <?php endif; ?>

                <h1 class="text-4xl lg:text-5xl font-extrabold leading-tight mb-6">
                    <?php echo e($hero['title_line1'] ?? 'Inspeksi Kendaraan'); ?><br>
                    <span class="text-blue-200"><?php echo e($hero['title_line2'] ?? 'Profesional & Transparan'); ?></span>
                </h1>

                <?php if(!empty($hero['subtitle'])): ?>
                <p class="text-lg text-blue-100 mb-8 leading-relaxed">
                    <?php echo e($hero['subtitle']); ?>

                </p>
                <?php endif; ?>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="<?php echo e(route('booking.create')); ?>"
                       class="inline-flex items-center justify-center gap-2 bg-white text-blue-700 font-bold px-7 py-3 rounded-xl hover:bg-blue-50 transition-colors shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <?php echo e($hero['btn_primary'] ?? 'Booking Sekarang'); ?>

                    </a>
                    <a href="<?php echo e(route('packages')); ?>"
                       class="inline-flex items-center justify-center gap-2 border-2 border-white/50 text-white font-semibold px-7 py-3 rounded-xl hover:bg-white/10 transition-colors">
                        <?php echo e($hero['btn_secondary'] ?? 'Lihat Paket'); ?>

                    </a>
                </div>
            </div>

            
            <div class="hidden lg:flex justify-center">
                <div class="relative">
                    <div class="w-72 h-72 bg-white/10 rounded-3xl flex items-center justify-center">
                        <svg class="w-40 h-40 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="absolute -top-4 -right-8 bg-white rounded-2xl shadow-xl p-4 min-w-[160px]">
                        <p class="text-xs text-gray-500 mb-1"><?php echo e($stats['stat1_label'] ?? 'Inspeksi Selesai'); ?></p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['stat1_value'] ?? '0'); ?>+</p>
                    </div>
                    <div class="absolute -bottom-4 -left-8 bg-white rounded-2xl shadow-xl p-4 min-w-[160px]">
                        <p class="text-xs text-gray-500 mb-1"><?php echo e($stats['stat3_label'] ?? 'Inspektor Terlatih'); ?></p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['stat3_value'] ?? '0'); ?>+</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="border-b border-gray-100 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-gray-100">
            <?php for($i = 1; $i <= 4; $i++): ?>
            <?php
                $val   = $stats["stat{$i}_value"] ?? '—';
                $label = $stats["stat{$i}_label"] ?? '';
                $icons = ['🔧','⭐','👨‍🔧','📦'];
            ?>
            <?php if(!empty($label)): ?>
            <div class="py-6 px-4 text-center">
                <p class="text-2xl font-bold text-gray-900"><?php echo e($icons[$i-1]); ?> <?php echo e($val); ?></p>
                <p class="text-sm text-gray-500 mt-1"><?php echo e($label); ?></p>
            </div>
            <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
</section>


<?php if($packages->isNotEmpty()): ?>
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Pilih Paket Inspeksi</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Tiga pilihan paket sesuai kebutuhan dan budget Anda. Setiap paket dilengkapi laporan tertulis.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card p-6 hover:shadow-md transition-shadow relative <?php echo e($i === 1 ? 'border-blue-500 border-2 ring-4 ring-blue-50' : ''); ?>">
                <?php if($i === 1): ?>
                <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                    <span class="bg-blue-600 text-white text-xs font-bold px-4 py-1 rounded-full">Paling Populer</span>
                </div>
                <?php endif; ?>
                <div class="mb-4">
                    <div class="w-10 h-10 rounded-xl mb-3 flex items-center justify-center <?php echo e(['bg-green-100 text-green-600','bg-blue-100 text-blue-600','bg-purple-100 text-purple-600'][$i] ?? 'bg-gray-100 text-gray-600'); ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900"><?php echo e($package->name); ?></h3>
                    <p class="text-sm text-gray-500 mt-1 leading-relaxed"><?php echo e($package->description); ?></p>
                </div>
                <div class="mb-6">
                    <span class="text-3xl font-extrabold text-gray-900"><?php echo e($package->formatted_price); ?></span>
                    <span class="text-gray-400 text-sm ml-1">/ inspeksi</span>
                    <p class="text-xs text-gray-400 mt-1">⏱ Estimasi <?php echo e($package->duration_label); ?></p>
                </div>
                <a href="<?php echo e(route('booking.create', ['package_id' => $package->id])); ?>"
                   class="<?php echo e($i === 1 ? 'btn-primary' : 'btn-secondary'); ?> w-full justify-center">
                    Pilih Paket Ini
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="text-center mt-8">
            <a href="<?php echo e(route('packages')); ?>" class="text-blue-600 text-sm font-medium hover:underline">
                Lihat detail semua paket →
            </a>
        </div>
    </div>
</section>
<?php endif; ?>


<?php if(!empty($how['title'])): ?>
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-3"><?php echo e($how['title']); ?></h2>
            <?php if(!empty($how['subtitle'])): ?>
            <p class="text-gray-500"><?php echo e($how['subtitle']); ?></p>
            <?php endif; ?>
        </div>

        <div class="grid md:grid-cols-4 gap-6">
            <?php
                $stepColors = ['bg-blue-600','bg-indigo-600','bg-violet-600','bg-purple-600'];
            ?>
            <?php for($s = 1; $s <= 4; $s++): ?>
            <?php if(!empty($how["step{$s}_title"])): ?>
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-14 h-14 <?php echo e($stepColors[$s-1]); ?> text-white text-xl font-bold rounded-2xl mb-4">
                    <?php echo e($s); ?>

                </div>
                <h3 class="font-semibold text-gray-900 mb-2"><?php echo e($how["step{$s}_title"]); ?></h3>
                <?php if(!empty($how["step{$s}_desc"])): ?>
                <p class="text-sm text-gray-500 leading-relaxed"><?php echo e($how["step{$s}_desc"]); ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
</section>
<?php endif; ?>


<?php if(!empty($why_us['title'])): ?>
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900"><?php echo e($why_us['title']); ?></h2>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <?php for($w = 1; $w <= 3; $w++): ?>
            <?php if(!empty($why_us["item{$w}_title"])): ?>
            <div class="text-center">
                <div class="text-4xl mb-3"><?php echo e($why_us["item{$w}_icon"] ?? '✅'); ?></div>
                <h3 class="font-semibold text-gray-900 mb-2"><?php echo e($why_us["item{$w}_title"]); ?></h3>
                <?php if(!empty($why_us["item{$w}_desc"])): ?>
                <p class="text-sm text-gray-500 leading-relaxed"><?php echo e($why_us["item{$w}_desc"]); ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
</section>
<?php endif; ?>


<?php if(!empty($cta['title'])): ?>
<section class="py-16 bg-blue-600">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-4"><?php echo e($cta['title']); ?></h2>
        <?php if(!empty($cta['subtitle'])): ?>
        <p class="text-blue-100 mb-8"><?php echo e($cta['subtitle']); ?></p>
        <?php endif; ?>
        <a href="<?php echo e(route('booking.create')); ?>"
           class="inline-flex items-center gap-2 bg-white text-blue-700 font-bold px-8 py-3.5 rounded-xl hover:bg-blue-50 transition-colors shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <?php echo e($cta['btn_text'] ?? 'Booking Sekarang'); ?>

        </a>
    </div>
</section>
<?php endif; ?>


<?php if(!empty($contact['phone']) || !empty($contact['email'])): ?>
<section class="py-14 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Hubungi Kami</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php if(!empty($contact['phone'])): ?>
            <a href="tel:<?php echo e(preg_replace('/[^0-9+]/', '', $contact['phone'])); ?>"
               class="card p-5 hover:shadow-md transition-shadow text-center group">
                <div class="text-3xl mb-2">📞</div>
                <p class="text-xs text-gray-400 font-semibold uppercase mb-1">Telepon</p>
                <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600"><?php echo e($contact['phone']); ?></p>
            </a>
            <?php endif; ?>
            <?php if(!empty($contact['email'])): ?>
            <a href="mailto:<?php echo e($contact['email']); ?>"
               class="card p-5 hover:shadow-md transition-shadow text-center group">
                <div class="text-3xl mb-2">📧</div>
                <p class="text-xs text-gray-400 font-semibold uppercase mb-1">Email</p>
                <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600"><?php echo e($contact['email']); ?></p>
            </a>
            <?php endif; ?>
            <?php if(!empty($contact['address'])): ?>
            <div class="card p-5 text-center">
                <div class="text-3xl mb-2">📍</div>
                <p class="text-xs text-gray-400 font-semibold uppercase mb-1">Alamat</p>
                <p class="text-sm font-semibold text-gray-900"><?php echo e($contact['address']); ?></p>
            </div>
            <?php endif; ?>
            <?php if(!empty($contact['open_hours'])): ?>
            <div class="card p-5 text-center">
                <div class="text-3xl mb-2">🕐</div>
                <p class="text-xs text-gray-400 font-semibold uppercase mb-1">Jam Buka</p>
                <p class="text-sm font-semibold text-gray-900"><?php echo e($contact['open_hours']); ?></p>
            </div>
            <?php endif; ?>
        </div>

        
        <?php if(!empty($contact['whatsapp_number'])): ?>
        <div class="mt-8">
            <a href="https://wa.me/<?php echo e($contact['whatsapp_number']); ?>"
               target="_blank"
               class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold px-7 py-3 rounded-xl transition-colors shadow-md">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.124.558 4.121 1.529 5.857L0 24l6.335-1.508A11.943 11.943 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.796 9.796 0 01-4.99-1.371l-.358-.213-3.758.894.944-3.653-.234-.375A9.785 9.785 0 012.182 12C2.182 6.57 6.57 2.182 12 2.182S21.818 6.57 21.818 12 17.43 21.818 12 21.818z"/>
                </svg>
                Chat via WhatsApp
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\inspeksi\resources\views/home.blade.php ENDPATH**/ ?>