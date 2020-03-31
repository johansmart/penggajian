<?php
if($_GET) {
	switch ($_GET['page']){				
		case '' :				
			if(!file_exists ("main.php")) die ("Empty Main Page!"); 
			include "main.php";						
		break;
		case 'HalamanUtama' :				
			if(!file_exists ("main.php")) die ("Sorry Empty Page!"); 
			include "main.php";						
		break;
		case 'Login' :				
			if(!file_exists ("login.php")) die ("Sorry Empty Page!"); 
			include "login.php";						
		break;
		case 'Login-Validasi' :				
			if(!file_exists ("login_validasi.php")) die ("Sorry Empty Page!"); 
			include "login_validasi.php";						
		break;
		case 'Logout' :				
			if(!file_exists ("login_out.php")) die ("Sorry Empty Page!"); 
			include "login_out.php";						
		break;

		# MASTER DATA
		case 'Master-Data' :				
			if(!file_exists ("menu_master.php")) die ("Sorry Empty Page!"); 
			include "menu_master.php";	 break;		
			
		# USER LOGIN
		case 'User-Data' :				
			if(!file_exists ("user_data.php")) die ("Sorry Empty Page!"); 
			include "user_data.php";	 break;		
		case 'User-Add' :				
			if(!file_exists ("user_add.php")) die ("Sorry Empty Page!"); 
			include "user_add.php";	 break;		
		case 'User-Edit' :				
			if(!file_exists ("user_edit.php")) die ("Sorry Empty Page!"); 
			include "user_edit.php"; break;	
		case 'User-Delete' :				
			if(!file_exists ("user_delete.php")) die ("Sorry Empty Page!"); 
			include "user_delete.php"; break;	
			
		# KANTOR
		case 'Kantor-Data' :				
			if(!file_exists ("kantor_data.php")) die ("Sorry Empty Page!"); 
			include "kantor_data.php";	 break;		
		case 'Kantor-Add' :				
			if(!file_exists ("kantor_add.php")) die ("Sorry Empty Page!"); 
			include "kantor_add.php";	 break;		
		case 'Kantor-Edit' :				
			if(!file_exists ("kantor_edit.php")) die ("Sorry Empty Page!"); 
			include "kantor_edit.php"; break;	
		case 'Kantor-Delete' :				
			if(!file_exists ("kantor_delete.php")) die ("Sorry Empty Page!"); 
			include "kantor_delete.php"; break;	
			
		# BAGIAN
		case 'Bagian-Data' :				
			if(!file_exists ("bagian_data.php")) die ("Sorry Empty Page!"); 
			include "bagian_data.php"; break;		
		case 'Bagian-Add' :				
			if(!file_exists ("bagian_add.php")) die ("Sorry Empty Page!"); 
			include "bagian_add.php"; break;		
		case 'Bagian-Edit' :				
			if(!file_exists ("bagian_edit.php")) die ("Sorry Empty Page!"); 
			include "bagian_edit.php"; break;	
		case 'Bagian-Delete' :				
			if(!file_exists ("bagian_delete.php")) die ("Sorry Empty Page!"); 
			include "bagian_delete.php"; break;	
			
		# JABATAN
		case 'Jabatan-Data' :				
			if(!file_exists ("jabatan_data.php")) die ("Sorry Empty Page!"); 
			include "jabatan_data.php"; break;		
		case 'Jabatan-Add' :				
			if(!file_exists ("jabatan_add.php")) die ("Sorry Empty Page!"); 
			include "jabatan_add.php"; break;		
		case 'Jabatan-Edit' :				
			if(!file_exists ("jabatan_edit.php")) die ("Sorry Empty Page!"); 
			include "jabatan_edit.php"; break;	
		case 'Jabatan-Delete' :				
			if(!file_exists ("jabatan_delete.php")) die ("Sorry Empty Page!"); 
			include "jabatan_delete.php"; break;	

		# PEGAWAI
		case 'Pegawai-Data' :				
			if(!file_exists ("pegawai_data.php")) die ("Sorry Empty Page!"); 
			include "pegawai_data.php"; break;		
		case 'Pegawai-Add' :				
			if(!file_exists ("pegawai_add.php")) die ("Sorry Empty Page!"); 
			include "pegawai_add.php"; break;		
		case 'Pegawai-Edit' :				
			if(!file_exists ("pegawai_edit.php")) die ("Sorry Empty Page!"); 
			include "pegawai_edit.php"; break;	
		case 'Pegawai-Delete' :				
			if(!file_exists ("pegawai_delete.php")) die ("Sorry Empty Page!"); 
			include "pegawai_delete.php"; break;	

		# RIWAYAT JABATAN
		case 'Riwayat-Jabatan-Data' :				
			if(!file_exists ("riwayat_jabatan_data.php")) die ("Sorry Empty Page!"); 
			include "riwayat_jabatan_data.php"; break;
		case 'Riwayat-Jabatan-Add' :
			if(!file_exists ("riwayat_jabatan_add.php")) die ("Sorry Empty Page!"); 
			include "riwayat_jabatan_add.php"; break;
		case 'Riwayat-Jabatan-Edit' :
			if(!file_exists ("riwayat_jabatan_edit.php")) die ("Sorry Empty Page!"); 
			include "riwayat_jabatan_edit.php"; break;
		case 'Riwayat-Jabatan-Delete' :
			if(!file_exists ("riwayat_jabatan_delete.php")) die ("Sorry Empty Page!"); 
			include "riwayat_jabatan_delete.php"; break;

		# RIWAYAT MUTASI
		case 'Riwayat-Mutasi-Data' :	
			if(!file_exists ("riwayat_mutasi_data.php")) die ("Sorry Empty Page!"); 
			include "riwayat_mutasi_data.php"; break;		
		case 'Riwayat-Mutasi-Add' :	
			if(!file_exists ("riwayat_mutasi_add.php")) die ("Sorry Empty Page!"); 
			include "riwayat_mutasi_add.php"; break;		
		case 'Riwayat-Mutasi-Edit' :
			if(!file_exists ("riwayat_mutasi_edit.php")) die ("Sorry Empty Page!"); 
			include "riwayat_mutasi_edit.php"; break;	
		case 'Riwayat-Mutasi-Delete' :
			if(!file_exists ("riwayat_mutasi_delete.php")) die ("Sorry Empty Page!"); 
			include "riwayat_mutasi_delete.php"; break;	
		
		# ABSENSI
		case 'Absensi-Data' :				
			if(!file_exists ("absensi_data.php")) die ("Sorry Empty Page!"); 
			include "absensi_data.php"; break;		
		case 'Absensi-Add' :				
			if(!file_exists ("absensi_add.php")) die ("Sorry Empty Page!"); 
			include "absensi_add.php"; break;		
		case 'Absensi-Edit' :				
			if(!file_exists ("absensi_edit.php")) die ("Sorry Empty Page!"); 
			include "absensi_edit.php"; break;	
		case 'Absensi-Delete' :				
			if(!file_exists ("absensi_delete.php")) die ("Sorry Empty Page!"); 
			include "absensi_delete.php"; break;
		
		# PINJAMAN
		case 'Pinjaman-Data' :				
			if(!file_exists ("pinjaman_data.php")) die ("Sorry Empty Page!"); 
			include "pinjaman_data.php"; break;		
		case 'Pinjaman-Add' :				
			if(!file_exists ("pinjaman_add.php")) die ("Sorry Empty Page!"); 
			include "pinjaman_add.php"; break;		
		case 'Pinjaman-Edit' :				
			if(!file_exists ("pinjaman_edit.php")) die ("Sorry Empty Page!"); 
			include "pinjaman_edit.php"; break;	
		case 'Pinjaman-Delete' :				
			if(!file_exists ("pinjaman_delete.php")) die ("Sorry Empty Page!"); 
			include "pinjaman_delete.php"; break;
			
		# PENGGAJIAN
		case 'Penggajian-Data' :				
			if(!file_exists ("penggajian_data.php")) die ("Sorry Empty Page!"); 
			include "penggajian_data.php"; break;		
		case 'Penggajian-Add' :				
			if(!file_exists ("penggajian_add.php")) die ("Sorry Empty Page!"); 
			include "penggajian_add.php"; break;		
		case 'Penggajian-Edit' :				
			if(!file_exists ("penggajian_edit.php")) die ("Sorry Empty Page!"); 
			include "penggajian_edit.php"; break;	
		case 'Penggajian-Delete' :				
			if(!file_exists ("penggajian_delete.php")) die ("Sorry Empty Page!"); 
			include "penggajian_delete.php"; break;
			
		# LEMBUR
		case 'Lembur-Data' :				
			if(!file_exists ("lembur_data.php")) die ("Sorry Empty Page!"); 
			include "lembur_data.php"; break;		
		case 'Lembur-Add' :				
			if(!file_exists ("lembur_add.php")) die ("Sorry Empty Page!"); 
			include "lembur_add.php"; break;		
		case 'Lembur-Edit' :				
			if(!file_exists ("lembur_edit.php")) die ("Sorry Empty Page!"); 
			include "lembur_edit.php"; break;	
		case 'Lembur-Delete' :				
			if(!file_exists ("lembur_delete.php")) die ("Sorry Empty Page!"); 
			include "lembur_delete.php"; break;

			
		# MASTER DATA
		case 'Laporan' :	
			if(!file_exists ("menu_laporan.php")) die ("Sorry Empty Page!"); 
				include "menu_laporan.php";	break;						
		
			# INFORMASI DAN LAPORAN
			case 'Laporan-User' :				
				if(!file_exists ("laporan_user.php")) die ("Sorry Empty Page!"); 
				include "laporan_user.php"; break;		
				
			case 'Laporan-Kantor' :				
				if(!file_exists ("laporan_kantor.php")) die ("Sorry Empty Page!"); 
				include "laporan_kantor.php"; break;	
				
			case 'Laporan-Bagian' :				
				if(!file_exists ("laporan_bagian.php")) die ("Sorry Empty Page!"); 
				include "laporan_bagian.php"; break;	
				
			case 'Laporan-Jabatan' :				
				if(!file_exists ("laporan_jabatan.php")) die ("Sorry Empty Page!"); 
				include "laporan_jabatan.php"; break;	
				
			case 'Laporan-Pegawai' :				
				if(!file_exists ("laporan_pegawai.php")) die ("Sorry Empty Page!"); 
				include "laporan_pegawai.php"; break;
				
			case 'Laporan-Absensi' :				
				if(!file_exists ("laporan_absensi.php")) die ("Sorry Empty Page!"); 
				include "laporan_absensi.php"; break;	
				
			case 'Laporan-Pinjaman' :				
				if(!file_exists ("laporan_pinjaman.php")) die ("Sorry Empty Page!"); 
				include "laporan_pinjaman.php"; break;
				
			case 'Laporan-Penggajian' :				
				if(!file_exists ("laporan_penggajian.php")) die ("Sorry Empty Page!"); 
				include "laporan_penggajian.php"; break;
				
			case 'Laporan-Lembur' :				
				if(!file_exists ("laporan_lembur.php")) die ("Sorry Empty Page!"); 
				include "laporan_lembur.php"; break;
	
		default:
			if(!file_exists ("main.php")) die ("Empty Main Page!"); 
			include "main.php";						
		break;
	}
}
else {
	if(!file_exists ("main.php")) die ("Empty Main Page!"); 
		include "main.php";	
}
?>