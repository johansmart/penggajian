<?php
include_once "library/inc.sesadmin.php";

# Set nilai pada filter
$filterSQL = "";

# MEMBACA DATA KODE Pegawai
$Kode			= isset($_GET['Kode']) ? $_GET['Kode'] : "KOSONG";
$kodePegawai 	= isset($_POST['cmbPegawai']) ? $_POST['cmbPegawai'] : $Kode;

// Membuat Sub SQL dengan Filter
if(trim($kodePegawai)=="KOSONG") {
	$filterSQL = ""; 
	
	$filterKode	= "";
}
else {
	$filterSQL = " WHERE riwayat_jabatan.kd_pegawai='$kodePegawai'";
	
	// URL Menu
	$filterKode	= "&KodeKy=$kodePegawai";
}

# UNTUK PAGING (PEMjabatan HALAMAN)
$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM riwayat_jabatan $filterSQL";
$pageQry = mysqli_query($koneksidb, $pageSql) or die ("error paging: ".mysqli_errno());
$jml	 = mysqli_num_rows($pageQry);
$maksData= ceil($jml/$baris);
?>
<ul class="breadcrumb">
				<li>
					DATA RIWAYAT JABATAN
				</li>
				
</ul>

	
	<form name="form1" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
      <table class="table" width="400" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
          </tr>
        <tr>
          <td width="74"><strong> Pegawai </strong></td>
          <td width="5"><strong>:</strong></td>
          <td width="299">
		  <select name="cmbPegawai"  onchange="javascript:submitform();">
          <option value="KOSONG">....</option>
          <?php
		  $dataSql = "SELECT * FROM pegawai ORDER BY nip";
		  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errno());
		  while ($dataRow = mysqli_fetch_array($dataQry)) {
			if ($kodePegawai == $dataRow['kd_pegawai']) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$dataRow[kd_pegawai]' $cek> [ $dataRow[nip] ] $dataRow[nm_pegawai]</option>";
		  }
		  ?>
          </select></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><strong>
            <input name="btnTampil" type="submit" value="Tampilkan" />
          </strong></td>
        </tr>
      </table>
        </form>
  <br>
  <a href="?page=Riwayat-Jabatan-Add<?php echo $filterKode; ?>" target="_self"><img src="images/btn_add_data.png" width="134" height="36" border="0" /></a></br>
	<p></p><table class="table" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="28"><strong>No</strong></th>
        <th width="272"><strong>Jabatan</strong></th>
        <th width="127">Nomor SK </th>
        <th width="127"><strong>Tgl. Menjabat </strong></th>
        <th width="121"><strong>Tgl. Berakhir </strong></th>
        <th width="112"><strong>Status Aktif </strong></th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
      </tr>
      <?php
	$mySql 	= "SELECT riwayat_jabatan.*, jabatan.nm_jabatan FROM riwayat_jabatan
				LEFT JOIN jabatan ON riwayat_jabatan.kd_jabatan = jabatan.kd_jabatan
				$filterSQL";
	$myQry 	= mysqli_query($koneksidb, $mySql)  or die ("Query  salah : ".mysqli_errno());
	$nomor  = 0; 
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$ID = $myData['id'];
		
		// Warna baris data
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?> </td>
        <td><?php echo $myData['nm_jabatan']; ?> </td>
        <td><?php echo $myData['nomor_sk']; ?></td>
        <td><?php echo IndonesiaTgl($myData['tgl_menjabat']); ?></td>
        <td><?php echo IndonesiaTgl($myData['tgl_berakhir']); ?></td>
        <td><?php echo $myData['status_aktif']; ?> </td>
        <td width="50" align="center"><a href="?page=Riwayat-Jabatan-Edit&ID=<?php echo $ID; ?>" target="_self">Edit</a></td>
        <td width="50" align="center"><a href="?page=Riwayat-Jabatan-Delete&ID=<?php echo $ID; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA riwayat JABATAN INI ... ?')">Delete</a></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr class="selKecil">
    <td width="418" height="22" bgcolor="#CCCCCC"><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td width="374" align="right" bgcolor="#CCCCCC"><strong>Halaman ke :</strong> 
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?page=Riwayat-Jabatan-Data&hal=$list[$h]'>$h</a> ";
	}
	?>	</td>
  </tr>
</table>

