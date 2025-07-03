<x-guest-layout>
    <div class="mobile-auth-container">
        <div class="mobile-auth-card">
            <!-- Header -->
            <div class="text-center mb-6 lg:mb-8">
                <h2 class="mobile-auth-title">Confirm Password</h2>
                <p class="mobile-auth-subtitle">Secure area access</p>
            </div>

            <div class="mobile-info-card mb-6">
                <p class="text-sm text-slate-600">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                </p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="mobile-form-spacing">
                @csrf

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mobile-section-spacing">
                    <x-primary-button class="mobile-full-button">
                        {{ __('Confirm') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
