# OMD Order

Aplikasi Laravel untuk digitalisasi proses order dan repair OMD Workshop.

## Modul awal
- Login berbasis role: User, OMD Member, OMD Leader
- Form Order Repair Box NG
- Verifikasi dan proses repair OMD
- Input hasil OK / SCRAP / NG
- Konfirmasi user
- Dashboard monitoring dan grafik
- Master area, produk, jenis NG, dan target
- Struktur awal siap dikembangkan untuk TPS Tool

## Setup
1. Copy `.env.example` menjadi `.env`.
2. Buat database MySQL `omd_order`.
3. Atur `DB_*` pada `.env`.
4. Jalankan `composer install`.
5. Jalankan `php artisan key:generate`.
6. Jalankan `php artisan migrate --seed`.
7. Jalankan `npm install` dan `npm run build` jika ingin build asset Vite.
8. Jalankan `php artisan serve`.

## Akun demo
- User: `user@omd.local` / `password`
- OMD Member: `member@omd.local` / `password`
- OMD Leader: `leader@omd.local` / `password`

## Catatan requirement
Detail Electric, Produksi, dan implementasi penuh TPS Tool masih menunggu konfirmasi requirement bisnis. Struktur dibuat modular agar dapat ditambahkan tanpa mengubah alur utama.
