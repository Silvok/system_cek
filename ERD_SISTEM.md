# Entity Relationship Diagram (ERD) Sistem

Dokumen ini berisi rancangan ERD sistem pengecekan dan maintenance aset operasional. ERD disusun berdasarkan struktur tabel utama pada aplikasi, relasi model Laravel, dan kebutuhan proses bisnis sistem.

## Entitas Utama

| Entitas | Keterangan |
| --- | --- |
| `users` | Menyimpan data pengguna sistem. |
| `roles` | Menyimpan data peran pengguna. |
| `model_has_roles` | Tabel penghubung antara pengguna dan role. |
| `mesins` | Menyimpan data master mesin/aset operasional. |
| `m_components` | Menyimpan data komponen dari master mesin/aset. |
| `daftar_pengecekan` | Menyimpan daftar aset atau item yang harus dilakukan pengecekan. |
| `komponen_daftar_pengecekan` | Menyimpan komponen checklist, standar, dan frekuensi pengecekan. |
| `pengecekan_mesins` | Menyimpan data utama aktivitas pengecekan. |
| `detail_pengecekan_daftar` | Menyimpan detail hasil pengecekan setiap komponen. |
| `maintenance_reports` | Menyimpan laporan maintenance yang dihasilkan dari hasil pengecekan tidak sesuai. |
| `m_requests` | Menyimpan permintaan maintenance terhadap mesin/aset. |
| `m_logs` | Menyimpan laporan perawatan atau tindak lanjut maintenance oleh teknisi. |
| `spare_part_categories` | Menyimpan kategori suku cadang. |
| `spare_parts` | Menyimpan data suku cadang. |
| `spare_part_transactions` | Menyimpan histori transaksi stok suku cadang. |
| `maintenance_report_spare_part` | Tabel penghubung penggunaan suku cadang pada laporan maintenance. |
| `m_log_spare_parts` | Tabel penghubung penggunaan suku cadang pada log maintenance. |
| `m_audits` | Menyimpan audit trail aktivitas maintenance. |
| `notifications` | Menyimpan notifikasi sistem. |

## Relasi Utama

| Relasi | Kardinalitas |
| --- | --- |
| `users` ke `roles` | Many-to-many melalui `model_has_roles`. |
| `users` ke `mesins` | One-to-many sebagai penanggung jawab mesin/aset. |
| `mesins` ke `m_components` | One-to-many. |
| `mesins` ke `m_requests` | One-to-many. |
| `m_components` ke `m_requests` | One-to-many. |
| `users` ke `m_requests` | One-to-many sebagai pembuat atau penyetuju request. |
| `m_requests` ke `m_logs` | One-to-many. |
| `users` ke `m_logs` | One-to-many sebagai teknisi. |
| `users` ke `daftar_pengecekan` | One-to-many sebagai operator penanggung jawab. |
| `daftar_pengecekan` ke `komponen_daftar_pengecekan` | One-to-many. |
| `daftar_pengecekan` ke `pengecekan_mesins` | One-to-many. |
| `users` ke `pengecekan_mesins` | One-to-many sebagai operator pelaksana pengecekan. |
| `pengecekan_mesins` ke `detail_pengecekan_daftar` | One-to-many. |
| `komponen_daftar_pengecekan` ke `detail_pengecekan_daftar` | One-to-many. |
| `detail_pengecekan_daftar` ke `maintenance_reports` | One-to-many. |
| `users` ke `maintenance_reports` | One-to-many sebagai teknisi. |
| `spare_part_categories` ke `spare_parts` | One-to-many. |
| `spare_parts` ke `spare_part_transactions` | One-to-many. |
| `maintenance_reports` ke `spare_parts` | Many-to-many melalui `maintenance_report_spare_part`. |
| `m_logs` ke `spare_parts` | Many-to-many melalui `m_log_spare_parts`. |
| `mesins`, `m_requests`, `m_logs`, dan `users` ke `m_audits` | One-to-many. |

## Diagram ERD

```mermaid
erDiagram
    USERS {
        bigint id PK
        string name
        string email
        string password
        string phone
        string employee_id
        string department
        boolean is_active
        timestamp email_verified_at
    }

    ROLES {
        bigint id PK
        string name
        string guard_name
    }

    MODEL_HAS_ROLES {
        bigint role_id FK
        bigint model_id FK
        string model_type
    }

    MESINS {
        bigint id PK
        string kode_mesin
        string nama_mesin
        string jenis_mesin
        string serial_number
        string manufacturer
        string model_number
        string status
        string kondisi_terakhir
        string foto
        bigint user_id FK
    }

    M_COMPONENTS {
        bigint id PK
        bigint mesin_id FK
        string nama_komponen
        string part_number
        text spesifikasi_teknis
        integer jadwal_ganti_bulan
        datetime tanggal_perawatan_terakhir
        datetime estimasi_tanggal_ganti_berikutnya
        string status_komponen
    }

    DAFTAR_PENGECEKAN {
        bigint id PK
        string nama_mesin
        bigint user_id FK
        text deskripsi
    }

    KOMPONEN_DAFTAR_PENGECEKAN {
        bigint id PK
        bigint mesin_id FK
        string nama_komponen
        string standar
        string frekuensi
        text catatan
    }

    PENGECEKAN_MESINS {
        bigint id PK
        bigint mesin_id FK
        bigint user_id FK
        datetime tanggal_pengecekan
        string status
    }

    DETAIL_PENGECEKAN_DAFTAR {
        bigint id PK
        bigint pengecekan_mesin_id FK
        bigint komponen_mesin_id FK
        string status_sesuai
        text keterangan
    }

    MAINTENANCE_REPORTS {
        bigint id PK
        bigint detail_pengecekan_mesin_id FK
        bigint mesin_id FK
        bigint komponen_mesin_id FK
        text issue_description
        string status
        string foto_sebelum
        string foto_sesudah
        text catatan_teknisi
        bigint teknisi_id FK
        timestamp tanggal_mulai
        timestamp tanggal_selesai
    }

    M_REQUESTS {
        bigint id PK
        string request_number
        bigint mesin_id FK
        bigint komponen_id FK
        bigint created_by FK
        datetime requested_at
        text problema_deskripsi
        string urgency_level
        string status
        bigint approved_by FK
    }

    M_LOGS {
        bigint id PK
        bigint m_request_id FK
        bigint teknisi_id FK
        datetime tanggal_mulai
        datetime tanggal_selesai
        text catatan_teknisi
        string foto_sebelum
        string foto_sesudah
        string status
    }

    SPARE_PART_CATEGORIES {
        bigint id PK
        string name
        text description
    }

    SPARE_PARTS {
        bigint id PK
        bigint category_id FK
        string kode_suku_cadang
        string nama_suku_cadang
        string satuan
        integer stok
        integer stok_minimal
    }

    SPARE_PART_TRANSACTIONS {
        bigint id PK
        bigint spare_part_id FK
        bigint user_id FK
        string tipe_transaksi
        datetime tanggal_transaksi
        integer jumlah
        integer stok_sebelum
        integer stok_sesudah
        string status_approval
        bigint approved_by FK
    }

    MAINTENANCE_REPORT_SPARE_PART {
        bigint maintenance_report_id FK
        bigint spare_part_id FK
        integer jumlah_digunakan
        text catatan
    }

    M_LOG_SPARE_PARTS {
        bigint m_log_id FK
        bigint spare_part_id FK
        integer jumlah_digunakan
        decimal harga_satuan
        text catatan
    }

    M_AUDITS {
        bigint id PK
        bigint mesin_id FK
        bigint m_request_id FK
        bigint m_log_id FK
        bigint user_id FK
        string action_type
        text deskripsi_perubahan
        json perubahan_data
    }

    NOTIFICATIONS {
        uuid id PK
        string type
        string notifiable_type
        bigint notifiable_id
        text data
        timestamp read_at
    }

    USERS ||--o{ MODEL_HAS_ROLES : memiliki
    ROLES ||--o{ MODEL_HAS_ROLES : diberikan

    USERS ||--o{ MESINS : bertanggung_jawab
    MESINS ||--o{ M_COMPONENTS : memiliki
    MESINS ||--o{ M_REQUESTS : memiliki
    M_COMPONENTS ||--o{ M_REQUESTS : terkait
    USERS ||--o{ M_REQUESTS : membuat
    USERS ||--o{ M_REQUESTS : menyetujui
    M_REQUESTS ||--o{ M_LOGS : ditindaklanjuti
    USERS ||--o{ M_LOGS : mengerjakan

    USERS ||--o{ DAFTAR_PENGECEKAN : bertanggung_jawab
    DAFTAR_PENGECEKAN ||--o{ KOMPONEN_DAFTAR_PENGECEKAN : memiliki
    DAFTAR_PENGECEKAN ||--o{ PENGECEKAN_MESINS : diperiksa
    USERS ||--o{ PENGECEKAN_MESINS : melakukan
    PENGECEKAN_MESINS ||--o{ DETAIL_PENGECEKAN_DAFTAR : memiliki
    KOMPONEN_DAFTAR_PENGECEKAN ||--o{ DETAIL_PENGECEKAN_DAFTAR : dicek
    DETAIL_PENGECEKAN_DAFTAR ||--o{ MAINTENANCE_REPORTS : menghasilkan
    USERS ||--o{ MAINTENANCE_REPORTS : menangani

    SPARE_PART_CATEGORIES ||--o{ SPARE_PARTS : mengelompokkan
    SPARE_PARTS ||--o{ SPARE_PART_TRANSACTIONS : memiliki
    USERS ||--o{ SPARE_PART_TRANSACTIONS : melakukan
    USERS ||--o{ SPARE_PART_TRANSACTIONS : menyetujui

    MAINTENANCE_REPORTS ||--o{ MAINTENANCE_REPORT_SPARE_PART : menggunakan
    SPARE_PARTS ||--o{ MAINTENANCE_REPORT_SPARE_PART : dipakai
    M_LOGS ||--o{ M_LOG_SPARE_PARTS : menggunakan
    SPARE_PARTS ||--o{ M_LOG_SPARE_PARTS : dipakai

    MESINS ||--o{ M_AUDITS : terkait
    M_REQUESTS ||--o{ M_AUDITS : mencatat
    M_LOGS ||--o{ M_AUDITS : mencatat
    USERS ||--o{ M_AUDITS : melakukan

    USERS ||--o{ NOTIFICATIONS : menerima
```

## Catatan Penulisan Skripsi

ERD ini berfokus pada tabel yang berkaitan langsung dengan proses bisnis sistem, yaitu pengelolaan pengguna, aset/mesin, pengecekan, maintenance, suku cadang, histori, dan notifikasi. Tabel teknis bawaan framework seperti `sessions`, `cache`, `jobs`, dan `password_reset_tokens` tidak dimasukkan karena tidak merepresentasikan proses bisnis utama.

