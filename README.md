# Sistem Informasi Gereja GKI Sudirman

## Deskripsi

Sistem Informasi Gereja GKI Sudirman merupakan aplikasi berbasis web yang dikembangkan untuk membantu pengelolaan data dan penyebaran informasi gereja secara digital. Sistem ini menyediakan berbagai fitur yang mendukung administrasi gereja, pengelolaan jemaat, publikasi warta jemaat, renungan harian, jadwal ibadah, serta informasi pelayanan gerejawi.

Aplikasi ini dikembangkan menggunakan framework Laravel dengan antarmuka yang responsif sehingga dapat diakses oleh jemaat maupun pengurus gereja melalui berbagai perangkat.

---

## Fitur Utama

### Halaman Publik

* Informasi profil gereja
* Visi dan misi gereja
* Renungan harian berdasarkan kategori
* Warta jemaat aktif
* Jadwal kegiatan mingguan
* Informasi ulang tahun jemaat
* Jadwal dan informasi ibadah
* Daftar pelayanan ibadah
* Detail khotbah dan video ibadah

### Halaman Administrasi

* Manajemen data jemaat
* Manajemen rayon
* Manajemen komisi
* Manajemen pelayan
* Manajemen pengkhotbah
* Manajemen kalender liturgi
* Manajemen renungan
* Manajemen warta jemaat
* Manajemen jadwal ibadah
* Manajemen pelayanan ibadah
* Manajemen informasi gereja

---

## Teknologi yang Digunakan

### Backend

* PHP 8+
* Laravel 12
* MySQL

### Frontend

* Blade Template Engine
* Tailwind CSS
* Alpine.js
* Font Awesome

### Tools

* Composer
* NPM
* Vite

---

## Struktur Modul

### Jemaat

Mengelola data jemaat aktif maupun nonaktif beserta informasi pribadi dan keanggotaannya.

### Rayon

Mengelola pembagian rayon dan anggota jemaat pada masing-masing rayon.

### Komisi

Mengelola kegiatan pelayanan berdasarkan komisi seperti:

* Remaja
* Pemuda
* Sekolah Minggu
* Usia Indah
* Komisi lainnya

### Renungan

Mengelola publikasi renungan berdasarkan kategori pelayanan.

### Warta Jemaat

Mengelola pengumuman gereja dengan periode tayang tertentu sehingga hanya pengumuman aktif yang ditampilkan kepada jemaat.

### Ibadah

Mengelola informasi ibadah, antara lain:

* Tema khotbah
* Pengkhotbah
* Kalender liturgi
* Ayat Alkitab
* Video ibadah
* Jadwal pelayanan

### Pelayanan Ibadah

Mengelola petugas pelayanan berdasarkan bidang pelayanan dan jadwal ibadah.

---

## Instalasi

### Clone Repository

```bash
git clone https://github.com/username/nama-repository.git
cd nama-repository
```

### Install Dependency

```bash
composer install
npm install
```

### Konfigurasi Environment

Salin file `.env.example` menjadi `.env`

```bash
cp .env.example .env
```

Atur konfigurasi database pada file `.env`.

### Generate Key

```bash
php artisan key:generate
```

### Migrasi Database

```bash
php artisan migrate
```

### Menjalankan Seeder (Opsional)

```bash
php artisan db:seed
```

### Menjalankan Aplikasi

```bash
php artisan serve
npm run dev
```

---

## Hak Akses

### Administrator

Memiliki akses penuh terhadap seluruh modul dan data pada sistem.

### Jemaat

Dapat mengakses informasi publik seperti:

* Warta Jemaat
* Renungan
* Jadwal Ibadah
* Kegiatan Gereja
* Informasi Pelayanan

---

## Pengembang

Proyek ini dikembangkan sebagai bagian dari pengembangan Sistem Informasi Gereja GKI Sudirman untuk mendukung digitalisasi pelayanan dan administrasi gereja.

---

## Lisensi

Proyek ini dikembangkan untuk kebutuhan internal Gereja Kristen Indonesia (GKI) Sudirman.
