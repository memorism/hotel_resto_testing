
<x-app-layout>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4">Edit Data Pelanggan</h2>

                <form action="{{ route('shared_customers.update', $sharedCustomer->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $sharedCustomer->name) }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $sharedCustomer->email) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $sharedCustomer->phone) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <select name="gender"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                            <option value="">- Pilih -</option>
                            <option value="L" {{ old('gender', $sharedCustomer->gender) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $sharedCustomer->gender) === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $sharedCustomer->birth_date) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea name="address" rows="3"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('address', $sharedCustomer->address) }}</textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('shared_customers.index') }}"
                           class="ml-4 text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
