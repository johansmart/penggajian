<?php
if(isset($_SESSION['SES_ADMIN'])){
?>
	<ul class="nav nav-tabs nav-stacked main-menu">
	<li><a href='?page' title='Halaman Utama'>Home</a></li>
	<li><a href="#" class="dropmenu"><i class=""></i><span class=""> Master Data</span><b class=""></b></a>
	<ul class="submenu" >
	<li><a href='?page=User-Data' title='User Data' target="_self">Data User</a></li>
	<li><a href='?page=Kantor-Data' title='Kantor Data' target="_self">Data Kantor </a></li>
	<li><a href='?page=Bagian-Data' title='Bagian Data' target="_self">Data Bagian </a></li>
	<li><a href='?page=Jabatan-Data' title='Jabatan Data' target="_self">Data Jabatan </a></li>
	<li><a href='?page=Pegawai-Data' title='Karyawan Data' target="_self">Data Pegawai </a></li>
	</ul>
	</li>
	<li><a href="#" class="dropmenu"><i class=""></i><span class="">Transaksi</span><b class=""></b></a>
	<ul class="submenu" >
	<li><a href='?page=Riwayat-Jabatan-Data' title='Riwayat Jabatan' target="_self">Data Riwayat Jabatan </a></li>
	<li><a href='?page=Riwayat-Mutasi-Data' title='Riwayat Mutasi' target="_self">Data Riwayat Mutasi </a></li>
	<li><a href='?page=Lembur-Data' title='Lembur Data' target="_self">Data Lembur </a></li>
	<li><a href='?page=Pinjaman-Data' title='Pinjaman Data' target="_self">Data Pinjaman </a></li>
	<li><a href='?page=Penggajian-Data' title='Penggajian Data' target="_self">Data Penggajian</a></li>
	<li><a href='?page=Absensi-Data' title='Absensi Data' target="_self">Data Absensi </a></li>
	</ul>
	</li>
	<li><a href="#" class="dropmenu"><i class=""></i><span class="">Laporan</span><b class=""></b></a>
	<ul class="submenu" >
	<li><a href='?page=Laporan-User' title='Laporan User' target="_self">Laporan Data User</a>
    <li><a href='?page=Laporan-Kantor' title='Laporan Kantor' target="_self">Laporan Data Kantor </a>    
    <li><a href='?page=Laporan-Bagian' title='Laporan Bagian' target="_self">Laporan Data Bagian </a>    
    <li><a href='?page=Laporan-Jabatan' title='Laporan Jabatan' target="_self">Laporan Data Jabatan</a>    
    <li><a href='?page=Laporan-Pegawai' title='Laporan Pegawai' target="_self">Laporan Data Pegawai </a>    
    <li><a href='?page=Laporan-Pinjaman' title='Laporan Pinjaman' target="_self">Laporan Data Pinjaman </a></li>
    <li><a href='?page=Laporan-Lembur' title='Laporan Lembur' target="_self">Laporan Data Lembur </a></li>
    <li><a href='?page=Laporan-Penggajian' title='Laporan Penggajian' target="_self">Laporan Data Penggajian</a></li>
    <li><a href='?page=Laporan-Absensi' title='Laporan Absensi' target="_self">Laporan Data Absensi </a></li>
	<li><a href='?page=Logout' title='Logout (Exit)' target="_self">Logout</a></li>
	</ul>
	</li>
	</ul>
<?php
}
else if(isset($_SESSION['SES_DIREKTUR'])){ 
?>
	<ul class="nav nav-tabs nav-stacked main-menu">
	<li><a href='?page' title='Halaman Utama'>Home</a></li>
	<li><a href='?page=User-Data' title='User Data' target="_self">Data User</a></li>
	<li><a href='?page=Bagian-Data' title='Bagian Data' target="_self">Data Bagian </a></li>
	<li><a href='?page=Jabatan-Data' title='Jabatan Data' target="_self">Data Jabatan </a></li>
	<li><a href='?page=Pegawai-Data' title='Pegawai Data' target="_self">Data Pegawai </a></li>
	<li><a href='?page=Lembur-Data' title='Lembur Data' target="_self">Data Lembur </a></li>
	<li><a href='?page=Pinjaman-Data' title='Pinjaman Data' target="_self">Data Pinjaman </a></li>
	<li><a href='?page=Penggajian-Data' title='Penggajian Data' target="_self">Data Penggajian</a></li>
	<li><a href='?page=Absensi-Data' title='Absensi Data' target="_self">Data Absensi </a></li>
	<li><a href='?page=Laporan' title='Laporan'>Laporan</a></li>
	<li><a href='?page=Logout' title='Logout (Exit)' target="_self">Logout</a></li>
	</ul>
<?php 
}
else if(isset($_SESSION['SES_KASIR'])){ ?>
	<ul class="nav nav-tabs nav-stacked main-menu">
	<li><a href='?page' title='Halaman Utama'>Home</a></li>
	<li><a href='?page=Penggajian-Data' title='Penggajian Data' target="_self">Data Penggajian</a></li>
	<li><a href='?page=Laporan' title='Laporan'>Laporan</a></li>
	<li><a href='?page=Logout' title='Logout (Exit)'>Logout</a></li>
	</ul>
<?php 
}
else { ?>
	<ul class="nav nav-tabs nav-stacked main-menu">
	<li><a href='?page=Login' title='Login System'>Login</a></li>	
	</ul>
<?php 
}
?>