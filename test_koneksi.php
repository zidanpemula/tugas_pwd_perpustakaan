<!--Ibnu Zidan F.F
    250302045 
    pert10-->
<?php

require_once "koneksi.php";

$versi_server = mysqli_get_server_info($koneksi);
mysqli_close($koneksi);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tes Koneksi Database</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Tes Koneksi Database</h1>
    <p class="sukses" style="width: auto;">Koneksi ke MySQL berhasil.</p>

    <table style="margin-top: 16px;">
        <tr>
            <td>Host</td>
            <td>: <?php echo htmlspecialchars($host); ?></td>
        </tr>
        <tr>
            <td>Database</td>
            <td>: <?php echo htmlspecialchars($database); ?></td>
        </tr>
        <tr>
            <td>Versi server</td>
            <td>: <?php echo htmlspecialchars($versi_server); ?></td>
        </tr>
    </table>
</body>
</html>