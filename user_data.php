<?php
include_once "library/inc.sesadmin.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM user";
$pageQry = mysqli_query($koneksidb, $pageSql) or die ("error paging: ".mysqli_errno());
$jml	 = mysqli_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<ul class="breadcrumb">
				<li>
					 DATA USER
				</li>
				
</ul>
<a href="?page=User-Add" target="_self"><img src="images/btn_add_data.png" height="30" border="0" /></a><p></p>
	<table class="table table-bordered table-striped table-condensed" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="26"><b>No</b></th>
        <th width="102">Kode</th>
        <th width="219"><b>Nama User</b></th>
        <th width="114"><b>No. Telepon </b></th>
        <th width="133"><b>Username</b></th>
        <th width="84"><b>Level</b></th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b><b></b></td>
        </tr>
      <?php
	$mySql 	= "SELECT * FROM user ORDER BY kd_user ASC LIMIT $hal, $row";
	$myQry 	= mysqli_query($koneksidb, $mySql)  or die ("Query  salah : ".mysqli_errno());
	$nomor  = 0; 
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_user'];
		
		// Warna baris data
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_user']; ?></td>
        <td><?php echo $myData['nm_user']; ?></td>
        <td><?php echo $myData['no_telepon']; ?></td>
        <td><?php echo $myData['username']; ?></td>
        <td><?php echo $myData['level']; ?></td>
        <td width="34" align="center"><a href="?page=User-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
        <td width="43" align="center"><a href="?page=User-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA USER INI ... ?')">Delete</a></td>
      </tr>
      <?php } ?>
    </table>
   
<b>Jumlah Data :</b> <?php echo $jml; ?><b> Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=User-Data&hal=$list[$h]'>$h</a> ";
	}
	?>