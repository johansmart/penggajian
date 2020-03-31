<?php
include_once "library/inc.sesadmin.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pinjaman";
$pageQry = mysqli_query($koneksidb, $pageSql) or die ("error paging: ".mysqli_errno());
$jml	 = mysqli_num_rows($pageQry);
$maksData= ceil($jml/$baris);
?>
<ul class="breadcrumb">
				<li>
					DATA PINJAMAN
				</li>
				
</ul>
<a href="?page=Pinjaman-Add" target="_self"><img src="images/btn_add_data.png" width="134" height="36" border="0" /></a><p></p>

<table class="table" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="25"><strong>No</strong></th>
        <th width="87"><strong>Tanggal</strong></th>
        <th width="83"><strong>NIP </strong></th>
        <th width="152"><strong>Nama Pegawai </strong></th>
        <th width="177" align="right"><strong>Pinjaman (Rp) </strong></th>
        <th width="79"><strong>Status </strong></th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
        </tr>
      <?php
	$mySql 	= "SELECT pinjaman.*, pegawai.nip, pegawai.nm_pegawai FROM pinjaman
				LEFT JOIN pegawai ON pinjaman.kd_pegawai=pegawai.kd_pegawai
				ORDER BY pinjaman.no_pinjaman DESC LIMIT $hal, $baris";
	$myQry 	= mysqli_query($koneksidb, $mySql)  or die ("Query  salah : ".mysqli_errno());
	$nomor  = 0; 
	while ($kolomData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['no_pinjaman'];
		
		// Warna baris data
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo $kolomData['tanggal']; ?></td>
        <td><?php echo $kolomData['nip']; ?></td>
        <td><?php echo $kolomData['nm_pegawai']; ?></td>
        <td align="right"><?php echo format_angka($kolomData['besar_pinjaman']); ?></td>
        <td><?php echo $kolomData['status_lunas']; ?></td>
        <td width="41" align="center"><a href="?page=Pinjaman-Edit&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
		<td width="53" align="center"><a href="?page=Pinjaman-Delete&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENTING INI ... ?')">Delete</a></td>
      </tr>
      <?php } ?>
    </table> 
	<strong>Jumlah Data :</strong> <?php echo $jml; ?> 
	<b>Halaman ke :</b> 
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?page=Pinjaman-Data&hal=$list[$h]'>$h</a> ";
	}
	?>

