<?php
// Catatan: Baris "include 'koneksi.php';" sudah dihapus karena koneksi ($conn)
//          sudah dimuat oleh file index.php (Router)
$sql = "SELECT * FROM data_barang ORDER BY id_barang DESC";
$result = $conn->query($sql);

// Hapus semua tag HTML: <html>, <head>, <body>, dll.
?>

<h1>Data Barang</h1>

<p>
    <a class="btn" href="index.php?page=barang/add">+ Tambah Data</a>
</p>

<table>
    <thead>
        <tr>
            <th>Gambar</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php if ($result && $result->num_rows > 0): while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td>
                    <?php if (!empty($row['gambar']) && file_exists($row['gambar'])): ?>
                        <img src="<?= htmlspecialchars($row['gambar']) ?>" width="80">
                    <?php else: ?>
                        <span class="noimg">No Image</span>
                    <?php endif; ?>
                </td>

                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['kategori']) ?></td>
                <td><?= number_format($row['harga_beli']) ?></td>
                <td><?= number_format($row['harga_jual']) ?></td>
                <td><?= $row['stok'] ?></td>

                <td>
                    <a href="index.php?page=barang/edit&id=<?= $row['id_barang'] ?>">Ubah</a> |
                    <a href="index.php?page=barang/delete&id=<?= $row['id_barang'] ?>" onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; else: ?>
            <tr>
                <td colspan="7">Belum ada data</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php
// Hapus semua tag penutup HTML: </div>, </body>, </html>
?>