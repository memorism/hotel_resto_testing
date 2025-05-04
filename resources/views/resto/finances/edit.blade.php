<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Edit Transaksi Keuangan Resto</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">
            <form action="{{ route('resto.finances.update', $finance->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                @method('PUT')

                <x-form.input name="tanggal" label="Tanggal" type="date" :value="\Carbon\Carbon::parse($finance->tanggal)->format('Y-m-d')" required />

                <x-form.select name="jenis" label="Jenis Transaksi"
                    :options="['pemasukan' => 'Pemasukan', 'pengeluaran' => 'Pengeluaran']"
                    :selected="$finance->jenis" required />

                <x-form.input name="nominal" label="Nominal (Rp)" type="number" step="0.01" :value="$finance->nominal" class="md:col-span-2" required />

                <x-form.textarea name="keterangan" label="Keterangan" :value="$finance->keterangan" class="md:col-span-2" />

                <div class="md:col-span-2 flex justify-end gap-3 pt-4">
                    <a href="{{ route('resto.finances.index') }}"
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
