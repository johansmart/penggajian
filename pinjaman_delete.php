<?php
include_once "library/inc.sesadmin.php";

if($_GET) {
	if(empty($_GET['Kode'])){
		echo "<b>Data yang dihapus tidak ada</b>";
	}
	else {
		// Hapus data  
		$mySql = "DELETE FROM pinjaman WHERE no_pinjaman='".$_GET['Kode']."'";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("Eror hapus data".mysqli_errno());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Pinjaman-Data'>";
		}
	}
}
?>