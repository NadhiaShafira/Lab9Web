<?php 
// Kita harus memastikan variabel $is_logged_in tersedia
$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Data Barang Modular</title>
    <link rel="stylesheet" href="[https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css](https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css)">
    <link rel="stylesheet" href="assets/css/style.css"> 
</head>
<body>
    <div class="container">
        <header class="app-header">
            <div class="app-title">
                <i class="fas fa-seedling"></i> Sistem Informasi Modular <i class="fas fa-heart"></i>
            </div>
            <nav class="main-nav">
                <?php if ($is_logged_in): ?>
                    <a href="index.php?page=barang/dashboard"><i class="fas fa-home"></i> Dashboard Barang</a>
                    <a href="index.php?page=barang/add"><i class="fas fa-plus-circle"></i> Tambah Barang</a>
                    <div class="user-info">
                        Halo, <b><?= htmlspecialchars($_SESSION['user_email'] ?? 'User') ?></b> | 
                        <a href="index.php?page=auth/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                <?php else: ?>
                    <a href="index.php?page=auth/login"><i class="fas fa-sign-in-alt"></i> Login</a>
                <?php endif; ?>
            </nav>
        </header>
        <div class="content">