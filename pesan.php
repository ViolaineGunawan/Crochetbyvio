<?php include "connectdb.php";
if (isset($_POST['edit'])) {
    $id_pesanan = $_POST['id_pesanan'];
    $query_edit = mysqli_query($link, "SELECT * FROM pesanan WHERE id_pesanan='$id_pesanan'");
    $edit = mysqli_fetch_assoc($query_edit);
    if (!empty($edit['tambahan'])) {
        $tambahan_edit = explode(', ', $edit['tambahan']);
    } else {
        $tambahan_edit = [];
    }
}
if (isset($_POST['delete'])) {
    $id_pesanan = $_POST['id_pesanan'];
    mysqli_query($link, "DELETE FROM pesanan WHERE id_pesanan=$id_pesanan");
};
if (isset($_POST['kirim'])) {
    $nama = $_POST['nama'];
    $hp = $_POST['hp'];
    $tgl = $_POST['tgl'];
    $produk = $_POST['produk'];
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $jlh = $_POST['jlh'];
    $ganci = $_POST['ganci'];
    if (isset($_POST['tambahan'])) {
        $tambahan = implode(', ', $_POST['tambahan']);
    } else {
        $tambahan = '';
    }
    $alamat = $_POST['alamat'];

    if (isset($_POST['id_pesanan'])) {
        $id_pesanan = $_POST['id_pesanan'];
        $query_lama = mysqli_query($link, "SELECT foto FROM pesanan WHERE id_pesanan='$id_pesanan'");
        $data_lama = mysqli_fetch_assoc($query_lama);
        $foto_lama = $data_lama['foto'];
        if ($foto != "") {
            move_uploaded_file($tmp, "foto/" . $foto);
        } else {
            $foto = $foto_lama;
        }
        mysqli_query($link, "UPDATE pesanan SET nama='$nama',hp='$hp',tanggal='$tgl',produk='$produk',foto='$foto',jumlah='$jlh',ganci='$ganci',tambahan='$tambahan',alamat='$alamat' WHERE id_pesanan='$id_pesanan'");
    } else {
        if ($foto != "") {
            move_uploaded_file($tmp, "foto/" . $foto);
        }

        mysqli_query($link, "INSERT INTO pesanan(nama, hp, tanggal, produk, foto, jumlah, ganci, tambahan, alamat) VALUES('$nama','$hp','$tgl','$produk','$foto','$jlh','$ganci','$tambahan','$alamat')");
    }
    header("Location: index.php?pesan");
    exit;
}

?>
<h2>Form Pemesanan</h2>
<table align="center" width="550px">
    <form method="POST" action="" enctype="multipart/form-data">
        <?php if (isset($edit)) { ?><input type="hidden" name="id_pesanan" value="<?php echo $edit['id_pesanan']; ?>"><?php } ?>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><input type="text" name="nama" value="<?php echo isset($edit) ? $edit['nama'] : ''; ?>"></td>
        </tr>
        <tr>
            <td>No.Hp</td>
            <td>:</td>
            <td><input type="text" name="hp" value="<?php echo isset($edit) ? $edit['hp'] : ''; ?>"></td>
        </tr>
        <tr>
            <td style="vertical-align:top;">Tanggal pesanan diambil/diantar</td>
            <td style="vertical-align:top;">:</td>
            <td><input type="date" name="tgl" value="<?php echo isset($edit) ? $edit['tanggal'] : ''; ?>"><br>
                catatan: apabila waktu kurang dari 2 minggu (dihitung dari tanggal pesan) dikenakan penambahan biaya</td>
        </tr>
        <tr>
            <td>Produk yang dipesan</td>
            <td style="vertical-align: top;">:</td>
            <td style="vertical-align: top;"><select name="produk">
                    <option <?php echo (isset($edit) && $edit['produk'] == 'Custom') ? 'selected' : ''; ?>>Custom</option>
                    <option <?php echo (isset($edit) && $edit['produk'] == 'Polar Bear') ? 'selected' : ''; ?>>Polar Bear</option>
                    <option <?php echo (isset($edit) && $edit['produk'] == 'Hamburger') ? 'selected' : ''; ?>>Hamburger</option>
                    <option <?php echo (isset($edit) && $edit['produk'] == 'Glove') ? 'selected' : ''; ?>>Glove</option>
                    <option <?php echo (isset($edit) && $edit['produk'] == 'Turtle') ? 'selected' : ''; ?>>Turtle</option>
                </select></td>
        </tr>
        <tr>
            <td>Foto Produk (contoh)</td>
            <td style="vertical-align: top;">:</td>
            <td><input type="file" name="foto"><?php if (isset($edit) && $edit['foto'] != '') {
                                                    echo "<br>Foto sebelumnya: ";
                                                    echo $edit['foto'];
                                                } ?><br>catatan: diisi apabila memilih produk custom</td>

        </tr>
        <tr>
            <td>Jumlah Produk</td>
            <td>:</td>
            <td><input type="number" name="jlh" min="1" value="<?php echo isset($edit) ? $edit['jumlah'] : ''; ?>"></td>
        </tr>
        <tr>
            <td>Pakai gantungan kunci?</td>
            <td style="vertical-align:top">:</td>
            <td style="vertical-align:top">
                <input type="radio" name="ganci" value="Ya" <?php echo isset($edit) && $edit['ganci'] == 'Ya' ? 'checked' : ''; ?>>Ya
                <input type="radio" name="ganci" value="Tidak" <?php echo isset($edit) && $edit['ganci'] == 'Tidak' ? 'checked' : ''; ?>>Tidak
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Tambahan</td>
            <td style="vertical-align: top;">:</td>
            <td><input type="checkbox" name="tambahan[]" value="Kartu ucapan" <?php echo isset($tambahan_edit) && in_array('Kartu ucapan', $tambahan_edit) ? 'checked' : ''; ?>>Kartu ucapan<br>
                <input type="checkbox" name="tambahan[]" value="Kotak hadiah" <?php echo isset($tambahan_edit) && in_array('Kotak hadiah', $tambahan_edit) ? 'checked' : ''; ?>>Kotak Hadiah<br>
                <input type="checkbox" name="tambahan[]" value="Pita" <?php echo isset($tambahan_edit) && in_array('Pita', $tambahan_edit) ? 'checked' : ''; ?>>Pita

            </td>
        </tr>
        <tr>
            <td style="vertical-align:top;">Alamat pengantaran</td>
            <td style="vertical-align:top;">:</td>
            <td><textarea cols="50" name="alamat"><?php echo isset($edit) ? $edit['alamat'] : ''; ?></textarea><br>
                catatan: kosongkan jika pesanan diambil sendiri
        </tr>
        <tr>
            <td colspan="3"><input type="submit" class="button" name="kirim" value="Kirim" style="margin-right:10px;"><input class="button" type="reset" value="Batal" onclick="window.location.href='index.php?pesan';"></td>
        </tr>
    </form>
    <table align="center" width="700px" border="1">
        <h2>Pesanan</h2>
        <tr style="text-align: center;">
            <th style="font-size: medium;">Foto Produk</th>
            <th style="font-size: medium;">Detail Pesanan</th>
            <th style="font-size: medium;">Ubah</th>
            <th style="font-size: medium;">Hapus</th>
        </tr>
        <?php
        $query_tampil = mysqli_query($link, "SELECT * FROM pesanan ORDER BY id_pesanan DESC");
        while ($tampil = mysqli_fetch_assoc($query_tampil)) {
        ?>
            <tr>
                <td align="center"><img alt="Tidak ada foto" src="foto/<?php echo $tampil['foto']; ?>" width="130px"></td>
                <td>Nama: <?php echo $tampil['nama']; ?><br>
                    No. HP: <?php echo $tampil['hp']; ?><br>
                    Tanggal: <?php echo $tampil['tanggal']; ?><br>
                    Produk: <?php echo $tampil['produk']; ?><br>
                    Jumlah: <?php echo $tampil['jumlah']; ?><br>
                    Gantungan kunci: <?php echo $tampil['ganci']; ?><br>
                    Tambahan: <?php echo $tampil['tambahan']; ?><br>
                    <br>Alamat: <?php echo $tampil['alamat']; ?><br>
                    <form method="POST" action="">
                <td align="center"><input type="hidden" name="id_pesanan" value="<?php echo $tampil['id_pesanan']; ?>"><input class="button2" type=submit name="edit" value="Ubah"></td>
                <td align="center"><input type="hidden" name="id_pesanan" value="<?php echo $tampil['id_pesanan']; ?>"><input class="button2" type=submit name="delete" value="Hapus"></td>
                </form>
            </tr>
        <?php
        }
        ?>
    </table>