<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtNama			= $_POST['txtNama']; 
	$txtNama			= strtoupper($txtNama); // Kuruf menjadi BESAR
	
	$txtTunjangan		= $_POST['txtTunjangan'];
	$txtTunjangan		= str_replace(".","",$txtTunjangan); // menghilangkan karakter titik dalang angka

	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Jabatan</b> tidak boleh kosong !";		
	}
	if (trim($txtTunjangan)=="" or ! is_numeric(trim($txtTunjangan))) {
		$pesanError[] = "Data <b>Tunjangan Jabatan (Rp)</b> tidak boleh kosong, harus diisi angka  atau 0 !";		
	}
	
	// Validasi nama ke Database
	$txtNamaLama		= $_POST['txtNamaLama']; 
	$cekSql="SELECT * FROM jabatan WHERE nm_jabatan='$txtNama' AND NOT(nm_jabatan='$txtNamaLama')";
	$cekQry=mysqli_query($koneksidb, $cekSql) or die ("Eror Query".mysqli_errno()); 
	if(mysqli_num_rows($cekQry)>=1){
		$pesanError[] = "Nama Jabatan <b>$txtNama</b> Sudah Ada, ganti dengan yang lain";
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
		
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database
		$txtKode= $_POST['txtKode']; 
		$mySql  = "UPDATE jabatan SET nm_jabatan='$txtNama', tunj_jabatan='$txtTunjangan' WHERE kd_jabatan='$txtKode'";
		$myQry=mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_errno());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Jabatan-Data'>";
		}
		exit;
	}	
} // Penutup POST

# ====================== TAMPILKAN  DATA KE FORM ===============================================
# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan kembali ke form edit
$Kode= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
$mySql = "SELECT * FROM jabatan WHERE kd_jabatan='$Kode'";
$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query ambil data salah : ".mysqli_errno());
	// Baca data
	$myData = mysqli_fetch_array($myQry);
	
	// Masukkan data ke dalam variabel
	$dataKode		= $myData['kd_jabatan'];
	$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_jabatan'];
	$dataTunjangan	= isset($_POST['txtTunjangan']) ? $_POST['txtTunjangan'] : $myData['tunj_jabatan'];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"   name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><b>UBAH DATA JABATAN </b></th>
    </tr>
    <tr>
      <td><b>Kode</b></td>
      <td><b>:</b></td>
      <td><input name="textfield" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly"/>
          <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td><b>Nama Jabatan </b></td>
      <td><b>:</b></td>
      <td><input name="txtNama" type="text"  value="<?php echo $dataNama; ?>" size="80" maxlength="100" />
      <input name="txtNamaLama" type="hidden" value="<?php echo $myData['nm_jabatan']; ?>" /></td>
    </tr>
    <tr>
      <td><b>Tunjangan  (Rp.) </b></td>
      <td><b>:</b></td>
      <td><input name="txtTunjangan" type="text" value="<?php echo $dataTunjangan; ?>" size="30" maxlength="12" /></td>
    </tr>
    

    <tr>
      <td width="231">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="950">
        <input type="submit" name="btnSimpan" value=" Simpan " /> </td>
    </tr>
  </table>
</form>
