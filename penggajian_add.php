<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($_POST['cmbPegawai'])=="KOSONG") {
		$pesanError[] = "Data <b>Pegawai</b> tidak boleh kosong, <b> ini adalah pegawai yang akan digaji</b> !";		
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
	if (trim($_POST['txtTotalLembur'])=="" or ! is_numeric(trim($_POST['txtTotalLembur']))) {
		$pesanError[] = "Data <b>Total Gaji Lembur (Rp) harus diisi angka</b>, silahkan perbaiki datanya !";		
	}	
	if (trim($_POST['txtTotalBonus'])=="" or ! is_numeric(trim($_POST['txtTotalBonus']))) {
		$pesanError[] = "Data <b>Total Bonus (Rp) harus diisi angka</b>, silahkan perbaiki datanya !";		
	}	
	if (trim($_POST['txtTotalPinjaman'])=="" or ! is_numeric(trim($_POST['txtTotalPinjaman']))) {
		$pesanError[] = "Data <b>Total Pinjaman (Rp) harus diisi angka</b>, silahkan perbaiki datanya !";		
	}	
			
	# BACA DATA DALAM FORM, masukkan datake variabel
	$cmbBulan			= $_POST['cmbBulan'];
	$cmbTahun			= $_POST['cmbTahun'];
	$cmbPegawai			= $_POST['cmbPegawai'];
	$txtGajiPokok		= $_POST['txtGajiPokok'];
	$txtTunjJabatan		= $_POST['txtTunjJabatan'];
	$txtTunjTransport	= $_POST['txtTunjTransport'];
	$txtTunjMakan		= $_POST['txtTunjMakan'];
	$txtTotalLembur		= $_POST['txtTotalLembur'];
	$txtTotalBonus		= $_POST['txtTotalBonus'];
	$txtTotalPinjaman	= $_POST['txtTotalPinjaman'];
	
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
		$kodeBaru	= buatKode("no_penggajian","penggajian", "PG");
		$tanggalGaji= date('Y-m-d');
		$mySql  	= "INSERT INTO penggajian(no_penggajian, periode_gaji, tanggal, kd_pegawai, gaji_pokok, tunj_jabatan, tunj_transport, tunj_makan, 
												total_lembur, total_bonus, total_pinjaman, kd_user)
						VALUES ('$kodeBaru', 
								'$cmbBulan-$cmbTahun',
								'$tanggalGaji', 
								'$cmbPegawai', 
								'$txtGajiPokok', 
								'$txtTunjJabatan',
								'$txtTunjTransport',
								'$txtTunjMakan',
								'$txtTotalLembur', 
								'$txtTotalBonus',
								'$txtTotalPinjaman', '$userLogin')";
		$myQry=mysqli_query($koneksidb, $mySql) or die ("Gagal query 1".mysqli_errno());
		if($myQry){
			// Update status Pinjaman Lunas
			$my2Sql  = "UPDATE pinjaman SET status_lunas='Lunas' WHERE kd_pegawai='$cmbPegawai'";
			mysqli_query($koneksidb, $my2Sql) or die ("Gagal query 2".mysqli_errno());
			
			// Refresh Jendela baru
			echo "<script>";
			echo "window.open('penggajian_nota.php?noNota=$kodeBaru', width=330,height=330,left=100, top=25)";
			echo "</script>";

			echo "<meta http-equiv='refresh' content='0; url=?page=Penggajian-Add'>";
		}
		exit;
	}	
} // Penutup POST

# MASUKKAN DATA KE VARIABEL
$dataKode			= buatKode("no_penggajian","penggajian", "PG");
$dataPegawai		= isset($_POST['cmbPegawai']) ? $_POST['cmbPegawai'] : '';

$dataBulan			= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : date('m')-1; // bulan kemaren (asumsi Penggajian dilakukan di tanggal 1, bulan berikutnya)

// Membuat angka bulan selalu 2 digit (01, 02, 03.....12)
if(strlen($dataBulan)=="1") { $dataBulan= "0".$dataBulan; } else { $dataBulan = $dataBulan; }

$dataTahun			= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : date('Y'); // tahun sekarang

// Mendapatkan Informasi Gaji Poko + Tunjangan dari tabel BAGIAN
$mySql = "SELECT bagian.* FROM bagian, pegawai WHERE pegawai.kd_bagian=bagian.kd_bagian AND pegawai.kd_pegawai='$dataPegawai'";
$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query 1 salah : ".mysqli_errno());
$myData= mysqli_fetch_array($myQry);

$dataGajiPokok		= isset($_POST['txtGajiPokok']) ? $_POST['txtGajiPokok'] : '0';
$dataGajiPokok		= isset($myData['gaji_pokok']) ? $myData['gaji_pokok'] : $dataGajiPokok;

$dataTunjTransport	= isset($_POST['txtTunjTransport']) ? $_POST['txtTunjTransport'] : '0';
$dataTunjTransport	= isset($myData['uang_transport']) ? $myData['uang_transport'] : $dataTunjTransport;

$dataTunjMakan		= isset($_POST['txtTunjMakan']) ? $_POST['txtTunjMakan'] : '0';
$dataTunjMakan		= isset($myData['uang_makan']) ? $myData['uang_makan'] : $dataTunjMakan;

// Menghitung Total Lembur
$my2Sql = "SELECT COUNT(*) tot_lembur FROM lembur 
			WHERE kd_pegawai='$dataPegawai' 
				  AND LEFT(tanggal,4)='$dataTahun' AND MID(tanggal,6,2)='$dataBulan'";
$my2Qry = mysqli_query($koneksidb, $my2Sql)  or die ("Query 2 salah : ".mysqli_errno());
$my2Data= mysqli_fetch_array($my2Qry);  
$totalLembur = $my2Data['tot_lembur'] * $myData['uang_lembur'];

$dataTotalLembur	= isset($_POST['txtTotalLembur']) ? $_POST['txtTotalLembur'] : '0';
$dataTotalLembur	= isset($my2Data['tot_lembur']) ? $totalLembur : $dataTotalLembur;

// total Bonus
$dataTotalBonus		= isset($_POST['txtTotalBonus']) ? $_POST['txtTotalBonus'] : '0';

// Menghitung Total Pinjaman
$my3Sql = "SELECT SUM(besar_pinjaman) tot_pinjaman FROM pinjaman 
			WHERE kd_pegawai='$dataPegawai' AND status_lunas='No' 
			      AND LEFT(tanggal,4)='$dataTahun' AND MID(tanggal,6,2)='$dataBulan'";
$my3Qry = mysqli_query($koneksidb, $my3Sql)  or die ("Query 3 salah : ".mysqli_errno());
$my3Data= mysqli_fetch_array($my3Qry);  

$dataTotalPinjaman	= isset($_POST['txtTotalPinjaman']) ? $_POST['txtTotalPinjaman'] : '0';
$dataTotalPinjaman	= isset($my3Data['tot_pinjaman']) ? $my3Data['tot_pinjaman'] : $dataTotalPinjaman;


// Menghitung Total Tunjangan Jabtan
$my4Sql = "SELECT SUM(tunj_jabatan) tot_tunjabatan FROM jabatan, riwayat_jabatan
			WHERE jabatan.kd_jabatan = riwayat_jabatan.kd_jabatan
			AND riwayat_jabatan.kd_pegawai='$dataPegawai' AND riwayat_jabatan.status_aktif='Aktif'";
$my4Qry = mysqli_query($koneksidb, $my4Sql)  or die ("Query 4 salah : ".mysqli_errno());
$my4Data= mysqli_fetch_array($my4Qry);  

$dataTunjJabatan	= isset($_POST['txtTunjJabatan']) ? $_POST['txtTunjJabatan'] : '0';
$dataTunjJabatan	= isset($my4Data['tot_tunjabatan']) ? $my4Data['tot_tunjabatan'] : $dataTunjJabatan;
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><b>TRANSAKSI PENGGAJIAN BARU</b></th>
    </tr>
    <tr>
      <td><strong>No. Penggajian </strong></td>
      <td><strong>:</strong></td>
      <td><input name="textfield" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Periode Bulan </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbBulan">
          <?php
	$namaBulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret",
					 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
					 "08" => "Agustus", "09" => "September", "10" => "Oktober",
					 "11" => "November", "12" => "Desember");

	  foreach($namaBulan as $bulanKe => $bulanNM) {
	  	if ($bulanKe == $dataBulan) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$bulanKe' $cek>$bulanKe - $bulanNM</option>";
	  }
	  ?>
        </select>
          <select name="cmbTahun">
            <?php
		$tahunKemaren = date('Y') - 1;
	  for($thn= $tahunKemaren; $thn <= date('Y'); $thn++) {
	  	if ($thn == $dataTahun) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$thn' $cek>$thn</option>";
	  }
	  ?>
        </select></td>
    </tr>
    <tr>
      <td><strong>Pegawai </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbPegawai"  onchange="javascript:submitform();">
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
	  $sqlData ="";
	  ?>
      </select>
      <input type="submit" name="Submit" value=" Hitung " /></td>
    </tr>
    <tr>
      <td><strong>Gaji Pokok  (Rp)</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtGajiPokok" type="text" value="<?php echo $dataGajiPokok; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><strong>Tunjangan Jabatan (Rp)</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTunjJabatan" type="text" value="<?php echo $dataTunjJabatan; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><strong>Tunjangan Transport (Rp)</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTunjTransport" type="text" value="<?php echo $dataTunjTransport; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><strong>Tunjangan Makan  (Rp)</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTunjMakan" type="text" value="<?php echo $dataTunjMakan; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><strong>Total Lembur  (Rp)</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTotalLembur" type="text"  value="<?php echo $dataTotalLembur; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><strong>Total Bonus  (Rp)</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTotalBonus" type="text"  value="<?php echo $dataTotalBonus; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td><strong>Total Pinjaman  (Rp)</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTotalPinjaman" type="text"  value="<?php echo $dataTotalPinjaman; ?>" size="30" maxlength="12" /></td>
    </tr>
    <tr>
      <td width="230">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="968">
      <input type="submit" name="btnSimpan" value=" Simpan " />      </td>
    </tr>
  </table>
</form>
