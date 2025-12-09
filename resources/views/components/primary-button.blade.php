<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150']) }}
    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"
    onmouseover="this.style.boxShadow = '0 15px 40px rgba(102, 126, 234, 0.4)'; this.style.transform = 'translateY(-2px)';"
    onmouseout="this.style.boxShadow = 'none'; this.style.transform = 'translateY(0)';">
    {{ $slot }}
</button>
