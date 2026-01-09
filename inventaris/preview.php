<?php
include "../config/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Ambil ID inventaris dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data inventaris
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM inventaris WHERE id=$id"));

if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}

// Ambil nama ruang
$ruangData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM ruang WHERE id=" . $data['ruang_id']));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Preview Inventaris <?= htmlspecialchars($data['nama']) ?></title>

    <!-- Panggil CSS utama -->
    <link rel="stylesheet" href="../assets/css/ruang.css">

    <!-- CSS khusus preview -->
    <style>
        /* Container preview */
        .preview-box {
            max-width: 600px;
            margin: 40px auto;
            padding: 25px 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            font-family: Arial, sans-serif;
            color: #333;
        }

        /* Header & tombol kembali */
        .preview-box h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 24px;
            color: #007bff;
            text-align: center;
        }

        .btn-back {
            display: inline-block;
            margin-bottom: 20px;
            padding: 6px 14px;
            background: #6c757d;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-back:hover {
            background: #5a6268;
        }

        /* Detail item */
        .preview-box p {
            margin: 8px 0;
            font-size: 16px;
            line-height: 1.5;
        }

        .preview-box p strong {
            width: 120px;
            display: inline-block;
        }

        /* Gambar inventaris */
        .preview-box img {
            display: block;
            max-width: 100%;
            height: auto;
            margin-top: 15px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .preview-box {
                margin: 20px 15px;
                padding: 20px;
            }
            .preview-box p strong {
                width: 100px;
            }
            .preview-box h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

<div class="preview-box">
    <a href="index.php?ruang_id=<?= $data['ruang_id'] ?>" class="btn-back">← Kembali</a>
    <h2>Detail Inventaris</h2>

    <p><strong>Kode:</strong> <?= htmlspecialchars($data['kode']) ?></p>
    <p><strong>Nama Barang:</strong> <?= htmlspecialchars($data['nama']) ?></p>
    <p><strong>Tahun:</strong> <?= htmlspecialchars($data['tahun'] ?? '-') ?></p>
    <p><strong>Rak:</strong> <?= htmlspecialchars($data['rak']) ?></p>
    <p><strong>Baris:</strong> <?= htmlspecialchars($data['baris']) ?></p>
    <p><strong>Box:</strong> <?= htmlspecialchars($data['box']) ?></p>
    <p><strong>Gambar:</strong></p>
    <?php if(!empty($data['image']) && file_exists('../uploads/'.$data['image'])): ?>
        <img src="../uploads/<?= htmlspecialchars($data['image']) ?>" alt="<?= htmlspecialchars($data['nama']) ?>">
    <?php else: ?>
        <p>-</p>
    <?php endif; ?>
</div>

</body>
</html>
