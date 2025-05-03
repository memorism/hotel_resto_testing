<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Tambah Pelanggan Baru') }}
            </h2>
            <a class="invisible btn btn-primary">test</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <form action="{{ route('resto.shared_customers.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" id="name" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-300">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="text" name="phone" id="phone"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-300">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-300">
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <select name="gender" id="gender"
                            class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:ring focus:ring-indigo-300">
                            <option value="">- Pilih -</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2 pt-4">
                        <a href="{{ url()->previous() }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-medium px-4 py-2 rounded-md">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-md">
                            Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>