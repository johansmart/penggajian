<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($_POST['txtBagian'])=="") {
		$pesanError[] = "Data <b>Nama Bagian</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtGajiPokok'])=="" or ! is_numeric(trim($_POST['txtGajiPokok']))) {
		$pesanError[] = "Data <b>Gaji Pokok (Rp)</b> tidak boleh kosong, harus diisi angka  atau 0 !";		
	}
	if (trim($_POST['txtUangTransport'])=="" or ! is_numeric(trim($_POST['txtUangTransport']))) {
		$pesanError[] = "Data <b>Uang Transport (Rp)</b> tidak boleh kosong, harus diisi angka  atau 0 !";		
	}
	if (trim($_POST['txtUangMakan'])=="" or ! is_numeric(trim($_POST['txtUangMakan']))) {
		$pesanError[] = "Data <b>Uang Makan (Rp)</b> tidak boleh kosong, harus diisi angka  atau 0 !";		
	}
	if (trim($_POST['txtUangLembur'])=="" or ! is_numeric(trim($_POST['txtUangLembur']))) {
		$pesanError[] = "Data <b>Uang Lembur (Rp)</b> tidak boleh kosong, harus diisi angka  atau 0 !";		
	}
	
	// Validasi nama ke Database
	$cekSql="SELECT * FROM bagian WHERE nm_bagian='".$_POST['txtBagian']."'";
	$cekQry=mysqli_query($koneksidb, $cekSql) or die ("Eror Query".mysqli_errno()); 
	if(mysqli_num_rows($cekQry)>=1){
		$pesanError[] = "NAMA BAGIAN <b>".$_POST['txtBagian']."</b> SUDAH ADA, ganti dengan yang lain";
	}
			
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtBagian			= $_POST['txtBagian']; 
	$txtBagian			= strtoupper($txtBagian); // Kuruf menjadi BESAR
	
	$txtGajiPokok		= $_POST['txtGajiPokok'];
	$txtGajiPokok		= str_replace(".","",$txtGajiPokok); // menghilangkan karakter titik dalang angka
	
	$txtUangTransport	= $_POST['txtUangTransport'];
	$txtUangTransport	= str_replace(".","",$txtUangTransport); // menghilangkan karakter titik dalang angka
	
	$txtUangMakan		= $_POST['txtUangMakan'];
	$txtUangMakan		= str_replace(".","",$txtUangMakan); // menghilangkan karakter titik dalang angka
	
	$txtUangLembur		= $_POST['txtUangLembur'];
	$txtHargaJutxtUangLembural	= str_replace(".","",$txtUangLembur); // menghilangkan karakter titik dalang angka
	
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
		$kodeBaru	= buatKode("kd_bagian","bagian", "B");
		$mySql  	= "INSERT INTO bagian (kd_bagian, nm_bagian, gaji_pokok, uang_transport, uang_makan, uang_lembur)
						VALUES ('$kodeBaru', 
								'$txtBagian', 
								'$txtGajiPokok', 
								'$txtUangTransport', 
								'$txtUangMakan',
								'$txtUangLembur')";
		$myQry=mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_errno());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Bagian-Add'>";
		}
		exit;
	}	
} // Penutup POST

# MASUKKAN DATA KE VARIABEL
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataKode			= buatKode("kd_bagian","bagian", "B");
$dataBagian			= isset($_POST['txtBagian']) ? $_POST['txtBagian'] : '';
$dataGajiPokok		= isset($_POST['txtGajiPokok']) ? $_POST['txtGajiPokok'] : '';
$dataUangTransport	= isset($_POST['txtUangTransport']) ? $_POST['txtUangTransport'] : '';
$dataUangMakan		= isset($_POST['txtUangMakan']) ? $_POST['txtUangMakan'] : '';
$dataUangLembur		= isset($_POST['txtUangLembur']) ? $_POST['txtUangLembur'] : '';
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><b>TAMBAH DATA BAGIAN </b></th>
    </tr>
    <tr>
      <td><b>Kode</b></td>
      <td><b>:</b></td>
      <td><input name="textfield" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><b>Nama Bagian </b></td>
      <td><b>:</b></td>
      <td><input name="txtBagian" type="text"  value="<?php echo $dataBagian; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td><b>Gaji Pokok (Rp.)  </b></td>
      <td><b>:</b></td>
      <td><input name="txtGajiPokok" type="text" value="<?php echo $dataGajiPokok; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><b>Uang Transport  (Rp.)  </b></td>
      <td><b>:</b></td>
      <td><input name="txtUangTransport" type="text"  value="<?php echo $dataUangTransport; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><b>Uang Makan  (Rp.)  </b></td>
      <td><b>:</b></td>
      <td><input name="txtUangMakan" type="text"   value="<?php echo $dataUangMakan; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><b>Uang Lembur  (Rp.)  </b></td>
      <td><b>:</b></td>
      <td><input name="txtUangLembur" type="text"  value="<?php echo $dataUangLembur; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td width="231">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="950">
      <input type="submit" name="btnSimpan" value=" Simpan " />      </td>
    </tr>
  </table>
</form>
