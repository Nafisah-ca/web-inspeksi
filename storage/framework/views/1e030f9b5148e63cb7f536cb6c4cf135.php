<?php $__env->startSection('title', 'Booking Inspeksi'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-10">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Booking Inspeksi Kendaraan</h1>
        <p class="text-gray-500 text-sm mt-1">Isi formulir di bawah ini untuk membuat jadwal inspeksi.</p>
    </div>

    <?php if($errors->any()): ?>
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
        <p class="text-sm font-semibold text-red-700 mb-2">Ada kesalahan pada form:</p>
        <ul class="text-sm text-red-600 list-disc list-inside space-y-1">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('booking.store')); ?>"
          x-data="bookingForm()" @submit.prevent="submitForm">
        <?php echo csrf_field(); ?>

        
        <div class="flex items-center gap-3 mb-8">
            <?php $__currentLoopData = ['Pilih Paket', 'Data Kendaraan', 'Jadwal']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold
                            <?php echo e($step === 0 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600'); ?>">
                    <?php echo e($step + 1); ?>

                </div>
                <span class="text-sm font-medium <?php echo e($step === 0 ? 'text-blue-600' : 'text-gray-400'); ?>"><?php echo e($label); ?></span>
            </div>
            <?php if(!$loop->last): ?>
            <div class="flex-1 h-px bg-gray-200"></div>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="card p-6 mb-5">
            <h2 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 bg-blue-100 text-blue-600 rounded-full text-xs font-bold flex items-center justify-center">1</span>
                Pilih Paket Inspeksi
            </h2>

            <div class="grid sm:grid-cols-3 gap-3">
                <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="relative cursor-pointer">
                    <input type="radio" name="package_id" value="<?php echo e($package->id); ?>"
                           class="sr-only peer"
                           <?php echo e(old('package_id', $selectedPackage?->id) == $package->id ? 'checked' : ''); ?>

                           required>
                    <div class="border-2 rounded-xl p-4 peer-checked:border-blue-500 peer-checked:bg-blue-50 border-gray-200 hover:border-gray-300 transition-colors">
                        <p class="font-semibold text-sm text-gray-900"><?php echo e($package->name); ?></p>
                        <p class="text-blue-600 font-bold text-base mt-1"><?php echo e($package->formatted_price); ?></p>
                        <p class="text-xs text-gray-400 mt-0.5">⏱ <?php echo e($package->duration_label); ?></p>
                    </div>
                    <div class="absolute top-3 right-3 w-4 h-4 rounded-full border-2 border-gray-300 peer-checked:border-blue-500 peer-checked:bg-blue-500 hidden peer-checked:flex items-center justify-center">
                        <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php $__errorArgs = ['package_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error mt-2"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div class="card p-6 mb-5">
            <h2 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 bg-blue-100 text-blue-600 rounded-full text-xs font-bold flex items-center justify-center">2</span>
                Data Kendaraan
            </h2>

            <div class="mb-4">
                <label class="form-label">Kendaraan</label>
                <select name="vehicle_type" x-model="vehicleType" class="form-input">
                    <option value="existing">Pilih dari kendaraan tersimpan</option>
                    <option value="new">Tambah kendaraan baru</option>
                </select>
            </div>

            
            <div x-show="vehicleType === 'existing'" x-transition>
                <?php if($vehicles->isEmpty()): ?>
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-sm text-yellow-700">
                    Belum ada kendaraan tersimpan. Pilih "Tambah kendaraan baru" di atas.
                </div>
                <?php else: ?>
                <div class="grid sm:grid-cols-2 gap-3">
                    <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="cursor-pointer">
                        <input type="radio" name="vehicle_id" value="<?php echo e($vehicle->id); ?>"
                               class="sr-only peer"
                               <?php echo e(old('vehicle_id') == $vehicle->id ? 'checked' : ''); ?>>
                        <div class="border-2 rounded-xl p-4 peer-checked:border-blue-500 peer-checked:bg-blue-50 border-gray-200 hover:border-gray-300 transition-colors">
                            <p class="font-semibold text-sm text-gray-900"><?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?></p>
                            <p class="text-xs text-gray-500"><?php echo e($vehicle->plate_number); ?> · <?php echo e($vehicle->year); ?> · <?php echo e($vehicle->getTypeLabel()); ?></p>
                        </div>
                    </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php $__errorArgs = ['vehicle_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error mt-2"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php endif; ?>
            </div>

            
            <div x-show="vehicleType === 'new'" x-transition class="space-y-4">
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Merek <span class="text-red-500">*</span></label>
                        <input type="text" name="brand" value="<?php echo e(old('brand')); ?>"
                               class="form-input <?php $__errorArgs = ['brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Toyota, Honda, dll">
                        <?php $__errorArgs = ['brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="form-label">Model <span class="text-red-500">*</span></label>
                        <input type="text" name="model" value="<?php echo e(old('model')); ?>"
                               class="form-input <?php $__errorArgs = ['model'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Avanza, Civic, dll">
                        <?php $__errorArgs = ['model'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="form-label">No. Plat <span class="text-red-500">*</span></label>
                        <input type="text" name="plate_number" value="<?php echo e(old('plate_number')); ?>"
                               class="form-input <?php $__errorArgs = ['plate_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="B 1234 ABC">
                        <?php $__errorArgs = ['plate_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="form-label">Tahun <span class="text-red-500">*</span></label>
                        <input type="number" name="year" value="<?php echo e(old('year')); ?>"
                               class="form-input <?php $__errorArgs = ['year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="<?php echo e(date('Y')); ?>" min="1990" max="<?php echo e(date('Y') + 1); ?>">
                        <?php $__errorArgs = ['year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="form-label">Tipe <span class="text-red-500">*</span></label>
                        <select name="type" class="form-input <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Pilih tipe</option>
                            <?php $__currentLoopData = \App\Models\Vehicle::$types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val); ?>" <?php echo e(old('type') == $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card p-6 mb-5">
            <h2 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 bg-blue-100 text-blue-600 rounded-full text-xs font-bold flex items-center justify-center">3</span>
                Pilih Jadwal
            </h2>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" name="booking_date" id="booking_date"
                           value="<?php echo e(old('booking_date')); ?>"
                           min="<?php echo e(date('Y-m-d')); ?>"
                           @change="fetchSlots($event.target.value)"
                           class="form-input <?php $__errorArgs = ['booking_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['booking_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="form-label">Waktu <span class="text-red-500">*</span></label>
                    <div x-show="!slots.length && !loading" class="text-xs text-gray-400 py-2.5">Pilih tanggal dulu</div>
                    <div x-show="loading" class="text-xs text-gray-400 py-2.5">Memuat slot waktu...</div>
                    <div x-show="slots.length > 0 && !loading" class="grid grid-cols-4 gap-2">
                        <template x-for="slot in slots" :key="slot.time">
                            <label class="cursor-pointer" :class="{ 'opacity-40 cursor-not-allowed': !slot.available }">
                                <input type="radio" name="booking_time" :value="slot.time"
                                       class="sr-only peer" :disabled="!slot.available">
                                <div class="border-2 rounded-lg py-2 text-center text-xs font-medium transition-colors
                                            peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700
                                            border-gray-200 hover:border-gray-300"
                                     :class="slot.available ? 'text-gray-700' : 'text-gray-400 bg-gray-50'">
                                    <span x-text="slot.time"></span>
                                    <div class="text-[10px] mt-0.5"
                                         :class="slot.available ? 'text-green-500' : 'text-red-400'"
                                         x-text="slot.available ? 'Tersedia' : 'Penuh'"></div>
                                </div>
                            </label>
                        </template>
                    </div>
                    <?php $__errorArgs = ['booking_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>

        
        <div class="card p-6 mb-6">
            <label class="form-label">Catatan Tambahan (opsional)</label>
            <textarea name="notes" rows="3"
                      class="form-input <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                      placeholder="Jelaskan keluhan atau hal yang ingin dicek secara khusus..."><?php echo e(old('notes')); ?></textarea>
            <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="flex gap-3 justify-end">
            <a href="<?php echo e(route('home')); ?>" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary px-8">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Konfirmasi Booking
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function bookingForm() {
    return {
        vehicleType: '<?php echo e(old('vehicle_type', $vehicles->isNotEmpty() ? 'existing' : 'new')); ?>',
        slots: [],
        loading: false,

        async fetchSlots(date) {
            if (!date) return;
            this.loading = true;
            this.slots = [];
            try {
                const res = await fetch(`<?php echo e(route('booking.slots')); ?>?date=${date}`);
                this.slots = await res.json();
            } catch (e) {
                console.error(e);
            } finally {
                this.loading = false;
            }
        },

        submitForm() {
            this.$el.submit();
        }
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\inspeksi\resources\views/booking/create.blade.php ENDPATH**/ ?>