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

            {{-- Form Filter berdasarkan User --}}
            <div class="mt-8">
                <form method="GET" action="{{ route('admin.dashboard') }}">
                    <div class="flex items-center space-x-4">
                        <select name="user_id" class="border px-4 py-2 rounded-md">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $selectedUserId == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Filter</button>
                    </div>
                </form>
            </div>

            {{-- Menampilkan Chart --}}
            <div class="mt-8">
                <div>
                    {!! $chart->bookingStatusChart->script() !!}
                    {!! $chart->bookingStatusChart->container() !!}
                </div>
                <div>
                    {!! $chart->typeMealChart->script() !!}
                    {!! $chart->typeMealChart->container() !!}
                </div>
                <div>
                    {!! $chart->arrivalYearChart->script() !!}
                    {!! $chart->arrivalYearChart->container() !!}
                </div>
                <div>
                    {!! $chart->arrivalMonthChart->script() !!}
                    {!! $chart->arrivalMonthChart->container() !!}
                </div>
                <div>
                    {!! $chart->roomTypeChart->script() !!}
                    {!! $chart->roomTypeChart->container() !!}
                </div>
                <div>
                    {!! $chart->marketSegmentChart->script() !!}
                    {!! $chart->marketSegmentChart->container() !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
