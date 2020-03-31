<?php
session_start();
include_once "../library/inc.sesadmin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if(isset($_GET['Kode'])){
	$Kode	= isset($_GET['Kode']) ? $_GET['Kode'] : 'P0001'; 
	
	// Untuk informasi 
	$mySql	= "SELECT pegawai.*, bagian.nm_bagian FROM pegawai 
				LEFT JOIN bagian ON pegawai.kd_bagian = bagian.kd_bagian 
				WHERE pegawai.kd_pegawai='$Kode'";
	$myQry	= mysqli_query($koneksidb, $mySql) or die ("Gagal Query".mysqli_errno());
	$myData = mysqli_fetch_array($myQry);
	$Kode	= $myData['kd_pegawai'];
	
	// Periksa data foto
	if($myData['foto']=="") {
		$foto = "noimage.jpg";
	}
	else {
		$foto = $myData['foto'];
	}
}

?>
<html>
<head>
<title>:: Cetak Data Pegawai</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> CETAK DATA PEGAWAI </h2>
<table width="700" border="0">
  
  <tr>
    <td width="179"><strong>Kode</strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="350"><?php echo $myData['kd_pegawai']; ?></td>
    <td width="138" rowspan="9" align="center" valign="top"><img src="../img-foto/<?php echo $foto; ?>" width="130"/></td>
  </tr>
  <tr>
    <td><strong>NIP</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['nip']; ?></td>
  </tr>
  <tr>
    <td><strong>Nama Pegawai </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['nm_pegawai']; ?></td>
  </tr>
  <tr>
    <td><strong>Jenis Kelamin </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['kelamin']; ?></td>
  </tr>
  <tr>
    <td><strong>Gol. Darah </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['gol_darah']; ?></td>
  </tr>
  <tr>
    <td><strong>Agama</strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['agama']; ?></td>
  </tr>
  <tr>
    <td><strong>Alamat Tinggal </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['alamat_tinggal']; ?></td>
  </tr>
  <tr>
    <td><strong>No. Telepon </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['no_telepon']; ?></td>
  </tr>
  <tr>
    <td><strong>Tempat, Tanggal Lahir </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['tempat_lahir'].", ".IndonesiaTgl($myData['tanggal_lahir']); ?></td>
  </tr>
  <tr>
    <td><strong>Status Kawin </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['status_kawin']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Jumlah Anak </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['jumlah_anak']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Pendidikan Terakhir </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['pendidikan_terakhir']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Tahun Lulus </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['tahun_lulus']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Bagian </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['nm_bagian']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Tanggal Masuk </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo IndonesiaTgl($myData['tanggal_masuk']); ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<br>

<strong>RIWAYAT JABATAN</strong>
<table class="table-list" width="700" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="28" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="272" bgcolor="#CCCCCC"><strong>Jabatan</strong></td>
    <td width="127" bgcolor="#CCCCCC"><strong>Nomor SK </strong></td>
    <td width="127" bgcolor="#CCCCCC"><strong>Tgl. Menjabat </strong></td>
    <td width="121" bgcolor="#CCCCCC"><strong>Tgl. Berakhir </strong></td>
    <td width="112" bgcolor="#CCCCCC"><strong>Status Aktif </strong></td>
  </tr>
  <?php
	$my2Sql = "SELECT riwayat_jabatan.*, jabatan.nm_jabatan FROM riwayat_jabatan
				LEFT JOIN jabatan ON riwayat_jabatan.kd_jabatan = jabatan.kd_jabatan
				WHERE kd_pegawai='$Kode' 
				ORDER BY id";
	$my2Qry = mysqli_query($koneksidb, $my2Sql)  or die ("Query  salah : ".mysqli_errno());
	$nomor  = 0; 
	while ($my2Data = mysqli_fetch_array($my2Qry)) {
		$nomor++;
	?>
  <tr>
    <td><?php echo $nomor; ?> </td>
    <td><?php echo $my2Data['nm_jabatan']; ?> </td>
    <td><?php echo $my2Data['nomor_sk']; ?></td>
    <td><?php echo IndonesiaTgl($my2Data['tgl_menjabat']); ?></td>
    <td><?php echo IndonesiaTgl($my2Data['tgl_berakhir']); ?></td>
    <td><?php echo $my2Data['status_aktif']; ?> </td>
  </tr>
  <?php } ?>
</table>


<br>
<strong>RIWAYAT MUTASI</strong>
<table class="table-list" width="700" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="29" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="323" bgcolor="#CCCCCC"><b>Kantor</b></td>
    <td width="123" bgcolor="#CCCCCC"><strong>Tgl. Mutasi </strong></td>
    <td width="204" bgcolor="#CCCCCC"><strong>Kantor Lama </strong></td>
  </tr>
  <?php
	$my3Sql = "SELECT riwayat_mutasi.*, kantor.nm_kantor, kantor.lokasi FROM riwayat_mutasi
				LEFT JOIN kantor ON riwayat_mutasi.kd_kantor = kantor.kd_kantor
				WHERE kd_pegawai='$Kode'";
	$my3Qry = mysqli_query($koneksidb, $my3Sql)  or die ("Query  salah : ".mysqli_errno());
	$nomor  = 0; 
	while ($my3Data = mysqli_fetch_array($my3Qry)) {
		$nomor++;
	?>
  <tr>
    <td><?php echo $nomor; ?> </td>
    <td><?php echo $my3Data['nm_kantor']." (".$my3Data['lokasi']." )"; ?> </td>
    <td><?php echo IndonesiaTgl($my3Data['tgl_mutasi']); ?></td>
    <td><?php echo $my3Data['kantor_lama']; ?></td>
  </tr>
  <?php } ?>
</table>
<br />
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>