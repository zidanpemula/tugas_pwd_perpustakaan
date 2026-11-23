<!--Ibnu Zidan F.F
    250302045 
    pert10-->
<?php
require_once "koneksi.php";


$q = isset($_GET["q"]) ? trim($_GET["q"]) : "";

if ($q !== "") {
    
    $q_aman = str_replace(array("\\", "%", "_"), array("\\\\", "\\%", "\\_"), $q);
    $kata   = "%" . $q_aman . "%";

    $sql = "SELECT id, no_anggota, nama_lengkap, email, no_hp, jenis_anggota, alamat
            FROM anggota
            WHERE no_anggota LIKE ? OR nama_lengkap LIKE ?
               OR email LIKE ? OR alamat LIKE ?
            ORDER BY id DESC";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $kata, $kata, $kata, $kata);
    mysqli_stmt_execute($stmt);
    $hasil = mysqli_stmt_get_result($stmt);
} else {
    $sql   = "SELECT id, no_anggota, nama_lengkap, email, no_hp, jenis_anggota, alamat
              FROM anggota ORDER BY id DESC";
    $hasil = mysqli_query($koneksi, $sql);
}

$jumlah_data = mysqli_num_rows($hasil);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Data Anggota Perpustakaan</h1>

    <div class="toolbar">
        <form class="form-cari" action="data.php" method="get" role="search">
            <input type="search" name="q"
                   value="<?php echo htmlspecialchars($q); ?>"
                   placeholder="Cari nomor anggota, nama, email, atau alamat..."
                   aria-label="Cari data anggota">
            <button type="submit" class="btn">Cari</button>
            <?php if ($q !== "") { ?>
                <a href="data.php" class="btn btn-abu">Reset</a>
            <?php } ?>
        </form>

        <div>
            <a href="index.php" class="btn btn-abu">Beranda</a>
            <a href="form_anggota.php" class="btn">+ Tambah Anggota</a>
        </div>
    </div>

    <p class="info">
        <?php if ($q !== "") { ?>
            Ditemukan <strong><?php echo $jumlah_data; ?></strong> data
            untuk "<strong><?php echo htmlspecialchars($q); ?></strong>"
        <?php } else { ?>
            Total <strong><?php echo $jumlah_data; ?></strong> anggota
        <?php } ?>
    </p>

    <div class="tabel-wrap">
        <table>
            <thead>
                <tr>
                    <th>No. Anggota</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Jenis Anggota</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($jumlah_data === 0) { ?>
                <tr>
                    <td colspan="6" class="kosong">
                        <?php echo ($q !== "")
                            ? "Tidak ada data yang cocok. Coba kata kunci lain."
                            : "Belum ada data anggota."; ?>
                    </td>
                </tr>
            <?php } else { ?>
                <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['no_anggota']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['no_hp']); ?></td>
                    <td><?php echo htmlspecialchars($row['jenis_anggota']); ?></td>
                    <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
<?php
if (isset($stmt)) {
    mysqli_stmt_close($stmt);
}
mysqli_close($koneksi);
?>