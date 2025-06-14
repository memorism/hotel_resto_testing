{{-- Form Container --}}
<div class="space-y-8">
    {{-- Nama Hotel --}}
    <div>
        <x-input-label for="name" :value="__('Nama Hotel')" class="text-sm font-medium text-gray-700"/>
        <div class="mt-1.5">
            <x-text-input 
                id="name" 
                type="text" 
                name="name" 
                value="{{ old('name', $hotel->name ?? '') }}"
                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm"
                placeholder="Masukkan nama hotel"
                required 
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
    </div>

    {{-- Alamat Lengkap --}}
    <div>
        <h3 class="text-sm font-medium text-gray-700 mb-3">Alamat Lengkap</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ([
                'street' => 'Jalan',
                'village' => 'Kelurahan/Desa',
                'district' => 'Kecamatan',
                'city' => 'Kota/Kabupaten',
                'province' => 'Provinsi',
                'postal_code' => 'Kode Pos'
            ] as $field => $label)
                <div>
                    <x-input-label for="{{ $field }}" :value="__($label)" class="text-sm font-medium text-gray-700"/>
                    <div class="mt-1.5">
                        <x-text-input 
                            id="{{ $field }}" 
                            type="text" 
                            name="{{ $field }}"
                            value="{{ old($field, $hotel->$field ?? '') }}"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm"
                            placeholder="Masukkan {{ strtolower($label) }}"
                        />
                        <x-input-error :messages="$errors->get($field)" class="mt-2" />
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Kontak --}}
    <div>
        <h3 class="text-sm font-medium text-gray-700 mb-3">Informasi Kontak</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Telepon --}}
            <div>
                <x-input-label for="phone" :value="__('Telepon')" class="text-sm font-medium text-gray-700"/>
                <div class="mt-1.5">
                    <x-text-input 
                        id="phone" 
                        type="text" 
                        name="phone" 
                        value="{{ old('phone', $hotel->phone ?? '') }}"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm"
                        placeholder="Masukkan nomor telepon"
                    />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
            </div>

            {{-- Email --}}
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700"/>
                <div class="mt-1.5">
                    <x-text-input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email', $hotel->email ?? '') }}"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm"
                        placeholder="Masukkan alamat email"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            </div>
        </div>
    </div>

    {{-- Logo --}}
    <div>
        <x-input-label for="logo" :value="__('Logo Hotel')" class="text-sm font-medium text-gray-700"/>
        <div class="mt-1.5">
            <div class="flex items-center space-x-4">
                @if(isset($hotel) && $hotel->logo)
                    <div class="flex-shrink-0">
                        <img src="{{ asset('storage/' . $hotel->logo) }}" 
                             alt="Logo {{ $hotel->name }}" 
                             class="h-16 w-16 rounded-lg object-cover ring-2 ring-gray-200">
                    </div>
                @endif
                <div class="flex-grow">
                    <label class="block">
                        <span class="sr-only">Pilih logo hotel</span>
                        <input type="file" 
                               name="logo" 
                               id="logo"
                               accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 focus:outline-none"
                        />
                    </label>
                    <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                    <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                </div>
            </div>
        </div>
    </div>
</div>
