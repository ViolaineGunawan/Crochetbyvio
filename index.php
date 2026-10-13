<?php include "connectdb.php"; ?>

<html>

<head>
    <title>Crochetbyvio</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <table border="1" align="center" class="tabel">
        <tr class="judul">
            <th colspan="3">
                <p>Crochetbyvio</p>
            </th>
        </tr>
        <tr class="menu">
            <td colspan="3">
                <a href="index.php">Beranda</a>
                <a href="index.php?pesan">Pesan</a>
                <a href="index.php?estimasi">Estimasi</a>
            </td>
        </tr>
        <tr class="isi">
            <td class="kanankiri">
                <?php include "login.php" ?>
            </td>
            <td class="tengah">
                <?php
                if (isset($_GET['pesan'])) {
                    include "pesan.php";
                } else if (isset($_GET['estimasi'])) {
                    include "estimasi.php";
                } else {
                    include "beranda.php";
                } ?>
            </td>
            <td class="kanankiri">Pesanan teratas:
                <ol>
                    <li>Spiderman</li>
                    <li>Spongebob</li>
                    <li>Cinnamoroll</li>
                </ol>

                <br>Jenis produk:
                <ul>
                    <li>Boneka</li>
                    <li>Gantungan kunci</li>
                    <li>Tas</li>
                </ul>
            </td>
        </tr>
        <tr class="footer">
            <td colspan="3">Instagram: <a href="https://www.instagram.com/crochetbyvio/">@crochetbyvio</a> WhatsApp: <a href="https://wa.me/628125901267">0812-5690-1267</a></td>
        </tr>
    </table>

</body>

</html>