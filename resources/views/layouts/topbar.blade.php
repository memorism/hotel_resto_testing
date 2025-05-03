<div class="flex items-center justify-end w-full h-full px-4">
    <div class="flex items-center space-x-6">

        {{-- 🔔 Notifikasi --}}
        <div class="relative">
            <button class="relative focus:outline-none">
                <svg class="w-6 h-6 text-gray-500 hover:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 00-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold text-white bg-red-600 rounded-full">
                    3
                </span>
            </button>
        </div>

        {{-- 👤 Avatar dan Dropdown --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                @if(Auth::user()->logo)
                    <img src="{{ asset('storage/' . Auth::user()->logo) }}" alt="avatar"
                         class="w-8 h-8 rounded-full object-cover border border-gray-300">
                @else
                    <div class="w-8 h-8 bg-gray-300 text-gray-700 rounded-full flex items-center justify-center text-sm font-bold uppercase">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
                <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.061a.75.75 0 111.08 1.04l-4.25 4.657a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z"
                          clip-rule="evenodd" />
                </svg>
            </button>

            {{-- Dropdown --}}
            <div x-show="open" @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-1"
                 style="display: none;" class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg z-50">
                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
