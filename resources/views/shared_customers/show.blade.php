
<x-app-layout>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4">Detail Pelanggan</h2>

                <div class="space-y-3 text-sm text-gray-700">
                    <div><strong>Nama:</strong> {{ $sharedCustomer->name }}</div>
                    <div><strong>Email:</strong> {{ $sharedCustomer->email ?? '-' }}</div>
                    <div><strong>No. Telepon:</strong> {{ $sharedCustomer->phone ?? '-' }}</div>
                    <div><strong>Jenis Kelamin:</strong>
                        {{ $sharedCustomer->gender === 'L' ? 'Laki-laki' : ($sharedCustomer->gender === 'P' ? 'Perempuan' : '-') }}
                    </div>
                    <div><strong>Tanggal Lahir:</strong> {{ $sharedCustomer->birth_date ?? '-' }}</div>
                    <div><strong>Alamat:</strong> {{ $sharedCustomer->address ?? '-' }}</div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('shared_customers.index') }}"
                       class="text-sm text-blue-600 hover:underline">← Kembali ke daftar pelanggan</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
