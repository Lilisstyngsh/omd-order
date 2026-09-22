# Implementasi OMD Order

## Sudah diimplementasikan
- Role-based login: User, OMD Member, OMD Leader.
- Dashboard user untuk monitoring order miliknya.
- Dashboard OMD/Leader dengan total Order, Finish, Scrap, Target dan grafik bulanan.
- Form Order Repair Box NG.
- Workflow Repair Box: Submitted -> Verified -> In Repair -> Completed -> Confirmed.
- Input hasil repair: OK, SCRAP, NG.
- Rekap dasar melalui data transaksi dan dashboard.
- Master area: Unit (DC, MA, Sub-Assy, PPIC) dan Body (INJ, PT, Sub-Assy, PPIC).
- Jenis NG: P, H, C.
- Master produk awal berdasarkan contoh produk pada dokumen.
- Target FY 2026 yang tersedia pada dokumen untuk Apr-Sep.
- Struktur awal Repair TPS Tool: submit -> leader check -> verification -> schedule -> repair -> completion -> confirmation.

## Belum dikunci karena requirement belum lengkap
- Detail Electric dan sub-area Electric.
- Apakah Produksi menjadi role/user terpisah.
- Detail field tambahan pada form yang belum terdefinisi secara digital.
- Aturan approval/otorisasi yang lebih rinci.
- Detail schedule TPS Tool yang lebih lengkap.
- Notification/email/WhatsApp jika nantinya diperlukan.

## Cara menjalankan
1. Copy `.env.example` menjadi `.env`.
2. Buat database MySQL `omd_order`.
3. Sesuaikan DB_* pada `.env`.
4. `composer install`
5. `php artisan key:generate`
6. `php artisan migrate --seed`
7. `npm install`
8. `npm run build`
9. `php artisan serve`

## Akun demo
- user@omd.local / password
- member@omd.local / password
- leader@omd.local / password
