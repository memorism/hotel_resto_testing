<!-- Nama Hotel -->
<div class="mb-4">
    <x-input-label for="name" :value="__('Nama Hotel')" />
    <x-text-input id="name" type="text" name="name" value="{{ old('name', $hotel->name ?? '') }}" class="block w-full mt-1" required />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<!-- Alamat -->
@foreach (['street' => 'Jalan', 'village' => 'Kelurahan/Desa', 'district' => 'Kecamatan', 'city' => 'Kota/Kabupaten', 'province' => 'Provinsi', 'postal_code' => 'Kode Pos'] as $field => $label)
    <div class="mb-4">
        <x-input-label for="{{ $field }}" :value="__($label)" />
        <x-text-input id="{{ $field }}" type="text" name="{{ $field }}" value="{{ old($field, $hotel->$field ?? '') }}" class="block w-full mt-1" />
        <x-input-error :messages="$errors->get($field)" class="mt-2" />
    </div>
@endforeach

<!-- Telepon -->
<div class="mb-4">
    <x-input-label for="phone" :value="__('Telepon')" />
    <x-text-input id="phone" type="text" name="phone" value="{{ old('phone', $hotel->phone ?? '') }}" class="block w-full mt-1" />
    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
</div>

<!-- Email -->
<div class="mb-4">
    <x-input-label for="email" :value="__('Email')" />
    <x-text-input id="email" type="email" name="email" value="{{ old('email', $hotel->email ?? '') }}" class="block w-full mt-1" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

<!-- Logo -->
<div class="mb-4">
    <x-input-label for="logo" :value="__('Logo (Opsional)')" />
    <input id="logo" type="file" name="logo" 
        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" accept="image/*" />
    <x-input-error :messages="$errors->get('logo')" class="mt-2" />
    @if(isset($hotel) && $hotel->logo)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $hotel->logo) }}" alt="Logo" class="h-16">
        </div>
    @endif
</div>
