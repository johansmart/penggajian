<?php
include_once "library/inc.sesadmin.php";

if(empty($_GET['Kode'])){
	echo "<b>Data yang dihapus tidak ada</b>";
}
else {
	// Membaca Kode dari URL
	$Kode	= $_GET['Kode'];
	
	# MENGHAPUS GAMBAR/FOTO, Caranya dengan membaca file gambar
	$mySql = "SELECT * FROM pegawai WHERE kd_pegawai='$Kode'";
	$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query salah : ".mysqli_errno());
	$myData= mysqli_fetch_array($myQry);
	if(! $myData['foto']=="") {
		if(file_exists("img-foto/".$myData['foto'])) {
			// Jika file gambarnya ada, akan dihapus
			unlink("img-foto/".$myData['foto']); 
		}
	}

	$mySql = "DELETE FROM pegawai WHERE kd_pegawai='$Kode'";
	$myQry = mysqli_query($koneksidb, $mySql) or die ("Eror hapus data".mysqli_errno());
	if($myQry){
		echo "<meta http-equiv='refresh' content='0; url=?page=Pegawai-Data'>";
	}
}
?>