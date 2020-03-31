<?php
include_once "library/inc.sesadmin.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pegawai";
$pageQry = mysqli_query($koneksidb, $pageSql) or die ("error paging: ".mysqli_errno());
$jml	 = mysqli_num_rows($pageQry);
$maksData= ceil($jml/$baris);
?>
<ul class="breadcrumb">
				<li>
				 DATA PEGAWAI
				</li>
				
</ul>
<a href="?page=Pegawai-Add" target="_self"><img src="images/btn_add_data.png" width="134" height="36" border="0" /></a><p></p>
<table class="table" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="31"><strong>No</strong></th>
        <th width="119"><strong>Nip</strong></th>
        <th width="318"><strong>Nama Pegawai </strong></th>
        <th width="209"><strong>Bagian </strong></th>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
        </tr>
	<?php
	$mySql 	= "SELECT pegawai.*, bagian.nm_bagian FROM pegawai
			LEFT JOIN bagian ON pegawai.kd_bagian=bagian.kd_bagian 
			ORDER BY pegawai.kd_pegawai ASC  LIMIT $hal, $baris";
	$myQry 	= mysqli_query($koneksidb, $mySql)  or die ("Query  salah : ".mysqli_errno());
	$nomor  = 0; 
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_pegawai'];
		
		// Warna baris data
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td> <?php echo $nomor; ?> </td>
        <td> <?php echo $myData['nip']; ?> </td>
        <td> <?php echo $myData['nm_pegawai']; ?> </td>
        <td> <?php echo $myData['nm_bagian']; ?> </td>
        <td width="44" align="center"><a href="cetak/pegawai_cetak.php?Kode=<?php echo $myData['kd_pegawai']; ?>" target="_blank">Print</a></td>
        <td width="44" align="center"><a href="?page=Pegawai-Edit&Kode=<?php echo $Kode; ?>" target="_self">Edit</a></td>
        <td width="44" align="center"><a href="?page=Pegawai-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PEGAWAI INI ... ?')">Delete</a></td>
      </tr>
      <?php } ?>
    </table>    </td>
  </tr>
  <strong>Jumlah Data :</strong> <?php echo $jml; ?> 
  <strong>Halaman ke :</strong>
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?page=Pegawai-Data&hal=$list[$h]'>$h</a> ";
	}
	?>