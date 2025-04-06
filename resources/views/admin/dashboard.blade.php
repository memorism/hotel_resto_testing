<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-dark">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                {{-- Card untuk Hotel --}}
                <div class="p-4 bg-blue-100 shadow rounded-lg flex items-center justify-start space-x-4">
                    <div class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center text-2xl">
                        🏨
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Jumlah Hotel</h3>
                        <p class="text-2xl font-bold">{{ $hotelCount }}</p>
                    </div>
                </div>

                {{-- Card untuk Resto --}}
                <div class="p-4 bg-green-100 shadow rounded-lg flex items-center justify-start space-x-4">
                    <div class="w-12 h-12 bg-green-500 text-white rounded-full flex items-center justify-center text-2xl">
                        🍽️
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Jumlah Restaurant</h3>
                        <p class="text-2xl font-bold">{{ $restoCount }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
