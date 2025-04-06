<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0">
                    <a href="{{ Auth::user()->usertype == 'admin' ? route('admin.dashboard') : route('dashboard') }}">
                        @if(Auth::user()->logo)
                            <img src="{{ asset('storage/' . Auth::user()->logo) }}" class="h-9 w-auto rounded-full" alt="User Logo">
                        @else
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        @endif
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:flex sm:ml-10">
                    @if (Auth::user()->usertype == 'admin')
                        <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('admin.okupansiresto') }}" :active="request()->routeIs('admin.okupansiresto')">
                            {{ __('Okupansi Resto') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('admin.okupansihotel') }}" :active="request()->routeIs('admin.okupansihotel')">
                            {{ __('Okupansi Hotel') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('admin.hotel') }}" :active="request()->routeIs('admin.hotel')">
                            {{ __('Dashboard Hotel') }}
                        </x-nav-link>
                        
                        <x-nav-link href="{{ route('admin.resto') }}" :active="request()->routeIs('admin.resto')">
                            {{ __('Dashboard Restaurant') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('admin.user.user') }}" :active="request()->routeIs('admin.user.user')">
                            {{ __('User') }}
                        </x-nav-link>
                    @endif

                    @if (Auth::user()->usertype == 'hotel')
                        <x-nav-link href="{{ route('hotel.dashboard') }}" :active="request()->routeIs('hotel.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('hotel.okupansi') }}" :active="request()->routeIs('hotel.okupansi')">
                            {{ __('Okupansi') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('hotel.rooms.rooms') }}" :active="request()->routeIs('hotel.rooms.rooms')">
                            {{ __('Kamar') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('hotel.databooking.index') }}" :active="request()->routeIs('hotel.databooking.index')">
                            {{ __('Data Unggah') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('hotel.booking.booking') }}" :active="request()->routeIs('hotel.booking.booking')">
                            {{ __('Data Keseluruhan') }}
                        </x-nav-link>
                    @endif

                    @if (Auth::user()->usertype == 'resto')
                        <x-nav-link href="{{ route('resto.dashboard') }}" :active="request()->routeIs('resto.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('resto.okupansi') }}" :active="request()->routeIs('resto.okupansi')">
                            {{ __('Okupansi') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('resto.dataorders.index') }}" :active="request()->routeIs('resto.dataorders.index')">
                            {{ __('Data Unggah') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('resto.orders.index') }}" :active="request()->routeIs('resto.orders.index')">
                            {{ __('Data Keseluruhan') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none">
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Menu -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': ! open, 'inline-flex': open }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-white border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            @if (Auth::user()->usertype == 'admin')
                <x-responsive-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('admin.okupansiresto') }}" :active="request()->routeIs('admin.okupansiresto')">
                    {{ __('Okupansi Resto') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('admin.okupansihotel') }}" :active="request()->routeIs('admin.okupansihotel')">
                    {{ __('Okupansi Hotel') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link href="{{ route('admin.hotel') }}" :active="request()->routeIs('admin.hotel')">
                    {{ __('Dashboard Hotel') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link href="{{ route('admin.resto') }}" :active="request()->routeIs('admin.resto')">
                    {{ __('Dashboard Restaurant') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('admin.user.user') }}" :active="request()->routeIs('admin.user.user')">
                    {{ __('User') }}
                </x-responsive-nav-link>
            @endif

            @if (Auth::user()->usertype == 'hotel')
                <x-responsive-nav-link href="{{ route('hotel.dashboard') }}" :active="request()->routeIs('hotel.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('hotel.okupansi') }}" :active="request()->routeIs('hotel.okupansi')">
                    {{ __('Okupansi') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('hotel.rooms.rooms') }}" :active="request()->routeIs('hotel.rooms.rooms')">
                    {{ __('Kamar') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('hotel.databooking.index') }}" :active="request()->routeIs('hotel.databooking.index')">
                    {{ __('Data Unggah') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('hotel.booking.booking') }}" :active="request()->routeIs('hotel.booking.booking')">
                    {{ __('Data Keseluruhan') }}
                </x-responsive-nav-link>
            @endif

            @if (Auth::user()->usertype == 'resto')
                <x-responsive-nav-link href="{{ route('resto.dashboard') }}" :active="request()->routeIs('resto.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('resto.okupansi') }}" :active="request()->routeIs('resto.okupansi')">
                    {{ __('Okupansi') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('resto.dataorders.index') }}" :active="request()->routeIs('resto.dataorders.index')">
                    {{ __('Data Unggah') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('resto.orders.index') }}" :active="request()->routeIs('resto.orders.index')">
                    {{ __('Data Keseluruhan') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
