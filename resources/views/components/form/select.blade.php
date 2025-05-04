@props(['name', 'label' => null, 'options' => [], 'selected' => '', 'required' => false])

<div>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif
    <select name="{{ $name }}" id="{{ $name }}" @if($required) required @endif {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:ring focus:ring-indigo-300']) }}>
        <option value="">Pilih</option>
        @foreach($options as $key => $option)
            @php
                $stringKey = (string) $key;
                $stringSelected = (string) old($name, $selected);
            @endphp
            <option value="{{ $stringKey }}" {{ $stringSelected === $stringKey ? 'selected' : '' }}>
                {{ $option }}
            </option>
        @endforeach
    </select>

</div>