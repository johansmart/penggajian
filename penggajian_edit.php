<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($_POST['txtKode'])=="") {
		$pesanError[] = "Data <b>No. Penggajian</b> tidak terbaca !";		
	}
	if (trim($_POST['txtGajiPokok'])=="" or ! is_numeric(trim($_POST['txtGajiPokok']))) {
		$pesanError[] = "Data <b>Gaji Pokok (Rp) harus diisi angka</b>, silahkan perbaiki datanya !";		
	}	
	if (trim($_POST['txtTunjJabatan'])=="" or ! is_numeric(trim($_POST['txtTunjJabatan']))) {
		$pesanError[] = "Data <b>Tunjangan Jabatan (Rp) harus diisi angka</b>, silahkan perbaiki datanya !";		
	}	
	if (trim($_POST['txtTunjTransport'])=="" or ! is_numeric(trim($_POST['txtTunjTransport']))) {
		$pesanError[] = "Data <b>Tunjangan Transport (Rp) harus diisi angka</b>, silahkan perbaiki datanya !";		
	}	
	if (trim($_POST['txtTunjMakan'])=="" or ! is_numeric(trim($_POST['txtTunjMakan']))) {
		$pesanError[] = "Data <b>Tunjangan Makan (Rp) harus diisi angka</b>, silahkan perbaiki datanya !";		
	}	
	
	if (trim($_POST['txtTotalBonus'])=="" or ! is_numeric(trim($_POST['txtTotalBonus']))) {
		$pesanError[] = "Data <b>Total Bonus (Rp) harus diisi angka</b>, silahkan perbaiki datanya !";		
	}	
			
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtGajiPokok		= $_POST['txtGajiPokok'];
	$txtTunjJabatan		= $_POST['txtTunjJabatan'];
	$txtTunjTransport	= $_POST['txtTunjTransport'];
	$txtTunjMakan		= $_POST['txtTunjMakan'];
	$txtTotalBonus		= $_POST['txtTotalBonus'];

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
		$mySql  = "UPDATE penggajian SET gaji_pokok='$txtGajiPokok', tunj_jabatan='$txtTunjJabatan',  tunj_transport='$txtTunjTransport', 
					tunj_makan='$txtTunjMakan', total_bonus='$txtTotalBonus'
					WHERE no_penggajian='".$_POST['txtKode']."'";
		$myQry=mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_errno());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Penggajian-Data'>";
		}
		exit;
	}	
} // Penutup POST


if($_GET) {
	# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan kembali ke form edit
	$Kode= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
	$mySql = "SELECT * FROM penggajian WHERE no_penggajian='$Kode'";
	$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query ambil data salah : ".mysqli_errno());
	$myData= mysqli_fetch_array($myQry);
		
		// Masukkan data ke dalam variabel
		$dataKode			= $myData['no_penggajian'];
		$dataPegawai		= isset($_POST['cmbPegawai']) ? $_POST['cmbPegawai'] : $myData['kd_pegawai'];
		$dataGajiPokok		= isset($_POST['txtGajiPokok']) ? $_POST['txtGajiPokok'] : $myData['gaji_pokok'];
		$dataTunjJabatan	= isset($_POST['txtTunjJabatan']) ? $_POST['txtTunjJabatan'] : $myData['tunj_jabatan'];
		$dataTunjTransport	= isset($_POST['txtTunjTransport']) ? $_POST['txtTunjTransport'] : $myData['tunj_transport'];
		$dataTunjMakan		= isset($_POST['txtTunjMakan']) ? $_POST['txtTunjMakan'] : $myData['tunj_makan'];
		$dataTotalLembur	= isset($_POST['txtTotalLembur']) ? $_POST['txtTotalLembur'] : $myData['total_lembur'];
		$dataTotalBonus		= isset($_POST['txtTotalBonus']) ? $_POST['txtTotalBonus'] : $myData['total_bonus'];
		$dataTotalPinjaman	= isset($_POST['txtTotalPinjaman']) ? $_POST['txtTotalPinjaman'] : $myData['total_pinjaman'];
} // Penutup GET
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><strong>UBAH TRANSAKSI PENGGAJIAN </strong></th>
    </tr>
    <tr>
      <td><strong>No. Penggajian </strong></td>
      <td><strong>:</strong></td>
      <td><input name="textfield" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly"/>
          <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td><strong> Pegawai </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbPegawai" disabled="disabled">
          <option value="BLANK">....</option>
          <?php
	  $dataSql = "SELECT * FROM pegawai ORDER BY kd_pegawai";
	  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errno());
	  while ($dataRow = mysqli_fetch_array($dataQry)) {
	  	if ($dataPegawai == $dataRow['kd_pegawai']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$dataRow[kd_pegawai]' $cek>[ $dataRow[nip] ] $dataRow[nm_pegawai]</option>";
	  }
	  $sqlData ="";
	  ?>
      </select></td>
    </tr>
    <tr>
      <td><strong>Gaji Pokok (Rp) </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtGajiPokok" type="text" value="<?php echo $dataGajiPokok; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><strong>Tunjangan Jabatan (Rp)</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTunjJabatan" type="text" value="<?php echo $dataTunjJabatan; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><strong>Tunjangan Transport  (Rp)</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTunjTransport" type="text" value="<?php echo $dataTunjTransport; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><strong>Tunjangan Makan  (Rp)</strong></td>
      <td>&nbsp;</td>
      <td><input name="txtTunjMakan" type="text" value="<?php echo $dataTunjMakan; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><strong>Total Lembur  (Rp)</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTotalLembur" type="text"  value="<?php echo $dataTotalLembur; ?>" size="30" maxlength="12"  readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Total Bonus  (Rp)</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTotalBonus" type="text"  value="<?php echo $dataTotalBonus; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><strong>Total Pinjaman  (Rp)</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTotalPinjaman" type="text"  value="<?php echo $dataTotalPinjaman; ?>" size="30" maxlength="12"  readonly="readonly"/></td>
    </tr>
    <tr>
      <td width="232">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="966">
      <input type="submit" name="btnSimpan" value=" Simpan " /> </td>
    </tr>
  </table>
</form>
