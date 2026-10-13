<?php
include "connectdb.php";
session_start();

if (isset($_POST['login'])) {
	$usr  = trim($_POST['user']);
	$pas  = trim($_POST['pass']);
	if ($usr == '' or $pas == '') {
		echo "Data Tidak Boleh Kosong<br><br>";
	} else if ($usr == 'admin' and $pas == 'admin') {
		$_SESSION['user'] = "Admin";
	} else {
		echo "Username dan Password Salah<br><br>";
	}
}

if (isset($_GET['logout'])) {
	unset($_SESSION['user']);
	echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
} else if (isset($_SESSION['user'])) {
	echo "Selamat Datang, <b>" . $_SESSION['user'] . "</b><br>";
	echo "<a href='index.php?logout'>Logout</a>";
} else {
	echo "
	<form method='POST' action=''>
	<input type='text' name='user' placeholder='Username'><br><br>
	<input type='password' name='pass' placeholder='Password'><br><br>
	<input type='submit' name='login' value='Login' id='submit' class='button'>
	</form>
	";
}
