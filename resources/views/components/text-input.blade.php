@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-2 border-gray-300 rounded-lg shadow-sm transition-all duration-200 focus:outline-none']) }}
    onfocus="this.style.borderColor = '#667eea'; this.style.boxShadow = '0 0 0 3px rgba(102, 126, 234, 0.1)';"
    onblur="this.style.borderColor = '#d1d5db'; this.style.boxShadow = '';">
