<?php
include_once "../library/inc.sesadmin.php";

if($_GET) {
	if(empty($_GET['Kode'])){
		echo "<b>Data yang dihapus tidak ada</b>";
	}
	else {
		// Hapus data User, Kecuali yang username-nya admin tidak boleh dihapus
		$mySql = "DELETE FROM user WHERE kd_user='".$_GET['Kode']."' AND username !='admin'";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("Eror hapus data".mysqli_errno());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=User-Data'>";
		}
	}
}
?>