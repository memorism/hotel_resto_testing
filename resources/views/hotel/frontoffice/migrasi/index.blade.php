<x-app-layout>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Histori Data Migrasi Booking') }}
            </h2>
            <a href="{{ route('hotel.frontoffice.migrasi.create') }}" class="btn btn-primary">
                Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-4 text-green-600">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 text-red-600">{{ session('error') }}</div>
                @endif


                @if($uploadOrders->count())
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">#</th>
                                <th class="px-4 py-2 text-left">File Name</th>
                                <th class="px-4 py-2 text-left">Keterangan</th>
                                <th class="px-4 py-2 text-left">Tanggal Upload</th>
                                <th class="px-4 py-2 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($uploadOrders as $order)
                                <tr>
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $order->file_name }}</td>
                                    <td class="px-4 py-2">{{ $order->description ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                    <td class="px-4 py-2">
                                        <form action="{{ route('hotel.frontoffice.migrasi.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini beserta bookings-nya?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-600 mt-4">Belum ada data migrasi yang diupload.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
