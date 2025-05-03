<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Edit Pelanggan Hotel</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto bg-white shadow rounded-lg p-6">
            <form action="{{ route('hotel.shared_customers.update_hotel', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-form.input name="name" label="Nama" :value="$customer->name" required />
                    <x-form.input name="email" label="Email" type="email" :value="$customer->email" />

                    <x-form.input name="phone" label="No. Telepon" :value="$customer->phone" />
                    <x-form.select name="gender" label="Jenis Kelamin"
                        :options="['L' => 'Laki-laki', 'P' => 'Perempuan']"
                        :selected="$customer->gender" />

                    <x-form.input name="birth_date" label="Tanggal Lahir" type="date" :value="$customer->birth_date" />
                    <div class="md:col-span-2">
                        <x-form.textarea name="address" label="Alamat" :value="$customer->address" />
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('hotel.shared_customers.index_hotel') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Batal
                    </a>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
