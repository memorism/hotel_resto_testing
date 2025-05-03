@props(['name', 'label' => null, 'value' => '', 'required' => false])

<div>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif
    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="4"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-300']) }}
    >{{ old($name, $value) }}</textarea>
</div>
