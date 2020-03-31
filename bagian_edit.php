<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($_POST['txtKode'])=="") {
		$pesanError[] = "Data <b>Kode</b> tidak terbaca !";		
	}
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
	$cekSql="SELECT * FROM bagian WHERE nm_bagian='".$_POST['txtBagian']."' AND NOT(nm_bagian='".$_POST['txtBagianLama']."')";
	$cekQry=mysqli_query($koneksidb, $cekSql) or die ("Eror Query".mysqli_errno()); 
	if(mysqli_num_rows($cekQry)>=1){
		$pesanError[] = "NAMA BAGIAN <b>".$_POST['txtBagian']."</b> SUDAH ADA, ganti dengan yang lain";
	}
			
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtBagian			= $_POST['txtBagian'];
	$txtBagian			= strtoupper($txtBagian);
	
	$txtGajiPokok		= $_POST['txtGajiPokok'];
	$txtGajiPokok		= str_replace(".","",$txtGajiPokok);
	
	$txtUangTransport	= $_POST['txtUangTransport'];
	$txtUangTransport	= str_replace(".","",$txtUangTransport);
	
	$txtUangMakan		= $_POST['txtUangMakan'];
	$txtUangMakan		= str_replace(".","",$txtUangMakan);
	
	$txtUangLembur		= $_POST['txtUangLembur'];
	$txtHargaJutxtUangLembural	= str_replace(".","",$txtUangLembur);
	

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
		$mySql  = "UPDATE bagian SET nm_bagian='$txtBagian', gaji_pokok='$txtGajiPokok', 
					uang_transport='$txtUangTransport', uang_makan='$txtUangMakan', uang_lembur='$txtUangLembur' 
					WHERE kd_bagian='".$_POST['txtKode']."'";
		$myQry=mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_errno());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Bagian-Data'>";
		}
		exit;
	}	
} // Penutup POST

# ====================== TAMPILKAN  DATA KE FORM ===============================================
# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan kembali ke form edit
if($_GET) {
	$Kode= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
	$mySql = "SELECT * FROM bagian WHERE kd_bagian='$Kode'";
	$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query ambil data salah : ".mysqli_errno());
		// Baca data
		$myData = mysqli_fetch_array($myQry);
		
		// Masukkan data ke dalam variabel
		$dataKode			= $myData['kd_bagian'];
		$dataBagian			= isset($_POST['txtBagian']) ? $_POST['txtBagian'] : $myData['nm_bagian'];
		$dataBagianLama		= $myData['nm_bagian'];
		$dataGajiPokok		= isset($_POST['txtGajiPokok']) ? $_POST['txtGajiPokok'] : $myData['gaji_pokok'];
		$dataUangTransport	= isset($_POST['txtUangTransport']) ? $_POST['txtUangTransport'] : $myData['uang_transport'];
		$dataUangMakan		= isset($_POST['txtUangMakan']) ? $_POST['txtUangMakan'] : $myData['uang_makan'];
		$dataUangLembur		= isset($_POST['txtUangLembur']) ? $_POST['txtUangLembur'] : $myData['uang_lembur'];
} // Penutup GET
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"   name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><b>UBAH DATA BAGIAN </b></th>
    </tr>
    <tr>
      <td><b>Kode</b></td>
      <td><b>:</b></td>
      <td><input name="textfield" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly"/>
          <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td><b>Nama Bagian </b></td>
      <td><b>:</b></td>
      <td><input name="txtBagian" type="text"  value="<?php echo $dataBagian; ?>" size="80" maxlength="100" />
      <input name="txtBagianLama" type="hidden" value="<?php echo $dataBagianLama; ?>" /></td>
    </tr>
    <tr>
      <td><b>Gaji Pokok (Rp.) </b></td>
      <td><b>:</b></td>
      <td><input name="txtGajiPokok" type="text" value="<?php echo $dataGajiPokok; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><b>Uang Transport  (Rp.) </b></td>
      <td><b>:</b></td>
      <td><input name="txtUangTransport" type="text"  value="<?php echo $dataUangTransport; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><b>Uang Makan  (Rp.) </b></td>
      <td><b>:</b></td>
      <td><input name="txtUangMakan" type="text"   value="<?php echo $dataUangMakan; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><b>Uang Lembur  (Rp.) </b></td>
      <td><b>:</b></td>
      <td><input name="txtUangLembur" type="text"  value="<?php echo $dataUangLembur; ?>" size="30" maxlength="12" /></td>
    </tr>
    

    <tr>
      <td width="231">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="950">
        <input type="submit" name="btnSimpan" value=" Simpan " /> </td>
    </tr>
  </table>
</form>
