<h3 style="margin-left: 10px;text-align:left">Estimasi pesanan selesai</h3>
<table>
    <form method="POST" action="">
        <tr>
            <td>Id pesanan</td>
            <td><input type="text" name="id"></td>
        </tr>
        <tr>
            <td>Harga</td>
            <td><input type="number" name="harga"></td>
        </tr>
        <tr>
            <td><input type="submit" class="button" value="Kirim" name="kirim1"></td>
        </tr>
    </form>
    <?php if (isset($_POST['kirim1'])) {
        $id = $_POST['id'];
        $harga = $_POST['harga'];
        echo "Id pesanan: $id <br>";
        if ($harga >= 100000) {
            echo "Estimasi : 1 minggu++";
        } elseif ($harga >= 80000) {
            echo "Estimasi : 6 hari++";
        } elseif ($harga >= 60000) {
            echo "Estimasi : 5 hari++";
        } elseif ($harga >= 40000) {
            echo "Estimasi : 4 hari++";
        } elseif ($harga >= 1000) {
            echo "Estimasi : 3 hari++";
        } else {
            echo "Harga tidak valid";
        }
    }
    ?>

</table>
<hr>
<h3 style="margin-left: 10px;text-align:left;">Nilai</h3>
<table>
    <form method="POST" action="">
        <tr>
            <td>Pilih jenis</td>
            <td> <input type="radio" name="gangen" value="Genap">Genap<br><input type="radio" name="gangen" value="Ganjil">Ganjil</td>
        </tr>
        <tr>
            <td>Masukkan nilai awal</td>
            <td><input type="number" name="awal"></td>
        </tr>
        <tr>
            <td>Masukkan nilai akhir</td>
            <td><input type="number" name="akhir"></td>
        </tr>
        <tr>
            <td><input class="button" type="submit" value="Kirim" name="kirim2"></td>
        </tr>
    </form>
    <?php
    if (isset($_POST['kirim2'])) {
        $gangen = $_POST['gangen'];
        if ($_POST['awal'] > $_POST['akhir']) {
            echo "Nilai tidak valid";
        } else {
            $awal = $_POST['awal'];
            $akhir = $_POST['akhir'];
            if ($gangen == "Genap") {
                for ($awal; $awal <= $akhir; $awal++) {
                    if ($awal % 2 == 0) {
                        echo "$awal ";
                    }
                }
            } else {
                for ($awal; $awal <= $akhir; $awal++) {
                    if ($awal % 2 != 0) {
                        echo "$awal ";
                    }
                }
            }
        }
    }
    ?>
</table>