<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtNama		= $_POST['txtNama']; 
	$txtNama		= strtoupper($txtNama); // Kuruf menjadi BESAR
	
	$txtLokasi		= $_POST['txtLokasi'];
	$txtLokasi		= str_replace(".","",$txtLokasi); 

	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Kantor</b> tidak boleh kosong !";		
	}
	if (trim($txtLokasi)=="") {
		$pesanError[] = "Data <b>Lokasi Kantor</b> tidak boleh kosong !";		
	}
	
	// Validasi nama ke Database
	$cekSql="SELECT * FROM kantor WHERE nm_kantor='$txtNama'";
	$cekQry=mysqli_query($koneksidb, $cekSql) or die ("Eror Query".mysqli_errno()); 
	if(mysqli_num_rows($cekQry)>=1){
		$pesanError[] = "Nama Kantor <b>$txtNama</b> Sudah Ada, ganti dengan yang lain";
	}
		
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE. Jika tidak menemukan pesan error, simpan data ke database
		$kodeBaru	= buatKode("kd_kantor","kantor", "K");
		$mySql  	= "INSERT INTO kantor (kd_kantor, nm_kantor, lokasi) VALUES ('$kodeBaru', '$txtNama', '$txtLokasi')";
		$myQry=mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_errno());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Kantor-Add'>";
		}
		exit;
	}	
} // Penutup POST

# MASUKKAN DATA KE VARIABEL
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataKode		= buatKode("kd_kantor","kantor", "K");
$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataLokasi		= isset($_POST['txtLokasi']) ? $_POST['txtLokasi'] : '';
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><b>TAMBAH DATA KANTOR </b></th>
    </tr>
    <tr>
      <td><b>Kode</b></td>
      <td><b>:</b></td>
      <td><input name="textfield" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><b>Nama Kantor </b></td>
      <td><b>:</b></td>
      <td><input name="txtNama" type="text"  value="<?php echo $dataNama; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td><b>Lokasi</b></td>
      <td><b>:</b></td>
      <td><input name="txtLokasi" type="text" value="<?php echo $dataLokasi; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td width="231">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="950">
      <input type="submit" name="btnSimpan" value=" Simpan " />      </td>
    </tr>
  </table>
</form>
