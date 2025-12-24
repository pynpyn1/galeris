# Galleris - Wedding & Event Photo Management System

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)

**Galleris** adalah platform manajemen galeri digital yang dirancang khusus untuk Fotografer dan _Wedding Organizer_. Platform ini memungkinkan penggunanya mengunggah foto/video resolusi tinggi, mengelola event, dan mendistribusikan link akses secara otomatis kepada tamu melalui integrasi WhatsApp.

## Author

-   **Danu O** (as Kimberlynn01)

---

## Fitur Utama

-   **High-Resolution Storage:** Simpan foto dan video dengan kualitas asli tanpa kompresi berlebih untuk menjaga kepuasan klien.
-   **Event Management:** Membuat folder khusus per event (pernikahan, engagement, dll) dengan sistem _privacy control_.
-   **WhatsApp Integration:** Kirim link galeri secara otomatis ke WhatsApp tamu undangan yang telah terdata.
-   **Subscription Plans:** Sistem paket berlangganan (Basic, Pro, Premium) dengan limit penyimpanan hingga 500GB.
-   **Guest Access:** Tamu dapat langsung melihat dan mengunduh foto melalui link unik yang diberikan.
-   **Automatic Cleanup:** Fitur pembersihan otomatis untuk folder trial yang kadaluwarsa melalui _Console Commands_.

---

## Tech Stack

-   **Backend:** Laravel 10 & NodeJS (as Express)
-   **Database:** MySQL
-   **Console:** Artisan Commands (Cron)
-   **API:** RESTful API untuk integrasi Client & Chatbot logic

---

## Paket Berlangganan (Seeded)

Proyek ini dilengkapi dengan 3 skema langganan utama:

| Paket       | Penyimpanan | Fitur Unggulan                  | Harga          |
| :---------- | :---------- | :------------------------------ | :------------- |
| **Basic**   | 12 GB       | Event tanpa batas, WhatsApp Bot | Rp 99.000/bln  |
| **Pro**     | 25 GB       | Tanpa watermark, Upload cepat   | Rp 199.000/bln |
| **Premium** | 30 GB       | Support Prioritas, WO & Studio  | Rp 499.000/bln |

### [1.0.0] - 2025-12-05

-   **Initial Release**
    -   Struktur database dasar: `Folders`, `Photos`, `Users`, `Packages`.
    -   CRUD dasar untuk semua controller (Photo, Folder, Guest, WhatsApp, Purchase, Payment, User, Subscription, Admin).
    -   **Fix:** Menangani error _permission denied_ saat sistem membuat folder penyimpanan baru di server.

### [1.0.1] - 2025-12-06

-   **PhotoController**
    -   **Fix:** Bug gagal menampilkan thumbnail untuk video `.mov`.
-   **FolderController**
    -   **Fix:** Bug folder tidak bisa dibuat jika nama mengandung karakter spesial.
-   **WhatsAppController**
    -   **Improvement:** Logging awal pengiriman pesan.
-   **Console Commands**
    -   **Added:** Command `ExpirePendingPurchases` untuk membatalkan pesanan _pending_.

### [1.1.0] - 2025-12-10

-   **PhotoController**
    -   **Added:** Sistem resize otomatis foto >10MB.
-   **GuestController**
    -   **Added:** Export daftar tamu ke CSV/XLSX.
-   **PurchaseController**
    -   **Added:** Flow upgrade/downgrade paket untuk user aktif.
    -   **Fix:** Status _pending_ yang tidak otomatis dibatalkan.
-   **WhatsAppController**
    -   **Fix:** Validasi format nomor telepon internasional dan lokal.
    -   **Improvement:** Logging lebih rinci pesan terkirim/gagal.
-   **PaymentController**
    -   **Added:** Integrasi midtrans & xendit untuk metode pembayaran tambahan.

### [1.2.0] - 2025-12-15

-   **PhotoController**
    -   **Added:** Batch upload dengan progress bar.
    -   **Fix:** Bug _timeout_ saat upload video >500MB.
    -   **Improvement:** Kompresi thumbnail untuk mempercepat load galeri.
-   **FolderController**
    -   **Added:** Duplikasi folder event dengan semua kontennya.
    -   **Fix:** Validasi folder duplikat user yang sama.
    -   **Improvement:** _Soft delete_ agar folder bisa dipulihkan.
-   **GuestController**
    -   **Fix:** Email notification gagal terkirim jika email kosong.
    -   **Improvement:** Pencarian dan filter tabel tamu per event.
-   **UserController**
    -   **Added:** Reset password & edit profil.
    -   **Fix:** Bug role admin gagal ubah hak akses user.
    -   **Improvement:** Validasi avatar <5MB.
-   **SubscriptionController**
    -   **Added:** Reminder otomatis paket hampir habis.
    -   **Fix:** Perhitungan limit penyimpanan saat upgrade paket.
    -   **Improvement:** Histori perubahan paket user di dashboard admin.
-   **AdminController**
    -   **Added:** Dashboard statistik event, tamu, storage.
    -   **Fix:** Bug filter event berdasar tanggal.
    -   **Improvement:** Grafik penggunaan storage realtime via AJAX.
-   **Console Commands**
    -   **Added:** `CleanupExpiredFolders` untuk membersihkan folder trial kadaluwarsa.
    -   **Fix:** Cron job `ExpirePendingPurchases` tidak mengulang entri.
    -   **Improvement:** Logging otomatis hasil cleanup ke `storage/logs/console.log`.

### [1.3.0] - 2025-12-18

-   **PurchaseController**
    -   **Added:** Sistem `Purchase` dan flow transaksi langganan.
-   **Console Commands**
    -   **Added:** `ExpirePendingPurchases` otomatis membatalkan pesanan tidak dibayar.
-   **PhotoController**
    -   **Fix:** Mengatasi _timeout_ saat mengunggah banyak foto resolusi tinggi bersamaan.
-   **WhatsAppController**
    -   **Fix:** Perbaikan validasi agar pesan tetap terkirim meski nomor tidak pakai format internasional.

---

### [1.3.5] - 2025-12-20

-   **DiscountCodeController**
    -   **Added:** Sistem `Discount` dalam flow transaksi langganan.
-   **Console Commands**
    -   **Added:** `DisableExpiredDiscounts` otomatis menonaktifkan diskon yang sudah hapus koutanya.

---

<!-- QrController + Payment Gateway -->

## Instalasi

1.  **Clone repository:**
    ```bash
    git clone [https://github.com/kimberlynn01/galleris.git](https://github.com/kimberlynn01/galleris.git)
    ```
2.  **Install dependencies:**
    ```bash
    composer install
    npm install && npm run dev
    ```
3.  **Konfigurasi Environment:**
    Salin `.env.example` ke `.env` dan sesuaikan koneksi database Anda.
4.  **Run migrations & seeders:**
    ```bash
    php artisan migrate --seed
    ```
    _Langkah ini akan mengisi database dengan data paket (Basic, Pro, Premium) dan user awal._

---

## Status Proyek

Project ini dikembangkan selama **2 minggu terakhir** (Desember 2025) untuk memberikan solusi praktis bagi industri wedding dalam mendistribusikan hasil karya fotografer ke tamu undangan secara instan.
