<?php
include 'koneksi.php';

// SEARCH
$keyword = isset($_GET['search']) ? $_GET['search'] : "";

// QUERY DATA
$query = "SELECT * FROM tugas 
          WHERE judul LIKE '%$keyword%' 
          OR deskripsi LIKE '%$keyword%'
          ORDER BY deadline ASC";
$data = mysqli_query($koneksi, $query);

// DASHBOARD COUNT
$total    = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tugas"));
$selesai  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tugas WHERE status='Selesai'"));
$pending  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tugas WHERE status='Pending'"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>To Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>📌 Dashboard Tugas</h2>
<div class="dashboard">
    <div>Total: <?= $total ?></div>
    <div>Selesai: <?= $selesai ?></div>
    <div>Pending: <?= $pending ?></div>
</div>

<hr>

<!-- SEARCH -->
<form method="GET">
    <input type="text" name="search" placeholder="Cari tugas..." value="<?= $keyword ?>">
    <button type="submit">Search</button>
</form>

<hr>

<!-- FORM TAMBAH -->
<h3>➕ Tambah Tugas</h3>
<form method="POST" action="proses_tugas.php" onsubmit="return validasi()">
    <input type="text" name="judul" id="judul" placeholder="Judul Tugas">
    <textarea name="deskripsi" placeholder="Deskripsi"></textarea>
    <input type="date" name="deadline">
    <button type="submit" name="tambah">Tambah</button>
</form>

<hr>

<!-- TABEL DATA -->
<h3>📋 Daftar Tugas</h3>
<table>
<tr>
    <th>Judul</th>
    <th>Deskripsi</th>
    <th>Deadline</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($data)) { ?>
<tr>
    <td><?= $row['judul'] ?></td>
    <td><?= $row['deskripsi'] ?></td>
    <td><?= $row['deadline'] ?></td>
    <td><?= $row['status'] ?></td>
    <td>
        <?php if ($row['status'] == 'Pending') { ?>
            <a href="proses_tugas.php?selesai=<?= $row['id'] ?>">✔ Selesai</a>
        <?php } ?>
        |
        <a href="proses_tugas.php?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus tugas?')">🗑 Hapus</a>
    </td>
</tr>
<?php } ?>
</table>

<script>
function validasi() {
    let judul = document.getElementById("judul").value;
    if (judul === "") {
        alert("Judul tugas tidak boleh kosong!");
        return false;
    }
    return true;
}
</script>

</body>
</html>
