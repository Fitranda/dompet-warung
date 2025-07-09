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

### 📈 Laporan Keuangan Profesional
- **Buku Besar (General Ledger)** - Detail transaksi per akun dengan running balance
- **Laporan Laba Rugi (Income Statement)** - Analisis profitabilitas dengan detail transaksi
- **Neraca (Balance Sheet)** - Posisi keuangan dengan pengecekan keseimbangan otomatis
- **Filter Canggih** - Filter berdasarkan periode, akun, dan tipe akun
- **Export Multi-Format** - PDF professional dan Excel (XLSX) dengan styling
- **Real-time Calculation** - Perhitungan otomatis saldo dan retained earnings

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
- **mPDF** - Professional PDF generation untuk laporan
- **PhpSpreadsheet** - Excel export dengan formula dan styling

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

# Install PDF and Excel export dependencies
composer require mpdf/mpdf
composer require phpoffice/phpspreadsheet

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

# Test specific laporan
php artisan test tests/Feature/ReportTest.php
```

### Testing Laporan Keuangan

```php
// Test Buku Besar
php artisan test --filter=test_general_ledger_shows_correct_data

// Test Export PDF
php artisan test --filter=test_export_pdf_generates_valid_file

// Test Export Excel  
php artisan test --filter=test_export_excel_creates_spreadsheet

// Test Filter Validation
php artisan test --filter=test_filter_validation_works
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

# Export endpoints
GET    /reports/general-ledger/pdf
GET    /reports/general-ledger/excel
GET    /reports/income-statement/pdf  
GET    /reports/income-statement/excel
GET    /reports/balance-sheet/pdf
GET    /reports/balance-sheet/excel
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

## 📊 Fitur Laporan Keuangan

Sistem ini menyediakan tiga laporan keuangan utama yang lengkap dengan fitur filter canggih dan export multi-format:

### 📋 Buku Besar (General Ledger)

Menampilkan detail transaksi untuk setiap akun dengan running balance yang akurat.

**Fitur Utama:**
- **Running Balance**: Saldo berjalan untuk setiap transaksi
- **Filter Multi-Kriteria**: Periode, akun spesifik, dan tipe akun
- **Summary Information**: Total debit, kredit, dan saldo akhir
- **Export PDF & Excel**: Format professional dengan styling konsisten

**Cara Menggunakan Filter:**
```
1. Pilih tanggal mulai dan akhir periode
2. Filter berdasarkan akun tertentu (opsional):
   - Ketik nama akun untuk pencarian real-time
   - Pilih dari dropdown yang tersedia
3. Filter berdasarkan tipe akun (opsional):
   - Asset, Liability, Equity, Revenue, Expense
4. Klik "Filter" untuk menerapkan atau "Reset" untuk mengosongkan
```

**Export Options:**
- **PDF**: Format landscape dengan header perusahaan dan metadata
- **Excel (XLSX)**: Spreadsheet dengan formula dan formatting profesional
- **Print**: Optimized untuk printer dengan page break yang tepat

### 💰 Laporan Laba Rugi (Income Statement)

Analisis profitabilitas dengan perhitungan laba/rugi bersih yang akurat.

**Komponen Laporan:**
- **Pendapatan (Revenue)**: Semua akun tipe Revenue
- **Beban (Expenses)**: Semua akun tipe Expense  
- **Laba/Rugi Bersih**: Selisih antara pendapatan dan beban

**Filter Tersedia:**
```
1. Periode Laporan:
   - Tanggal mulai dan tanggal akhir
   - Preset: Bulan ini, Tahun ini, Custom range
2. Include Detail:
   - ☑️ Tampilkan detail transaksi per akun
   - ☐ Hanya tampilkan summary per akun
```

**Detail Transaksi (jika diaktifkan):**
- Tanggal transaksi
- Nomor jurnal dan deskripsi
- Jumlah debit/kredit per transaksi
- Total per akun

**Export Features:**
- **PDF**: Portrait format dengan breakdown detail
- **Excel**: Multi-sheet dengan data mentah dan summary
- **Print**: Responsive layout untuk berbagai ukuran kertas

### ⚖️ Neraca (Balance Sheet)

Laporan posisi keuangan dengan pengecekan keseimbangan otomatis.

**Struktur Neraca:**
```
ASET (ASSETS)
├── Aset Lancar (Current Assets)
├── Aset Tetap (Non-Current Assets)
└── Total Aset

KEWAJIBAN & EKUITAS (LIABILITIES & EQUITY)
├── Kewajiban (Liabilities)
├── Ekuitas (Equity)
│   ├── Modal (Equity Accounts)
│   └── Laba Ditahan (Retained Earnings) - Otomatis
└── Total Kewajiban & Ekuitas
```

**Fitur Khusus:**
- **Auto Balance Check**: Sistem otomatis mengecek keseimbangan neraca
- **Retained Earnings**: Dihitung otomatis dari akumulasi laba/rugi
- **Multi-Level Grouping**: Pengelompokan berdasarkan tipe dan subtipe akun

**Filter Options:**
```
1. Tanggal Neraca:
   - Per tanggal tertentu (balance as of date)
   - Default: Tanggal hari ini
2. Include Detail:
   - ☑️ Tampilkan detail transaksi per akun
   - ☐ Hanya tampilkan saldo akhir per akun
```

**Validation Features:**
- **Balance Check**: Alert jika total aset ≠ total kewajiban + ekuitas
- **Missing Accounts**: Peringatan jika ada tipe akun yang belum ada
- **Zero Balance**: Option untuk menyembunyikan akun dengan saldo nol

### 🔧 Cara Menggunakan Filter

#### 1. Filter Periode
```html
<!-- Contoh filter tanggal -->
<input type="date" name="start_date" value="2024-01-01">
<input type="date" name="end_date" value="2024-12-31">
```

#### 2. Filter Akun
```html
<!-- Search dengan autocomplete -->
<input type="text" placeholder="Cari akun..." class="search-account">
<!-- atau dropdown -->
<select name="account_id">
  <option value="">Semua Akun</option>
  <option value="1">1-1000 Kas</option>
  <option value="2">1-1100 Bank</option>
</select>
```

#### 3. Filter Tipe Akun
```html
<select name="account_type">
  <option value="">Semua Tipe</option>
  <option value="asset">Aset</option>
  <option value="liability">Kewajiban</option>
  <option value="equity">Ekuitas</option>
  <option value="revenue">Pendapatan</option>
  <option value="expense">Beban</option>
</select>
```

### 📁 Export & Download

#### Export PDF
```php
// Generate PDF dengan mPDF
Route::get('/reports/{type}/pdf', [ReportController::class, 'exportPdf'])
    ->name('reports.export.pdf');

// Contoh URL:
// /reports/general-ledger/pdf?start_date=2024-01-01&end_date=2024-12-31
// /reports/income-statement/pdf?start_date=2024-01-01&end_date=2024-12-31&include_detail=1
// /reports/balance-sheet/pdf?as_of_date=2024-12-31&include_detail=1
```

**PDF Features:**
- Header dengan logo dan nama perusahaan
- Metadata: tanggal cetak, periode laporan, user
- Table styling dengan border dan shading
- Page numbering dan footer
- Landscape/Portrait sesuai konten

#### Export Excel (XLSX)
```php
// Generate Excel dengan PhpSpreadsheet
Route::get('/reports/{type}/excel', [ReportController::class, 'exportExcel'])
    ->name('reports.export.excel');

// Contoh URL:
// /reports/general-ledger/excel?account_id=1&start_date=2024-01-01
// /reports/income-statement/excel?include_detail=1
// /reports/balance-sheet/excel?as_of_date=2024-12-31
```

**Excel Features:**
- Multiple worksheets untuk data kompleks
- Cell formatting (currency, date, alignment)
- Formula untuk kalkulasi
- Auto column width
- Header styling dengan background color
- Freeze panes untuk header

### 🎨 Styling & UI

#### Responsive Design
```css
/* Mobile-first approach */
@media (max-width: 768px) {
  .report-table {
    overflow-x: auto;
  }
  .filter-container {
    flex-direction: column;
  }
}

/* Desktop enhancements */
@media (min-width: 1024px) {
  .report-layout {
    display: grid;
    grid-template-columns: 300px 1fr;
  }
}
```

#### Filter UI Components
```html
<!-- Modern filter dengan Tailwind CSS -->
<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <!-- Filter inputs -->
  </div>
  <div class="flex justify-between items-center mt-4">
    <button class="btn-primary">Terapkan Filter</button>
    <button class="btn-secondary">Reset</button>
  </div>
</div>
```

#### Table Styling
```html
<!-- Responsive table dengan alternating rows -->
<div class="overflow-x-auto">
  <table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
          Akun
        </th>
        <!-- ... columns ... -->
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
      <!-- Data rows dengan alternating background -->
    </tbody>
  </table>
</div>
```

### ⚡ Performance Tips

#### 1. Database Optimization
```php
// Index untuk query cepat
Schema::table('journal_details', function (Blueprint $table) {
    $table->index(['account_id', 'created_at']);
    $table->index(['journal_entry_id', 'account_id']);
});
```

#### 2. Query Optimization
```php
// Eager loading untuk menghindari N+1 queries
$journalDetails = JournalDetail::with(['account', 'journalEntry'])
    ->whereBetween('created_at', [$startDate, $endDate])
    ->orderBy('created_at')
    ->get();
```

#### 3. Caching untuk Report
```php
// Cache laporan untuk performa
$cacheKey = "report.{$type}.{$filters_hash}";
$report = Cache::remember($cacheKey, 3600, function () use ($filters) {
    return $this->generateReport($filters);
});
```

## 🔍 Contoh Penggunaan Fitur

### Membuat Laporan Buku Besar
```php
// Via web interface
1. Navigasi ke menu "Laporan" > "Buku Besar"
2. Pilih periode: 01/01/2024 - 31/12/2024
3. Filter akun: "1-1000 Kas" (opsional)
4. Klik "Tampilkan Laporan"
5. Export: Klik "Export PDF" atau "Export Excel"

// Via URL langsung
GET /reports/general-ledger?start_date=2024-01-01&end_date=2024-12-31&account_id=1
```

### Generate Laporan Laba Rugi dengan Detail
```php
// Dengan detail transaksi
GET /reports/income-statement?start_date=2024-01-01&end_date=2024-12-31&include_detail=1

// Export ke PDF
GET /reports/income-statement/pdf?start_date=2024-01-01&end_date=2024-12-31&include_detail=1

// Export ke Excel
GET /reports/income-statement/excel?start_date=2024-01-01&end_date=2024-12-31&include_detail=1
```

### Cetak Neraca per Tanggal Tertentu
```php
// Neraca per 31 Desember 2024
GET /reports/balance-sheet?as_of_date=2024-12-31

// Dengan detail transaksi
GET /reports/balance-sheet?as_of_date=2024-12-31&include_detail=1

// Export langsung ke PDF
GET /reports/balance-sheet/pdf?as_of_date=2024-12-31
```

### Filter Advanced dengan JavaScript
```javascript
// Auto-submit form ketika filter berubah
document.getElementById('account_id').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});

// Save filter state ke localStorage
function saveFilterState() {
    const filters = {
        start_date: document.getElementById('start_date').value,
        end_date: document.getElementById('end_date').value,
        account_id: document.getElementById('account_id').value
    };
    localStorage.setItem('reportFilters', JSON.stringify(filters));
}

// Restore filter state
function restoreFilterState() {
    const saved = localStorage.getItem('reportFilters');
    if (saved) {
        const filters = JSON.parse(saved);
        document.getElementById('start_date').value = filters.start_date || '';
        document.getElementById('end_date').value = filters.end_date || '';
        document.getElementById('account_id').value = filters.account_id || '';
    }
}
```

## ❗ Troubleshooting

### Common Issues

#### 1. PDF Export Error
```bash
# Jika error "Permission denied" pada folder temp
chmod 755 storage/app/temp
chown www-data:www-data storage/app/temp

# Jika mPDF error "Unable to create output file"
php artisan storage:link
php artisan cache:clear
```

#### 2. Excel Export Memory Limit
```php
// Tambahkan di .env untuk file Excel besar
PHP_MEMORY_LIMIT=512M

// Atau di config/app.php
ini_set('memory_limit', '512M');
```

#### 3. Filter Tidak Berfungsi
```php
// Pastikan validation rules benar di ReportController
$request->validate([
    'start_date' => 'required|date',
    'end_date' => 'required|date|after_or_equal:start_date',
    'account_id' => 'nullable|exists:accounts,id',
    'include_detail' => 'nullable|boolean'
]);
```

#### 4. Laporan Kosong
```sql
-- Cek data jurnal tersedia
SELECT COUNT(*) FROM journal_entries 
WHERE created_at BETWEEN '2024-01-01' AND '2024-12-31';

-- Cek relasi account
SELECT a.name, COUNT(jd.id) as transaction_count
FROM accounts a 
LEFT JOIN journal_details jd ON a.id = jd.account_id
GROUP BY a.id, a.name;
```

#### 5. Performance Issues
```php
// Add database indexes
php artisan make:migration add_indexes_for_reports

// In migration file:
Schema::table('journal_details', function (Blueprint $table) {
    $table->index(['account_id', 'created_at']);
    $table->index(['created_at', 'debit', 'credit']);
});

php artisan migrate
```

### FAQ

**Q: Bagaimana cara mengubah format tanggal di laporan?**
A: Edit file `config/app.php` dan ubah `'locale'` dan `'timezone'`, atau customize di masing-masing controller laporan.

**Q: Apakah bisa custom logo di PDF?**
A: Ya, ganti file logo di `public/images/logo.png` atau edit template PDF di ReportController.

**Q: Bagaimana cara menambah tipe akun baru?**
A: Tambahkan di enum `account_type` pada migration dan update validation di AccountController.

**Q: Apakah support multi-currency?**
A: Belum, saat ini hanya mendukung satu mata uang. Bisa dikembangkan dengan menambah field `currency` di table accounts.

**Q: Bagaimana cara backup data laporan?**
A: Gunakan export Excel untuk backup data, atau setup automated database backup dengan `mysqldump`.

### 📱 Mobile UI & UX

Aplikasi ini telah dioptimalkan penuh untuk penggunaan mobile dengan pendekatan mobile-first design.

**Mobile Sidebar Features:**
- **Consistent Menu Structure**: Menu mobile sama persis dengan desktop untuk konsistensi UX
- **In-Sidebar Close Button**: Tombol close (X) berada di dalam sidebar, bukan di luar
- **Touch-Friendly Navigation**: Semua tombol dan dropdown dioptimalkan untuk touch interaction
- **Responsive Dropdown**: Menu dropdown bekerja sempurna di semua screen sizes
- **Smooth Animations**: Transisi slide-in/slide-out yang smooth dengan Alpine.js

**Mobile-Specific Optimizations:**
```css
/* Responsive table untuk mobile */
@media (max-width: 768px) {
  .report-table {
    font-size: 0.875rem;
    overflow-x: auto;
  }
  
  .filter-controls {
    flex-direction: column;
    gap: 0.75rem;
  }
  
  .mobile-sidebar {
    transform: translateX(-100%);
    transition: transform 0.3s ease;
  }
  
  .mobile-sidebar.open {
    transform: translateX(0);
  }
}
```

**Touch Interactions:**
- Swipe gestures untuk sidebar navigation
- Long-press untuk context menus
- Pinch-to-zoom untuk detailed tables
- Pull-to-refresh untuk data updates

### ⚡ Memory Management & Performance

Aplikasi ini menggunakan teknik advanced memory management khususnya untuk export PDF yang besar.

**PDF Export Optimizations:**
```php
// Memory cleanup setelah PDF generation
public function exportPdf(Request $request)
{
    // Clear output buffers
    while (ob_get_level()) {
        ob_end_clean();
    }
    
    // Set memory limit
    ini_set('memory_limit', '512M');
    
    // Generate PDF
    $mpdf = new Mpdf([...]);
    $mpdf->WriteHTML($html);
    
    // Get content before cleanup
    $pdfContent = $mpdf->Output('', 'S');
    
    // Aggressive memory cleanup
    unset($data, $html, $mpdf);
    
    // Force garbage collection
    if (function_exists('gc_collect_cycles')) {
        gc_collect_cycles();
    }
    
    return response($pdfContent)
        ->header('Content-Type', 'application/pdf')
        ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
}
```

**Performance Features:**
- **Progressive Loading**: Data dimuat secara bertahap untuk laporan besar
- **Memory Flush**: Automatic memory cleanup setelah export
- **Garbage Collection**: Force GC untuk mencegah memory leaks
- **Output Buffer Management**: Proper OB handling untuk PDF generation
- **Temp File Cleanup**: Automatic cleanup temporary files

**Monitoring Memory Usage:**
```php
// Monitor memory usage selama export
$memoryBefore = memory_get_usage(true);
// ... process export ...
$memoryAfter = memory_get_usage(true);
Log::info('Memory used for export: ' . ($memoryAfter - $memoryBefore) . ' bytes');
```

**Cache Strategy:**
```php
// Cache laporan untuk performa optimal
$cacheKey = "report.{$type}.{$hash}";
$report = Cache::remember($cacheKey, 3600, function () {
    return $this->generateReport();
});
```

### 🖼️ Asset Management

**Logo & Favicon Setup:**
```
public/images/
├── logo.png              # Logo utama (512x512px recommended)
├── favicon.ico           # Favicon (16x16, 32x32, multi-size)
├── logo-placeholder.png  # Placeholder untuk development
├── favicon-placeholder.ico # Placeholder untuk development
└── assets/images/reports/ # Logo untuk PDF reports
```

**Adding Your Logo:**
1. Replace `public/images/logo.png` dengan logo perusahaan Anda
2. Replace `public/images/favicon.ico` dengan favicon Anda
3. Pastikan file logo berformat PNG/JPG dengan aspect ratio 1:1
4. Favicon sebaiknya multi-size ICO file (16x16, 32x32, 48x48)

**Fallback Behavior:**
- Jika logo.png tidak ditemukan, akan tampil icon SVG default
- Jika favicon.ico tidak ada, browser akan gunakan default
- Error handling dengan `onerror` attribute untuk graceful degradation
