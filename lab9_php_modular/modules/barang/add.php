<?php
// Catatan: Baris include_once 'koneksi.php'; sudah dihapus.
// Koneksi ($conn) sudah dimuat oleh file index.php (Router)

error_reporting(E_ALL);
ini_set('display_errors', 1);
// $conn sudah tersedia di sini
$errors=[];

if($_SERVER['REQUEST_METHOD']==='POST'){
    $nama=$_POST['nama']; 
    $kategori=$_POST['kategori'];
    $harga_jual=(float)$_POST['harga_jual']; 
    $harga_beli=(float)$_POST['harga_beli'];
    $stok=(int)$_POST['stok']; 
    $gambar_path=null;

    if(!empty($_FILES['file_gambar'])&&$_FILES['file_gambar']['error']===0){
        $fn=preg_replace('/[^A-Za-z0-9_\.]/','_',$_FILES['file_gambar']['name']);
        
        // PERBAIKAN PATH GAMBAR: Ganti __DIR__.'/gambar/' menjadi __DIR__.'/../../gambar/'
        // Karena file ini berada 2 tingkat di bawah root project (project/modules/barang/)
        $dir=__DIR__.'/../../gambar/'; 
        
        if(!is_dir($dir)) mkdir($dir,0755,true);
        $target=$dir.time().'_'.$fn;
        
        // Simpan path yang relatif dari root (misalnya: gambar/namafile.jpg) untuk database
        if(move_uploaded_file($_FILES['file_gambar']['tmp_name'],$target))
            $gambar_path='gambar/'.basename($target);
    }
    
    $stmt=$conn->prepare("INSERT INTO data_barang (nama,kategori,harga_jual,harga_beli,stok,gambar) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssddis",$nama,$kategori,$harga_jual,$harga_beli,$stok,$gambar_path);
    
    if($stmt->execute()) { 
        // GANTI REDIRECT SUKSES ke skema routing baru
        header("Location: index.php?page=barang/dashboard"); 
        exit; 
    }
    else { 
        $errors[] = "Error: " . $stmt->error; 
    }
}
?>

<h1>Tambah Barang</h1>
<?php if(!empty($errors)): ?>
    <div class="error-msg">
        <?php foreach($errors as $error) echo "<p>$error</p>"; ?>
    </div>
<?php endif; ?>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nama Barang</label>
        <input type="text" name="nama" required>
    </div>
    <div class="form-group">
        <label>Kategori</label>
        <select name="kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="Komputer">Komputer</option>
            <option value="Elektronik">Elektronik</option>
            <option value="Hand Phone">Hand Phone</option>
        </select>
    </div>
    <div class="form-group">
        <label>Harga Jual</label>
        <input type="number" name="harga_jual" step="0.01" required>
    </div>
    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" name="harga_beli" step="0.01" required>
    </div>
    <div class="form-group">
        <label>Stok</label>
        <input type="number" name="stok" required>
    </div>
    <div class="form-group">
        <label>File Gambar</label>
        <input type="file" name="file_gambar" accept="image/*">
    </div>
    <div class="form-buttons">
        <button type="submit">Simpan</button>
    </div>
</form>