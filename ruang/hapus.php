<?php
include "../config/koneksi.php";

$id = $_GET['id'];

// opsional: hapus inventaris di ruang ini
mysqli_query($conn, "DELETE FROM inventaris WHERE ruang_id='$id'");

// hapus ruang
mysqli_query($conn, "DELETE FROM ruang WHERE id='$id'");

header("Location: index.php");
