<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($_POST['cmbPegawai'])=="BLANK") {
		$pesanError[] = "Data <b>Pegawai</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtTanggal'])=="") {
		$pesanError[] = "Data <b>Tanggal Lembur</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['txtKeterangan'])=="") {
		$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong !";		
	}	
		
	# BACA DATA DALAM FORM, masukkan datake variabel
	$cmbPegawai	= $_POST['cmbPegawai'];
	$txtTanggal		= InggrisTgl($_POST['txtTanggal']);
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
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database
		$userLogin	= $_SESSION['SES_LOGIN']; 
		$mySql  = "UPDATE lembur SET kd_pegawai='$cmbPegawai', 
					tanggal='$txtTanggal', keterangan='$txtKeterangan', kd_user='$userLogin'
					WHERE id='".$_POST['txtKode']."'";
		$myQry=mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_errno());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Lembur-Data'>";
		}
		exit;
	}	
} // Penutup POST


if($_GET) {
	# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan kembali ke form edit
	$Kode= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
	$mySql = "SELECT * FROM lembur WHERE id='$Kode'";
	$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query ambil data salah : ".mysqli_errno());
		// Baca data
		$myData = mysqli_fetch_array($myQry);
		
		// Masukkan data ke dalam variabel
		$dataKode		= $myData['id'];
		$dataPegawai	= isset($_POST['cmbPegawai']) ? $_POST['cmbPegawai'] : $myData['kd_pegawai'];
		$dataTanggal	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : IndonesiaTgl($myData['tanggal']);
		$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $myData['keterangan'];
} // Penutup GET
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><b>UBAH DATA LEMBUR </b></th>
    </tr>
    <tr>
      <td><b>Tanggal Lembur </b></td>
      <td><b>:</b></td>
      <td><input name="txtTanggal" type="text" class="tcal" value="<?php echo $dataTanggal; ?>"  maxlength="12" />
      <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td><strong>Pegawai </strong></td>
      <td><strong>:</strong></td>
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
	  ?>
        </select>      </td>
    </tr>
    <tr>
      <td><b>Keterangan </b></td>
      <td><b>:</b></td>
      <td><input name="txtKeterangan" type="text" value="<?php echo $dataKeterangan; ?>" size="60" maxlength="100" /></td>
    </tr>
    
    <tr>
      <td width="230">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="1037">
      <input type="submit" name="btnSimpan" value=" Simpan " /> </td>
    </tr>
  </table>
</form>
