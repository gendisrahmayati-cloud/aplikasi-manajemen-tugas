<?php
include 'koneksi.php';

$total     = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tugas"));
$selesai   = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tugas WHERE status='Selesai'"));
$pending   = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tugas WHERE status='Pending'"));

$data = mysqli_query($koneksi, "SELECT * FROM tugas ORDER BY deadline ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Tugas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <h2>📋 Aplikasi Tugas</h2>
</nav>

<section class="dashboard">
    <div>Total Tugas: <b><?= $total ?></b></div>
    <div>Selesai: <b><?= $selesai ?></b></div>
    <div>Pending: <b><?= $pending ?></b></div>
</section>

<section class="form">
    <h3>Tambah Tugas</h3>
    <form action="proses_tugas.php" method="POST" onsubmit="return validasi()">
        <input type="text" name="judul" id="judul" placeholder="Judul Tugas">
        <textarea name="deskripsi" placeholder="Deskripsi"></textarea>
        <input type="date" name="deadline">
        <button type="submit" name="tambah">Tambah</button>
    </form>
</section>

<section class="list">
    <h3>Daftar Tugas</h3>
    <table>
        <tr>
            <th>Judul</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($data)) : ?>
        <tr>
            <td><?= $row['judul'] ?></td>
            <td><?= $row['deadline'] ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <?php if ($row['status'] == 'Pending') : ?>
                    <a href="proses_tugas.php?selesai=<?= $row['id'] ?>">✔ Selesai</a>
                <?php endif; ?>
                <a href="proses_tugas.php?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus tugas?')">🗑 Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</section>

<script>
function validasi() {
    const judul = document.getElementById("judul").value;
    if (judul.trim() === "") {
        alert("Judul tugas tidak boleh kosong!");
        return false;
    }
    return true;
}
</script>

</body>
</html>
