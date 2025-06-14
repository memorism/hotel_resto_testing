@props([
    'viewUrl' => null,
    'editUrl' => null,
    'deleteUrl' => null,
    'restoreUrl' => null,
    'isRestore' => false,
])

<div x-data="{ open: false, position: 'bottom' }" x-init="
    () => {
        const button = $refs.button;
        const dropdown = $refs.dropdown;

        // Cek apakah dropdown keluar layar
        const rect = button.getBoundingClientRect();
        const dropdownHeight = 120; // kira-kira tinggi dropdown
        const spaceBelow = window.innerHeight - rect.bottom;
        if (spaceBelow < dropdownHeight) {
            position = 'top';
        }
    }
" class="relative inline-block text-left">
    <!-- Trigger -->
    <button x-ref="button" @click="open = !open"
    class="w-8 h-8 rounded-full bg-transparent hover:bg-gray-100 flex items-center justify-center group transition">
    <svg class="w-4 h-4 text-gray-500 group-hover:text-indigo-600 transition" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 5a1.5 1.5 0 110 3 1.5 1.5 0 010-3z" clip-rule="evenodd" />
    </svg>
</button>


    <!-- Dropdown -->
    <div x-show="open" @click.outside="open = false"
        x-ref="dropdown"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        :class="position === 'top' ? 'bottom-full mb-2' : 'top-full mt-2'"
        class="absolute z-50 right-0 w-40 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5"
        style="display: none;">
        <div class="py-1">

            @if($restoreUrl && $isRestore)
            <form method="POST" action="{{ $restoreUrl }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center px-4 py-2 text-sm text-green-600 hover:bg-gray-100">
                    <i class="fas fa-undo-alt mr-2"></i> Restore
                </button>
            </form>
            @endif
        


            @if($viewUrl)
            <a href="{{ $viewUrl }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fas fa-eye text-indigo-500 mr-2"></i> View
            </a>
            @endif

            @if($editUrl)
            <a href="{{ $editUrl }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fas fa-edit text-yellow-500 mr-2"></i> Edit
            </a>
            @endif

            @if($deleteUrl)
            <form method="POST" action="{{ $deleteUrl }}"
                onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                    <i class="fas fa-trash mr-2"></i> Delete
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
