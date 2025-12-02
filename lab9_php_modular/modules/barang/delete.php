<?php
// Catatan: Baris include_once 'koneksi.php'; sudah dihapus. 
// Koneksi ($conn) sudah dimuat oleh file index.php (Router)

$id = $_GET['id'] ?? null;

if ($id) {

    // 1. Ambil path gambar lama untuk dihapus
    $stmt = $conn->prepare("SELECT gambar FROM data_barang WHERE id_barang = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result && !empty($result['gambar']) && file_exists($result['gambar'])) {
        @unlink($result['gambar']); // Hapus file gambar
    }

    // 2. Hapus data dari database
    $stmt = $conn->prepare("DELETE FROM data_barang WHERE id_barang = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// GANTI REDIRECT SUKSES ke skema routing baru
header("Location: index.php?page=barang/dashboard");
exit;
?>