<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class DebugEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:debug {email : Email address to send debug email to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug email configuration with detailed logging';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        $this->info('🔍 Debugging Email Configuration...');
        $this->newLine();

        // Show current configuration
        $this->displayEmailConfig();

        $this->newLine();
        $this->info('📧 Attempting to send debug email to: ' . $email);

        try {
            // Enable detailed logging
            Log::info('Starting email debug test to: ' . $email);

            Mail::raw(
                "🎉 Email Debug Test Berhasil!\n\n" .
                "Jika Anda menerima email ini, konfigurasi email Anda sudah benar.\n\n" .
                "Waktu: " . now()->format('Y-m-d H:i:s') . "\n" .
                "Dari: Dompet Warung System\n\n" .
                "Terima kasih!",
                function ($message) use ($email) {
                    $message->to($email)
                            ->subject('🔧 Email Debug Test - Dompet Warung')
                            ->from(config('mail.from.address'), config('mail.from.name'));
                }
            );

            $this->info('✅ Email debug berhasil dikirim!');
            $this->info('📬 Silakan cek:');
            $this->line('   • Inbox email Anda');
            $this->line('   • Folder Spam/Junk');
            $this->line('   • Folder Promotions (Gmail)');

            Log::info('Debug email sent successfully to: ' . $email);

        } catch (\Exception $e) {
            $this->error('❌ Email debug gagal dikirim!');
            $this->newLine();

            $this->error('🐛 Error Details:');
            $this->line('Message: ' . $e->getMessage());
            $this->line('File: ' . $e->getFile() . ':' . $e->getLine());

            Log::error('Debug email failed', [
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->newLine();
            $this->warn('💡 Troubleshooting Steps:');
            $this->troubleshootGmail();

            return 1;
        }

        return 0;
    }

    private function displayEmailConfig()
    {
        $this->info('📋 Current Email Configuration:');
        $this->line('───────────────────────────────');
        $this->line('MAIL_MAILER: ' . config('mail.default'));
        $this->line('MAIL_HOST: ' . config('mail.mailers.smtp.host'));
        $this->line('MAIL_PORT: ' . config('mail.mailers.smtp.port'));
        $this->line('MAIL_USERNAME: ' . config('mail.mailers.smtp.username'));
        $this->line('MAIL_PASSWORD: ' . (config('mail.mailers.smtp.password') ? '***[SET]***' : '***[NOT SET]***'));
        $this->line('MAIL_ENCRYPTION: ' . config('mail.mailers.smtp.encryption'));
        $this->line('MAIL_FROM_ADDRESS: ' . config('mail.from.address'));
        $this->line('MAIL_FROM_NAME: ' . config('mail.from.name'));
        $this->line('───────────────────────────────');
    }

    private function troubleshootGmail()
    {
        $this->line('');
        $this->line('🔧 Gmail Troubleshooting:');
        $this->line('');
        $this->line('1. 🔐 App Password Required:');
        $this->line('   • Aktifkan 2-Step Verification di Gmail');
        $this->line('   • Buat App Password: https://myaccount.google.com/apppasswords');
        $this->line('   • Gunakan App Password, BUKAN password Gmail biasa');
        $this->line('');
        $this->line('2. 🛡️ Security Settings:');
        $this->line('   • Pastikan "Less secure app access" dimatikan');
        $this->line('   • Gmail modern mengharuskan App Password');
        $this->line('');
        $this->line('3. 🌐 Network Issues:');
        $this->line('   • Cek firewall/antivirus');
        $this->line('   • Pastikan port 587 tidak diblokir');
        $this->line('');
        $this->line('4. 📧 Alternative for Testing:');
        $this->line('   • Daftar Mailtrap.io (gratis)');
        $this->line('   • Atau gunakan MAIL_MAILER=log untuk debug');
        $this->line('');
        $this->line('💡 Quick Fix: Gunakan konfigurasi ini untuk testing:');
        $this->line('MAIL_MAILER=log');
        $this->line('(Email akan disimpan di storage/logs/laravel.log)');
    }
}
