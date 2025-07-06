<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email : Email address to send test email to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to verify email configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        $this->info('Testing email configuration...');
        $this->info('Sending test email to: ' . $email);

        try {
            Mail::raw('Ini adalah test email dari Dompet Warung. Jika Anda menerima email ini, konfigurasi email sudah benar!', function ($message) use ($email) {
                $message->to($email)
                        ->subject('Test Email - Dompet Warung')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            $this->info('✅ Email test berhasil dikirim!');
            $this->info('Silakan cek inbox email Anda.');

            // Log the test
            Log::info('Test email sent successfully to: ' . $email);

        } catch (\Exception $e) {
            $this->error('❌ Email test gagal dikirim!');
            $this->error('Error: ' . $e->getMessage());

            // Log the error
            Log::error('Test email failed: ' . $e->getMessage());

            $this->newLine();
            $this->warn('💡 Tips troubleshooting:');
            $this->line('1. Pastikan konfigurasi MAIL_* di file .env sudah benar');
            $this->line('2. Untuk Gmail, gunakan App Password bukan password biasa');
            $this->line('3. Pastikan MAIL_ENCRYPTION sesuai (tls/ssl)');
            $this->line('4. Cek firewall yang mungkin memblokir koneksi SMTP');

            return 1;
        }

        return 0;
    }
}
