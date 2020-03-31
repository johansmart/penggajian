<?php
if(isset($_SESSION['SES_ADMIN'])) {
	include "dasboardslider.php";
	exit;
}
else if(isset($_SESSION['SES_KASIR'])) {
	include "dasboardslider.php";
	exit;
}
else {
	echo "<h2 style='margin:-5px 0px 5px 0px; padding:0px;'>Selamat datang ........!</h2></p>";
	echo "<b>Anda belum login, silahkan <a href='?page=Login' alt='Login'>login </a>untuk mengakses sitem ini ";	
}
?>