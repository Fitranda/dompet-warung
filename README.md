# 🏪 Dompet Warung - Sistem Akuntansi Digital UMKM

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

Sistem akuntansi digital yang mudah digunakan, dirancang khusus untuk UMKM (Usaha Mikro, Kecil, dan Menengah) dengan antarmuka yang modern dan responsif.

## ✨ Fitur Utama

### 📊 Manajemen Akuntansi
- **Kode Akun** - Pengelolaan chart of accounts dengan kategori lengkap
- **Jurnal Umum** - Pencatatan transaksi harian dengan validasi otomatis
- **Saldo Awal** - Setup saldo pembukaan untuk setiap akun
- **Neraca Saldo** - Ringkasan saldo per periode secara real-time

### 📈 Laporan Keuangan
- **Buku Besar** - Detail transaksi per akun
- **Neraca Lajur** - Worksheet untuk penyusunan laporan
- **Laporan Laba Rugi** - Income statement dengan analisis profitabilitas
- **Laporan Posisi Keuangan** - Balance sheet yang akurat

### 🎨 User Experience
- **Responsive Design** - Optimal di semua device (mobile, tablet, desktop)
- **Modern UI/UX** - Antarmuka yang clean dan intuitif
- **Dark/Light Mode** - Tema yang dapat disesuaikan
- **Progressive Web App** - Dapat diinstall seperti aplikasi native

## 🎨 Design System

Menggunakan color palette modern yang konsisten:
- **Primary**: `#0F172A` (Slate 900)
- **Secondary**: `#14B8A6` (Teal 500)
- **Accent**: `#67E8F9` (Cyan 300)
- **Background**: `#F8FAFC` (Slate 50)
- **Text**: `#334155` (Slate 600)

## 🚀 Teknologi yang Digunakan

### Backend
- **Laravel 11.x** - PHP framework untuk API dan business logic
- **MySQL** - Database relational untuk data persistence
- **Laravel Sanctum** - API authentication
- **Laravel Breeze** - Authentication scaffolding

### Frontend
- **Blade Templates** - Server-side rendering
- **Tailwind CSS** - Utility-first CSS framework
- **Alpine.js** - Minimal JavaScript framework
- **Vite** - Modern build tool dan asset bundling

### Development Tools
- **Laravel Pint** - Code styling (PSR-12)
- **PHPUnit** - Unit dan feature testing
- **Laravel Sail** - Docker development environment

## 📋 Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- MySQL >= 8.0 atau MariaDB >= 10.4
- Git

## ⚡ Quick Start

### 1. Clone Repository
```bash
git clone https://github.com/username/dompet-warung.git
cd dompet-warung
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup
```bash
# Configure database di .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dompet_warung
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Run migrations
php artisan migrate

# Seed sample data (optional)
php artisan db:seed
```

### 5. Build Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### 6. Start Development Server
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 🔧 Konfigurasi Lanjutan

### Laravel Sail (Docker)
```bash
# Start dengan Sail
./vendor/bin/sail up -d

# Install dependencies dalam container
./vendor/bin/sail composer install
./vendor/bin/sail npm install

# Run migrations
./vendor/bin/sail artisan migrate
```

### Environment Variables
```env
APP_NAME="Dompet Warung"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dompet_warung
DB_USERNAME=root
DB_PASSWORD=

# Mail (untuk notifikasi)
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## 📱 Responsive Design

Aplikasi ini dibangun dengan pendekatan **mobile-first** dan fully responsive:

- **Mobile (320px - 768px)**: Layout stack, touch-friendly buttons
- **Tablet (768px - 1024px)**: Grid layout 2-3 kolom
- **Desktop (1024px+)**: Full grid layout dengan sidebar

### Utility Classes Custom
```css
.mobile-responsive-text    /* Font scaling otomatis */
.mobile-touch-target       /* Minimum 44px untuk touch */
.mobile-card-grid         /* Responsive card layout */
.mobile-form-spacing      /* Consistent form spacing */
```

## 🎯 Fitur Responsif

### Navigation
- Collapsible sidebar di mobile
- Hamburger menu dengan animasi smooth
- Touch-friendly navigation items
- Breadcrumb untuk orientasi user

### Dashboard
- Adaptive card layout
- Responsive charts dan grafik
- Quick actions yang mudah diakses
- Statistics cards yang informatif

### Forms
- Auto-resize inputs
- Keyboard navigation support
- Error handling yang user-friendly
- Save state untuk prevent data loss

## 🧪 Testing

```bash
# Run semua tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run dengan coverage
php artisan test --coverage
```

## 📝 API Documentation

### Authentication Endpoints
```
POST   /api/login
POST   /api/register
POST   /api/logout
GET    /api/user
```

### Accounts Management
```
GET    /api/accounts
POST   /api/accounts
GET    /api/accounts/{id}
PUT    /api/accounts/{id}
DELETE /api/accounts/{id}
```

### Transactions
```
GET    /api/transactions
POST   /api/transactions
GET    /api/transactions/{id}
PUT    /api/transactions/{id}
DELETE /api/transactions/{id}
```

### Reports
```
GET    /api/reports/trial-balance
GET    /api/reports/income-statement
GET    /api/reports/balance-sheet
GET    /api/reports/general-ledger
```

## 🔒 Security Features

- **CSRF Protection** - Laravel built-in CSRF protection
- **XSS Prevention** - Input sanitization dan output escaping
- **SQL Injection Prevention** - Eloquent ORM dan prepared statements
- **Authentication** - Laravel Sanctum untuk API authentication
- **Authorization** - Role-based access control
- **Rate Limiting** - API rate limiting untuk prevent abuse

## 🚀 Deployment

### Production Setup
```bash
# Optimize untuk production
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build production assets
npm run build

# Set proper permissions
chmod -R 755 storage bootstrap/cache
```

### Server Requirements
- Nginx atau Apache
- PHP 8.2+ dengan extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- MySQL 8.0+ atau PostgreSQL 12+
- Composer
- SSL Certificate (recommended)

## 📊 Performance

### Optimizations
- **Lazy Loading** - Images dan components
- **Database Indexing** - Optimal query performance
- **Caching** - Redis untuk session dan cache
- **Asset Optimization** - Minified CSS/JS
- **CDN Ready** - Static assets can be served via CDN

### Monitoring
- Laravel Telescope untuk debugging (development)
- Laravel Horizon untuk queue monitoring
- Custom dashboard untuk system metrics

## 🤝 Contributing

Kami sangat menghargai kontribusi dari komunitas! Silakan ikuti panduan berikut:

### Development Workflow
1. Fork repository ini
2. Buat feature branch (`git checkout -b feature/amazing-feature`)
3. Commit perubahan (`git commit -m 'Add amazing feature'`)
4. Push ke branch (`git push origin feature/amazing-feature`)
5. Buat Pull Request

### Coding Standards
- Ikuti PSR-12 coding standards
- Gunakan Laravel Pint untuk formatting: `./vendor/bin/pint`
- Tulis tests untuk fitur baru
- Update dokumentasi sesuai perubahan

### Pull Request Checklist
- [ ] Code mengikuti style guidelines
- [ ] Self-review terhadap perubahan
- [ ] Komentar kode yang kompleks
- [ ] Tests yang relevan sudah ditambahkan
- [ ] Tests existing masih pass
- [ ] Dokumentasi sudah diupdate

## 📄 License

Proyek ini dilisensikan di bawah [MIT License](LICENSE) - lihat file LICENSE untuk detail lengkap.

## 👥 Tim Pengembang

- **Lead Developer**: [Your Name](https://github.com/yourusername)
- **UI/UX Designer**: [Designer Name](https://github.com/designerusername)
- **Backend Developer**: [Backend Dev](https://github.com/backenddev)

## 📞 Support & Contact

- **Email**: support@dompetwarung.com
- **Documentation**: [docs.dompetwarung.com](https://docs.dompetwarung.com)
- **Issues**: [GitHub Issues](https://github.com/username/dompet-warung/issues)
- **Discussions**: [GitHub Discussions](https://github.com/username/dompet-warung/discussions)

## 🙏 Acknowledgments

- Laravel Community untuk framework yang luar biasa
- Tailwind CSS untuk utility-first CSS framework
- Heroicons untuk icon set yang beautiful
- Komunitas open source yang supportif

---

<div align="center">

**⭐ Jika proyek ini membantu, jangan lupa berikan star!**

[Demo](https://demo.dompetwarung.com) • [Documentation](https://docs.dompetwarung.com) • [Support](mailto:support@dompetwarung.com)

</div>
