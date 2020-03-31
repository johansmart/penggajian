<?php
include_once "library/inc.sesadmin.php";

// Membaca Kode dari URL
if(empty($_GET['ID'])){
	echo "<b>Data yang dihapus tidak ada</b>";
}
else {
	// Hapus data  
	$mySql = "DELETE FROM riwayat_jabatan WHERE id='".$_GET['ID']."'";
	$myQry = mysqli_query($koneksidb, $mySql) or die ("Eror hapus data".mysqli_errno());
	if($myQry){
		echo "<meta http-equiv='refresh' content='0; url=?page=Riwayat-Jabatan-Data'>";
	}
}
?>