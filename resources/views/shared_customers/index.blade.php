<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
                    {{ __('Daftar Pelanggan') }}
                </h2>
            </div>

            <div class="mb-4">
                <a href="{{ route('shared_customers.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700">
                    Tambah Pelanggan
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4">
                    <table class="min-w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama</th>
                                <th scope="col" class="px-6 py-3">No. Telepon</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Jenis Kelamin</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $customer)
                                <tr class="border-b">
                                    <td class="px-6 py-4">{{ $customer->name }}</td>
                                    <td class="px-6 py-4">{{ $customer->phone ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $customer->email ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        {{ $customer->gender === 'L' ? 'Laki-laki' : ($customer->gender === 'P' ? 'Perempuan' : '-') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <x-action-dropdown :viewUrl="route('shared_customers.show', $customer->id)"
                                            :editUrl="route('shared_customers.edit', $customer->id)"
                                            :deleteUrl="route('shared_customers.destroy', $customer->id)" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data pelanggan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>