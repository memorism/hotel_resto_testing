@props(['name', 'label' => null, 'type' => 'text', 'value' => '', 'required' => false])

<div>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-300']) }}
    >
</div>
