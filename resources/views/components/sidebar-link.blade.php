@props(['active' => false])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-3 text-sm font-medium rounded-xl text-white bg-primary-600 shadow-sm transition-all duration-200'
            : 'flex items-center px-4 py-3 text-sm font-medium rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
