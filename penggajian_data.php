<?php
include_once "library/inc.sesadmin.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM penggajian";
$pageQry = mysqli_query($koneksidb, $pageSql) or die ("error paging: ".mysqli_errno());
$jml	 = mysqli_num_rows($pageQry);
$maksData= ceil($jml/$baris);
?>
<ul class="breadcrumb">
				<li>
					DATA PENGGAJIAN
				</li>
				
</ul>
<a href="?page=Penggajian-Add" target="_self"><img src="images/btn_add_data.png" width="134" height="36" border="0" /></a><p></p>
  <table class="table" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="24"><b>No</b></th>
        <th width="74"><strong>Periode</strong></th>
        <th width="82"><strong>Tanggal</strong></th>
        <th width="92">NIP</th>
        <th width="200">Nama Pegawai </th>
        <th width="125"><b>Gaji Bersih (Rp) </b></th>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><b>Tools</b><b></b></td>
        </tr>
      <?php
	$mySql 	= "SELECT penggajian.*, pegawai.nip, pegawai.nm_pegawai FROM penggajian
				LEFT JOIN pegawai ON penggajian.kd_pegawai=pegawai.kd_pegawai 
				ORDER BY penggajian.no_penggajian ASC LIMIT $hal, $baris";
	$myQry 	= mysqli_query($koneksidb, $mySql)  or die ("Query  salah : ".mysqli_errno());
	$nomor  = 0; 
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['no_penggajian'];
		
		// Hitung Total Gaji Bersih
		$totalGaji = $myData['gaji_pokok'] + $myData['tunj_transport'] + $myData['tunj_makan'] + $myData['total_lembur'] + $myData['total_bonus']; 
		$gajiBersih= $totalGaji - $myData['total_pinjaman'];
		
		// Warna baris data
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['periode_gaji']; ?></td>
        <td><?php echo IndonesiaTgl($myData['tanggal']); ?></td>
        <td><?php echo $myData['nip']; ?></td>
        <td><?php echo $myData['nm_pegawai']; ?></td>
        <td align="right"><?php echo format_angka($gajiBersih); ?></td>
        <td width="40" align="center"><a href="penggajian_nota.php?noNota=<?php echo $Kode; ?>" target="_blank">Nota</a></td>
        <td width="38" align="center"><a href="?page=Penggajian-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
		<td width="52" align="center"><a href="?page=Penggajian-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENGGAJIAN INI ... ?')">Delete</a></td>
      </tr>
      <?php } ?>
    </table>   <b>Jumlah Data :</b> <?php echo $jml; ?> 
	<b>Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?page=Penggajian-Data&hal=$list[$h]'>$h</a> ";
	}
	?>