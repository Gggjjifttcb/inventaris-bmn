<?php
include "../config/koneksi.php";


if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("ID tidak valid");
}

// Ambil data inventaris
$qInventaris = mysqli_query($conn, "SELECT * FROM inventaris WHERE id = $id");
$data = mysqli_fetch_assoc($qInventaris);

if (!$data) {
    die("Data tidak ditemukan");
}

// Ambil data ruang
$ruangData = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM ruang WHERE id = " . intval($data['ruang_id']))
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Preview Inventaris</title>

    <!-- CSS utama -->
    <link rel="stylesheet" href="../assets/css/ruang.css">

    <!-- CSS khusus preview -->
    <style>
        body {
            background: #f1f3f6;
        }

        .preview-box {
            max-width: 680px;
            margin: 40px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 12px 35px rgba(0,0,0,0.08);
        }

        .preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .preview-header h2 {
            margin: 0;
            font-size: 22px;
            color: #0d6efd;
        }

        .btn-back {
            padding: 7px 16px;
            background: #6c757d;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            transition: 0.2s;
        }

        .btn-back:hover {
            background: #5a6268;
        }

        .detail-list {
            display: grid;
            grid-template-columns: 150px auto;
            column-gap: 16px;
            row-gap: 14px;
            font-size: 15px;
        }

        .detail-list .label {
            font-weight: 600;
            color: #555;
        }

        .detail-list .value {
            color: #222;
        }
        .detail-list .label {
    font-weight: 600;
    color: #555;
    position: relative;
}

.detail-list .label::after {
    content: " :";
}

        .image-box {
            margin-top: 30px;
            text-align: center;
        }

        .image-box img {
            max-width: 100%;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        }

        .image-box p {
            font-size: 14px;
            color: #999;
        }

        @media (max-width: 600px) {
            .preview-box {
                margin: 20px 15px;
                padding: 22px;
            }

            .detail-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="preview-box">

    <div class="preview-header">
        <h2>Detail Arsip</h2>
        <a href="index.php?ruang_id=<?= intval($data['ruang_id']) ?>" class="btn-back">← Kembali</a>
    </div>

    <div class="detail-list">
        <div class="label">Kode Klasifikasi</div>
        <div class="value"><?= htmlspecialchars($data['kode'] ?? '-') ?></div>

        <div class="label">Nama Arsip</div>
        <div class="value"><?= htmlspecialchars($data['nama'] ?? '-') ?></div>

        <div class="label">Tahun</div>
        <div class="value"><?= htmlspecialchars($data['tahun'] ?? '-') ?></div>

        <div class="label">Rak</div>
        <div class="value"><?= htmlspecialchars($data['rak'] ?? '-') ?></div>

        <div class="label">Box</div>
        <div class="value"><?= htmlspecialchars($data['box'] ?? '-') ?></div>

        <div class="label">No. Berkas</div>
        <div class="value"><?= htmlspecialchars($data['baris'] ?? '-') ?></div>

        <div class="label">Gambar</div>
        <div class="value"><?= htmlspecialchars($data['image'] ?? 'Tidak ada gambar') ?></div>
    </div>

    <div class="image-box">
        <?php if (!empty($data['image']) && file_exists("../uploads/" . $data['image'])): ?>
            <img src="../uploads/<?= htmlspecialchars($data['image']) ?>" alt="Gambar Inventaris">
        <?php else: ?>
            <p>Tidak ada gambar</p>
        <?php endif; ?>
    </div>

</div>

</body>
</html>
