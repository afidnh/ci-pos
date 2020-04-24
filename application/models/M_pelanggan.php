<?php
class M_pelanggan extends CI_Model{

	function hapus_pelanggan($kode){
		$hsl=$this->db->query("DELETE FROM tbl_pelanggan where pelanggan_id='$kode'");
		return $hsl;
	}

	function update_pelanggan($kode,$nama,$alamat,$notelp,$kategori){
		$hsl=$this->db->query("UPDATE tbl_pelanggan set pelanggan_nama='$nama',pelanggan_alamat='$alamat',pelanggan_notelp='$notelp',pelanggan_kategori='$kategori' where pelanggan_id='$kode'");
		return $hsl;
	}

	function tampil_pelanggan(){
		$hsl=$this->db->query("select * from tbl_pelanggan order by pelanggan_id desc");
		return $hsl;
	}

	function simpan_pelanggan($nama,$alamat,$notelp,$kategori){
		$hsl=$this->db->query("INSERT INTO tbl_pelanggan(pelanggan_nama,pelanggan_alamat,pelanggan_notelp,pelanggan_kategori) VALUES ('$nama','$alamat','$notelp','$kategori')");
		return $hsl;
	}

	function get_pelanggan($kopel){
		if (is_null($kopel)) {
			$hsl=$this->db->query("SELECT * FROM tbl_pelanggan ");
		return $hsl;
		}else{
			$hsl=$this->db->query("SELECT * FROM tbl_pelanggan where pelanggan_nama = '$kopel'");
		return $hsl;
		}
		
	}

}