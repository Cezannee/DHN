# Digi Herba Nusantara

**Digi Herba Nusantara** adalah homepage aplikasi CMS untuk menampilkan profil perusahaan, produk, testimoni, kontak, galeri, dan semua kebutuhan utama website perusahaan herbal.

Aplikasi ini dibangun di atas Laravel 13 dengan struktur modular. Backend CMS terpisah dari frontend publik sehingga homepage bisa dikelola dan diperbarui dengan mudah.

## Fitur Utama

* Profil perusahaan
* Produk dan katalog produk
* Testimoni pelanggan
* Halaman kontak
* Galeri foto
* Manajemen konten CMS untuk homepage dan halaman statis
* User dan peran/permission untuk admin
* Frontend publik dan backend admin terpisah
* Asset build dengan Vite/Tailwind
* Dukungan Livewire untuk interaksi admin yang cepat

## Persyaratan

* PHP ^8.4
* Composer
* Node.js + npm
* Database (MySQL, SQLite, PostgreSQL, atau SQL Server)

## Instalasi & Setup

1. Clone repository ini atau salin dari template.
2. Jalankan dependensi PHP.

```bash
composer install --no-interaction
```

3. Pasang dependensi frontend.

```bash
npm install
```

4. Salin file environment dan atur konfigurasi database.

```bash
copy .env.example .env
```

5. Hasilkan application key.

```bash
php artisan key:generate
```

6. Jalankan installer proyek.

```bash
php artisan starter:install --no-interaction
```

7. Build asset jika ingin menyiapkan produksi atau memastikan asset sudah tersedia.

```bash
npm run build
```

## Menjalankan Aplikasi

```bash
php artisan serve
npm run dev
```

Kemudian akses aplikasi melalui URL yang ditampilkan oleh `php artisan serve`.

## Perintah Penting

* `php artisan starter:install` — install dan konfigurasi Digi Herba Nusantara
* `php artisan starter:update` — update paket Composer, jalankan migrasi baru, dan bersihkan cache
* `php artisan clear-all` — bersihkan cache aplikasi, route, view, config, dan permission cache
* `composer pint` — jalankan Laravel Pint untuk formatting PHP
* `npm run format` — format Blade templates dengan Prettier

## Catatan

* Gunakan `npm` sebagai package manager yang didukung untuk frontend.
* Hindari mencampur `npm` dan `yarn` pada checkout yang sama.
* Jika ingin menjalankan development penuh, gunakan `php artisan serve` dan `npm run dev` bersamaan.

## Struktur Umum

* `app/` — kode Laravel aplikasi
* `config/` — konfigurasi aplikasi
* `resources/` — view Blade, CSS, dan JS
* `routes/` — definisi route frontend dan backend
* `database/` — migrasi dan seeder
* `modules/` — modul CMS jika digunakan

---

The setup wizard will guide you through environment configuration, database selection, migrations, seeding, and building frontend assets. When finished it prints the app URL and default login credentials.

**Available options:**

| Option | Description |
|---|---|
| `--skip-db` | Skip database setup |
| `--skip-seed` | Skip database seeding |
| `--skip-npm` | Skip `npm install` and asset build |
| `--demo` | Seed with demo data (no prompt) |

If you only need to rerun cache clearing after setup, use:

```bash
php artisan clear-all
```

### Via Existing Repository

After cloning this repository, run the setup wizard to seed and build assets:

```bash
php artisan starter:install --skip-db
```

*After creating the new permissions use the following commands to update cached permissions.*

`php artisan cache:forget spatie.permission.cache`

## Database Seeding

Two seeder categories are available:

- **Essential** (always run): users, roles, permissions, menu — `AuthTableSeeder`, `MenuDatabaseSeeder`
- **Dummy data** (optional): posts, categories, tags — disabled via `SEED_DUMMY_DATA=false` in `.env`

```bash
# Full seed (essential + dummy data)
php artisan migrate:fresh --seed

# Essential data only
php artisan db:seed-essential --fresh

# Add or refresh demo content at any time
php artisan laravel-starter:insert-demo-data
php artisan laravel-starter:insert-demo-data --fresh
```

For production, set `SEED_DUMMY_DATA=false` and use `--force`:
```bash
php artisan db:seed-essential --fresh --force
```

## Docker and Laravel Sail
This project is configured with Laravel Sail (https://laravel.com/docs/sail). You can use all the docker functionalities here. To install using docker and sail:

1. Clone or download the repository
2. Go to the project directory and run `composer install`
3. Create `.env` file by copying the `.env-sail`. You may use the command to do that `cp .env-sail .env`
4. Update the database name and credentials in `.env` file
5. Run the command `sail up` (consider adding this to your alias: `alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'`)
6. Run the command `sail artisan migrate --seed`
7. Link storage directory: `sail artisan storage:link`
8. Since Sail is already up, you can just visit http://localhost:80
