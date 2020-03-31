<?php
include_once "library/inc.sesadmin.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM lembur";
$pageQry = mysqli_query($koneksidb, $pageSql) or die ("error paging: ".mysqli_errno());
$jml	 = mysqli_num_rows($pageQry);
$maksData= ceil($jml/$baris);
?>
<ul class="breadcrumb">
				<li>
					DATA LEMBUR
				</li>
				
</ul>
<a href="?page=Lembur-Add" target="_self"><img src="images/btn_add_data.png" width="134" height="36" border="0" /></a><p></p>
<table class="table" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="27"><b>No</b></th>
        <th width="88"><b>Tanggal</b></th>
        <th width="85">NIP </th>
        <th width="241">Pegawai </th>
        <th width="164">Keterangan</th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b><b></b></td>
        </tr>
      <?php
	$mySql 	= "SELECT lembur.*, pegawai.nip, pegawai.nm_pegawai FROM lembur
				LEFT JOIN pegawai ON lembur.kd_pegawai=pegawai.kd_pegawai 
				ORDER BY lembur.id DESC  LIMIT $hal, $baris";
	$myQry 	= mysqli_query($koneksidb, $mySql)  or die ("Query  salah : ".mysqli_errno());
	$nomor  = 0; 
	while ($kolomData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['id'];
		
		// Warna baris data
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo IndonesiaTgl($kolomData['tanggal']); ?></td>
        <td><?php echo $kolomData['nip']; ?></td>
        <td><?php echo $kolomData['nm_pegawai']; ?></td>
        <td><?php echo $kolomData['keterangan']; ?></td>
        <td width="48" align="center"><a href="?page=Lembur-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
		<td width="53" align="center"><a href="?page=Lembur-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA LEMBUR INI ... ?')">Delete</a></td>
      </tr>
      <?php } ?>
    </table> <strong>Jumlah Data : <?php echo $jml; ?> </strong>
	<strong>Halaman ke :
      <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?page=Lembur-Data&hal=$list[$h]'>$h</a> ";
	}
	?>
    </strong>