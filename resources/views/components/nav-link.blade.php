@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-600 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}
    @if ($active) style="border-bottom-color: #667eea; color: #667eea;" @else onmouseover="this.style.color = '#667eea';" onmouseout="this.style.color = '#666';" @endif>
    {{ $slot }}
</a>
