<button {{ $attributes->merge(['type' => 'button', 'class' => 'mobile-button bg-white text-slate-700 border border-slate-300 hover:bg-slate-50 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed shadow-sm hover:shadow-md']) }}>
    {{ $slot }}
</button>
