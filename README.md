# smart-tourism-basic

A school project about smart tourism.

# Note to teammate

Auth-service will be the database owner. DO NOT RUN MIGRATIONS FROM OTHER APP. THEY WILL FIGHT, CLASH, OVERWRITE, DROP, OR CORRUPT OTHER APP'S TABLES.

# Feature checklist

## User

- [x] Registrasi & Login.
- [] Input profil: Nama lengkap, Foto profil, dan Kewarganegaraan.
- [] Mencantumkan harapan/ekspektasi dari perjalanan wisata ini.
- [] Membaca artikel blog terkurasi & daftar direktori restoran setempat.

## Vendor

- [] Management content (tulis blog, isi profil vendor, informasi jam buka-tutup,)
- [] Membaca profil semua user yang ada

## Admin

- [] Otorisasi dan moderasi blog vendor.
- [] Post pengumuman untuk vendor-vendor
- [] Post pengumuman untuk pengguna
- [] Manajemen vendor (setujui permintaan user menjadi vendor, tag vendor)
