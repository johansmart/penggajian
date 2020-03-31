<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if(isset($_POST['btnMasuk'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtNIP	= $_POST['txtNIP'];

	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($txtNIP)=="") {
		$pesanError[] = "Data <b>Nomor Induk Pegawai (NIP)</b> tidak boleh kosong !";		
	}	
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# Periksa, Pada tanggal yang sama NIP tersebut sudah absen atau belum
		$tanggal= date('Y-m-d');
		$cekSql	= "SELECT absensi.* FROM absensi, pegawai WHERE absensi.kd_pegawai = pegawai.kd_pegawai
					AND pegawai.nip='$txtNIP' AND absensi.tanggal='$tanggal'";
		$cekQry	= mysqli_query($koneksidb, $cekSql) or die ("Gagal query".mysqli_errno()); 
		if(mysqli_num_rows($cekQry) < 1) {
			# JIKA BELUM ADA (belum absen)
			// Membaca data Kode pegawai
			$infoSql	= "SELECT kd_pegawai FROM pegawai WHERE nip='$txtNIP'";
			$infoQry	= mysqli_query($infoSql, $koneksidb) or die ("Gagal query 2".mysqli_errno()); 
			$infoData	= mysqli_fetch_array($infoQry);
			$kodePegawai= $infoData['kd_pegawai'];
			
			// Jika Belum Absen, maka datanya baru diinput
			$jam		= date("H:i:s");
			$mySql  	= "INSERT INTO absensi (kd_pegawai, tanggal, jam_masuk, jam_keluar, status_kehadiran, jenis_kerja, keterangan)
							VALUES ('$kodePegawai', 
									'$tanggal', 
									'$jam', 
									'',
									'1',
									'Wajib',
									'Masuk')";
			mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_errno());
			
			// Refresh
			echo "<meta http-equiv='refresh' content='2; url=absensi_masuk.php'>";
			
			echo "ABSENSI MASUK BERHASIL DIINPUT.....! Selamat Berkarya...";
		}
	}	
} // Penutup POST

# MASUKKAN DATA KE VARIABEL
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataNIP		= isset($_POST['txtNIP']) ? $_POST['txtNIP'] : '';
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> :: Absensi Masuk ( IN )</title> 
<link href="styles/style_admin.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>ABSENSI MASUK (IN)</strong></td>
    </tr>
    <tr>
      <td width="181"><strong>NIP Pegawai </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="1000"><input name="txtNIP" type="text" value="<?php echo $dataNIP; ?>" size="60" maxlength="40" 
				onfocus="if (value == '<?php echo $dataNIP; ?>') {value =''}"/>
      <input type="submit" name="btnMasuk" value=" Masuk " /></td>
    </tr>
  </table>
</form>
</body>
</html>
