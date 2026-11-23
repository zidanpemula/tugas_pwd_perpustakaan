<!-- Ibnu Zidan F.F
    250302045 
    pert10-->
<?php

$status = isset($_GET["status"]) ? $_GET["status"] : "";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Anggota Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 style="border-bottom: 2px solid #1f3864; padding-bottom: 8px; width: 340px;">
        Pendaftaran Anggota Perpustakaan
    </h1>

    <?php if ($status === "sukses") { ?>
        <p class="sukses">Data anggota berhasil disimpan.</p>
    <?php } ?>

    <form action="proses_anggota.php" method="post">
        <label for="no_anggota">Nomor Anggota</label>
        <input type="text" id="no_anggota" name="no_anggota">

        <label for="nama_lengkap">Nama Lengkap</label>
        <input type="text" id="nama_lengkap" name="nama_lengkap">

        <label for="email">Email</label>
        <input type="text" id="email" name="email">

        <label for="no_hp">Nomor HP</label>
        <input type="text" id="no_hp" name="no_hp">

        <label for="jenis_anggota">Jenis Anggota</label>
        <select id="jenis_anggota" name="jenis_anggota">
            <option value="">-- Pilih Jenis Anggota --</option>
            <option value="Mahasiswa">Mahasiswa</option>
            <option value="Dosen">Dosen</option>
            <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
        </select>

        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat" rows="4"></textarea>

        <button type="submit"
                style="background-color: #1f3864; color: #ffffff; border: none; border-radius: 4px;">
            Simpan
        </button>
    </form>
</body>
</html>