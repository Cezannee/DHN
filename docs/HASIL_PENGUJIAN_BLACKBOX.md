# Dokumentasi Hasil Pengujian Black Box Testing

## Aplikasi Digi Herba Nusantara

### 1. Identitas Pengujian

| Keterangan | Isi |
|---|---|
| Nama Aplikasi | Digi Herba Nusantara |
| Jenis Aplikasi | Website profil perusahaan dan CMS produk herbal |
| Metode Pengujian | Black Box Testing |
| Penguji | ................................................ |
| Pembimbing Lapangan | ................................................ |
| Tempat Pengujian | ................................................ |
| Tanggal Pengujian | ................................................ |
| Status Dokumen | Telah diperiksa dan disetujui oleh pembimbing lapangan |

### 2. Tujuan Pengujian

Pengujian black box dilakukan untuk memastikan setiap fitur pada aplikasi Digi Herba Nusantara berjalan sesuai dengan kebutuhan pengguna tanpa melihat struktur kode program secara langsung. Pengujian difokuskan pada masukan, proses, dan keluaran dari setiap fitur yang tersedia pada aplikasi.

Tujuan dari pengujian ini adalah:

1. Memastikan halaman publik dapat diakses oleh pengguna.
2. Memastikan fitur autentikasi berjalan sesuai kebutuhan.
3. Memastikan fitur kontak dapat menerima dan memvalidasi data pengguna.
4. Memastikan fitur backend hanya dapat diakses oleh pengguna yang memiliki hak akses.
5. Memastikan fitur manajemen user, role, notifikasi, pengaturan website, dan media berjalan dengan benar.
6. Mengetahui apakah sistem memberikan respons yang sesuai terhadap input valid maupun tidak valid.

### 3. Lingkup Pengujian

Lingkup pengujian pada aplikasi ini meliputi:

| No | Modul/Fitur | Keterangan |
|---|---|---|
| 1 | Halaman utama | Menampilkan profil aplikasi, deskripsi, galeri produk, dan tombol marketplace |
| 2 | Halaman kontak | Menampilkan informasi kontak dan form pengiriman pesan |
| 3 | Autentikasi | Login, register, lupa password, reset password, dan logout |
| 4 | Profil pengguna | Melihat profil, mengubah profil, dan mengganti password |
| 5 | Dashboard admin | Menampilkan halaman backend untuk admin |
| 6 | Manajemen user | Menambah, melihat, mengubah, menghapus, memblokir, dan memulihkan user |
| 7 | Manajemen role | Menambah, melihat, mengubah, dan menghapus role |
| 8 | Notifikasi | Melihat, membaca, menandai, dan menghapus notifikasi |
| 9 | Pengaturan website | Mengubah identitas website, kontak, media, dan galeri |
| 10 | Hak akses | Membatasi akses halaman admin berdasarkan role dan permission |

### 4. Skenario dan Hasil Pengujian

| No | Fitur yang Diuji | Skenario Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|---|---|---|---|---|---|---|
| 1 | Halaman utama | Pengguna membuka halaman utama aplikasi | URL `/` atau `/home` | Sistem menampilkan nama aplikasi, deskripsi, logo, galeri produk jika tersedia, dan tombol marketplace jika sudah diatur | Halaman utama berhasil tampil | Lulus |
| 2 | Galeri produk | Pengguna melihat bagian galeri produk | Data gambar produk tersedia | Sistem menampilkan daftar gambar produk dengan tampilan yang rapi | Galeri produk berhasil tampil | Lulus |
| 3 | Link marketplace | Pengguna menekan tombol belanja | URL marketplace Shopee, Tokopedia, atau TikTok Shop | Sistem mengarahkan pengguna ke link marketplace yang valid | Link marketplace dapat dibuka | Lulus |
| 4 | Form kontak valid | Pengguna mengirim pesan dengan nama, email, nomor kontak, dan pesan yang valid | Nama, email valid, nomor kontak, pesan | Sistem mengirim pesan dan menampilkan notifikasi berhasil | Pesan berhasil diproses oleh sistem | Lulus |
| 5 | Form kontak tanpa nama | Pengguna mengirim form kontak tanpa mengisi nama | Nama kosong | Sistem menolak input dan menampilkan pesan validasi | Sistem menampilkan validasi nama wajib diisi | Lulus |
| 6 | Form kontak email tidak valid | Pengguna mengisi email dengan format salah | `email-salah` | Sistem menolak input dan menampilkan pesan validasi email | Sistem menampilkan validasi email tidak valid | Lulus |
| 7 | Form kontak tanpa pesan | Pengguna mengirim form kontak tanpa pesan | Pesan kosong | Sistem menolak input dan menampilkan pesan validasi | Sistem menampilkan validasi pesan wajib diisi | Lulus |
| 8 | Rate limit kontak | Pengguna mengirim form kontak berulang kali dalam waktu singkat | Lebih dari 5 request per menit | Sistem membatasi request untuk mencegah spam | Sistem membatasi pengiriman pesan berlebihan | Lulus |
| 9 | Halaman login | Pengguna membuka halaman login | URL `/login` | Sistem menampilkan form login | Form login berhasil tampil | Lulus |
| 10 | Login valid | Pengguna login menggunakan email dan password yang benar | Email dan password terdaftar | Sistem mengizinkan login dan mengarahkan pengguna ke dashboard/profil | Pengguna berhasil login | Lulus |
| 11 | Login tidak valid | Pengguna login menggunakan email atau password salah | Email/password salah | Sistem menolak login dan menampilkan pesan kesalahan | Login ditolak oleh sistem | Lulus |
| 12 | Register | Pengguna membuka dan mengisi form register | Nama, email, password, konfirmasi password | Sistem membuat akun baru jika pendaftaran diaktifkan | Akun dapat dibuat saat fitur register aktif | Lulus |
| 13 | Lupa password | Pengguna membuka halaman lupa password | Email terdaftar | Sistem menampilkan form reset password dan memproses permintaan reset | Fitur lupa password dapat diakses | Lulus |
| 14 | Logout | Pengguna yang sudah login menekan logout | Session aktif | Sistem mengakhiri session dan mengarahkan pengguna keluar dari area login | Pengguna berhasil logout | Lulus |
| 15 | Profil pengguna | Pengguna login membuka halaman profil | Akun pengguna aktif | Sistem menampilkan data profil pengguna | Profil pengguna berhasil tampil | Lulus |
| 16 | Ubah profil | Pengguna mengubah data profil | Nama, username, atau data profil lain | Sistem menyimpan perubahan data profil | Data profil berhasil diperbarui | Lulus |
| 17 | Ganti password | Pengguna mengganti password dengan data valid | Password baru dan konfirmasi password sama | Sistem menyimpan password baru | Password berhasil diperbarui | Lulus |
| 18 | Akses admin tanpa login | Pengguna belum login membuka `/admin` | Guest user | Sistem mengarahkan pengguna ke halaman login | Akses admin ditolak | Lulus |
| 19 | Akses admin tanpa permission | Pengguna login tanpa permission backend membuka `/admin` | User biasa | Sistem menolak akses dan menampilkan status tidak diizinkan | Akses admin ditolak | Lulus |
| 20 | Dashboard admin | Admin membuka halaman dashboard backend | User dengan permission `view_backend` | Sistem menampilkan halaman dashboard admin | Dashboard admin berhasil tampil | Lulus |
| 21 | Manajemen user - lihat data | Admin membuka halaman daftar user | URL `/admin/users` | Sistem menampilkan daftar user | Daftar user berhasil tampil | Lulus |
| 22 | Manajemen user - tambah data | Admin membuka form tambah user dan menyimpan data valid | Nama, email, password, role | Sistem menyimpan data user baru | User baru berhasil dibuat | Lulus |
| 23 | Manajemen user - edit data | Admin mengubah data user | Data user valid | Sistem memperbarui data user | Data user berhasil diperbarui | Lulus |
| 24 | Manajemen user - hapus data | Admin menghapus user | Data user tersedia | Sistem menghapus user secara soft delete | User berhasil dihapus sementara | Lulus |
| 25 | Manajemen user - restore | Admin memulihkan user yang sudah dihapus | User berada di data terhapus | Sistem mengembalikan user ke daftar aktif | User berhasil dipulihkan | Lulus |
| 26 | Manajemen user - blokir | Admin memblokir user | User aktif | Sistem mengubah status user menjadi terblokir | User berhasil diblokir | Lulus |
| 27 | Manajemen user - buka blokir | Admin membuka blokir user | User terblokir | Sistem mengubah status user menjadi aktif kembali | Blokir user berhasil dibuka | Lulus |
| 28 | Manajemen role - lihat data | Admin membuka halaman role | URL `/admin/roles` | Sistem menampilkan daftar role | Daftar role berhasil tampil | Lulus |
| 29 | Manajemen role - tambah data | Admin menambahkan role baru | Nama role valid | Sistem menyimpan role baru | Role berhasil dibuat | Lulus |
| 30 | Manajemen role - edit data | Admin mengubah data role | Data role valid | Sistem memperbarui data role | Role berhasil diperbarui | Lulus |
| 31 | Manajemen role - hapus data | Admin menghapus role | Role tersedia | Sistem menghapus role | Role berhasil dihapus | Lulus |
| 32 | Notifikasi | Admin membuka halaman notifikasi | URL `/admin/notifications` | Sistem menampilkan daftar notifikasi | Daftar notifikasi berhasil tampil | Lulus |
| 33 | Tandai semua notifikasi dibaca | Admin memilih fitur mark all as read | Notifikasi tersedia | Sistem menandai seluruh notifikasi sebagai sudah dibaca | Notifikasi berhasil ditandai | Lulus |
| 34 | Hapus semua notifikasi | Admin memilih fitur delete all | Notifikasi tersedia | Sistem menghapus seluruh notifikasi | Notifikasi berhasil dihapus | Lulus |
| 35 | Pengaturan website | Admin mengubah nama aplikasi, deskripsi, kontak, dan link marketplace | Data pengaturan valid | Sistem menyimpan perubahan pengaturan website | Pengaturan berhasil diperbarui | Lulus |
| 36 | Upload media halaman utama | Admin mengunggah gambar background atau galeri | File gambar valid | Sistem menyimpan file dan menampilkannya pada halaman frontend | Media berhasil diunggah | Lulus |
| 37 | Hapus media halaman utama | Admin menghapus media yang tidak digunakan | File media tersedia | Sistem menghapus file dari daftar media | Media berhasil dihapus | Lulus |
| 38 | Halaman privacy | Pengguna membuka halaman privacy | URL `/privacy` | Sistem menampilkan halaman kebijakan privasi | Halaman privacy berhasil tampil | Lulus |
| 39 | Halaman terms | Pengguna membuka halaman terms | URL `/terms` | Sistem menampilkan halaman syarat dan ketentuan | Halaman terms berhasil tampil | Lulus |
| 40 | Pergantian bahasa | Pengguna memilih bahasa | URL `/language/{language}` | Sistem mengganti bahasa tampilan sesuai pilihan | Bahasa berhasil diganti | Lulus |

### 5. Rekapitulasi Hasil Pengujian

| Keterangan | Jumlah |
|---|---:|
| Total skenario pengujian | 40 |
| Skenario lulus | 40 |
| Skenario gagal | 0 |
| Persentase keberhasilan | 100% |

### 6. Kesimpulan

Berdasarkan hasil pengujian black box yang telah dilakukan, aplikasi Digi Herba Nusantara telah berjalan sesuai dengan kebutuhan fungsional yang diuji. Fitur utama seperti halaman publik, galeri produk, form kontak, autentikasi, profil pengguna, dashboard admin, manajemen user, manajemen role, notifikasi, pengaturan website, upload media, dan pembatasan hak akses dapat digunakan sesuai dengan hasil yang diharapkan.

Dengan demikian, aplikasi Digi Herba Nusantara dinyatakan layak digunakan untuk mendukung kebutuhan website profil perusahaan dan pengelolaan konten produk herbal.

### 7. Catatan Pengujian

1. Pengujian dilakukan menggunakan metode black box, sehingga penilaian difokuskan pada fungsi aplikasi dari sisi pengguna.
2. Pengujian tidak membahas detail struktur kode program secara langsung.
3. Apabila di kemudian hari terdapat penambahan fitur, maka perlu dilakukan pengujian ulang pada fitur baru tersebut.
4. Tanda tangan pembimbing lapangan pada dokumen cetak menjadi bukti bahwa hasil pengujian telah diperiksa dan disetujui.

---

## Lembar Pengesahan Hasil Pengujian Black Box

Yang bertanda tangan di bawah ini menyatakan bahwa dokumen hasil pengujian black box testing pada aplikasi Digi Herba Nusantara telah diperiksa dan disetujui sebagai bagian dari laporan kerja praktik.

| Keterangan | Isi |
|---|---|
| Nama Mahasiswa | ................................................ |
| NIM | ................................................ |
| Program Studi | ................................................ |
| Nama Instansi | ................................................ |
| Nama Aplikasi | Digi Herba Nusantara |
| Metode Pengujian | Black Box Testing |
| Tanggal Pengesahan | ................................................ |

### Mengetahui,

| Pembimbing Lapangan | Mahasiswa |
|---|---|
|  |  |
|  |  |
|  |  |
| (................................................) | (................................................) |
| NIP/NIK: ........................................ | NIM: ............................................ |

### Disetujui Oleh,

| Pembimbing Akademik |
|---|
|  |
|  |
|  |
| (................................................) |
| NIP/NIDN: ....................................... |
