<?php
include_once "library/inc.sesadmin.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM bagian";
$pageQry = mysqli_query($koneksidb, $pageSql) or die ("error paging: ".mysqli_errno());
$jml	 = mysqli_num_rows($pageQry);
$maksData= ceil($jml/$baris);
?>
<ul class="breadcrumb">
				<li>
					 DATA BAGIAN
				</li>
				
</ul>
<a href="?page=Bagian-Add" target="_self"><img src="images/btn_add_data.png" width="134" height="36" border="0" /></a><p></p>
<table class="table" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="26"><b>No</b></th>
        <th width="69"><b>Kode  </b></th>
        <th width="211">Nama Bagian </th>
        <th width="127"><b>Gaji Pokok </b></th>
        <th width="128">Uang Lembur </th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b><b></b></td>
        </tr>
      <?php
	$mySql 	= "SELECT * FROM bagian ORDER BY kd_bagian ASC LIMIT $hal, $baris";
	$myQry 	= mysqli_query($koneksidb, $mySql)  or die ("Query  salah : ".mysqli_errno());
	$nomor  = 0; 
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_bagian'];
		
		// Warna baris data
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_bagian']; ?></td>
        <td><?php echo $myData['nm_bagian']; ?></td>
        <td><?php echo format_angka($myData['gaji_pokok']); ?></td>
        <td><?php echo format_angka($myData['uang_lembur']); ?></td>
        <td width="44" align="center"><a href="?page=Bagian-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
		<td width="55" align="center"><a href="?page=Bagian-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA BAGIAN INI ... ?')">Delete</a></td>
      </tr>
      <?php } ?>
    </table>   
	<b>Jumlah Data :</b> <?php echo $jml; ?> 
	<strong>Halaman ke :</strong> 
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?page=Bagian-Data&hal=$list[$h]'>$h</a> ";
	}
	?>

