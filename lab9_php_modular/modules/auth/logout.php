<?php
// Hapus semua data session
session_unset();
session_destroy();

// Redirect kembali ke halaman login
header('Location: index.php?page=auth/login');
exit;
?>