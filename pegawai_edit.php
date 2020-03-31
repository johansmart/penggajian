<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($_POST['txtKode'])=="") {
		$pesanError[] = "Data <b>Kode </b> tidak terbaca !";		
	}
	if (trim($_POST['txtNip'])=="") {
		$pesanError[] = "Data <b>NIP</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtNamaPegawai'])=="") {
		$pesanError[] = "Data <b>Nama Pegawai</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['cmbKelamin'])=="KOSONG") {
		$pesanError[] = "Data <b>Jenis Kelamin</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['cmbGolDarah'])=="KOSONG") {
		$pesanError[] = "Data <b>Golongan Darah</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['cmbAgama'])=="") {
		$pesanError[] = "Data <b>Agama</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['txtAlamatTinggal'])=="") {
		$pesanError[] = "Data <b>Alamat Tinggal</b> tidak boleh kosong !";	
	}	
	if (trim($_POST['txtNoTelepon'])=="") {
		$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['txtTempatLahir'])=="") {
		$pesanError[] = "Data <b>Tempat Lahir</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['cmbStatusKawin'])=="KOSONG") {
		$pesanError[] = "Data <b>Status Kawin</b> tidak boleh kosong !";		
	}		
	if (trim($_POST['txtJumlahAnak'])=="" or ! is_numeric(trim($_POST['txtJumlahAnak']))) {
		$pesanError[] = "Data <b>Jumlah Anak</b> tidak boleh kosong, harus diisi angka !";		
	}		
	if (trim($_POST['cmbPendidikan'])=="KOSONG") {
		$pesanError[] = "Data <b>Pendidikan</b> tidak boleh kosong, belum dipilih !";		
	}		
	if (trim($_POST['txtTahunLulus'])=="" or ! is_numeric(trim($_POST['txtTahunLulus']))) {
		$pesanError[] = "Data <b>Tahun Lulus</b> tidak boleh kosong, harus diisi angka !";		
	}		
	if (trim($_POST['cmbBagian'])=="KOSONG") {
		$pesanError[] = "Data <b>Kode Bagian</b> tidak boleh kosong, belum dipilih !";	
	}	
	if (trim($_POST['txtTglMasuk'])=="") {
		$pesanError[] = "Data <b>Tanggal Masuk</b> tidak boleh kosong !";		
	}	
		
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtNip				= $_POST['txtNip'];
	$txtNamaPegawai		= $_POST['txtNamaPegawai'];
	$cmbBagian			= $_POST['cmbBagian'];
	$cmbKelamin			= $_POST['cmbKelamin'];
	$cmbGolDarah		= $_POST['cmbGolDarah'];
	$cmbAgama			= $_POST['cmbAgama'];
	$txtAlamatTinggal	= $_POST['txtAlamatTinggal'];
	$txtNoTelepon		= $_POST['txtNoTelepon'];
	$txtTempatLahir		= $_POST['txtTempatLahir'];
	$cmbStatusKawin		= $_POST['cmbStatusKawin'];
	$txtJumlahAnak		= $_POST['txtJumlahAnak'];
	$cmbPendidikan		= $_POST['cmbPendidikan'];
	$txtTahunLulus		= $_POST['txtTahunLulus'];
	$txtTglMasuk		= InggrisTgl($_POST['txtTglMasuk']);

	$cmbTglLahir		= $_POST['cmbTglLahir'];
	$cmbBlnLahir		= $_POST['cmbBlnLahir'];
	$cmbThnLahir		= $_POST['cmbThnLahir'];
	$tanggalLahir		= "$cmbThnLahir-$cmbBlnLahir-$cmbTglLahir";

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
		
		# SIMPAN DATA KE DATABASE. // Jika tidak menemukan error, simpan data ke database
		// Membaca Kode dari form
		$Kode	= $_POST['txtKode'];

		# baca, keadaan gambar
		if (empty($_FILES['namaFile']['tmp_name'])) {
			$file_name = $_POST['txtNamaFileH'];
		}
		else  {
			// Jika file gambar lama ada, akan dihapus
			if(! $_POST['txtNamaFileH']=="") {
				unlink("img-foto/".$_POST['txtNamaFileH']);	
			}

			# Jika gambar lama kosong, atau ada gambar baru, maka Mengkopi file gambar
			$file_name = $_FILES['namaFile']['name'];
			$file_name = stripslashes($file_name);
			$file_name = str_replace("'","",$file_name);
			
			$file_name = $Kode.".".$file_name;
			copy($_FILES['namaFile']['tmp_name'],"img-foto/".$file_name);					
		}
		
		// SIMPAN DATA KEMBALI KE DATABASE
		$mySql  = "UPDATE pegawai SET nip='$txtNip', nm_pegawai='$txtNamaPegawai', 
					 kd_bagian='$cmbBagian', kelamin='$cmbKelamin', gol_darah='$cmbGolDarah',
					 agama='$cmbAgama', alamat_tinggal='$txtAlamatTinggal', no_telepon='$txtNoTelepon', 
					 tempat_lahir='$txtTempatLahir', tanggal_lahir='$tanggalLahir',
					 status_kawin='$cmbStatusKawin', jumlah_anak ='$txtJumlahAnak', foto='$file_name', 
					 pendidikan_terakhir='$cmbPendidikan', tahun_lulus='$txtTahunLulus', kd_bagian='$cmbBagian', tanggal_masuk='$txtTglMasuk' 
					 WHERE kd_pegawai='$Kode'"; 
		$myQry=mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_errno());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Pegawai-Data'>";
		}
		exit;
	}	
} // Penutup POST

# ====================== TAMPILKAN  DATA KE FORM ===============================================
# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan kembali ke form edit
$Kode= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
$mySql = "SELECT * FROM pegawai WHERE kd_pegawai='$Kode'";
$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query ambil data salah : ".mysqli_errno());
	// Baca data
	$myData = mysqli_fetch_array($myQry);
	
	// Masukkan data ke dalam variabel
	$dataKode			= $myData['kd_pegawai'];
	$dataNip			= isset($_POST['txtNip']) ? $_POST['txtNip'] : $myData['nip'];
	$dataNamaPegawai	= isset($_POST['txtNamaPegawai']) ? $_POST['txtNamaPegawai'] : $myData['nm_pegawai'];
	$dataJenisKelamin	= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : $myData['kelamin'];
	$dataGolDarah		= isset($_POST['cmbGolDarah']) ? $_POST['cmbGolDarah'] : $myData['gol_darah'];
	$dataAgama			= isset($_POST['cmbAgama']) ? $_POST['cmbAgama'] : $myData['agama'];
	$dataAlamatTinggal	= isset($_POST['txtAlamatTinggal']) ? $_POST['txtAlamatTinggal'] : $myData['alamat_tinggal'];
	$dataNoTelepon		= isset($_POST['txtNoTelepon']) ? $_POST['txtNoTelepon'] : $myData['no_telepon'];
	$dataTempatLahir	= isset($_POST['txtTempatLahir']) ? $_POST['txtTempatLahir'] : $myData['tempat_lahir'];
	$dataTglLahir		= isset($_POST['cmbThnLahir']) ? $_POST['cmbThnLahir'] : $myData['tanggal_lahir'];
	$dataStatusKawin	= isset($_POST['cmbStatusKawin']) ? $_POST['cmbStatusKawin'] : $myData['status_kawin'];
	$dataJumlahAnak		= isset($_POST['txtJumlahAnak']) ? $_POST['txtJumlahAnak'] : $myData['jumlah_anak'];
	$dataPendidikan		= isset($_POST['cmbPendidikan']) ? $_POST['cmbPendidikan'] : $myData['pendidikan_terakhir']; 
	$dataTahunLulus		= isset($_POST['txtTahunLulus']) ? $_POST['txtTahunLulus'] : $myData['tahun_lulus'];
	$dataBagian			= isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : $myData['kd_bagian'];
	$dataTglMasuk		= isset($_POST['txtTglMasuk']) ? $_POST['txtTglMasuk'] : IndonesiaTgl($myData['tanggal_masuk']);
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1"  enctype="multipart/form-data" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><b>UBAH DATA PEGAWAI </b></th>
    </tr>
    <tr>
      <td width="230"><b>Kode</b></td>
      <td width="5"><b>:</b></td>
      <td width="951"> <input name="textfield" type="text"  value="<?php echo $dataKode; ?>" size="10" maxlength="5"  readonly="readonly"/>
      <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td><b>NIP</b></td>
      <td><b>:</b></td>
      <td><input name="txtNip" type="text" value="<?php echo $dataNip; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><b>Nama Pegawai </b></td>
      <td><b>:</b></td>
      <td><input name="txtNamaPegawai" type="text" value="<?php echo $dataNamaPegawai; ?>" size="70" maxlength="100" /></td>
    </tr>
    <tr>
      <td><b>Jenis Kelamin </b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbKelamin">
          <option value="KOSONG">....</option>
          <?php
		  $pilihan	= array("Perempuan", "Laki-laki");
          foreach ($pilihan as $nilai) {
            if ($dataJenisKelamin==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><b>Gol. Darah </b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbGolDarah">
          <option value="KOSONG">....</option>
          <?php
		  $pilihan	= array("A", "B", "AB", "O");
          foreach ($pilihan as $nilai) {
            if ($dataGolDarah==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><b>Agama</b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbAgama">
          <option value="KOSONG">....</option>
          <?php
		  $pilihan	= array("Islam", "Kristen", "Katolik", "Hindu", "Budha");
          foreach ($pilihan as $nilai) {
            if ($dataAgama==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><b>Alamat Tinggal </b></td>
      <td><b>:</b></td>
      <td><input name="txtAlamatTinggal" type="text"  value="<?php echo $dataAlamatTinggal; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td><b>No. Telepon </b></td>
      <td><b>:</b></td>
      <td><input name="txtNoTelepon" type="text" value="<?php echo $dataNoTelepon; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><b>Tempat, Tanggal Lahir </b></td>
      <td><b>:</b></td>
      <td><input name="txtTempatLahir" type="text"  value="<?php echo $dataTempatLahir; ?>" size="50" maxlength="100" />
        , <?php echo listTanggal("Lahir",$dataTglLahir); ?></td>
    </tr>
    <tr>
      <td><b>Status Kawin </b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbStatusKawin">
          <option value="KOSONG">....</option>
          <?php
		  $pilihan	= array("Kawin", "Belum Kawin");
          foreach ($pilihan as $nilai) {
            if ($dataStatusKawin==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><strong>Jumlah Anak </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtJumlahAnak" type="text" value="<?php echo $dataJumlahAnak; ?>" size="10" maxlength="4" /></td>
    </tr>
    <tr>
      <td><strong>Foto Terbaru </strong></td>
      <td><strong>:</strong></td>
      <td><input name="namaFile" type="file" size="50" />
          <input name="txtNamaFileH" type="hidden" value="<?php echo $myData['foto']; ?>" /></td>
    </tr>
    <tr>
      <td><strong>Pendidikan Terakhir </strong></td>
      <td><strong>:</strong></td>
      <td><b>
        <select name="cmbPendidikan">
          <option value="KOSONG">....</option>
          <?php
		  include "library/inc.pilihan.php";
          foreach ($pendidikan as $kode => $nilai) {
            if($dataPendidikan == $kode) {
                $cek=" selected";
            } else { $cek = ""; } 
            echo "<option value='$kode' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><strong>Tahun Lulus </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTahunLulus" type="text" value="<?php echo $dataTahunLulus; ?>" size="10" maxlength="4" /></td>
    </tr>
    <tr>
      <td><strong>Bagian </strong></td>
      <td><b>:</b></td>
      <td><select name="cmbBagian">
          <option value="KOSONG">....</option>
          <?php
	  $dataSql = "SELECT * FROM bagian ORDER BY kd_bagian";
	  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errno());
	  while ($dataRow = mysqli_fetch_array($dataQry)) {
	  	if ($dataBagian == $dataRow['kd_bagian']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$dataRow[kd_bagian]' $cek>$dataRow[nm_bagian]</option>";
	  }
	  $sqlData ="";
	  ?>
      </select></td>
    </tr>
    <tr>
      <td><b>Tanggal Masuk </b></td>
      <td><b>:</b></td>
      <td><input name="txtTglMasuk" type="text"  class="tcal"  value="<?php echo $dataTglMasuk; ?>" maxlength="12" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
        <input type="submit" name="btnSimpan" value=" Simpan " /> </td>
    </tr>
  </table>
</form>
