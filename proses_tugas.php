<?php
include 'koneksi.php';

// CREATE
if (isset($_POST['tambah'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $deadline = $_POST['deadline'];

    mysqli_query($koneksi, "INSERT INTO tugas VALUES (
        NULL, '$judul', '$deskripsi', '$deadline', 'Pending'
    )");

    header("Location: index.php");
}

// UPDATE STATUS
if (isset($_GET['selesai'])) {
    $id = $_GET['selesai'];
    mysqli_query($koneksi, "UPDATE tugas SET status='Selesai' WHERE id=$id");
    header("Location: index.php");
}

// DELETE
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM tugas WHERE id=$id");
    header("Location: index.php");
}
?>
