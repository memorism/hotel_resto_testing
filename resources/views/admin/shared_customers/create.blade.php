<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Tambah Pelanggan Global
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">
            <form action="{{ route('admin.shared_customers.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf

                <x-form.input name="name" label="Nama" required />
                <x-form.input name="email" label="Email" type="email" />
                <x-form.input name="phone" label="No. Telepon" />
                <x-form.select name="gender" label="Jenis Kelamin" :options="['L' => 'Laki-laki', 'P' => 'Perempuan']" />
                <x-form.input name="birth_date" label="Tanggal Lahir" type="date" class="md:col-span-2" />
                <x-form.textarea name="address" label="Alamat" class="md:col-span-2" />

                <div class="md:col-span-2 pt-4 flex justify-end gap-3">
                    <a href="{{ route('admin.shared_customers.index') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Batal
                    </a>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                        Simpan
                    </button>
                </div>                
            </form>
        </div>
    </div>
</x-app-layout>
