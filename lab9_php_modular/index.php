<?php
// Langkah 1: Mulai Session (HARUS di awal file)
session_start();

// BASE_DIR adalah path absolut ke folder project Anda (tempat index.php berada)
define('BASE_DIR', __DIR__ . '/'); 

// Langkah 2: Panggil Konfigurasi Database (config/database.php)
require_once(BASE_DIR . 'config/database.php');

// Langkah 3: Definisikan Halaman Default dan yang Diminta
// Default halaman utama adalah 'auth/login'
$page = isset($_GET['page']) ? $_GET['page'] : 'auth/login';

// Cek status login
$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Halaman yang Boleh Diakses Tanpa Login
$public_pages = ['auth/login', 'auth/logout']; 

// --- Logika Proteksi Halaman ---
// Jika user BELUM login dan halaman yang diminta BUKAN halaman public, paksa ke login
if (!$is_logged_in && !in_array($page, $public_pages)) {
    header('Location: index.php?page=auth/login');
    exit;
} 
// Jika user SUDAH login dan mencoba mengakses halaman login, redirect ke dashboard
else if ($is_logged_in && $page === 'auth/login') {
    // Menggunakan 'barang/dashboard' karena kode Anda adalah Data Barang
    header('Location: index.php?page=barang/dashboard'); 
    exit;
}

// --- Logika Routing Utama ---
// Tentukan path file yang akan di-include: modules/auth/login.php
$file_to_load = BASE_DIR . 'modules/' . $page . '.php';

// Cek dan Muat Konten
if (file_exists($file_to_load)) {
    // Gunakan BASE_DIR untuk memastikan header dan footer selalu ditemukan
    require_once(BASE_DIR . 'views/header.php');
    require_once($file_to_load); // Konten utama dimuat di sini
    require_once(BASE_DIR . 'views/footer.php');
} else {
    // Handle 404 Not Found (Error yang Anda lihat sebelumnya)
    require_once(BASE_DIR . 'views/header.php');
    echo "<div style='padding: 20px; text-align: center;'><h2>404 Not Found</h2><p>Halaman <strong>" . htmlspecialchars($page) . "</strong> tidak ditemukan!</p></div>";
    require_once(BASE_DIR . 'views/footer.php');
}
?>