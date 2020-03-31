<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	$cmbPegawai		= $_POST['cmbPegawai'];
	$cmbJabatan		= $_POST['cmbJabatan'];
	$txtNomorSK		= $_POST['txtNomorSK'];
	$txtTglMenjabat	= InggrisTgl($_POST['txtTglMenjabat']);
	$txtTglBerakhir	= InggrisTgl($_POST['txtTglBerakhir']);
	$cmbStatus		= $_POST['cmbStatus'];

	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($cmbPegawai)=="KOSONG") {
		$pesanError[] = "Data <b>Nama Pegawai</b> tidak boleh kosong !";		
	}
	if (trim($cmbJabatan)=="KOSONG") {
		$pesanError[] = "Data <b>Nama Jabatan</b> tidak boleh kosong !";		
	}
	if (trim($txtNomorSK)=="") {
		$pesanError[] = "Data <b>Nomor SK</b> tidak boleh kosong !";		
	}
	if (trim($txtTglMenjabat)=="") {
		$pesanError[] = "Data <b>Tgl. Menjabat</b> tidak boleh kosong !";		
	}
	if (trim($cmbStatus)=="KOSONG") {
		$pesanError[] = "Data <b>Status Jabatan</b> belum dipilih, silahkan pilih pada combo !";		
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
		$ID		= $_POST['txtID']; 
		$mySql  = "UPDATE riwayat_jabatan SET kd_jabatan='$cmbJabatan', nomor_sk='$txtNomorSK', tgl_menjabat='$txtTglMenjabat',
						tgl_berakhir='$txtTglBerakhir', status_aktif='$cmbStatus'
						WHERE id='$ID'";
		$myQry=mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_errno());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Riwayat-Jabatan-Data'>";
		}
		exit;
	}	
} // Penutup POST

# ====================== TAMPILKAN  DATA KE FORM ===============================================
# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan kembali ke form edit
$ID		= isset($_GET['ID']) ?  $_GET['ID'] : $_POST['txtID']; 
$mySql 	= "SELECT * FROM riwayat_jabatan WHERE id='$ID'";
$myQry 	= mysqli_query($koneksidb, $mySql)  or die ("Query ambil data salah : ".mysqli_errno());
	// Baca data
	$myData = mysqli_fetch_array($myQry);
	
	// Masukkan data ke dalam variabel
	$dataPegawai	= isset($_POST['cmbPegawai']) ? $_POST['cmbPegawai'] : $myData['kd_pegawai'];
	$dataJabatan	= isset($_POST['cmbJabatan']) ? $_POST['cmbJabatan'] : $myData['kd_jabatan'];
	$dataNomorSK	= isset($_POST['txtNomorSK']) ? $_POST['txtNomorSK'] : $myData['nomor_sk'];
	$dataTglMenjabat= isset($_POST['txtTglMenjabat']) ? $_POST['txtTglMenjabat'] : IndonesiaTgl($myData['tgl_menjabat']);
	$dataTglBerakhir= isset($_POST['txtTglBerakhir']) ? $_POST['txtTglBerakhir'] : IndonesiaTgl($myData['tgl_berakhir']);
	$dataStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : $myData['status_aktif'];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"   name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><b>UBAH RIWAYAT JABATAN </b></th>
    </tr>
    <tr>
      <td><b>Nama Pegawai </b></td>
      <td><b>:</b></td>
      <td><select name="cmbPegawai">
          <option value="KOSONG">....</option>
          <?php
	  $dataSql = "SELECT * FROM Pegawai ORDER BY nip";
	  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errno());
	  while ($dataRow = mysqli_fetch_array($dataQry)) {
	  	if ($dataPegawai == $dataRow['kd_pegawai']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$dataRow[kd_pegawai]' $cek>[ $dataRow[nip] ] $dataRow[nm_pegawai]</option>";
	  }
	  ?>
      </select>
      <input name="txtID" type="hidden" value="<?php echo $myData['id']; ?>" /></td>
    </tr>
    <tr>
      <td><b>Nama Jabatan </b></td>
      <td><b>:</b></td>
      <td><select name="cmbJabatan">
          <option value="KOSONG">....</option>
          <?php
	  $dataSql = "SELECT * FROM jabatan ORDER BY kd_jabatan";
	  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errno());
	  while ($dataRow = mysqli_fetch_array($dataQry)) {
	  	if ($dataJabatan == $dataRow['kd_jabatan']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$dataRow[kd_jabatan]' $cek>$dataRow[nm_jabatan]</option>";
	  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td><b>Nomor Surat Keputusan (SK) </b></td>
      <td><b>:</b></td>
      <td><input name="txtNomorSK" type="text" value="<?php echo $dataNomorSK; ?>" size="40" maxlength="40" /></td>
    </tr>
    <tr>
      <td><b>Tgl. Menjabat </b></td>
      <td><b>:</b></td>
      <td><input name="txtTglMenjabat" type="text" class="tcal" value="<?php echo $dataTglMenjabat; ?>" maxlength="23" /></td>
    </tr>
    <tr>
      <td><b>Tgl. Berakhir </b></td>
      <td><b>:</b></td>
      <td><input name="txtTglBerakhir" type="text" class="tcal" value="<?php echo $dataTglBerakhir; ?>" maxlength="23" /></td>
    </tr>
    <tr>
      <td><strong>Status Aktif </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbStatus">
          <option value="KOSONG">....</option>
          <?php
		  $pilihan	= array("Aktif", "Tidak");
          foreach ($pilihan as $nilai) {
            if ($dataStatus==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>      </td>
    </tr>
    

    <tr>
      <td width="231">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="950">
        <input type="submit" name="btnSimpan" value=" Simpan " /> </td>
    </tr>
  </table>
</form>
