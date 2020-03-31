<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	$cmbPegawai		= $_POST['cmbPegawai'];
	$cmbKantor		= $_POST['cmbKantor'];
	$txtKantorLama	= $_POST['txtKantorLama'];
	$txtTglMutasi	= InggrisTgl($_POST['txtTglMutasi']);

	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($cmbPegawai)=="KOSONG") {
		$pesanError[] = "Data <b>Nama Pegawai</b> tidak boleh kosong !";		
	}
	if (trim($cmbKantor)=="KOSONG") {
		$pesanError[] = "Data <b>Nama Kantor</b> tidak boleh kosong !";		
	}
	if (trim($txtTglMutasi)=="") {
		$pesanError[] = "Data <b>Tgl. Mutasi</b> tidak boleh kosong !";		
	}
	if (trim($txtKantorLama)=="") {
		$pesanError[] = "Data <b>Kantor Lama</b> tidak boleh kosong !";		
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
		$mySql  = "UPDATE riwayat_mutasi SET kd_kantor='$cmbKantor', kantor_lama='$txtKantorLama', tgl_mutasi='$txtTglMutasi' WHERE id='$ID'";
		$myQry=mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_errno());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Riwayat-Mutasi-Data'>";
		}
		exit;
	}	
} // Penutup POST

# ====================== TAMPILKAN  DATA KE FORM ===============================================
# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan kembali ke form edit
$ID		= isset($_GET['ID']) ?  $_GET['ID'] : $_POST['txtID']; 
$mySql 	= "SELECT * FROM riwayat_mutasi WHERE id='$ID'";
$myQry 	= mysqli_query($koneksidb, $mySql)  or die ("Query ambil data salah : ".mysqli_errno());
	// Baca data
	$myData = mysqli_fetch_array($myQry);
	
	// Masukkan data ke dalam variabel
	$dataPegawai	= isset($_POST['cmbPegawai']) ? $_POST['cmbPegawai'] : $myData['kd_pegawai'];
	$dataKantor		= isset($_POST['cmbKantor']) ? $_POST['cmbKantor'] : $myData['kd_kantor'];
	$dataKantorLama	= isset($_POST['txtKantorLama']) ? $_POST['txtKantorLama'] : $myData['kantor_lama'];
	$dataTglMutasi	= isset($_POST['txtTglMutasi']) ? $_POST['txtTglMutasi'] : IndonesiaTgl($myData['tgl_mutasi']);
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"   name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><b>UBAH RIWAYAT MUTASI </b></th>
    </tr>
    <tr>
      <td><b>Nama Pegawai </b></td>
      <td><b>:</b></td>
      <td><select name="cmbPegawai">
          <option value="KOSONG">....</option>
          <?php
	  $dataSql = "SELECT * FROM pegawai ORDER BY nip";
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
      <td><b>Nama Kantor </b></td>
      <td><b>:</b></td>
      <td><select name="cmbKantor">
          <option value="KOSONG">....</option>
          <?php
	  $dataSql = "SELECT * FROM kantor ORDER BY kd_kantor";
	  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errno());
	  while ($dataRow = mysqli_fetch_array($dataQry)) {
	  	if ($dataKantor == $dataRow['kd_kantor']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$dataRow[kd_kantor]' $cek>$dataRow[nm_kantor]</option>";
	  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td><b>Tgl. Mutasi </b></td>
      <td><b>:</b></td>
      <td><input name="txtTglMutasi" type="text" class="tcal" value="<?php echo $dataTglMutasi; ?>" maxlength="23" /></td>
    </tr>
    <tr>
      <td><strong>Kantor Lama </strong></td>
      <td><b>:</b></td>
      <td><input name="txtKantorLama" type="text" value="<?php echo $dataKantorLama; ?>" size="80" maxlength="100" /></td>
    </tr>
    

    <tr>
      <td width="231">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="950">
        <input type="submit" name="btnSimpan" value=" Simpan " /> </td>
    </tr>
  </table>
</form>
