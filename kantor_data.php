<?php
include_once "library/inc.sesadmin.php";

# UNTUK PAGING (PEMkantor HALAMAN)
$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM kantor";
$pageQry = mysqli_query($koneksidb, $pageSql) or die ("error paging: ".mysqli_errno());
$jml	 = mysqli_num_rows($pageQry);
$maksData= ceil($jml/$baris);
?>
<ul class="breadcrumb">
				<li>
					 DATA KANTOR
				</li>
</ul>				
<a href="?page=Kantor-Add" target="_self"><img src="images/btn_add_data.png" width="134" height="36" border="0" /></a><p></p>
    <table class="table" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="30"><b>No</b></th>
        <th width="90"><b>Kode  </b></th>
        <th width="395"><b>Nama Kantor</b> </th>
        <th width="150"><strong>Lokasi</strong></th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b><b></b></td>
        </tr>
      <?php
	$mySql 	= "SELECT * FROM kantor ORDER BY kd_kantor ASC LIMIT $hal, $baris";
	$myQry 	= mysqli_query($koneksidb, $mySql)  or die ("Query  salah : ".mysqli_errno());
	$nomor  = 0; 
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_kantor'];
		
		// Warna baris data
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_kantor']; ?></td>
        <td><?php echo $myData['nm_kantor']; ?></td>
        <td><?php echo $myData['lokasi']; ?></td>
        <td width="50" align="center"><a href="?page=Kantor-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
		<td width="50" align="center"><a href="?page=Kantor-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA kantor INI ... ?')">Delete</a></td>
      </tr>
      <?php } ?>
    </table>   
	<b>Jumlah Data :</b> <?php echo $jml; ?> 
	<strong>Halaman ke :</strong> 
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?page=Kantor-Data&hal=$list[$h]'>$h</a> ";
	}
	?>