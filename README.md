DOKUMENTASI DAN PANDUAN APLIKASI SEKAWAN FLEET
PT SEKAWAN NIKEL INDONESIA

Aplikasi ini merupakan sistem informasi pemesanan, pemantauan konsumsi bahan bakar, jadwal perawatan servis, dan monitoring riwayat armada kendaraan operasional tambang nikel yang beroperasi di kantor pusat, kantor cabang, serta enam lokasi tambang.

SPESIFIKASI DAN TEKNOLOGI SISTEM

1. Bahasa Pemrograman
PHP versi 8.2.12

2. Kerangka Kerja Web Framework
Laravel Framework versi 12

3. Database Management System
MariaDB MySQL versi 10.4.32
Nama Database: vehicle_booking
Port: 3306
Host: 127.0.0.1 atau localhost
Username Database: root
Password Database: kosong

4. Antarmuka dan Desain UI
HTML5, CSS Vanilla murni, Font Plus Jakarta Sans, Font Awesome versi 6, dan Chart JS versi 4.


DAFTAR AKUN PENGGUNA DAN KATA SANDI

Berikut adalah daftar akun yang dapat digunakan untuk masuk ke dalam aplikasi:

1. Administrator Sistem
Nama: Administrator Sistem
Email: admin@sekawan.com
Password: admin123
Peran: Admin Sistem
Keterangan: Memiliki kewenangan penuh mengelola seluruh armada, data driver, akun pengguna, pengajuan pemesanan, memantau log aktivitas, dan ekspor laporan ke Excel.

2. Staff Pool Kendaraan
Nama: Budi Santoso
Email: budi@sekawan.com
Password: budi123
Peran: Admin Pool
Keterangan: Bertanggung jawab membuat pemesanan operasional dan mengelola kendaraan serta driver di pool.

3. Penyetuju Tingkat Satu Atasan Langsung
Nama: Ir. Hendra Wijaya
Email: hendra@sekawan.com
Password: hendra123
Jabatan: Kepala Seksi Operasional Tambang
Peran: Approver Tingkat 1
Keterangan: Bertugas memverifikasi permohonan awal dan jadwal tugas lapangan dari pemohon.

4. Penyetuju Tingkat Dua Manajemen Operasional
Nama: Dr. Siti Rahayu
Email: siti@sekawan.com
Password: siti123
Jabatan: Manajer Operasional
Peran: Approver Tingkat 2
Keterangan: Bertugas memberikan otorisasi final sebelum kendaraan diizinkan keluar dan beroperasi.

5. Penyetuju Tingkat Satu Alternatif
Nama: Drs. Bambang Sutrisno
Email: bambang@sekawan.com
Password: bambang123
Jabatan: Kepala HRD
Peran: Approver Tingkat 1

6. Penyetuju Tingkat Dua Alternatif
Nama: Dra. Dewi Permata
Email: dewi@sekawan.com
Password: dewi123
Jabatan: Direktur Operasional
Peran: Approver Tingkat 2


CARA MENJALANKAN APLIKASI SECARA LOKAL

1. Pastikan modul Apache dan MySQL pada aplikasi XAMPP sudah aktif dan berjalan normal.
2. Buka terminal atau command prompt pada direktori proyek.
3. Jalankan perintah php artisan serve untuk menjalankan web server lokal.
4. Buka peramban browser lalu akses alamat web http://127.0.0.1:8000.
5. Anda akan langsung diarahkan ke halaman login aplikasi SEKAWAN Fleet.


PANDUAN LENGKAP PENGGUNAAN APLIKASI

1. Alur Masuk Sistem Login
Buka halaman login. Masukkan email dan password sesuai daftar akun di atas, atau Anda dapat langsung menekan tombol akun demo cepat yang telah disediakan pada halaman login untuk mengisi data secara otomatis. Setelah itu tekan tombol Masuk.

2. Memahami Alur Persetujuan Bertingkat Dua Level
Sistem menerapkan standar operasional prosedur persetujuan minimal dua tingkat:
Tahap pertama: Permohonan diajukan oleh admin ke Atasan Langsung sebagai Penyetuju Tingkat Satu.
Tahap kedua: Setelah disetujui Tingkat Satu, permohonan otomatis berpindah ke antrean Penyetuju Tingkat Dua yaitu pihak Manajemen atau Direksi.
Setelah Penyetuju Tingkat Dua memberikan persetujuan final, status kendaraan otomatis berubah menjadi sedang digunakan dan status driver menjadi bertugas.

3. Panduan Membuat Pemesanan Kendaraan oleh Admin
Masuk sebagai Admin menggunakan akun admin@sekawan.com.
Pilih menu Buat Pemesanan pada bilah navigasi sebelah kiri.
Isi formulir dengan memasukkan keperluan pemakaian, lokasi tujuan, waktu keberangkatan, waktu kembali, serta jumlah penumpang. Anda juga dapat menggunakan tombol cepat untuk mengisi lokasi site tambang populer secara instan.
Tentukan Penyetuju Tingkat Satu dan Penyetuju Tingkat Dua pada bagian alur persetujuan.
Pilih kendaraan dan driver yang tersedia. Sistem akan otomatis menampilkan kartu pratinjau spesifikasi kendaraan dan data driver secara langsung.
Periksa ringkasan pemesanan pada kartu sebelah kanan, lalu tekan tombol Kirim Permohonan Pemesanan.
Status pemesanan pertama kali akan tercatat sebagai pending.

4. Panduan Melakukan Persetujuan oleh Penyetuju Tingkat Satu
Keluar dari akun admin, lalu masuk menggunakan akun Penyetuju Tingkat Satu hendra@sekawan.com dengan password hendra123.
Buka menu Persetujuan pada bilah navigasi sebelah kiri.
Pada bagian Persetujuan Tingkat Satu Atasan Langsung, periksa rincian perjalanan pemohon.
Apabila sesuai, klik tombol hijau Setujui Level 1 dan konfirmasi pada jendela pop-up.
Status pemesanan akan otomatis naik menjadi disetujui level satu dan diteruskan ke antrean tingkat dua. Jika permohonan tidak sesuai, tekan tombol Tolak dan tuliskan alasan penolakan.

5. Panduan Melakukan Persetujuan Final oleh Penyetuju Tingkat Dua
Masuk menggunakan akun Penyetuju Tingkat Dua siti@sekawan.com dengan password siti123 atau dewi@sekawan.com dengan password dewi123.
Pilih menu Persetujuan pada bilah navigasi sebelah kiri.
Pada bagian Persetujuan Tingkat Dua Manajemen Direksi, periksa permohonan yang telah lolos verifikasi dari tingkat satu.
Tekan tombol Setujui Final Level 2 dan lakukan konfirmasi persetujuan.
Status pemesanan menjadi disetujui level dua. Pada saat ini, kendaraan resmi ditugaskan ke lapangan.

6. Panduan Menyelesaikan Perjalanan dan Pencatatan Bahan Bakar
Setelah tugas dinas lapangan selesai dan armada kembali ke pool, login kembali sebagai Admin.
Pilih menu Semua Pemesanan lalu klik tombol Detail pada pemesanan yang bersangkutan.
Pada bagian penyelesaian perjalanan, masukkan angka odometer awal, odometer akhir saat tiba, jumlah konsumsi bahan bakar yang digunakan dalam liter, serta catatan kondisi kendaraan.
Tekan tombol Selesaikan Pemesanan.
Status pemesanan akan berubah menjadi selesai. Kendaraan dan driver secara otomatis kembali ke status tersedia dan siap digunakan untuk penugasan berikutnya.

7. Panduan Memantau Dashboard dan Ekspor Data ke Excel
Untuk melihat analisis grafik pemakaian kendaraan mingguan, persentase jenis armada, pemakaian bahan bakar, serta jadwal servis berkala, buka menu Dashboard.
Untuk mengunduh laporan rekapitulasi data pemesanan, buka menu Semua Pemesanan lalu tekan tombol hijau bertuliskan Ekspor Excel di bagian kanan atas tabel. File laporan berformat spreadsheet akan otomatis terunduh ke komputer Anda.

LINK GOOGLE DRIVE : https://drive.google.com/drive/folders/1J0adHlR9p-Qg9o9W30q2bXjdwRna4NjU?usp=sharing
