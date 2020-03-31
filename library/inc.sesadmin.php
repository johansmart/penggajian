<?php
if(! isset($_SESSION['SES_LOGIN'])) {
	echo "<center>";
	echo "<br> <br> <b>Maaf Akses Anda Ditolak!</b> <br>
		  Yang boleh login hanya Admin dan Level yang sudah Login saja <br>
		  Silahkan masukkan Data Login Anda dengan benar untuk bisa mengakses halaman ini.";
	echo "</center>";
	include_once "login.php";
	exit;
}
?>