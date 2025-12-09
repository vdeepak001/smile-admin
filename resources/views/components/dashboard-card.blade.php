@props(['title', 'value' => 0, 'icon' => 'chart-bar', 'color' => 'blue', 'trend' => null])

@php
    $colorClasses = match ($color) {
        'blue' => 'bg-blue-600 hover:bg-blue-700 text-white',
        'green' => 'bg-green-600 hover:bg-green-700 text-white',
        'purple' => 'bg-purple-600 hover:bg-purple-700 text-white',
        'red' => 'bg-red-600 hover:bg-red-700 text-white',
        'yellow' => 'bg-amber-500 hover:bg-amber-600 text-white',
        default => 'bg-slate-700 hover:bg-slate-800 text-white',
    };

    $iconBgClasses = 'bg-white/20';

    $icons = [
        'chart-bar' =>
            'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'users' =>
            'M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM12 14a9 9 0 00-9 9v2h18v-2a9 9 0 00-9-9z',
        'building' =>
            'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m5 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
        'book' =>
            'M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z',
        'check' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'clock' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
    ];

    $iconPath = $icons[$icon] ?? $icons['chart-bar'];
@endphp

<div
    class="rounded-xl shadow-md border border-transparent overflow-hidden transition-transform duration-200 transform hover:-translate-y-1">
    <div class="p-6 {{ $colorClasses }}">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-white/80 mb-2">{{ $title }}</p>
                <div class="flex items-end space-x-2">
                    <p class="text-4xl font-extrabold leading-none">{{ $value }}</p>
                    @if ($trend)
                        <span class="text-sm font-semibold {{ $trend > 0 ? 'text-lime-200' : 'text-rose-200' }}">
                            {{ $trend > 0 ? '+' : '' }}{{ $trend }}%
                        </span>
                    @endif
                </div>
            </div>
            <div class="{{ $iconBgClasses }} p-3 rounded-full">
                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}">
                    </path>
                </svg>
            </div>
        </div>
    </div>
</div>
