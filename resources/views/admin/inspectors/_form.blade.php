@if($errors->any())
<div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4">
    <ul class="text-sm text-red-600 list-disc list-inside space-y-1">
        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
    </ul>
</div>
@endif

<div>
    <label class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
    <input type="text" name="name" value="{{ old('name', $inspector->name ?? '') }}"
           class="form-input @error('name') border-red-300 @enderror" required>
    @error('name') <p class="form-error">{{ $message }}</p> @enderror
</div>

<div>
    <label class="form-label">Email <span class="text-red-500">*</span></label>
    <input type="email" name="email" value="{{ old('email', $inspector->email ?? '') }}"
           class="form-input @error('email') border-red-300 @enderror" required>
    @error('email') <p class="form-error">{{ $message }}</p> @enderror
</div>

<div>
    <label class="form-label">No. HP</label>
    <input type="tel" name="phone" value="{{ old('phone', $inspector->phone ?? '') }}"
           class="form-input @error('phone') border-red-300 @enderror"
           placeholder="08xxxxxxxxxx">
    @error('phone') <p class="form-error">{{ $message }}</p> @enderror
</div>

<div>
    <label class="form-label">
        Password
        @isset($inspector) <span class="text-gray-400 font-normal">(kosongkan jika tidak diubah)</span> @endisset
        @unless(isset($inspector)) <span class="text-red-500">*</span> @endunless
    </label>
    <input type="password" name="password"
           class="form-input @error('password') border-red-300 @enderror"
           placeholder="Minimal 8 karakter"
           {{ isset($inspector) ? '' : 'required' }}>
    @error('password') <p class="form-error">{{ $message }}</p> @enderror
</div>

<div>
    <label class="form-label">Konfirmasi Password {{ isset($inspector) ? '' : '*' }}</label>
    <input type="password" name="password_confirmation"
           class="form-input"
           placeholder="Ulangi password"
           {{ isset($inspector) ? '' : 'required' }}>
</div>
