# Sistem Peminjaman Ruangan Kampus + API Kalender

Nama : Permana Chandra

NIM : 1482400089

Program Studi : Sistem dan Teknologi Informasi

Institusi : Universitas 17 Agustus 1945 Surabaya

Aplikasi **Sistem Peminjaman Ruangan Kampus** merupakan aplikasi berbasis web yang dikembangkan untuk memudahkan proses pengelolaan data ruangan, peminjaman ruangan, serta monitoring jadwal penggunaan ruangan melalui tampilan kalender.  
Aplikasi ini dibangun menggunakan framework **Laravel** dengan konsep **MVC (Model-View-Controller)**.

---

## Fitur Utama

### 1. Manajemen Ruangan (CRUD Room)
- Menambah data ruangan
- Mengubah data ruangan
- Menghapus data ruangan
- Melihat daftar ruangan

### 2. Sistem Booking Ruangan
- User dapat melakukan peminjaman ruangan
- Admin dapat melihat seluruh data booking
- Admin dapat menyetujui atau menolak booking
- Riwayat booking tersimpan dalam sistem

### 3. Kalender Peminjaman
- Menampilkan jadwal peminjaman ruangan dalam bentuk kalender
- Data kalender diambil melalui API dari backend
- Update jadwal secara real-time berdasarkan data booking

### 4. Manajemen Role & Akses
- **Admin**: mengelola ruangan, booking, dan melihat seluruh data
- **User**: melakukan booking dan melihat data booking miliknya sendiri
- Pembatasan akses menggunakan middleware

---

## Teknologi yang Digunakan

- **Backend**: Laravel
- **Database**: MySQL
- **Frontend**: Blade Template + JavaScript
- **ORM**: Eloquent ORM
- **API**: REST API (JSON Response)
- **Authentication**: Laravel Auth
- **Calendar Library**: Full Calendar ( link : https://fullcalendar.io/ ) 

---
