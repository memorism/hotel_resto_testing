<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Edit Meja - {{ $table->table_code }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">

                <form method="POST" action="{{ route('resto.tables.update', $table->id) }}">
                    @csrf
                    @method('PUT')

                    <x-form.input name="table_code" label="Kode Meja" :value="$table->table_code" required />
                    <x-form.input name="capacity" label="Kapasitas" type="number" :value="$table->capacity" min="1"
                        required />

                    <x-form.select name="is_active" label="Status" :options="['1' => 'Aktif', '0' => 'Tidak Aktif']"
                        :selected="(string) $table->is_active" required />



                    <div class="text-right pt-4">
                        <a href="{{ route('resto.tables.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                            Update
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>