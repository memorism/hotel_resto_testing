<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kamar Hotel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto border-b border-gray-200 bg-white p-6">
                    <div class="min-w-full align-middle">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center px-4 py-2">Nomor Kamar</th>
                                    <th scope="col" class="text-center px-4 py-2">Tipe Kamar</th>
                                    <th scope="col" class="text-center px-4 py-2">Harga Kamar</th>
                                    <th scope="col" class="text-center px-4 py-2">Tipe User</th>
                                    <th scope="col" class="text-center px-4 py-2">Waktu Pembuatan Akun</th>
                                    <th scope="col" class="text-center px-4 py-2" style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                        <td class="text-center px-4 py-2">
                                            <form method="POST" action="" style="display:inline;">
                                                @csrf
                                                @method('DELETE') <!-- Menandakan metode DELETE -->
                                                <button type="submit"
                                                    class="px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
