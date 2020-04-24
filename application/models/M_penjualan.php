<?php
class M_penjualan extends CI_Model{

	function hapus_retur($kode){
		$hsl=$this->db->query("DELETE FROM tbl_retur WHERE retur_id='$kode'");
		return $hsl;
	}

	function tampil_retur(){
		$hsl=$this->db->query("SELECT retur_id,DATE_FORMAT(retur_tanggal,'%d/%m/%Y') AS retur_tanggal,retur_barang_id,retur_barang_nama,retur_barang_satuan,retur_harjul,retur_qty,(retur_harjul*retur_qty) AS retur_subtotal,retur_keterangan FROM tbl_retur ORDER BY retur_id DESC");
		return $hsl;
	}

	function simpan_retur($kobar,$nabar,$satuan,$harjul,$qty,$keterangan){
		$hsl=$this->db->query("INSERT INTO tbl_retur(retur_barang_id,retur_barang_nama,retur_barang_satuan,retur_harjul,retur_qty,retur_keterangan) VALUES ('$kobar','$nabar','$satuan','$harjul','$qty','$keterangan')");
		return $hsl;
	}

	function simpan_penjualan($nofak,$total,$jml_uang,$kembalian,$pelanggan_id,$ongkir){
		$idadmin=$this->session->userdata('idadmin');
		$this->db->query("INSERT INTO tbl_jual (jual_nofak,jual_total,jual_jml_uang,jual_kembalian,jual_user_id,jual_pelanggan_id,jual_keterangan,jual_ongkir) VALUES ('$nofak','$total','$jml_uang','$kembalian','$idadmin','$pelanggan_id','Lunas','$ongkir')");
		foreach ($this->cart->contents() as $item) {
			$data=array(
				'd_jual_nofak' 			=>	$nofak,
				'd_jual_barang_id'		=>	$item['id'],
				'd_jual_barang_nama'	=>	$item['name'],
				'd_jual_barang_satuan'	=>	$item['satuan'],
				'd_jual_barang_harpok'	=>	$item['harpok'],
				'd_jual_barang_harjul'	=>	$item['amount'],
				'd_jual_qty'			=>	$item['qty'],
				'd_jual_diskon'			=>	$item['disc'],
				'd_jual_total'			=>	$item['subtotal']
			);
			$this->db->insert('tbl_detail_jual',$data);
			$this->db->query("update tbl_barang set barang_stok=barang_stok-'$item[qty]' where barang_id='$item[id]'");
		}
		return true;
	}
	function get_nofak(){
		$q = $this->db->query("SELECT MAX(RIGHT(jual_nofak,6)) AS kd_max FROM tbl_jual WHERE DATE(jual_tanggal)=CURDATE()");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }else{
            $kd = "000001";
        }
        return date('dmy').$kd;
	}

	//=====================Penjualan Hutang================================
	function simpan_penjualan_hutang($nofak,$total,$jml_uang,$kembalian,$pelanggan_id,$ongkir){
		$idadmin=$this->session->userdata('idadmin');
		$this->db->query("INSERT INTO tbl_jual (jual_nofak,jual_total,jual_jml_uang,jual_piutang,jual_user_id,jual_pelanggan_id,jual_keterangan,jual_ongkir) VALUES ('$nofak','$total','$jml_uang','$kembalian','$idadmin','$pelanggan_id','hutang','$ognkir')");
		foreach ($this->cart->contents() as $item) {
			$data=array(
				'd_jual_nofak' 			=>	$nofak,
				'd_jual_barang_id'		=>	$item['id'],
				'd_jual_barang_nama'	=>	$item['name'],
				'd_jual_barang_satuan'	=>	$item['satuan'],
				'd_jual_barang_harpok'	=>	$item['harpok'],
				'd_jual_barang_harjul'	=>	$item['amount'],
				'd_jual_qty'			=>	$item['qty'],
				'd_jual_diskon'			=>	$item['disc'],
				'd_jual_total'			=>	$item['subtotal']
			);
			$this->db->insert('tbl_detail_jual',$data);
			$this->db->query("update tbl_barang set barang_stok=barang_stok-'$item[qty]' where barang_id='$item[id]'");
		}
		return true;
	}

	//=====================Penjualan PO================================
	function simpan_penjualan_po($nofak,$total,$jml_uang,$kembalian,$pelanggan_id,$ongkir){
		$idadmin=$this->session->userdata('idadmin');
		$this->db->query("INSERT INTO tbl_jual (jual_nofak,jual_total,jual_jml_uang,jual_piutang,jual_user_id,jual_pelanggan_id,jual_keterangan,jual_ongkir) VALUES ('$nofak','$total','$jml_uang','$kembalian','$idadmin','$pelanggan_id','PO','$ongkir')");
		foreach ($this->cart->contents() as $item) {
			$data=array(
				'd_jual_nofak' 			=>	$nofak,
				'd_jual_barang_id'		=>	$item['id'],
				'd_jual_barang_nama'	=>	$item['name'],
				'd_jual_barang_satuan'	=>	$item['satuan'],
				'd_jual_barang_harpok'	=>	$item['harpok'],
				'd_jual_barang_harjul'	=>	$item['amount'],
				'd_jual_qty'			=>	$item['qty'],
				'd_jual_diskon'			=>	$item['disc'],
				'd_jual_total'			=>	$item['subtotal']
			);
			$this->db->insert('tbl_detail_jual',$data);
			$this->db->query("update tbl_barang set barang_stok=barang_stok-'$item[qty]' where barang_id='$item[id]'");
		}
		return true;
	}

	function cetak_faktur(){
		$nofak=$this->session->userdata('nofak');
		$hsl=$this->db->query("SELECT tbl_jual.jual_nofak, DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal, tbl_jual.jual_total, tbl_jual.jual_jml_uang, tbl_jual.jual_kembalian,tbl_jual.jual_keterangan, tbl_detail_jual.d_jual_barang_nama, tbl_detail_jual.d_jual_barang_satuan, tbl_detail_jual.d_jual_barang_harjul, tbl_detail_jual.d_jual_qty,tbl_detail_jual.d_jual_diskon, tbl_detail_jual.d_jual_total, tbl_jual.jual_pelanggan_id, tbl_pelanggan.pelanggan_id, tbl_pelanggan.pelanggan_nama, tbl_pelanggan.pelanggan_alamat, tbl_pelanggan.pelanggan_notelp, tbl_pelanggan.pelanggan_kategori,tbl_jual.jual_piutang,,tbl_jual.jual_ongkir 
			FROM
			tbl_jual
			JOIN tbl_detail_jual ON tbl_jual.jual_nofak = d_jual_nofak
			INNER JOIN tbl_pelanggan ON tbl_jual.jual_pelanggan_id = tbl_pelanggan.pelanggan_id WHERE jual_nofak='$nofak'");
		return $hsl;
	}
	function cetak_daftar_faktur(){
		$nofak=$this->input->get('nofak');
		$hsl=$this->db->query("SELECT tbl_jual.jual_nofak, DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal, tbl_jual.jual_total, tbl_jual.jual_jml_uang, tbl_jual.jual_kembalian,tbl_jual.jual_keterangan, tbl_detail_jual.d_jual_barang_nama,tbl_detail_jual.d_jual_barang_id, tbl_detail_jual.d_jual_barang_satuan, tbl_detail_jual.d_jual_barang_harjul, tbl_detail_jual.d_jual_qty,tbl_detail_jual.d_jual_diskon, tbl_detail_jual.d_jual_total, tbl_jual.jual_pelanggan_id, tbl_pelanggan.pelanggan_id, tbl_pelanggan.pelanggan_nama, tbl_pelanggan.pelanggan_alamat, tbl_pelanggan.pelanggan_notelp, tbl_pelanggan.pelanggan_kategori,tbl_jual.jual_piutang,tbl_jual.jual_ongkir,tbl_detail_jual.d_jual_id 
			FROM
			tbl_jual
			JOIN tbl_detail_jual ON tbl_jual.jual_nofak = d_jual_nofak
			INNER JOIN tbl_pelanggan ON tbl_jual.jual_pelanggan_id = tbl_pelanggan.pelanggan_id WHERE jual_nofak='$nofak'");
		return $hsl;
	}
	function tampil(){
		$hsl=$this->db->query("SELECT tbl_jual.jual_nofak, DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal, tbl_jual.jual_total, tbl_jual.jual_jml_uang, tbl_jual.jual_kembalian,tbl_jual.jual_keterangan, tbl_detail_jual.d_jual_barang_nama, tbl_detail_jual.d_jual_barang_satuan, tbl_detail_jual.d_jual_barang_harjul, tbl_detail_jual.d_jual_qty,tbl_detail_jual.d_jual_diskon, tbl_detail_jual.d_jual_total, tbl_jual.jual_pelanggan_id, tbl_pelanggan.pelanggan_id, tbl_pelanggan.pelanggan_nama, tbl_pelanggan.pelanggan_alamat, tbl_pelanggan.pelanggan_notelp, tbl_pelanggan.pelanggan_kategori,tbl_jual.jual_piutang 
			FROM tbl_jual JOIN tbl_detail_jual ON tbl_jual.jual_nofak = d_jual_nofak , tbl_pelanggan");
		return $hsl;

	}
	function bayar_piutang($nofak){
		$hsl=$this->db->query("UPDATE tbl_jual set jual_piutang=0, jual_keterangan='Lunas' where jual_nofak='$nofak'");
		return $hsl;

	}
	function hapus($nofak){
		$hsl=$this->db->query("DELETE tbl_detail_jual,tbl_jual FROM tbl_detail_jual LEFT JOIN tbl_jual ON tbl_detail_jual.d_jual_nofak = tbl_jual.jual_nofak where tbl_detail_jual.d_jual_nofak='$nofak'");
			return $hsl;
	}

	function hapus_barang($id_barang){
		$hsl=$this->db->query("DELETE FROM tbl_detail_jual where tbl_detail_jual.d_jual_id='$id_barang'");
			return $hsl;
	}

	function kirim($nofak){
		$hsl=$this->db->query("UPDATE tbl_jual set jual_pengiriman=1 where jual_nofak='$nofak'");
		return $hsl;

	}
	function update_barang_edit($nofak,$kode_brg,$nabar,$satuan,$stok,$harjul,$qty,$subtotal,$diskon,$harpok){
		$hsl=$this->db->query("INSERT INTO tbl_detail_jual(d_jual_nofak,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total) VALUES ('$nofak','$kode_brg','$nabar','$satuan','$harpok','$harjul','$qty','$diskon','$subtotal')");
		$this->db->query("update tbl_barang set barang_stok=barang_stok-'$qty' where barang_id='$kode_brg'");
		return $hsl;

	}

	function proses_edit_penjualan($nofak,$ongkir,$totalbel,$jml_uang,$kembalian,$keterangan){
		if ( $keterangan == 'PO') {
			if ($jml_uang >= $totalbel) {
			$hsl=$this->db->query("UPDATE tbl_jual SET jual_total='$totalbel',jual_jml_uang='$jml_uang',jual_kembalian='$kembalian',jjual_ongkir='$ongkir' WHERE jual_nofak='$nofak'");
		
			}else{
				$hsl=$this->db->query("UPDATE tbl_jual SET jual_total='$totalbel',jual_jml_uang='$jml_uang',jual_piutang='$kembalian',jual_ongkir='$ongkir' WHERE jual_nofak='$nofak'");
			
			}
		}else{
			if ($jml_uang >= $totalbel) {
			$hsl=$this->db->query("UPDATE tbl_jual SET jual_total='$totalbel',jual_jml_uang='$jml_uang',jual_kembalian='$kembalian',jjual_ongkir='$ongkir',jual_keterangan='Lunas' WHERE jual_nofak='$nofak'");
			
			}else{
				$hsl=$this->db->query("UPDATE tbl_jual SET jual_total='$totalbel',jual_jml_uang='$jml_uang',jual_piutang='$kembalian',jual_ongkir='$ongkir',jual_keterangan='hutang' WHERE jual_nofak='$nofak'");
			
			}
		}
		return $hsl;
		
	}
	
}