<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($_POST['cmbPegawai'])=="BLANK") {
		$pesanError[] = "Data <b>Pegawai</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtTanggal'])=="") {
		$pesanError[] = "Data <b>Tanggal Pinjam</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['txtBesarPinjaman'])=="" or ! is_numeric(trim($_POST['txtBesarPinjaman']))) {
		$pesanError[] = "Data <b>Besar Pinjaman (Rp) harus diisi angka</b>, silahkan perbaiki datanya !";		
	}	
	if (trim($_POST['txtKeterangan'])=="") {
		$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong !";		
	}	
			
	# BACA DATA DALAM FORM, masukkan datake variabel
	$cmbPegawai		= $_POST['cmbPegawai'];
	$txtTanggal		= InggrisTgl($_POST['txtTanggal']);
	$txtBesarPinjaman= $_POST['txtBesarPinjaman'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	
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
		$userLogin	= $_SESSION['SES_LOGIN'];
		$kodeBaru	= buatKode("no_pinjaman","pinjaman", "PJ");
		$mySql  	= "INSERT INTO pinjaman (no_pinjaman, kd_pegawai, tanggal, besar_pinjaman, keterangan, status_lunas, kd_user)
						VALUES ('$kodeBaru', 
								'$cmbPegawai', 
								'$txtTanggal', 
								'$txtBesarPinjaman', 
								'$txtKeterangan',
								'Hutang','$userLogin')";
		$myQry=mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_errno());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Pinjaman-Add'>";
		}
		exit;
	}	
} // Penutup POST

# MASUKKAN DATA KE VARIABEL
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataKode			= buatKode("no_pinjaman","pinjaman", "PJ");
$dataPegawai		= isset($_POST['cmbPegawai']) ? $_POST['cmbPegawai'] : '';
$dataTanggal		= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataBesarPinjaman	= isset($_POST['txtBesarPinjaman']) ? $_POST['txtBesarPinjaman'] : '';
$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><strong>TRANSAKSI PINJAMAN BARU</strong></th>
    </tr>
    <tr>
      <td><strong>No Pinjaman </strong></td>
      <td><strong>:</strong></td>
      <td><input name="textfield" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong> Pegawai </strong></td>
      <td><b>:</b></td>
      <td><select name="cmbPegawai">
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
      <td><strong>Tanggal </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTanggal" type="text" class="tcal"  value="<?php echo $dataTanggal; ?>"  maxlength="12" /></td>
    </tr>
    <tr>
      <td><strong>Besar Pinjaman  (Rp) </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtBesarPinjaman" type="text"  value="<?php echo $dataBesarPinjaman; ?>" size="23" maxlength="20" /></td>
    </tr>
    <tr>
      <td><strong>Keterangan </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKeterangan" type="text" value="<?php echo $dataKeterangan; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td width="282">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="1002">
      <input type="submit" name="btnSimpan" value=" Simpan " /></td>
    </tr>
  </table>
</form>
