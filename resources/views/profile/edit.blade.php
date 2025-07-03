<x-admin-layout>
    <!-- Page Header -->
    <div class="mobile-page-header">
        <div class="mobile-page-header-content">
            <div class="mobile-flex-between">
                <div>
                    <h1 class="mobile-page-title">Profile Settings</h1>
                    <p class="mobile-page-subtitle">Manage your account settings and preferences</p>
                </div>
                <div class="mobile-user-avatar">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="mobile-container mobile-section-spacing">
        <div class="max-w-4xl mx-auto space-y-6 lg:space-y-8">
            <!-- Profile Information Card -->
            <div class="mobile-card">
                <div class="mobile-card-header">
                    <h2 class="mobile-card-title">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile Information
                    </h2>
                </div>
                <div class="mobile-card-content">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Security Card -->
            <div class="mobile-card">
                <div class="mobile-card-header-secondary">
                    <h2 class="mobile-card-title">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Password Security
                    </h2>
                </div>
                <div class="mobile-card-content">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
