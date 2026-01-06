<?php
$conn = mysqli_connect("localhost", "root", "", "inventaris_bmn");

if (!$conn) {
    die("Koneksi gagal");
}
session_start();
?>
