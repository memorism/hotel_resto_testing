<!-- Topbar Container -->
<div class="flex items-center justify-end w-full h-16 px-6 bg-white border-b border-gray-200">
    <div class="flex items-center space-x-6">
        <!-- Notification Button -->
        {{-- <div class="relative">
            <button class="relative p-2 rounded-full hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg class="w-6 h-6 text-gray-600 hover:text-gray-800 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 00-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                {{-- Notification Badge --}} 
                {{--<span class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full shadow-sm">
                    3
                </span>
            </button>
        </div> --}}

        <!-- User Profile Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <!-- Profile Button -->
            <button @click="open = !open" 
                class="flex items-center gap-3 p-2 rounded-full hover:bg-gray-100 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                @if(Auth::user()->logo)
                    <img src="{{ asset('storage/' . Auth::user()->logo) }}" 
                         alt="Profile picture" 
                         class="w-8 h-8 rounded-full object-cover ring-2 ring-gray-200">
                @else
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-full flex items-center justify-center text-sm font-semibold shadow-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
                <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" 
                     :class="{'rotate-180': open}"
                     fill="currentColor" 
                     viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.061a.75.75 0 111.08 1.04l-4.25 4.657a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z"
                          clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" 
                 @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-1"
                 style="display: none;" 
                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg border border-gray-200 shadow-lg divide-y divide-gray-100 z-50">
                <div class="py-1">
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors duration-150">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profil
                    </a>
                </div>
                <div class="py-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
