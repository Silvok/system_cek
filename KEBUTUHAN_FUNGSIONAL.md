# Kebutuhan Fungsional Sistem

Dokumen ini berisi kebutuhan fungsional untuk Sistem Cek, yaitu sistem pengecekan, maintenance, manajemen mesin, suku cadang, pelaporan, audit, dan notifikasi. Kebutuhan disusun berdasarkan ERD, modul aplikasi Laravel Filament, dan alur bisnis yang terdapat pada sistem.

## Tujuan Sistem

Sistem bertujuan membantu perusahaan dalam mengelola data mesin/aset operasional, menjadwalkan dan mencatat pengecekan rutin, menindaklanjuti ketidaksesuaian melalui proses maintenance, mengelola penggunaan suku cadang, serta menyediakan laporan dan riwayat aktivitas yang dapat ditelusuri.

## Aktor Sistem

| Aktor | Deskripsi |
| --- | --- |
| Super Admin | Pengguna dengan akses penuh ke seluruh fitur sistem, termasuk role dan permission. |
| Admin | Pengguna yang mengelola data operasional sistem, master data, laporan, maintenance, dan suku cadang. |
| Operator | Pengguna yang bertanggung jawab melakukan pengecekan mesin/aset sesuai daftar pengecekan. |
| Teknisi | Pengguna yang menangani laporan atau permintaan maintenance, mengisi log pekerjaan, dan mencatat penggunaan suku cadang. |

## Kebutuhan Fungsional

### 1. Autentikasi dan Otorisasi

| Kode | Kebutuhan Fungsional |
| --- | --- |
| KF-001 | Sistem harus menyediakan fitur login bagi pengguna terdaftar. |
| KF-002 | Sistem harus menyediakan fitur logout untuk mengakhiri sesi pengguna. |
| KF-003 | Sistem harus menyediakan fitur lupa password dan reset password. |
| KF-004 | Sistem harus mengelola hak akses berdasarkan role pengguna. |
| KF-005 | Sistem harus membatasi akses menu dan aksi berdasarkan permission pengguna. |
| KF-006 | Sistem harus menyediakan role Super Admin, Admin, Operator, dan Teknisi. |
| KF-007 | Sistem harus memungkinkan Super Admin mengelola role dan permission. |

### 2. Manajemen Pengguna

| Kode | Kebutuhan Fungsional |
| --- | --- |
| KF-008 | Sistem harus memungkinkan pengelolaan data pengguna. |
| KF-009 | Sistem harus menyimpan data nama, email, nomor telepon, employee ID, departemen, status aktif, dan password pengguna. |
| KF-010 | Sistem harus memungkinkan pengguna diberi satu atau lebih role. |
| KF-011 | Sistem harus dapat menampilkan daftar pengguna beserta role dan statusnya. |
| KF-012 | Sistem harus dapat menonaktifkan pengguna tanpa menghapus riwayat aktivitasnya. |

### 3. Manajemen Master Mesin/Aset

| Kode | Kebutuhan Fungsional |
| --- | --- |
| KF-013 | Sistem harus memungkinkan Admin atau pengguna berwenang menambah data mesin/aset. |
| KF-014 | Sistem harus menyimpan identitas mesin seperti kode mesin, nama mesin, jenis mesin, serial number, manufaktur, model, dan tahun pembuatan. |
| KF-015 | Sistem harus memastikan kode mesin bersifat unik. |
| KF-016 | Sistem harus menyimpan status mesin, yaitu aktif, nonaktif, maintenance, atau rusak. |
| KF-017 | Sistem harus menyimpan kondisi terakhir mesin. |
| KF-018 | Sistem harus memungkinkan mesin memiliki penanggung jawab. |
| KF-019 | Sistem harus menyimpan informasi pengadaan mesin seperti tanggal pengadaan, harga pengadaan, nomor invoice/PO, supplier, garansi, umur ekonomis, dan estimasi penggantian. |
| KF-020 | Sistem harus menghitung estimasi penggantian mesin berdasarkan tanggal pengadaan dan umur ekonomis. |
| KF-021 | Sistem harus memungkinkan upload foto mesin. |
| KF-022 | Sistem harus menyimpan dokumen pendukung atau referensi dokumen mesin. |
| KF-023 | Sistem harus menyediakan fitur pencarian, filter, melihat detail, mengubah, dan menghapus data mesin sesuai hak akses. |
| KF-024 | Sistem harus menampilkan riwayat komponen, maintenance, dan audit yang terkait dengan mesin. |
| KF-025 | Sistem harus menyediakan export laporan detail mesin dan daftar mesin. |

### 4. Manajemen Komponen Mesin

| Kode | Kebutuhan Fungsional |
| --- | --- |
| KF-026 | Sistem harus memungkinkan setiap mesin memiliki satu atau lebih komponen. |
| KF-027 | Sistem harus menyimpan data komponen seperti nama komponen, manufaktur, part number, lokasi pemasangan, spesifikasi teknis, supplier, harga, jumlah terpasang, dan catatan. |
| KF-028 | Sistem harus menyimpan jadwal penggantian komponen dalam satuan bulan. |
| KF-029 | Sistem harus menyimpan tanggal perawatan terakhir komponen. |
| KF-030 | Sistem harus menghitung estimasi tanggal penggantian berikutnya berdasarkan tanggal perawatan terakhir dan jadwal ganti. |
| KF-031 | Sistem harus menyimpan status komponen seperti normal, perlu ganti, atau rusak. |
| KF-032 | Sistem harus menampilkan indikator komponen yang aman, mendekati jadwal ganti, atau melewati jadwal ganti. |
| KF-033 | Sistem harus mengirim reminder untuk komponen yang mendekati atau melewati jadwal penggantian. |

### 5. Manajemen Daftar Pengecekan

| Kode | Kebutuhan Fungsional |
| --- | --- |
| KF-034 | Sistem harus memungkinkan pembuatan daftar pengecekan untuk mesin/aset atau item operasional. |
| KF-035 | Sistem harus menyimpan nama item pengecekan, deskripsi, dan operator yang bertanggung jawab. |
| KF-036 | Sistem harus membatasi satu operator agar hanya bertanggung jawab pada satu daftar pengecekan aktif. |
| KF-037 | Sistem harus memungkinkan daftar pengecekan memiliki banyak komponen checklist. |
| KF-038 | Sistem harus menyimpan nama komponen checklist, standar pengecekan, frekuensi pengecekan, dan catatan. |
| KF-039 | Sistem harus menyediakan fitur tambah, ubah, hapus, lihat, cari, dan filter daftar pengecekan sesuai hak akses. |

### 6. Pengecekan Mesin/Aset

| Kode | Kebutuhan Fungsional |
| --- | --- |
| KF-040 | Sistem harus memungkinkan operator memulai pengecekan pada daftar pengecekan yang menjadi tanggung jawabnya. |
| KF-041 | Sistem harus hanya menampilkan daftar pengecekan yang belum diperiksa pada hari berjalan. |
| KF-042 | Sistem harus mencegah pengecekan lebih dari satu kali untuk daftar pengecekan yang sama pada tanggal yang sama. |
| KF-043 | Sistem harus mencatat operator yang melakukan pengecekan sebagai data historis. |
| KF-044 | Sistem harus menampilkan semua komponen checklist beserta standar pengecekannya saat pengecekan dimulai. |
| KF-045 | Sistem harus memungkinkan operator mengisi status setiap komponen, yaitu sesuai, tidak sesuai, atau tidak dicek jika fitur tersebut digunakan. |
| KF-046 | Sistem harus mewajibkan keterangan apabila komponen berstatus tidak sesuai. |
| KF-047 | Sistem harus menyimpan tanggal dan waktu pengecekan. |
| KF-048 | Sistem harus menyimpan status pengecekan seperti selesai, dalam proses, atau tidak dicek. |
| KF-049 | Sistem harus menyediakan riwayat pengecekan yang dapat dilihat berdasarkan tanggal, operator, daftar pengecekan, dan status. |
| KF-050 | Sistem harus membuat data hasil pengecekan bersifat read-only untuk operator setelah pengecekan disimpan, kecuali pengguna yang memiliki hak edit. |

### 7. Laporan Maintenance dari Hasil Pengecekan

| Kode | Kebutuhan Fungsional |
| --- | --- |
| KF-051 | Sistem harus otomatis membuat laporan maintenance ketika hasil pengecekan memiliki komponen berstatus tidak sesuai. |
| KF-052 | Sistem harus mencegah duplikasi laporan maintenance untuk ketidaksesuaian yang sama. |
| KF-053 | Sistem harus menyimpan mesin, komponen, deskripsi masalah, status laporan, teknisi, catatan teknisi, foto sebelum, foto sesudah, tanggal mulai, dan tanggal selesai. |
| KF-054 | Sistem harus menyediakan status laporan maintenance yaitu pending, in progress, dan completed. |
| KF-055 | Sistem harus mengubah status dari pending menjadi in progress setelah foto sebelum maintenance diunggah. |
| KF-056 | Sistem harus mencatat tanggal mulai maintenance saat proses maintenance dimulai. |
| KF-057 | Sistem harus memungkinkan teknisi mengisi catatan pekerjaan maintenance. |
| KF-058 | Sistem harus memungkinkan teknisi mencatat suku cadang yang digunakan pada laporan maintenance. |
| KF-059 | Sistem harus mengubah status menjadi completed setelah foto sesudah maintenance diunggah. |
| KF-060 | Sistem harus mencatat tanggal selesai maintenance saat laporan selesai. |
| KF-061 | Sistem harus mengurangi stok suku cadang sesuai jumlah yang digunakan saat maintenance selesai. |
| KF-062 | Sistem harus mencegah perubahan laporan maintenance yang sudah completed, kecuali oleh pengguna yang memiliki hak khusus. |

### 8. Permintaan Maintenance

| Kode | Kebutuhan Fungsional |
| --- | --- |
| KF-063 | Sistem harus memungkinkan pengguna berwenang membuat permintaan maintenance. |
| KF-064 | Sistem harus menghasilkan nomor request maintenance secara otomatis dan unik. |
| KF-065 | Sistem harus menyimpan mesin, komponen opsional, pembuat request, tanggal request, deskripsi masalah, tingkat urgensi, dan status request. |
| KF-066 | Sistem harus menyediakan tingkat urgensi low, medium, high, dan critical. |
| KF-067 | Sistem harus menyediakan status request seperti pending, in progress, dan completed. |
| KF-068 | Sistem harus mengirim notifikasi saat request maintenance dibuat. |
| KF-069 | Sistem harus mencatat audit trail saat request maintenance dibuat, diperbarui, atau selesai. |
| KF-070 | Sistem harus mengubah status mesin menjadi maintenance ketika terdapat request aktif. |
| KF-071 | Sistem harus mengembalikan status mesin menjadi aktif ketika tidak ada request maintenance aktif. |

### 9. Log Perawatan/Maintenance

| Kode | Kebutuhan Fungsional |
| --- | --- |
| KF-072 | Sistem harus memungkinkan teknisi membuat log perawatan berdasarkan request maintenance yang belum selesai. |
| KF-073 | Sistem harus menyimpan teknisi, tanggal mulai, tanggal selesai, status pekerjaan, foto sebelum, foto sesudah, dan catatan pekerjaan. |
| KF-074 | Sistem harus memungkinkan teknisi mencatat suku cadang yang digunakan pada log perawatan. |
| KF-075 | Sistem harus mencatat status pekerjaan seperti in progress, submitted, dan completed. |
| KF-076 | Sistem harus mengurangi stok suku cadang secara otomatis saat log perawatan selesai atau disubmit sesuai alur sistem. |
| KF-077 | Sistem harus membuat transaksi stok keluar untuk setiap suku cadang yang digunakan pada log perawatan. |
| KF-078 | Sistem harus mengubah status request menjadi completed ketika log perawatan selesai. |
| KF-079 | Sistem harus mencatat audit trail saat teknisi memulai dan menyelesaikan pekerjaan. |

### 10. Manajemen Suku Cadang

| Kode | Kebutuhan Fungsional |
| --- | --- |
| KF-080 | Sistem harus memungkinkan pengelolaan kategori suku cadang. |
| KF-081 | Sistem harus memungkinkan pembuatan kategori baru saat input suku cadang. |
| KF-082 | Sistem harus memungkinkan pengelolaan master suku cadang. |
| KF-083 | Sistem harus menyimpan kode, nama, kategori, deskripsi, spesifikasi teknis, foto, status, satuan, stok, stok minimum, stok maksimum, lokasi penyimpanan, harga satuan, supplier, tanggal pengadaan, tahun pengadaan, dan informasi garansi. |
| KF-084 | Sistem harus memastikan kode suku cadang bersifat unik. |
| KF-085 | Sistem harus menghitung nilai total stok berdasarkan stok dan harga satuan. |
| KF-086 | Sistem harus menampilkan status stok seperti habis, stok rendah, normal, dan over stock. |
| KF-087 | Sistem harus menampilkan indikator garansi aktif, akan berakhir, atau sudah berakhir. |
| KF-088 | Sistem harus menyediakan pencarian dan filter suku cadang berdasarkan kategori, status, dan status stok. |
| KF-089 | Sistem harus mencegah stok menjadi negatif saat transaksi keluar. |

### 11. Transaksi Suku Cadang

| Kode | Kebutuhan Fungsional |
| --- | --- |
| KF-090 | Sistem harus mencatat setiap perubahan stok suku cadang sebagai transaksi. |
| KF-091 | Sistem harus menghasilkan nomor transaksi suku cadang secara otomatis dan unik. |
| KF-092 | Sistem harus mendukung tipe transaksi masuk, keluar, retur, dan adjustment. |
| KF-093 | Sistem harus menyimpan tanggal transaksi, pengguna penginput, jumlah, stok sebelum, stok sesudah, keterangan, dokumen pendukung, dan status approval. |
| KF-094 | Sistem harus menyediakan aksi cepat tambah stok dari daftar suku cadang. |
| KF-095 | Sistem harus menyediakan aksi cepat kurangi stok dari daftar suku cadang. |
| KF-096 | Sistem harus memperbarui stok setelah transaksi disetujui atau auto-approved. |
| KF-097 | Sistem harus melakukan auto-approval untuk transaksi tertentu sesuai aturan sistem, misalnya transaksi masuk atau transaksi oleh Admin/Super Admin. |
| KF-098 | Sistem harus menyediakan riwayat transaksi pada detail suku cadang. |
| KF-099 | Sistem harus menyediakan laporan transaksi suku cadang yang dapat difilter berdasarkan tipe, suku cadang, dan periode tanggal. |

### 12. Audit Trail

| Kode | Kebutuhan Fungsional |
| --- | --- |
| KF-100 | Sistem harus mencatat audit trail untuk aktivitas penting pada mesin, request maintenance, log perawatan, dan penggunaan suku cadang. |
| KF-101 | Sistem harus menyimpan user pelaku, jenis aksi, waktu, deskripsi perubahan, data perubahan, IP address, dan user agent. |
| KF-102 | Sistem harus menampilkan audit trail pada detail mesin atau data terkait. |
| KF-103 | Sistem harus menjaga riwayat audit agar dapat digunakan untuk penelusuran dan pemeriksaan. |

### 13. Notifikasi

| Kode | Kebutuhan Fungsional |
| --- | --- |
| KF-104 | Sistem harus mengirim notifikasi ketika operator menemukan ketidaksesuaian saat pengecekan. |
| KF-105 | Sistem harus mengirim notifikasi ketika laporan maintenance selesai. |
| KF-106 | Sistem harus mengirim notifikasi ketika request maintenance dibuat. |
| KF-107 | Sistem harus mengirim notifikasi ketika teknisi mulai menangani request maintenance. |
| KF-108 | Sistem harus mengirim notifikasi ketika request maintenance selesai. |
| KF-109 | Sistem harus mengirim reminder komponen dan mesin yang mendekati atau melewati jadwal penggantian. |
| KF-110 | Sistem harus menampilkan badge jumlah notifikasi yang belum dibaca. |
| KF-111 | Sistem harus memungkinkan pengguna membuka notifikasi menuju halaman detail terkait. |
| KF-112 | Sistem harus memperbarui notifikasi secara berkala melalui database notification polling. |

### 14. Dashboard dan Monitoring

| Kode | Kebutuhan Fungsional |
| --- | --- |
| KF-113 | Sistem harus menyediakan dashboard untuk menampilkan ringkasan kondisi mesin, status pengecekan, maintenance, dan persediaan suku cadang. |
| KF-114 | Sistem harus menampilkan statistik jumlah mesin berdasarkan status. |
| KF-115 | Sistem harus menampilkan alert komponen atau mesin yang membutuhkan perhatian. |
| KF-116 | Sistem harus menampilkan tren request maintenance. |
| KF-117 | Sistem harus menampilkan ringkasan status pengecekan. |
| KF-118 | Sistem harus menampilkan reminder tugas pengecekan untuk operator. |
| KF-119 | Sistem harus menampilkan reminder pekerjaan maintenance untuk teknisi/petugas maintenance. |
| KF-120 | Sistem harus menampilkan ringkasan stok suku cadang dan kondisi stok rendah. |

### 15. Laporan dan Export

| Kode | Kebutuhan Fungsional |
| --- | --- |
| KF-121 | Sistem harus menyediakan laporan pengecekan mesin/aset. |
| KF-122 | Sistem harus memungkinkan laporan pengecekan difilter berdasarkan periode harian, mingguan, bulanan, tahunan, custom range, dan daftar pengecekan tertentu. |
| KF-123 | Sistem harus menampilkan ringkasan total daftar pengecekan, total pengecekan, total sesuai, dan total tidak sesuai. |
| KF-124 | Sistem harus menyediakan export laporan pengecekan ke PDF. |
| KF-125 | Sistem harus menyediakan export laporan pengecekan ke Excel. |
| KF-126 | Sistem harus menyediakan laporan maintenance. |
| KF-127 | Sistem harus menyediakan export laporan maintenance ke PDF atau Excel sesuai fitur yang tersedia. |
| KF-128 | Sistem harus menyediakan export master/detail mesin. |
| KF-129 | Sistem harus menyediakan laporan transaksi suku cadang. |
| KF-130 | Sistem harus menyediakan export transaksi suku cadang ke PDF. |

### 16. Proses Otomatis Sistem

| Kode | Kebutuhan Fungsional |
| --- | --- |
| KF-131 | Sistem harus menjalankan sinkronisasi status mesin berdasarkan request maintenance aktif. |
| KF-132 | Sistem harus menyediakan command untuk menjalankan sinkronisasi status mesin secara manual. |
| KF-133 | Sistem harus menyediakan command untuk mengecek mesin atau komponen yang mendekati jadwal penggantian. |
| KF-134 | Sistem harus menyediakan command untuk audit konsistensi stok dan transaksi suku cadang. |
| KF-135 | Sistem harus menyediakan opsi repair pada audit stok apabila ditemukan ketidaksesuaian data. |
| KF-136 | Sistem harus mendukung scheduler agar proses otomatis dapat berjalan secara berkala. |

## Ringkasan Modul Sistem

| Modul | Fungsi Utama |
| --- | --- |
| Pengguna dan Role | Mengelola akun, role, permission, dan hak akses. |
| Master Mesin | Mengelola data mesin/aset, status, dokumentasi, pengadaan, dan umur ekonomis. |
| Komponen Mesin | Mengelola detail komponen, jadwal ganti, status komponen, dan reminder. |
| Daftar Pengecekan | Mengelola checklist, standar pengecekan, frekuensi, dan operator penanggung jawab. |
| Pengecekan | Mencatat hasil pengecekan rutin oleh operator. |
| Laporan Maintenance | Menindaklanjuti ketidaksesuaian hasil pengecekan. |
| Request Maintenance | Mencatat permintaan maintenance dan status penanganan. |
| Log Perawatan | Mencatat pekerjaan teknisi dan penggunaan suku cadang. |
| Suku Cadang | Mengelola master spare part, kategori, stok, garansi, dan lokasi penyimpanan. |
| Transaksi Stok | Mencatat keluar masuk stok dan histori penggunaan suku cadang. |
| Audit Trail | Mencatat riwayat aktivitas penting untuk traceability. |
| Notifikasi | Memberikan pemberitahuan otomatis untuk kejadian penting. |
| Laporan | Menyediakan laporan dan export data untuk evaluasi serta dokumentasi. |
