<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
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
	if (trim($_POST['cmbAgama'])=="KOSONG") {
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
		$pesanError[] = "Data <b>Bagian</b> tidak boleh kosong !";		
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
	
	// Membaca form tanggal lahir (comboBox : tanggal, bulan dan tahun lahir)
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
		# SIMPAN DATA KE DATABASE. Jika tidak menemukan pesan error, simpan data ke database
		// Membuat kode baru, menggunakan fungsi BuatKode yang ada di inc.library.php
		$kodeBaru	= buatKode("kd_pegawai","pegawai", "P");

		# Mengkopi file foto
		if (! empty($_FILES['namaFile']['tmp_name'])) {
			// Simpan foto
			$file_name = $_FILES['namaFile']['name'];
			$file_name = stripslashes($file_name);
			$file_name = str_replace("'","",$file_name);
			
			$file_name = $kodeBaru.".".$file_name;
			copy($_FILES['namaFile']['tmp_name'],"img-foto/".$file_name);
		}
		else {
			$file_name = "";
		}
		
		// Menyimpan data Karyawan
		$mySql  	= "INSERT INTO pegawai (kd_pegawai, nip, nm_pegawai, kelamin, 
		                        gol_darah, agama, alamat_tinggal, no_telepon, tempat_lahir, tanggal_lahir, 
							    status_kawin, jumlah_anak, foto, pendidikan_terakhir, tahun_lulus, kd_bagian, tanggal_masuk)
						VALUES ('$kodeBaru', '$txtNip', '$txtNamaPegawai', '$cmbKelamin', 
						'$cmbGolDarah','$cmbAgama','$txtAlamatTinggal','$txtNoTelepon', '$txtTempatLahir', '$tanggalLahir',
						'$cmbStatusKawin', '$txtJumlahAnak', '$file_name', '$cmbPendidikan', '$txtTahunLulus', '$cmbBagian', '$txtTglMasuk')";
		$myQry=mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_errno());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Pegawai-Add'>";
		}
		exit;
	}	
} // Penutup POST

# MASUKKAN DATA KE VARIABEL
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataKode			= buatKode("kd_pegawai","pegawai", "P");
$dataNip			= isset($_POST['txtNip']) ? $_POST['txtNip'] : '';
$dataNamaPegawai	= isset($_POST['txtNamaPegawai']) ? $_POST['txtNamaPegawai'] : '';
$dataJenisKelamin	= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : '';
$dataGolDarah		= isset($_POST['cmbGolDarah']) ? $_POST['cmbGolDarah'] : '';
$dataAgama			= isset($_POST['cmbAgama']) ? $_POST['cmbAgama'] : '';
$dataAlamatTinggal	= isset($_POST['txtAlamatTinggal']) ? $_POST['txtAlamatTinggal'] : '';
$dataNoTelepon		= isset($_POST['txtNoTelepon']) ? $_POST['txtNoTelepon'] : '';
$dataTempatLahir	= isset($_POST['txtTempatLahir']) ? $_POST['txtTempatLahir'] : '';
$dataStatusKawin	= isset($_POST['cmbStatusKawin']) ? $_POST['cmbStatusKawin'] : '';
$dataJumlahAnak		= isset($_POST['txtJumlahAnak']) ? $_POST['txtJumlahAnak'] : '';
$dataPendidikan		= isset($_POST['cmbPendidikan']) ? $_POST['cmbPendidikan'] : '';
$dataTahunLulus		= isset($_POST['txtTahunLulus']) ? $_POST['txtTahunLulus'] : '';
$dataBagian			= isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : '';
$dataTglMasuk		= isset($_POST['txtTglMasuk']) ? $_POST['txtTglMasuk'] : date('d-m-Y');

$dataThn			= isset($_POST['cmbThnLahir']) ? $_POST['cmbThnLahir'] : date('Y');
$dataBln			= isset($_POST['cmbBlnLahir']) ? $_POST['cmbBlnLahir'] : date('m');
$dataTgl			= isset($_POST['cmbTglLahir']) ? $_POST['cmbTglLahir'] : date('d');
$dataTglLahir 		= $dataThn."-".$dataBln."-".$dataTgl;
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1"  enctype="multipart/form-data" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3">TAMBAH DATA PEGAWAI </th>
    </tr>
    <tr>
      <td width="231"><strong>Kode</strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="950"> <input name="textfield" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>NIP</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNip" type="text" value="<?php echo $dataNip; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><strong>Nama Pegawai </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNamaPegawai" type="text"  value="<?php echo $dataNamaPegawai; ?>" size="70" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>Jenis Kelamin </strong></td>
      <td><strong>:</strong></td>
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
      <td><strong>Gol. Darah </strong></td>
      <td><strong>:</strong></td>
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
      <td><strong>Agama</strong></td>
      <td><strong>:</strong></td>
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
      <td><strong>Alamat Tinggal </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtAlamatTinggal" type="text"  value="<?php echo $dataAlamatTinggal; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>No. Telepon </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNoTelepon" type="text" value="<?php echo $dataNoTelepon; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><strong>Tempat, Tanggal Lahir </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTempatLahir" type="text"  value="<?php echo $dataTempatLahir; ?>" size="50" maxlength="100" />
        , <?php echo listTanggal("Lahir",$dataTglLahir); ?></td>
    </tr>
    <tr>
      <td><strong>Status Kawin </strong></td>
      <td><strong>:</strong></td>
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
      <td><input name="namaFile" type="file" size="50" /></td>
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
            if ($dataPendidikan==$kode) {
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
      <td><strong>:</strong></td>
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
      <td><strong>Tanggal Masuk </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTglMasuk" type="text"  class="tcal"  value="<?php echo $dataTglMasuk; ?>" maxlength="12" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
        <input type="submit" name="btnSimpan" value=" Simpan " />       </td>
    </tr>
  </table>
</form>
