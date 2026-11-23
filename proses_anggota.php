<!--Ibnu Zidan F.F
    250302045 
    pert10-->
<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: form_anggota.php");
    exit;
}

$no_anggota    = isset($_POST["no_anggota"]) ? trim($_POST["no_anggota"]) : "";
$nama_lengkap  = isset($_POST["nama_lengkap"]) ? trim($_POST["nama_lengkap"]) : "";
$email         = isset($_POST["email"]) ? trim($_POST["email"]) : "";
$no_hp         = isset($_POST["no_hp"]) ? trim($_POST["no_hp"]) : "";
$jenis_anggota = isset($_POST["jenis_anggota"]) ? trim($_POST["jenis_anggota"]) : "";
$alamat        = isset($_POST["alamat"]) ? trim($_POST["alamat"]) : "";


$daftar_jenis = array("Mahasiswa", "Dosen", "Tenaga Kependidikan");
$errors = array();

if (empty($no_anggota)) {
    $errors[] = "Nomor anggota tidak boleh kosong.";
} elseif (!ctype_digit($no_anggota)) {
    $errors[] = "Nomor anggota hanya boleh berisi angka.";
} elseif (strlen($no_anggota) > 15) {
    $errors[] = "Nomor anggota maksimal 15 digit.";
}

if (empty($nama_lengkap)) {
    $errors[] = "Nama lengkap tidak boleh kosong.";
} elseif (strlen($nama_lengkap) > 100) {
    $errors[] = "Nama lengkap maksimal 100 karakter.";
}

if (empty($email)) {
    $errors[] = "Email tidak boleh kosong.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format email tidak valid.";
} elseif (strlen($email) > 100) {
    $errors[] = "Email maksimal 100 karakter.";
}

if (empty($no_hp)) {
    $errors[] = "Nomor HP tidak boleh kosong.";
} elseif (!ctype_digit($no_hp)) {
    $errors[] = "Nomor HP hanya boleh berisi angka.";
} elseif (strlen($no_hp) < 10 || strlen($no_hp) > 13) {
    $errors[] = "Nomor HP harus 10 sampai 13 digit.";
}

if (empty($jenis_anggota)) {
    $errors[] = "Jenis anggota wajib dipilih.";
} elseif (!in_array($jenis_anggota, $daftar_jenis, true)) {
    $errors[] = "Jenis anggota tidak valid.";
}

if (empty($alamat)) {
    $errors[] = "Alamat tidak boleh kosong.";
}

$berhasil = false;
$pesan_db = "";

if (empty($errors)) {
    require_once "koneksi.php";

    $sql = "INSERT INTO anggota "
         . "(no_anggota, nama_lengkap, email, no_hp, jenis_anggota, alamat) "
         . "VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param(
            $stmt, "ssssss",
            $no_anggota, $nama_lengkap, $email, $no_hp, $jenis_anggota, $alamat
        );

        if (mysqli_stmt_execute($stmt)) {
            $berhasil = true;
        } else {
            $pesan_db = mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $pesan_db = mysqli_error($koneksi);
    }
    mysqli_close($koneksi);

    
    if ($berhasil) {
        header("Location: form_anggota.php?status=sukses");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Penyimpanan Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php if (!empty($errors)) { ?>

    <h1>Data Tidak Valid</h1>
    <p class="gagal">Data belum dapat disimpan. Perbaiki kesalahan:</p>
    <ul style="color: #c0392b; line-height: 1.6;">
        <?php foreach ($errors as $pesan) { ?>
            <li><?php echo htmlspecialchars($pesan); ?></li>
        <?php } ?>
    </ul>

<?php } else { ?>

    <h1>Data Gagal Disimpan</h1>
    <p class="gagal">Terjadi kesalahan saat menyimpan data ke database.</p>
    <p>Pesan dari MySQL: <strong style="color: #c0392b;"><?php echo htmlspecialchars($pesan_db); ?></strong></p>

<?php } ?>

    <p><a href="javascript:history.back()" style="color: #1f3864; font-weight: bold;">Kembali dan perbaiki data</a></p>
</body>
</html>