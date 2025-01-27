<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Data Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Container with Flexbox for 2 charts per row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- First Row: Booking Status and Type of Meal Plan -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-lg mb-3">Booking Status</h3>
                            <div>{!! $bookingStatusChart->container() !!}</div>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-semibold text-lg mb-3">Type of Meal Plan</h3>
                            <div>{!! $typeMealChart->container() !!}</div>
                        </div>
                    </div>

                    <!-- Second Row: Yearly Distribution and Monthly Distribution -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-6">
                            <h3 class="font-semibold text-lg mb-3">Yearly Distribution</h3>
                            <div>{!! $arrivalYearChart->container() !!}</div>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-semibold text-lg mb-3">Monthly Distribution</h3>
                            <div>{!! $arrivalMonthChart->container() !!}</div>
                        </div>
                    </div>

                    <!-- Third Row: Room Type Reserved and Market Segment Type -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-6">
                            <h3 class="font-semibold text-lg mb-3">Room Type Reserved</h3>
                            <div>{!! $roomTypeChart->container() !!}</div>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-semibold text-lg mb-3">Market Segment Type</h3>
                            <div>{!! $marketSegmentChart->container() !!}</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

    <!-- Chart Scripts -->
    {!! $bookingStatusChart->script() !!}
    {!! $typeMealChart->script() !!}
    {!! $arrivalYearChart->script() !!}
    {!! $arrivalMonthChart->script() !!}
    {!! $roomTypeChart->script() !!}
    {!! $marketSegmentChart->script() !!}

</x-app-layout>
