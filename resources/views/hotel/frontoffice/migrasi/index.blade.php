<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ __('Histori Data Migrasi Booking') }}
            </h2>
            <a href="{{ route('hotel.frontoffice.migrasi.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6 overflow-x-auto">
                @if (session('success'))
                    <div class="mb-4 p-3 text-green-700 bg-green-100 border border-green-300 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-3 text-red-700 bg-red-100 border border-red-300 rounded-md">
                        {{ session('error') }}
                    </div>
                @endif

                @if($uploadOrders->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left whitespace-nowrap">No</th>
                                    <th class="px-4 py-2 text-left whitespace-nowrap">File Name</th>
                                    <th class="px-4 py-2 text-left whitespace-nowrap">Keterangan</th>
                                    <th class="px-4 py-2 text-left whitespace-nowrap">Tanggal Upload</th>
                                    <th class="px-4 py-2 text-left whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($uploadOrders as $order)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $order->file_name }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $order->description ?? '-' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <form action="{{ route('hotel.frontoffice.migrasi.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini beserta bookings-nya?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700 text-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-600 mt-4">Belum ada data migrasi yang diupload.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
