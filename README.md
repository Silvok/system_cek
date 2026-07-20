# System Cek

System Cek adalah aplikasi berbasis Laravel dan Filament untuk mengelola pengecekan mesin/aset, maintenance, stok suku cadang, notifikasi, audit trail, dan laporan operasional. Sistem ini ditujukan untuk membantu perusahaan mencatat kondisi mesin secara rutin, menindaklanjuti ketidaksesuaian, serta menjaga histori maintenance dan penggunaan suku cadang agar mudah ditelusuri.

## Tujuan Sistem

- Mengelola data master mesin/aset beserta komponen, dokumen, status, dan informasi pengadaan.
- Menyediakan daftar pengecekan yang dapat ditugaskan ke operator.
- Mencatat hasil pengecekan rutin mesin/aset secara historis.
- Membuat laporan maintenance dari temuan ketidaksesuaian hasil pengecekan.
- Mengelola permintaan maintenance dan log pekerjaan teknisi.
- Mencatat pemakaian suku cadang dan transaksi stok.
- Menyediakan audit trail, notifikasi, dashboard, dan export laporan.

## Aktor Pengguna

| Aktor | Peran Utama |
| --- | --- |
| Super Admin | Memiliki akses penuh ke seluruh fitur, termasuk role dan permission. |
| Admin | Mengelola data operasional, master data, laporan, maintenance, dan suku cadang. |
| Supervisor/Teknisi | Menangani request maintenance, log perawatan, dan penggunaan suku cadang. |
| Operator | Melakukan pengecekan mesin/aset sesuai daftar pengecekan yang menjadi tanggung jawabnya. |
| Viewer | Melihat data sesuai permission yang diberikan. |

Catatan: pada seeder saat ini role teknisi direpresentasikan sebagai `Supervisor`.

## Fitur Utama

### Autentikasi dan Hak Akses

- Login dan logout pengguna.
- Reset password dan verifikasi email.
- Pengelolaan role dan permission menggunakan Spatie Permission dan Filament Shield.
- Pembatasan akses menu dan aksi berdasarkan permission.

### Manajemen Pengguna

- Pengelolaan data user, status aktif, employee ID, departemen, nomor telepon, dan password.
- User dapat memiliki satu atau lebih role.
- User dapat dinonaktifkan tanpa menghapus riwayat aktivitas.

### Master Mesin dan Komponen

- Pengelolaan mesin/aset, kode unik mesin, status, kondisi terakhir, penanggung jawab, foto, dan dokumen pendukung.
- Pengelolaan informasi pengadaan seperti supplier, invoice/PO, harga, garansi, umur ekonomis, dan estimasi penggantian.
- Pengelolaan komponen mesin, part number, lokasi pemasangan, supplier, harga, jumlah terpasang, dan jadwal penggantian.
- Indikator komponen atau mesin yang mendekati/melewati jadwal penggantian.

### Daftar Pengecekan dan Pengecekan

- Pembuatan daftar pengecekan untuk mesin/aset atau item operasional.
- Daftar pengecekan memiliki banyak komponen checklist dan standar pengecekan.
- Operator hanya melihat daftar pengecekan yang menjadi tanggung jawabnya.
- Sistem mencegah pengecekan ganda pada daftar pengecekan yang sama di tanggal yang sama.
- Hasil pengecekan menyimpan status sesuai, tidak sesuai, atau tidak dicek.
- Keterangan wajib diisi ketika komponen berstatus tidak sesuai.
- Riwayat pengecekan dapat difilter berdasarkan tanggal, operator, daftar pengecekan, dan status.

### Maintenance

- Laporan maintenance dapat dibuat otomatis saat ditemukan ketidaksesuaian dari hasil pengecekan.
- Sistem menyimpan status laporan maintenance: pending, in progress, dan completed.
- Foto sebelum maintenance menandai proses mulai berjalan.
- Foto sesudah maintenance menandai pekerjaan selesai.
- Teknisi dapat mengisi catatan pekerjaan dan suku cadang yang digunakan.
- Request maintenance memiliki nomor otomatis, mesin terkait, urgensi, status, pembuat request, dan audit trail.
- Status mesin disinkronkan menjadi `maintenance` ketika ada request aktif dan kembali `aktif` ketika tidak ada request aktif.

### Suku Cadang dan Transaksi Stok

- Pengelolaan kategori dan master suku cadang.
- Data suku cadang mencakup kode unik, nama, kategori, spesifikasi, satuan, stok, stok minimum/maksimum, lokasi, harga, supplier, foto, pengadaan, dan garansi.
- Status stok: habis, stok rendah, normal, dan over stock.
- Transaksi stok mendukung tipe `IN`, `OUT`, `RETURN`, dan `ADJUSTMENT`.
- Sistem mencatat stok sebelum, stok sesudah, user penginput, tanggal transaksi, dokumen pendukung, dan status approval.
- Stok tidak boleh menjadi negatif saat transaksi keluar.
- Penggunaan suku cadang pada maintenance dicatat sebagai transaksi stok keluar.

### Audit Trail dan Notifikasi

- Audit trail mencatat aktivitas penting pada mesin, request maintenance, log perawatan, dan penggunaan suku cadang.
- Notifikasi database digunakan untuk temuan ketidaksesuaian, request maintenance, pekerjaan dimulai, pekerjaan selesai, dan reminder penggantian.
- Panel Filament melakukan polling notifikasi database setiap 30 detik.

### Dashboard, Monitoring, dan Laporan

- Dashboard menampilkan ringkasan status mesin, pengecekan, maintenance, dan persediaan suku cadang.
- Tersedia widget statistik, tren request maintenance, reminder operator/teknisi, alert mesin, dan stok rendah.
- Laporan pengecekan dapat difilter berdasarkan periode dan daftar pengecekan.
- Export tersedia untuk laporan pengecekan, maintenance, master/detail mesin, dan transaksi suku cadang.

## Teknologi

- PHP 8.2+
- Laravel 12
- Filament 4
- MySQL/MariaDB
- Tailwind CSS 4
- Vite
- Spatie Laravel Permission
- Filament Shield
- Laravel Excel
- DomPDF

## Struktur Modul Kode

| Area | Lokasi |
| --- | --- |
| Model domain | `app/Models` |
| Resource Filament | `app/Filament/Resources` |
| Page dashboard/laporan | `app/Filament/Pages` |
| Widget dashboard | `app/Filament/Widgets` |
| Observer proses otomatis | `app/Observers` |
| Artisan command | `app/Console/Commands` |
| Export Excel | `app/Exports` |
| Controller export PDF | `app/Http/Controllers` |
| Migration database | `database/migrations` |
| Seeder data awal | `database/seeders` |
| View PDF dan Filament custom | `resources/views` |

Resource Filament utama:

- `Users\UserResource`
- `Roles\RoleResource`
- `MesinResource`
- `DaftarPengecekanResource`
- `PengecekanMesins\PengecekanMesinResource`
- `MaintenanceReports\MaintenanceReportResource`
- `MRequests\MRequestResource`
- `MLogs\MLogResource`
- `SpareParts\SparePartResource`
- `SparePartTransactionResource`

## Persyaratan Instalasi

- PHP 8.2 atau lebih baru
- Composer 2
- Node.js 18 atau lebih baru
- npm
- MySQL/MariaDB
- Web server lokal seperti Laragon, XAMPP, atau Laravel development server

## Instalasi

Clone repository dan masuk ke folder project:

```bash
git clone <repository-url>
cd system_cek
```

Install dependency PHP:

```bash
composer install
```

Buat file environment:

```bash
cp .env.example .env
```

Untuk Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Atur konfigurasi database di `.env`, lalu jalankan migration dan seeder:

```bash
php artisan migrate --seed
```

Buat storage link:

```bash
php artisan storage:link
```

Install dependency frontend dan build asset:

```bash
npm install
npm run build
```

Jalankan aplikasi:

```bash
php artisan serve
```

Untuk mode development penuh:

```bash
composer run dev
```

Perintah `composer run dev` menjalankan Laravel server, queue listener, dan Vite secara bersamaan.

## Konfigurasi `.env`

Minimal konfigurasi yang perlu disesuaikan:

```env
APP_NAME="System Cek"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
APP_TIMEZONE=Asia/Jakarta

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=system_cek
DB_USERNAME=root
DB_PASSWORD=
```

Untuk fitur email seperti reset password dan verifikasi email, sesuaikan konfigurasi `MAIL_*`.

## Akun Default

Seeder membuat akun awal berikut:

| Role | Email | Password |
| --- | --- | --- |
| Super Admin | `admin@system-cek.com` | `password` |
| Supervisor | `supervisor@system-cek.com` | `password` |

Ubah password default sebelum aplikasi dipakai di lingkungan non-local.

## Role Default

Role yang dibuat oleh seeder:

- `Super Admin`
- `Admin`
- `Supervisor`
- `Operator`
- `viewer`

Permission dikelola melalui Filament Shield pada panel admin.

## URL Aplikasi

- Halaman root: `/`
- Panel admin Filament: `/admin`
- Login admin: `/admin/login`
- Laporan pengecekan export: `/laporan/export-pdf` dan `/laporan/export-excel`
- Export transaksi suku cadang PDF: `/spare-part-transactions/pdf`
- Export mesin PDF: `/mesin/export/pdf`

Route export berada di dalam middleware `auth`.

## Alur Kerja Utama

### Pengecekan Harian

1. Admin membuat daftar pengecekan dan komponen checklist.
2. Admin menetapkan operator penanggung jawab.
3. Operator masuk ke sistem dan memulai pengecekan.
4. Operator mengisi status setiap komponen checklist.
5. Jika ditemukan status tidak sesuai, sistem membuat laporan maintenance dan mengirim notifikasi.
6. Hasil pengecekan disimpan sebagai riwayat.

### Maintenance Request

1. Pengguna berwenang membuat request maintenance untuk mesin tertentu.
2. Sistem memberi nomor request otomatis dan mengubah status mesin menjadi `maintenance` jika request aktif.
3. Teknisi/Supervisor membuat log perawatan.
4. Teknisi mengisi foto sebelum, catatan pekerjaan, penggunaan suku cadang, dan foto sesudah.
5. Setelah pekerjaan selesai, status request menjadi completed dan stok suku cadang diperbarui.
6. Jika tidak ada request aktif, status mesin dikembalikan menjadi `aktif`.

### Transaksi Suku Cadang

1. Admin atau user berwenang membuat transaksi masuk, keluar, retur, atau adjustment.
2. Sistem mencatat stok sebelum dan stok sesudah.
3. Transaksi yang disetujui memperbarui stok master.
4. Riwayat transaksi dapat dilihat dari detail suku cadang dan laporan transaksi.

## Artisan Command Penting

Sinkronisasi status mesin berdasarkan request maintenance aktif:

```bash
php artisan machine:sync-status
php artisan machine:sync-status --dry-run
```

Cek mesin dan komponen yang mendekati/melewati jadwal penggantian:

```bash
php artisan machine:check-replacement
php artisan machine:check-replacement --days=60
```

Audit konsistensi stok dan transaksi suku cadang:

```bash
php artisan sparepart:audit-stock
php artisan sparepart:audit-stock --fix
php artisan sparepart:audit-stock --spare-part-id=1
php artisan sparepart:audit-stock --include-pending
```

Command historis pengecekan masih tersedia, tetapi saat ini tidak diperlukan karena status "tidak dicek" direpresentasikan sebagai tidak adanya data pengecekan:

```bash
php artisan pengecekan:backfill
php artisan pengecekan:generate-daily
```

## Scheduler

Scheduler saat ini menjalankan:

- `machine:sync-status` setiap hari pukul `00:10` dengan timezone `Asia/Jakarta`.

Contoh cron untuk server Linux:

```bash
* * * * * cd /path/to/system_cek && php artisan schedule:run >> /dev/null 2>&1
```

Untuk Windows, gunakan Task Scheduler yang menjalankan:

```powershell
php artisan schedule:run
```

## Queue Worker

Jalankan queue worker jika menggunakan queue untuk notifikasi atau proses async:

```bash
php artisan queue:work
```

## Testing dan Quality Check

Jalankan test:

```bash
php artisan test
```

Bersihkan cache konfigurasi dan aplikasi:

```bash
php artisan optimize:clear
php artisan config:clear
```

Format kode PHP jika diperlukan:

```bash
./vendor/bin/pint
```

## Troubleshooting

| Masalah | Solusi |
| --- | --- |
| Halaman admin tidak memuat asset | Jalankan `npm run build`. |
| Perubahan route/config tidak terbaca | Jalankan `php artisan optimize:clear`. |
| File upload tidak tampil | Jalankan `php artisan storage:link`. |
| Notifikasi async tidak diproses | Jalankan `php artisan queue:work`. |
| Status mesin tidak sesuai request aktif | Jalankan `php artisan machine:sync-status --dry-run`, lalu `php artisan machine:sync-status`. |
| Stok suku cadang tidak konsisten | Jalankan `php artisan sparepart:audit-stock`, lalu `php artisan sparepart:audit-stock --fix` jika hasil audit sudah dicek. |

## Dokumentasi Pendukung

- [Kebutuhan Fungsional](KEBUTUHAN_FUNGSIONAL.md)
- [Use Case Sistem](USE_CASE_SISTEM.md)
- [ERD Sistem](ERD_SISTEM.md)
- [Manajemen Mesin](MANAJEMEN_MESIN_README.md)
- [Pengecekan](PENGECEKAN_README.md)
- [Maintenance](MAINTENANCE_README.md)
- [Monitoring](MONITORING_README.md)
- [Notifikasi](NOTIFIKASI_README.md)
- [Revisi Suku Cadang](SUKU_CADANG_REVISI.md)

## Catatan Pengembangan

- Hindari menghapus user, mesin, request, atau log yang sudah memiliki histori; gunakan status nonaktif atau status proses.
- Jalankan audit stok setelah perubahan besar pada alur transaksi suku cadang.
- Gunakan command `machine:sync-status --dry-run` sebelum sinkronisasi massal di data production.
- Pastikan permission Filament Shield dibuat/diperbarui setelah menambah resource baru.

## Lisensi

Project ini mengikuti lisensi dependensi Laravel dan package terkait, kecuali ditentukan lain oleh pemilik source code.
