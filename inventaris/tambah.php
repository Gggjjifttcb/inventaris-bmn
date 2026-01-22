<?php

include "../config/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

/* ===============================
   KUNCI RUANG ID
================================ */
$ruang_id = 10;

$ruangData = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM ruang WHERE id = $ruang_id")
);

/* ===== AMBIL KODE KLASIFIKASI DARI JSON ===== */
$kode_klasifikasi = json_decode(
    file_get_contents("../assets/data/kode_klasifikasi.json"),
    true
);

if (isset($_POST['submit'])) {

    $kode  = mysqli_real_escape_string($conn, $_POST['kode']);
    $tahun = (int) $_POST['tahun'];
    $nama  = mysqli_real_escape_string($conn, $_POST['nama']);
    $rak   = mysqli_real_escape_string($conn, $_POST['rak']);
    $box   = mysqli_real_escape_string($conn, $_POST['box']);
    $baris = mysqli_real_escape_string($conn, $_POST['baris']);

    $image = NULL;
    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','gif'])) {
            $image = time().'_'.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/$image");
        }
    }

    mysqli_query($conn, "
        INSERT INTO inventaris
        (kode, tahun, nama, rak, box, baris, ruang_id, image)
        VALUES
        ('$kode','$tahun','$nama','$rak','$box','$baris','$ruang_id',
        ".($image ? "'$image'" : "NULL").")
    ");

    header("Location: index.php?ruang_id=10");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Inventaris</title>
<link rel="stylesheet" href="../assets/css/inventaris.css">

<style>
.autocomplete {
    position: relative;
}

.dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    max-height: 160px;
    overflow-y: auto;
    display: none;
    z-index: 999;
}

.dropdown div {
    padding: 8px 10px;
    cursor: pointer;
    font-size: 14px;
}

.dropdown div:hover {
    background: #f0f2f5;
}
</style>
</head>
<body>

<div class="form-container">
    <div class="form-header">
        <a href="index.php?ruang_id=10" class="btn-back">← Kembali</a>
        <h2>Tambah <?= $ruangData['nama_ruang'] ?? '10' ?></h2>
    </div>

    <form method="post" enctype="multipart/form-data">

        <label>Kode Klasifikasi</label>
        <div class="autocomplete">
            <input type="text"
                   name="kode"
                   id="kodeInput"
                   placeholder="Ketik kode klasifikasi..."
                   autocomplete="off"
                   required>
            <div id="kodeDropdown" class="dropdown"></div>
        </div>

        <label>Tahun</label>
        <input type="number" name="tahun" min="1900" max="2100" required>

        <label>Nama Arsip</label>
        <input type="text" name="nama" required>

        <label>Rak</label>
        <input type="text" name="rak" required>

        <label>Box</label>
        <input type="text" name="box" required>

        <label>No. Berkas</label>
        <input type="text" name="baris" required>

        <label>Gambar</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit" name="submit">Simpan Data</button>

    </form>
</div>

<script>
const dataKode = <?= json_encode($kode_klasifikasi); ?>;
const input = document.getElementById('kodeInput');
const dropdown = document.getElementById('kodeDropdown');

input.addEventListener('input', function () {
    const keyword = this.value.toLowerCase();
    dropdown.innerHTML = '';

    if (!keyword) {
        dropdown.style.display = 'none';
        return;
    }

    const hasil = dataKode.filter(k =>
        k.toLowerCase().includes(keyword)
    );

    hasil.forEach(k => {
        const div = document.createElement('div');
        div.textContent = k;
        div.onclick = () => {
            input.value = k;
            dropdown.style.display = 'none';
        };
        dropdown.appendChild(div);
    });

    dropdown.style.display = hasil.length ? 'block' : 'none';
});

document.addEventListener('click', e => {
    if (!e.target.closest('.autocomplete')) {
        dropdown.style.display = 'none';
    }
});
</script>

</body>
</html>
