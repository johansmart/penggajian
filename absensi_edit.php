<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($_POST['txtTanggal'])=="") {
		$pesanError[] = "Data <b>Tanggal</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['txtJamMasuk'])=="") {
		$pesanError[] = "Data <b>Jam Masuk</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['txtJamKeluar'])=="") {
		$pesanError[] = "Data <b>Jam Keluar</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['cmbStatus'])=="BLANK") {
		$pesanError[] = "Data <b>Status Kehadiran</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['cmbJenis'])=="BLANK") {
		$pesanError[] = "Data <b>Jenis Kerja</b> tidak boleh kosong !";		
	}	
			
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtTanggal		= InggrisTgl($_POST['txtTanggal']);
	$txtJamMasuk	= $_POST['txtJamMasuk'];
	$txtJamKeluar	= $_POST['txtJamKeluar'];
	$cmbStatus		= $_POST['cmbStatus'];
	$cmbJenis		= $_POST['cmbJenis'];
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
		$mySql  = "UPDATE absensi SET jam_masuk='$txtJamMasuk', jam_keluar='$txtJamKeluar', 
					status_kehadiran='$cmbStatus', jenis_kerja='$cmbJenis', keterangan='$txtKeterangan' 
					WHERE id='".$_POST['txtKode']."'";
		$myQry=mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_errno());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Absensi-Data'>";
		}
		exit;
	}	
} // Penutup POST


if($_GET) {
	# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan kembali ke form edit
	$Kode= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
	$mySql = "SELECT * FROM absensi WHERE id='$Kode'";
	$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query ambil data salah : ".mysqli_errno());
		// Baca data
		$myData = mysqli_fetch_array($myQry);
		
		// Masukkan data ke dalam variabel
		$dataKode			= $myData['id'];
		$dataPegawai		= isset($_POST['cmbPegawai']) ? $_POST['cmbPegawai'] : $myData['kd_pegawai'];
		$dataTanggal		= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : IndonesiaTgl($myData['tanggal']);
		$dataJamMasuk		= isset($_POST['txtJamMasuk']) ? $_POST['txtJamMasuk'] : $myData['jam_masuk'];
		$dataJamKeluar		= isset($_POST['txtJamKeluar']) ? $_POST['txtJamKeluar'] : $myData['jam_keluar'];
		$dataStatus			= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : $myData['status_kehadiran'];
		$dataJenis			= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : $myData['jenis_kerja'];
		$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $myData['keterangan'];
} // Penutup GET
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><b>UBAH ABSENSI </b></th>
    </tr>
    <tr>
      <td><strong>Pegawai </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbPegawai"  disabled="disabled">
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
        </select>
      <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td><b>Tanggal </b></td>
      <td><b>:</b></td>
      <td><input name="txtTanggal" type="text" value="<?php echo $dataTanggal; ?>"  maxlength="12"  readonly="readonly"/></td>
    </tr>
    <tr>
      <td><b>Jam Masuk </b></td>
      <td><b>:</b></td>
      <td><input name="txtJamMasuk" type="text"  value="<?php echo $dataJamMasuk; ?>" size="5" maxlength="5" /></td>
    </tr>
    <tr>
      <td><b>Jam Keluar </b></td>
      <td><b>:</b></td>
      <td><input name="txtJamKeluar" type="text"  value="<?php echo $dataJamKeluar; ?>" size="5" maxlength="5" /></td>
    </tr>
    <tr>
      <td><b>Status Kehadiran</b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbStatus">
          <option value="BLANK">....</option>
          <?php
		  $pilihan	= array("0" => "Tidak Masuk", "1" => "Masuk", "2" => "Izin", "3" => "Cuti");
          foreach ($pilihan as $nilai => $isi) {
            if ($dataStatus==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai -> $isi</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><b>Jenis Kerja </b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbJenis">
          <option value="BLANK">....</option>
          <?php
		  $pilihan	= array( "Wajib", "Lembur");
          foreach ($pilihan as $nilai) {
            if ($dataJenis==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><b>Keterangan </b></td>
      <td><b>:</b></td>
      <td><input name="txtKeterangan" type="text" value="<?php echo $dataKeterangan; ?>" size="80" maxlength="100" /></td>
    </tr>
    

    <tr>
      <td width="180">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="1001">
      <input type="submit" name="btnSimpan" value=" Simpan " /> </td>
    </tr>
  </table>
</form>
