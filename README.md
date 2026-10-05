# Laravel Architecture Explorer

Mini project ini dibuat untuk mempelajari arsitektur Laravel 12 secara mendalam, mencakup MVC, routing, controller, Blade, middleware, dan request lifecycle.

---

## Daftar Isi

1. [Tentang Project](#tentang-project)
2. [Command Composer & Artisan](#command-composer--artisan)
3. [Verifikasi Route](#verifikasi-route)
4. [Analisis Request: Browser hingga Response](#analisis-request)
5. [Perbandingan Laravel vs PHP Native](#perbandingan-laravel-vs-php-native)
6. [MVC dalam Laravel & Fitur Melampaui MVC](#mvc-dalam-laravel)

---

## Tentang Project

**Teknologi:**
- Laravel 12 (PHP ^8.2)
- Blade Templating Engine
- HTML & CSS (Glassmorphism)
- Artisan CLI

**Halaman yang tersedia:**

| Route | URL | Controller |
|---|---|---|
| `home` | `/` | Redirect ke architecture |
| `architecture.index` | `/architecture` | `ArchitectureController@index` |
| `lifecycle` | `/lifecycle` | `ArchitectureController@lifecycle` |
| `environment` | `/environment` | `EnvironmentController@index` |
| `about` | `/about` | Closure |

---

## Command Composer & Artisan

### Composer — Instalasi & Setup

```bash
# Membuat project Laravel 12 baru
composer create-project laravel/laravel laravel-architecture-explorer

# Masuk ke direktori project
cd laravel-architecture-explorer

# Menginstal semua dependency dari composer.json (jika clone dari repo)
composer install

# Memperbarui semua dependency ke versi terbaru yang diizinkan
composer update

# Melihat daftar package yang terinstal
composer show

# Mengecek versi Laravel yang terinstal
composer show laravel/framework
```

### Artisan — Development

```bash
# Menjalankan built-in development server
php artisan serve

# Membuat controller baru
php artisan make:controller ArchitectureController
php artisan make:controller EnvironmentController

# Membuat model baru (jika dibutuhkan)
php artisan make:model NamaModel

# Melihat daftar semua command Artisan yang tersedia
php artisan list

# Menampilkan info aplikasi Laravel
php artisan about
```

### Artisan — Manajemen Cache & Konfigurasi

```bash
# Membersihkan cache konfigurasi
php artisan config:clear

# Membersihkan cache tampilan (Blade compiled views)
php artisan view:clear

# Membersihkan cache route
php artisan route:clear

# Membersihkan semua cache sekaligus
php artisan optimize:clear

# Me-cache konfigurasi untuk production (mempercepat loading)
php artisan config:cache

# Me-cache route untuk production
php artisan route:cache
```

### Artisan — Database

```bash
# Menjalankan semua migration
php artisan migrate

# Membuat file migration baru
php artisan make:migration create_nama_table

# Melihat status semua migration
php artisan migrate:status

# Rollback migration terakhir
php artisan migrate:rollback
```

### Artisan — Key

```bash
# Generate APP_KEY untuk enkripsi (wajib dijalankan setelah clone)
php artisan key:generate
```

---

## Verifikasi Route

Perintah `php artisan route:list` digunakan untuk memverifikasi semua route yang terdaftar dalam aplikasi.

### Command

```bash
php artisan route:list
```

### Output

```
GET|HEAD  / ........................................ home › routes/web.php:7
GET|HEAD  about .................................. about › routes/web.php:20
GET|HEAD  architecture ... architecture.index › ArchitectureController@index
GET|HEAD  environment ............ environment › EnvironmentController@index
GET|HEAD  lifecycle ........... lifecycle › ArchitectureController@lifecycle
GET|HEAD  storage/{path} storage.local › vendor/laravel/...
PUT       storage/{path} storage.local.upload › vendor/laravel/...
GET|HEAD  up vendor/laravel/...

Showing [8] routes
```

### Penjelasan Kolom Output

| Kolom | Keterangan |
|---|---|
| `Method` | HTTP method yang diterima (GET, POST, PUT, DELETE, dsb.) |
| `URI` | Path URL yang ditangani |
| `Name` | Named route yang bisa digunakan di `route('nama')` |
| `Action` | Controller dan method yang menangani request, atau Closure |

---

## Analisis Request

### Studi Kasus: User Membuka `http://localhost:8000/architecture`

Berikut adalah analisis detail alur sebuah HTTP request dari browser hingga response HTML diterima kembali oleh pengguna.

#### Langkah 1 — Browser Mengirim Request HTTP

```
GET /architecture HTTP/1.1
Host: localhost:8000
```

Browser mengirimkan HTTP Request ke web server. Dalam development mode, web server tersebut adalah **built-in PHP server** yang dijalankan oleh `php artisan serve`.

#### Langkah 2 — Web Server Meneruskan ke `public/index.php`

Semua request yang masuk diarahkan menuju satu titik masuk tunggal yaitu `public/index.php`. Ini disebut **Single Entry Point Pattern**.

```php
// public/index.php (disederhanakan)
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request = Request::capture());
$response->send();
$kernel->terminate($request, $response);
```

#### Langkah 3 — Bootstrap Aplikasi

Laravel melakukan inisialisasi:
- Memuat konfigurasi dari `config/`
- Mendaftarkan **Service Provider** dari `bootstrap/providers.php`
- Membangun **IoC Container** (Service Container) untuk Dependency Injection

#### Langkah 4 — HTTP Kernel & Middleware

Request melewati rangkaian **Middleware** global. Middleware dapat:
- Menambahkan header CORS
- Memeriksa sesi/cookie
- Melakukan rate limiting
- Memverifikasi autentikasi

Jika middleware menolak request, proses berhenti dan langsung mengembalikan response (misalnya redirect ke halaman login).

#### Langkah 5 — Router Mencocokkan URL

Router Laravel membaca `routes/web.php` dan mencocokkan URI `/architecture`:

```php
// routes/web.php
Route::get('/architecture', [ArchitectureController::class, 'index'])
    ->name('architecture.index');
```

URI `/architecture` cocok! Laravel meneruskan ke `ArchitectureController::index()`.

#### Langkah 6 — Controller Menjalankan Logic

```php
// app/Http/Controllers/ArchitectureController.php
public function index(): View
{
    $folders = [
        ['name' => 'app/', 'function' => 'Tempat kode utama aplikasi...'],
        // ...dst
    ];
    return view('architecture', compact('folders'));
}
```

Controller menyiapkan data `$folders` lalu meminta Blade untuk merender view.

#### Langkah 7 — Blade Engine Merender View

Blade mengkompilasi `resources/views/architecture.blade.php` menjadi PHP murni, mengeksekusinya, dan meng-inject data `$folders` ke dalam template.

```blade
@foreach ($folders as $folder)
    <tr>
        <td><strong>{{ $folder['name'] }}</strong></td>
        <td>{{ $folder['function'] }}</td>
    </tr>
@endforeach
```

#### Langkah 8 — Response Dikirim ke Browser

Laravel membungkus HTML ke dalam objek `Response`:

```
HTTP/1.1 200 OK
Content-Type: text/html; charset=UTF-8
```

HTML dikirimkan ke browser dan pengguna melihat halaman **Architecture Dashboard**.

#### Diagram Ringkas

```
Browser  →  GET /architecture
              ↓
        public/index.php  (Entry Point tunggal)
              ↓
        Bootstrap & Service Container (IoC)
              ↓
        HTTP Kernel → Middleware Pipeline
              ↓
        Router → ArchitectureController@index
              ↓
        Controller → Siapkan $folders → return view()
              ↓
        Blade Engine → Kompilasi + Render → HTML
              ↓
        HTTP Response (200 OK + HTML)
              ↓
        Browser menampilkan halaman
```

---

## Perbandingan Laravel vs PHP Native

### 1. Routing

**PHP Native:**
```php
// Harus cek URL secara manual
$uri = $_SERVER['REQUEST_URI'];
if ($uri === '/architecture') {
    require 'pages/architecture.php';
} elseif ($uri === '/environment') {
    require 'pages/environment.php';
} else {
    http_response_code(404);
    require 'pages/404.php';
}
```

**Laravel:**
```php
// routes/web.php — deklaratif, bersih, dan terorganisir
Route::get('/architecture', [ArchitectureController::class, 'index'])->name('architecture.index');
Route::get('/environment', [EnvironmentController::class, 'index'])->name('environment');
```

**Keunggulan Laravel:** Named routes, route groups, middleware per route, resource routing, dan parameter binding otomatis.

---

### 2. Templating / View

**PHP Native:**
```php
// header.php dan footer.php — harus di-include manual di setiap halaman
<?php include 'header.php'; ?>
<h1>Hello <?= htmlspecialchars($nama) ?></h1>
<?php include 'footer.php'; ?>
```

**Laravel (Blade):**
```blade
@extends('lays.app')
@section('content')
    <h1>Hello {{ $nama }}</h1>
@endsection
```

**Keunggulan Laravel:** Layout inheritance dengan `@extends` & `@yield`, auto-escaping XSS dengan `{{ }}`, directive seperti `@foreach`, `@if`, `@auth`, dan kompilasi dengan cache.

---

### 3. Pengiriman Data ke View

**PHP Native:**
```php
// Menggunakan extract() yang rawan konflik variabel global
$data = ['name' => 'Budi', 'age' => 20];
extract($data);
include 'view.php';
```

**Laravel:**
```php
// Eksplisit dan aman — data di-scope ke view saja
return view('profile', compact('name', 'age'));
// atau
return view('profile')->with(['name' => 'Budi', 'age' => 20]);
```

---

### 4. Struktur Kode

**PHP Native:**
```
/web-project
  index.php           <- Logic + HTML campur
  architecture.php    <- Logic + HTML campur
  environment.php     <- Logic + HTML campur
  header.php
  footer.php
  db.php              <- Koneksi database manual
```

**Laravel:**
```
/laravel-project
  app/Http/Controllers/   <- Logic saja (Controller)
  resources/views/        <- Tampilan saja (View)
  app/Models/             <- Data & Database (Model)
  routes/web.php          <- Routing terpisah
  config/                 <- Konfigurasi terpisah
```

**Keunggulan Laravel:** Separation of Concerns yang tegas — setiap lapisan punya satu tanggung jawab, mudah dimaintain dan ditest.

---

### 5. Perbandingan Keamanan

| Aspek | PHP Native | Laravel |
|---|---|---|
| **XSS** | Harus manual `htmlspecialchars()` | Auto-escape dengan `{{ }}` |
| **CSRF** | Harus implementasi sendiri | Built-in via `@csrf` directive |
| **SQL Injection** | Harus manual `PDO::prepare()` | Query Builder & Eloquent otomatis parameterized |
| **Environment** | File `.env` manual atau hardcode | `.env` + `config()` helper, tanpa expose langsung ke view |

---

## MVC dalam Laravel

### Letak MVC dalam Project Ini

**Model (M)**

Bertanggung jawab atas data dan logika bisnis yang berkaitan dengan database. Dalam project ini, data disiapkan langsung di controller (tanpa database), namun dalam aplikasi nyata Model berdiri di `app/Models/`.

```php
// Contoh: app/Models/Folder.php (jika menggunakan Eloquent)
class Folder extends Model {
    protected $fillable = ['name', 'function'];
}
```

**View (V)**

Bertanggung jawab hanya untuk tampilan — tidak boleh mengandung logika bisnis.

```
resources/views/
├── architecture.blade.php   <- Tampilan daftar folder
├── lifecycle.blade.php      <- Tampilan diagram lifecycle
├── environment.blade.php    <- Tampilan info environment
├── about.blade.php          <- Tampilan halaman about
└── lays/
    └── app.blade.php        <- Layout utama (navigation + CSS)
```

**Controller (C)**

Jembatan antara Model dan View. Menerima request, mengolah data, lalu mengirimkan data ke View.

```
app/Http/Controllers/
├── ArchitectureController.php   <- Mengelola architecture & lifecycle
└── EnvironmentController.php    <- Mengelola environment
```

---

### Di Mana MVC Terlihat Jelas

Alur MVC saat user membuka `/architecture`:

```
[Router]  GET /architecture
    |
    v
[Controller]  ArchitectureController::index()
    |  -> Menyiapkan data $folders (logika bisnis)
    |  -> return view('architecture', compact('folders'))
    v
[View]  architecture.blade.php
    |  -> Menerima $folders
    |  -> Merender tabel HTML
    v
[Response]  HTML dikirim ke browser
```

Setiap lapisan melakukan **satu tanggung jawab** — inilah inti dari pola MVC.

---

### Fitur Laravel yang Melampaui MVC

Laravel bukan sekadar framework MVC. Berikut komponen yang ada di luar konsep MVC tradisional:

**1. Service Container (IoC Container)**
Mekanisme Dependency Injection otomatis. Laravel secara otomatis menginjeksi dependensi ke dalam constructor atau method.
```php
// Laravel otomatis inject Request — tidak perlu `new Request()`
public function store(Request $request) { ... }
```

**2. Service Provider**
Titik registrasi semua komponen Laravel (database, mail, cache, queue). Service Provider berjalan saat bootstrap, sebelum request sampai ke Controller.
```
bootstrap/providers.php -> AppServiceProvider
```

**3. Middleware**
Lapisan yang berjalan **sebelum dan sesudah** Controller. Berfungsi di luar alur MVC: autentikasi, CORS, rate limiting, logging.

**4. Eloquent ORM**
Abstraksi database yang jauh melampaui "Model" dalam MVC tradisional. Menangani relasi (`hasMany`, `belongsTo`), scope, accessor, mutator, dan event model.

**5. Artisan CLI**
Tools otomatisasi: generate file, migrate database, clear cache, menjalankan job. Tidak ada padanannya dalam konsep MVC murni.

**6. Blade Directive & Components**
Blade mendukung komponen reusable (`@component`, `<x-component>`), slot, dan template inheritance yang jauh lebih canggih dari include PHP biasa.

**7. Queue & Events**
Sistem antrian job dan event-driven programming. Memungkinkan proses berat dijalankan di background — sepenuhnya di luar siklus request-response MVC.

---

### Kesimpulan Perbandingan

| Konsep | PHP Native MVC | Laravel |
|---|---|---|
| **Model** | Class PHP biasa | Eloquent ORM dengan relasi & event |
| **View** | PHP + HTML campur | Blade dengan inheritance & komponen |
| **Controller** | Class PHP biasa | Controller + Middleware + DI otomatis |
| **Routing** | Manual `$_SERVER['REQUEST_URI']` | Deklaratif dengan Named Routes & Groups |
| **Extra** | — | Service Container, Providers, Queue, Events, Artisan |

> Laravel mengimplementasikan MVC sebagai **fondasi**, lalu membangun ekosistem lengkap di atasnya — menjadikannya framework yang cocok untuk proyek skala kecil hingga enterprise.

---

## Lisensi

Project ini dibuat untuk keperluan pembelajaran.
Laravel framework adalah open-source software berlisensi [MIT](https://opensource.org/licenses/MIT).
