<?php
include_once "library/inc.sesadmin.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM absensi";
$pageQry = mysqli_query($koneksidb, $pageSql) or die ("error paging: ".mysqli_errno());
$jml	 = mysqli_num_rows($pageQry);
$maksData= ceil($jml/$baris);
?>

    <ul class="breadcrumb">
				<li>
					 DATA ABSENSI
				</li>
				
</ul>
	<a href="absensi/absensi_masuk.php" target="_blank"><img src="images/btn_in.png" width="134" height="36" border="0" /></a>
	<a href="absensi/absensi_keluar.php" target="_blank"><img src="images/btn_out.png" width="134" height="36" border="0" /></a>
	<a href="?page=Absensi-Add" target="_self"><img src="images/btn_add_data.png" width="134" height="36" border="0" /></a></td>
  <p></p>
    <table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="26"><b>No</b></th>
        <th width="75"><b>Tanggal</b></th>
        <th width="100"><b>NIP</b></th>
        <th width="204"><b>Nama Pegawai </b></th>
        <th width="101"><b>Status</b></th>
        <th width="153"><b>Keterangan</b></th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b></td>
        </tr>
      <?php
	$mySql 	= "SELECT absensi.*, pegawai.nip, pegawai.nm_pegawai FROM absensi
				LEFT JOIN pegawai ON absensi.kd_pegawai=pegawai.kd_pegawai 
				ORDER BY absensi.tanggal DESC LIMIT $hal, $baris";
	$myQry 	= mysqli_query($koneksidb, $mySql)  or die ("Query  salah : ".mysqli_errno());
	$nomor  = 0;  $status = ""; 
	while ($kolomData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['id'];
		
		// Status Kerja
		$statusKerja = $kolomData['status_kehadiran'];
		if($statusKerja==0) { $status = "Tidak Masuk"; }
		elseif($statusKerja==1) { $status = "Masuk"; }
		elseif($statusKerja==2) { $status = "Izin"; }
		elseif($statusKerja==3) { $status = "Cuti"; }
		else { $status = ""; }
		
		// Warna baris data
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo IndonesiaTgl($kolomData['tanggal']); ?></td>
        <td><?php echo $kolomData['nip']; ?></td>
        <td><?php echo $kolomData['nm_pegawai']; ?></td>
        <td><?php echo $status; ?></td>
        <td><?php echo $kolomData['keterangan']; ?></td>
        <td width="44" align="center"><a href="?page=Absensi-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
		<td width="52" align="center"><a href="?page=Absensi-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA ABSENSI INI ... ?')">Delete</a></td>
      </tr>
      <?php } ?>
    </table>    </td>
  </tr>
 <b>Jumlah Data :</b> <?php echo $jml; ?><b> Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?page=Absensi-Data&hal=$list[$h]'>$h</a> ";
	}
	?>

