{{-- Nama --}}
<div class="mb-6">
    <x-input-label for="name" :value="__('Nama Resto')" />
    <x-text-input id="name" type="text" name="name" value="{{ old('name', $resto->name ?? '') }}"
        class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-300 focus:border-indigo-400" required />
    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-500" />
</div>

{{-- Alamat Lengkap --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    @foreach ([
        'street' => 'Jalan',
        'village' => 'Kelurahan/Desa',
        'district' => 'Kecamatan',
        'city' => 'Kota/Kabupaten',
        'province' => 'Provinsi',
        'postal_code' => 'Kode Pos'
    ] as $field => $label)
        <div>
            <x-input-label for="{{ $field }}" :value="__($label)" />
            <x-text-input id="{{ $field }}" type="text" name="{{ $field }}"
                value="{{ old($field, $resto->$field ?? '') }}"
                class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-300 focus:border-indigo-400" />
            <x-input-error :messages="$errors->get($field)" class="mt-2 text-sm text-red-500" />
        </div>
    @endforeach
</div>

{{-- Telepon --}}
<div class="mb-6">
    <x-input-label for="phone" :value="__('Telepon')" />
    <x-text-input id="phone" type="text" name="phone" value="{{ old('phone', $resto->phone ?? '') }}"
        class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-300 focus:border-indigo-400" />
    <x-input-error :messages="$errors->get('phone')" class="mt-2 text-sm text-red-500" />
</div>

{{-- Email --}}
<div class="mb-6">
    <x-input-label for="email" :value="__('Email')" />
    <x-text-input id="email" type="email" name="email" value="{{ old('email', $resto->email ?? '') }}"
        class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-300 focus:border-indigo-400" />
    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
</div>

{{-- Logo --}}
<div class="mb-6">
    <x-input-label for="logo" :value="__('Logo (Opsional)')" />
    <input id="logo" type="file" name="logo"
        class="mt-2 block w-full text-sm border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
        accept="image/*" />
    <x-input-error :messages="$errors->get('logo')" class="mt-2 text-sm text-red-500" />
    @if(isset($resto) && $resto->logo)
        <div class="mt-4">
            <img src="{{ asset('storage/' . $resto->logo) }}" alt="Logo" class="h-16 rounded-md border">
        </div>
    @endif
</div>
