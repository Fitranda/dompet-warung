@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'mobile-form-input bg-white text-slate-900 placeholder-slate-400 focus:bg-white disabled:bg-slate-50 disabled:text-slate-500']) }}>
