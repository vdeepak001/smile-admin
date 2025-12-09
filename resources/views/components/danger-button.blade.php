<button <button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150']) }}
    style="focus-ring-color: #dc2626;">
    {{ $slot }}
</button>
