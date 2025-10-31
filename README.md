<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

##Cara install laravel
=======================

A. Persiapan


1. Download php-8.1.14 dan extract (zip)
https://drive.google.com/file/d/1FjembBtcRYL4D4r2eRIOWOZKfwMPQT6w/view?usp=share_link

2. Buka php.ini dan cari 'extension_dir' lalu ganti dengan folder php yang di download

5. Buka Control Panel -> System -> Advanced System Settings -> Environment Variables -> System Variable
   - Edit System Variable 'Path'
   - Tambah variable baru sesuai direktori folder php seperti dibawah ini
   <img src="https://raw.githubusercontent.com/SepEko/kumpulan_gambar/main/ev_path1.png" alt="Menampilkan evpath php" aria-hidden="true" referrerpolicy="no-referrer">


3. buka cmd lalu ketik 'php - v' , jika tidak ada error, maka instalasi php berhasil

4. jika error, install instant client oracle (12)  (taruh di folder yang mudah di akses contoh C:\instantclient_12_2)

   https://drive.google.com/file/d/1U2MVCrfJNjqKLJ8hKapKcAZ4Vlm_aGhl/view?usp=share_link

5. Buka Control Panel -> System -> Advanced System Settings -> Environment Variables -> System Variable
   - Edit System Variable 'Path'
   - Tambah variable baru sesuai direktori folder instant client seperti dibawah ini
   <img src="https://raw.githubusercontent.com/SepEko/kumpulan_gambar/main/ev_path2.png" alt="Menampilkan evpath oracle" aria-hidden="true" referrerpolicy="no-referrer">


6. install composer
https://getcomposer.org/Composer-Setup.exe

7. ketika ada pilihan php di composer, cari folder php yang didownload dan centang add path

8. download wkhtml (untuk view pdf) versi 64 bit
   https://wkhtmltopdf.org/downloads.html


C. Selesai install 

- Download github desktop <br />
https://desktop.github.com/

- Clone Repository ke github desktop<br />
<img src="https://raw.githubusercontent.com/SepEko/kumpulan_gambar/main/clone.png" alt="clone" aria-hidden="true" referrerpolicy="no-referrer">

- Tentukan path folder lalu klik clone dan tunggu sampai selesai <br />
<img src="https://raw.githubusercontent.com/SepEko/kumpulan_gambar/main/clone_1.png" alt="path" aria-hidden="true" referrerpolicy="no-referrer">

- jalankan melalui command prompt <br />

	// tempat folder project laravel (folder bebas)

- contoh folder <br />
cd c://test_laravel

- kalau jalan di localhost ketik <br />
php artisan serve

- kalau ip local ketik <br />
php artisan serve --host iplokal --port 8000

- jalankan <br />
http://localhost:8000/app

======================================

- clear all cache <br />
http://localhost:8000/cache-clear

======================

D. Catatan Tambahan
- buat generate autoload (jika menambah function helper dan mengubah composer.json) <br />
composer dump-autoload

- enable zen OPcache di php ini (buat mempercepat loading)  <br />
zend_extension=opcache

- test aktivasi zen
jalankan perintah di cmd ketik <br />
php -m
