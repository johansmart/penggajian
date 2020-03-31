<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($_POST['cmbPegawai'])=="BLANK") {
		$pesanError[] = "Data <b>pegawai</b> tidak boleh kosong !";		
	}
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
	$cmbPegawai	= $_POST['cmbPegawai'];
	$txtTanggal		= InggrisTgl($_POST['txtTanggal']);
	$txtJamMasuk	= $_POST['txtJamMasuk'];
	$txtJamKeluar	= $_POST['txtJamKeluar'];
	$cmbStatus		= $_POST['cmbStatus'];
	$cmbJenis		= $_POST['cmbJenis'];
	$txtKeterangan	= $_POST['txtKeterangan'];

	# Validasi Absensi pada Tanggal yang sama untuk pegawai
	$sqlCek="SELECT * FROM absensi WHERE kd_pegawai='$cmbPegawai' AND tanggal='$txtTanggal'";
	$qryCek=mysqli_query($koneksidb, $sqlCek) or die ("Eror Query".mysqli_errno()); 
	if(mysqli_num_rows($qryCek)>=1){
		$pesanError[] = "<b>ABSENSI TANGGAL [ $txtTanggal ] SUDAH MASUK</b>, ganti dengan yang lain";
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
		$mySql  	= "INSERT INTO absensi (kd_pegawai, tanggal, jam_masuk, jam_keluar, status_kehadiran, jenis_kerja, keterangan)
						VALUES ('$cmbPegawai', 
								'$txtTanggal', 
								'$txtJamMasuk', 
								'$txtJamKeluar',
								'$cmbStatus',
								'$cmbJenis',
								'$txtKeterangan')";
		$myQry=mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_errno());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Absensi-Add'>";
		}
		exit;
	}	
} // Penutup POST

# MASUKKAN DATA KE VARIABEL
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataPegawai		= isset($_POST['cmbPegawai']) ? $_POST['cmbPegawai'] : '';
$dataTanggal		= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataJamMasuk		= isset($_POST['txtJamMasuk']) ? $_POST['txtJamMasuk'] : date('H:i');
$dataJamKeluar		= isset($_POST['txtJamKeluar']) ? $_POST['txtJamKeluar'] : '';
$dataStatus			= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : '';
$dataJenis			= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : '';
$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3">ABSENSI KEHADIRAN PEGAWAI </th>
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
      <td><strong>Tanggal </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTanggal" type="text" class="tcal" value="<?php echo $dataTanggal; ?>" maxlength="12" /></td>
    </tr>
    <tr>
      <td><strong>Jam Masuk </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtJamMasuk" type="text"  value="<?php echo $dataJamMasuk; ?>" size="5" maxlength="5" /></td>
    </tr>
    <tr>
      <td><strong>Jam Keluar </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtJamKeluar" type="text"  value="<?php echo $dataJamKeluar; ?>" size="5" maxlength="5" /></td>
    </tr>
    <tr>
      <td><strong>Status Kehadiran</strong></td>
      <td><strong>:</strong></td>
      <td>
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
        </select>      </td>
    </tr>
    <tr>
      <td><strong>Jenis Kerja</strong></td>
      <td><strong>:</strong></td>
      <td>
        <select name="cmbJenis">
          <option value="BLANK">....</option>
          <?php
		  $pilihan	= array("Wajib", "Lembur");
          foreach ($pilihan as $nilai) {
            if ($dataJenis==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>      </td>
    </tr>
    <tr>
      <td><strong>Keterangan </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKeterangan" type="text" value="<?php echo $dataKeterangan; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td width="181">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="1000">
      <input type="submit" name="btnSimpan" value=" Simpan " />      </td>
    </tr>
  </table>
</form>
