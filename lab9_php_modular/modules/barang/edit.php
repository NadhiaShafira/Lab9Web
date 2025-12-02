<?php
// Catatan: include_once 'koneksi.php'; sudah dihapus. Koneksi ($conn) sudah tersedia.

error_reporting(E_ALL);

if (isset($_POST['submit'])) {

    $id          = $_POST['id'];
    $nama        = $_POST['nama'];
    $kategori    = $_POST['kategori'];
    $harga_jual  = $_POST['harga_jual'];
    $harga_beli  = $_POST['harga_beli'];
    $stok        = $_POST['stok'];
    $file_gambar = $_FILES['file_gambar'];
    $gambar      = null;

    // Upload gambar
    if ($file_gambar['error'] == 0) {
        $filename    = str_replace(' ', '_', $file_gambar['name']);
        
        // PERBAIKAN PATH GAMBAR: Ganti dirname(__FILE__) . '/gambar/' menjadi 
        // dirname(__FILE__) . '/../../gambar/' untuk kembali ke root project
        $destination = dirname(__FILE__) . '/../../gambar/' . $filename;

        if (move_uploaded_file($file_gambar['tmp_name'], $destination)) {
            // Path yang disimpan di database relatif dari root project
            $gambar = 'gambar/' . $filename; 
        }
    }

    // Update data
    $sql  = "UPDATE data_barang SET ";
    $sql .= "nama = '{$nama}', kategori = '{$kategori}', ";
    $sql .= "harga_jual = '{$harga_jual}', harga_beli = '{$harga_beli}', ";
    $sql .= "stok = '{$stok}' ";

    if (!empty($gambar)) {
        $sql .= ", gambar = '{$gambar}' ";
    }

    $sql .= "WHERE id_barang = '{$id}'";

    mysqli_query($conn, $sql);
    
    // GANTI REDIRECT SUKSES ke skema routing baru
    header('location: index.php?page=barang/dashboard');
    exit;
}

// Ambil data barang
$id     = $_GET['id'] ?? null; // Tambahkan ?? null untuk menghindari Notice jika 'id' tidak ada
if (!$id) {
    // Jika tidak ada ID, redirect kembali ke dashboard
    header('location: index.php?page=barang/dashboard');
    exit;
}

$sql    = "SELECT * FROM data_barang WHERE id_barang = '{$id}'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) die('Error: Data tidak tersedia atau ID tidak valid');
$data = mysqli_fetch_array($result);

// Helper untuk select option
function is_select($value, $selected)
{
    return $value == $selected ? 'selected="selected"' : '';
}
?>

<h1>Ubah Barang</h1>

<div class="main">
    <form method="post" action="index.php?page=barang/edit&id=<?php echo $data['id_barang']; ?>" enctype="multipart/form-data">

        <div class="input">
            <label>Nama Barang</label>
            <input type="text" name="nama" value="<?php echo $data['nama']; ?>" />
        </div>

        <div class="input">
            <label>Kategori</label>
            <select name="kategori">
                <option value="Komputer" <?php echo is_select('Komputer', $data['kategori']); ?>>Komputer</option>
                <option value="Elektronik" <?php echo is_select('Elektronik', $data['kategori']); ?>>Elektronik</option>
                <option value="Hand Phone" <?php echo is_select('Hand Phone', $data['kategori']); ?>>Hand Phone</option>
            </select>
        </div>

        <div class="input">
            <label>Harga Jual</label>
            <input type="text" name="harga_jual" value="<?php echo $data['harga_jual']; ?>" />
        </div>

        <div class="input">
            <label>Harga Beli</label>
            <input type="text" name="harga_beli" value="<?php echo $data['harga_beli']; ?>" />
        </div>

        <div class="input">
            <label>Stok</label>
            <input type="text" name="stok" value="<?php echo $data['stok']; ?>" />
        </div>

        <div class="input">
            <label>File Gambar</label>
            <?php if (!empty($data['gambar'])): ?>
                <img src="<?php echo htmlspecialchars($data['gambar']); ?>" width="80" style="margin-bottom: 5px;">
            <?php endif; ?>
            <input type="file" name="file_gambar" />
        </div>

        <div class="submit">
            <input type="hidden" name="id" value="<?php echo $data['id_barang']; ?>" />
            <input type="submit" name="submit" value="Simpan" />
        </div>

    </form>
</div>