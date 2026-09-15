@if($errors->any())
<div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4">
    <ul class="text-sm text-red-600 list-disc list-inside space-y-1">
        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
    </ul>
</div>
@endif

<div>
    <label class="form-label">Nama Paket <span class="text-red-500">*</span></label>
    <input type="text" name="name" value="{{ old('name', $package->name ?? '') }}"
           class="form-input @error('name') border-red-300 @enderror"
           placeholder="mis. Inspeksi Dasar" required>
    @error('name') <p class="form-error">{{ $message }}</p> @enderror
</div>

<div>
    <label class="form-label">Deskripsi</label>
    <textarea name="description" rows="3"
              class="form-input @error('description') border-red-300 @enderror"
              placeholder="Jelaskan apa yang termasuk dalam paket ini...">{{ old('description', $package->description ?? '') }}</textarea>
    @error('description') <p class="form-error">{{ $message }}</p> @enderror
</div>

<div class="grid sm:grid-cols-2 gap-4">
    <div>
        <label class="form-label">Harga (Rp) <span class="text-red-500">*</span></label>
        <input type="number" name="price" value="{{ old('price', $package->price ?? '') }}"
               class="form-input @error('price') border-red-300 @enderror"
               placeholder="150000" min="0" step="1000" required>
        @error('price') <p class="form-error">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="form-label">Estimasi Durasi (menit) <span class="text-red-500">*</span></label>
        <input type="number" name="duration_estimate" value="{{ old('duration_estimate', $package->duration_estimate ?? '') }}"
               class="form-input @error('duration_estimate') border-red-300 @enderror"
               placeholder="60" min="30" required>
        @error('duration_estimate') <p class="form-error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="flex items-center gap-3">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" id="is_active" value="1"
           class="rounded border-gray-300 text-blue-600 w-4 h-4"
           {{ old('is_active', $package->is_active ?? true) ? 'checked' : '' }}>
    <label for="is_active" class="text-sm font-medium text-gray-700">Paket Aktif (tampil di website)</label>
</div>
