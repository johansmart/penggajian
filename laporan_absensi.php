<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";

# Tahun Terpilih
$dataTahun = isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : date('Y');
$dataBulan = isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : date('m');
?>
<ul class="breadcrumb">
				<li>
					LAPORAN ABSENSI
				</li>
				
</ul>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table class="table" width="500" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="111"><strong>Periode Bulan </strong></td>
      <td width="10"><strong>:</strong></td>
      <td width="365"><select name="cmbBulan">
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
		$tahunAwal = 2013;
	  for($thn= $tahunAwal; $thn <= date('Y'); $thn++) {
	  	if ($thn == $dataTahun) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$thn' $cek>$thn</option>";
	  }
	  ?>
          </select>
          <input name="btnTampil" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>

<table class="table" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="27" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="73" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="95" bgcolor="#CCCCCC"><strong>NIP </strong></td>
    <td width="190" bgcolor="#CCCCCC"><strong>Nama Pgawai </strong></td>
    <td width="85" bgcolor="#CCCCCC"><strong>Jam Masuk </strong></td>
    <td width="79" bgcolor="#CCCCCC"><strong>Jam Keluar </strong></td>
    <td width="63" bgcolor="#CCCCCC"><strong>Status</strong></td>
    <td width="147" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
  </tr>
	<?php
	$mySql = "SELECT absensi.*, pegawai.nip, pegawai.nm_pegawai FROM absensi
				LEFT JOIN pegawai ON absensi.kd_pegawai=pegawai.kd_pegawai 
				WHERE LEFT(tanggal,4)='$dataTahun' AND MID(tanggal,6,2)='$dataBulan'
				ORDER BY absensi.tanggal, pegawai.nip ASC";
	$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query salah : ".mysqli_errno());
	$nomor	 = 0; 
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;
				
		// Status Kerja
		$statusKerja = $myData['status_kehadiran'];
		if($statusKerja==0) { $status = "Tidak Masuk"; }
		elseif($statusKerja==1) { $status = "Masuk"; }
		elseif($statusKerja==2) { $status = "Izin"; }
		elseif($statusKerja==3) { $status = "Cuti"; }
		else { $status = ""; }
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tanggal']); ?></td>
    <td><?php echo $myData['nip']; ?></td>
    <td><?php echo $myData['nm_pegawai']; ?></td>
    <td><?php echo substr($myData['jam_masuk'],0,5); ?></td>
    <td><?php echo substr($myData['jam_keluar'],0,5); ?></td>
    <td><?php echo $status; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
  </tr>
  <?php } ?>
</table>
<br />
<a href="cetak/absensi.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
