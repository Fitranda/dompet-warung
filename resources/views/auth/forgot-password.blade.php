<x-guest-layout>
    <div class="mobile-auth-container">
        <div class="mobile-auth-card">
            <!-- Header -->
            <div class="text-center mb-6 lg:mb-8">
                <h2 class="mobile-auth-title">Reset Password</h2>
                <p class="mobile-auth-subtitle">Sistem Akuntansi Digital</p>
            </div>

            <div class="mobile-info-card mb-6">
                <p class="text-sm text-slate-600">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="mobile-form-spacing">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="Masukkan email Anda" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mobile-section-spacing">
                    <x-primary-button class="mobile-full-button">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
