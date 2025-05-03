<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Edit Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <form action="{{ route('resto.shared_customers.update_resto', $customer->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $customer->name) }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <select name="gender" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm">
                            <option value="">- Pilih -</option>
                            <option value="L" @if(old('gender', $customer->gender) === 'L') selected @endif>Laki-laki</option>
                            <option value="P" @if(old('gender', $customer->gender) === 'P') selected @endif>Perempuan</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2 pt-4">
                        <a href="{{ route('resto.shared_customers.index_resto') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white font-medium px-4 py-2 rounded-md">
                            Batal
                        </a>
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-md">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
