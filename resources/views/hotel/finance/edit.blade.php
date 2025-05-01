<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Transaksi Keuangan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
            <form action="{{ route('finance.update', $finance->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('hotel.finance.form')
                <div class="flex justify-end space-x-2 mt-6">
                    <a href="{{ route('finance.index') }}" 
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Batal
                    </a>
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
