<button <button
    {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 border-2 border-transparent rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm transition ease-in-out duration-150']) }}
    style="border-color: #667eea; color: #667eea; background: white;"
    onmouseover="this.style.backgroundColor = '#667eea'; this.style.color = 'white'; this.style.transform = 'translateY(-2px)';"
    onmouseout="this.style.backgroundColor = 'white'; this.style.color = '#667eea'; this.style.transform = 'translateY(0)';">
    {{ $slot }}
</button>
