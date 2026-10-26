<?php include "connectdb.php";
$user = $_SESSION['user'];
if (isset($_POST['kirim'])) {
    $nama = $_POST['nama'];
    $nohp = $_POST['hp'];
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $pass1 = $_POST['pass1'];

    if ($pass != $pass1) {
        echo "<h3 style='color:red;'>Password tidak cocok</h3>";
    } else {
        if ($user == 'Admin' && isset($_POST['edit'])) {
            $id_user = $_POST['id_user'];
            mysqli_query($link, "UPDATE user SET nama='$nama', nohp='$nohp', username='$username', password='$pass' WHERE id_user='$id_user'");
        } elseif ($user != 'Admin') {
            mysqli_query($link, "UPDATE user SET nama='$nama', nohp='$nohp', username='$username', password='$pass' WHERE username='$user'");
            $_SESSION['user'] = $username;
            $user = $username;
        } else {
            $cek = mysqli_query($link, "SELECT id_user FROM user WHERE username='$username'");
            if (mysqli_num_rows($cek) > 0) {
                echo "<h3 style='color:red;'>Username sudah digunakan</h3>";
            } else {
                mysqli_query($link, "INSERT INTO user(nama, nohp, username, password, status) VALUES ('$nama', '$nohp', '$username', '$pass', FALSE)");
            }
        }
    }
}

if (isset($_POST['hapus'])) {
    $id_user = $_POST['id_user'];
    mysqli_query($link, "DELETE FROM user WHERE id_user=$id_user");
};

if (isset($_POST['verif'])) {
    $id_user = $_POST['id_user'];
    $query_id_user = mysqli_query($link, "SELECT status FROM user WHERE id_user=$id_user");
    $data_verif = mysqli_fetch_assoc($query_id_user);
    if ($data_verif['status'] == 0) {
        mysqli_query($link, "UPDATE user SET status=TRUE WHERE id_user=$id_user");
    } else {
        mysqli_query($link, "UPDATE user SET status=FALSE WHERE id_user=$id_user");
    }
};

?>
<h2>Daftar sebagai pengguna</h2>
<table align="center" width="350px">
    <form method="POST" action="" enctype="multipart/form-data">
        <?php if ($user == 'Admin' && isset($_POST['edit'])) {
            $id_user = $_POST['id_user'];
            $query_tampil_user = mysqli_query($link,"SELECT * FROM user WHERE id_user=$id_user");
            $data_user = mysqli_fetch_assoc($query_tampil_user);
        } elseif ($user != 'Admin') {
            $query_tampil_user = mysqli_query($link,"SELECT * FROM user WHERE username='$user'");
            $data_user = mysqli_fetch_assoc($query_tampil_user);
        }
        ?>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><input type="text" name="nama" value="<?php echo isset($data_user) ? $data_user['nama'] : ''; ?>"></td>
        </tr>
        <tr>
            <td>No.Hp</td>
            <td>:</td>
            <td><input type="text" name="hp" value="<?php echo isset($data_user) ? $data_user['nohp'] : ''; ?>"></td>
        </tr>
        <tr>
            <td>Username</td>
            <td>:</td>
            <td><input type="text" name="username" value="<?php echo isset($data_user) ? $data_user['username'] : ''; ?>"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td>:</td>
            <td><input type="text" name="pass" value="<?php echo isset($data_user) ? $data_user['password'] : ''; ?>"></td>
        </tr>
        <tr>
            <td>Konfirmasi Password</td>
            <td>:</td>
            <td><input type="text" name="pass1" value="<?php echo isset($data_user) ? $data_user['password'] : ''; ?>"></td>
        </tr>
        <tr>
             <?php if ($user == 'Admin' && isset($_POST['edit'])) { ?>
             <input type="hidden" name="id_user" value="<?php echo $data_user['id_user']; ?>">
             <input type="hidden" name="edit" value="1"> <?php } ?>
             <td colspan="3" align="center"><input type="submit" class="button" name="kirim" value="Kirim" style="margin-right:10px;">
            </td>
        </tr>
    </form>
</table>
<table align="center" width="700px" border="1">
    <h2>Daftar User</h2>
    <tr style="text-align: center;">
        <th style="font-size: medium;">Username</th>
        <th style="font-size: medium;">Nama</th>
        <th style="font-size: medium;">No.Hp</th>
        <th style="font-size: medium;">Status</th>
        <?php if ($user == 'Admin') { ?>
            <th style="font-size: medium;">Verifikasi</th>
        <?php
        } ?>
    </tr>
    <?php
    $query_tampil = mysqli_query($link, "SELECT * FROM user ORDER BY id_user DESC");
    while ($tampil = mysqli_fetch_assoc($query_tampil)) {
    ?>
        <tr>
            <td><?php echo $tampil['username']; ?></td>
            <td><?php echo $tampil['nama']; ?></td>
            <td><?php echo $tampil['nohp']; ?></td>
            <td><?php if ($tampil['status'] == 0) {
                    echo "Belum diverifikasi admin";
                } else {
                    echo "Sudah diverivikasi admin";
                } ?></td>
            <?php if ($user == 'Admin') { ?>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="id_user" value="<?php echo $tampil['id_user']; ?>"><input type="submit" class="button" name="edit" value="Ubah " style="margin-right:10px;"><br><br>
                        <input type="submit" class="button" name="hapus" value="Hapus" style="margin-right:10px;"><br><br>
                        <input type="submit" class="button" name="verif" value="Verifikasi" style="margin-right:10px;">
                    </form>
                </td>
            <?php
            } ?>
        </tr>
    <?php
    }
    ?>
</table>