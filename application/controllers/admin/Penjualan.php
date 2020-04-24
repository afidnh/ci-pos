<?php
class Penjualan extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('m_kategori');
		$this->load->model('m_barang');
		$this->load->model('m_suplier');
		$this->load->model('m_penjualan');
		$this->load->model('m_pelanggan');
	}
	function index(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
		$data['data']=$this->m_barang->tampil_barang();
		$pelanggan['pelanggan']=$this->m_pelanggan->tampil_pelanggan();
		$x['tampil']=$this->m_penjualan->tampil();
		$this->load->view('admin/v_penjualan',$data,$pelanggan,$x);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function get_barang(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
		$kobar=$this->input->post('kode_brg');
		$x['brg']=$this->m_barang->get_barang($kobar);
		$this->load->view('admin/v_detail_barang_jual',$x);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function get_pelanggan(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
		$kopel=$this->input->post('kode_pel');
		$x['pel']=$this->m_pelanggan->get_pelanggan($kopel);
		$this->load->view('admin/v_detail_barang_jual_pelanggan',$x);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function add_to_cart(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
		$kobar=$this->input->post('kode_brg');
		$produk=$this->m_barang->get_barang($kobar);
		$i=$produk->row_array();
		$data = array(
               'id'       => $i['barang_id'],
               'name'     => $i['barang_nama'],
               'satuan'   => $i['barang_satuan'],
               'harpok'   => $i['barang_harpok'],
               'price'    => str_replace(",", "", $this->input->post('harjul'))-$this->input->post('diskon'),
               'disc'     => $this->input->post('diskon'),
               'qty'      => $this->input->post('qty'),
               'amount'	  => str_replace(",", "", $this->input->post('harjul'))
            );
	if(!empty($this->cart->total_items())){
		foreach ($this->cart->contents() as $items){
			$id=$items['id'];
			$qtylama=$items['qty'];
			$rowid=$items['rowid'];
			$kobar=$this->input->post('kode_brg');
			$barang_stok=$this->input->post('barang_stok');
			$qty=$this->input->post('qty');
			if($id==$kobar){
				$up=array(
					'rowid'=> $rowid,
					'qty'=>$qtylama+$qty
					);
				$this->cart->update($up);
			}else{
				$this->cart->insert($data);
			}
		}
	}else{
		$this->cart->insert($data);
	}

		redirect($_SERVER['HTTP_REFERER']);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function remove(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
		$row_id=$this->uri->segment(4);
		$this->cart->update(array(
               'rowid'      => $row_id,
               'qty'     => 0
            ));
		redirect($_SERVER['HTTP_REFERER']);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function simpan_penjualan(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
		$total=$this->input->post('totalbel');
		$ongkir=$this->input->post('ongkir');
		$pelanggan_id=$this->input->post('pelanggan_id');
		$jml_uang=str_replace(",", "", $this->input->post('jml_uang'));
		$kembalian=$jml_uang-$total;
		if(!empty($total) && !empty($jml_uang)){
			if($jml_uang < $total){
				// echo $this->session->set_flashdata('msg','<label class="label label-danger">Jumlah Uang yang anda masukan Kurang</label>');
				// redirect($_SERVER['HTTP_REFERER']);
				$nofak=$this->m_penjualan->get_nofak();
				$this->session->set_userdata('nofak',$nofak);
				$order_proses=$this->m_penjualan->simpan_penjualan_hutang($nofak,$total,$jml_uang,$kembalian,$pelanggan_id,$ongkir);
				if($order_proses){
					$this->cart->destroy();
					
					// $this->session->unset_userdata('tglfak');
					// $this->session->unset_userdata('suplier');
					$this->load->view('admin/alert/alert_sukses');
				}else{
					redirect($_SERVER['HTTP_REFERER']);
				}
			}else{
				$nofak=$this->m_penjualan->get_nofak();
				$this->session->set_userdata('nofak',$nofak);
				$order_proses=$this->m_penjualan->simpan_penjualan($nofak,$total,$jml_uang,$kembalian,$pelanggan_id,$ongkir);
				if($order_proses){
					$this->cart->destroy();
					
					// $this->session->unset_userdata('tglfak');
					// $this->session->unset_userdata('suplier');
					$this->load->view('admin/alert/alert_sukses');	
				}else{
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
			
		}else{
			echo $this->session->set_flashdata('msg','<label class="label label-danger">Penjualan Gagal di Simpan, Mohon Periksa Kembali Semua Inputan Anda!</label>');
			redirect($_SERVER['HTTP_REFERER']);
		}

	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function cetak_daftar_faktur(){
		$nofak=$this->input->get('nofak');
		$x['data']=$this->m_penjualan->cetak_daftar_faktur();
		$this->load->view('admin/laporan/v_faktur',$x);
		//$this->session->unset_userdata('nofak');
	}
	function hapus(){
		$nofak=$this->input->get('nofak');
		$this->m_penjualan->hapus($nofak);
		redirect('admin/penjualan');
	}

	function hapus_barang(){
		$id_barang=$this->input->get('id_barang');
		$this->m_penjualan->hapus_barang($id_barang);
		redirect($_SERVER['HTTP_REFERER']);
	}

	function cetak_faktur(){
		$x['data']=$this->m_penjualan->cetak_faktur();
		$this->load->view('admin/laporan/v_faktur',$x);
		//$this->session->unset_userdata('nofak');
	}

	function detail_penjualan(){
		$x['data']=$this->m_penjualan->cetak_daftar_faktur();
		$this->load->view('admin/v_detail_penjualan',$x);
		//$this->session->unset_userdata('nofak');
	}

	function bayar_piutang(){
	if($this->session->userdata('akses')=='1'){
		$nofak=$this->input->get('nofak');
		$a=a;
		$this->m_penjualan->bayar_piutang($nofak);
		echo $this->session->set_flashdata('msg','<label class="label label-danger">Orderan telah terbayar lunas</label>');
		redirect('admin/penjualan');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function kirim(){
	if($this->session->userdata('akses')=='1'){
		$nofak=$this->input->get('nofak');
		$a=a;
		$this->m_penjualan->kirim($nofak);
		redirect('admin/penjualan');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function tambah_data(){
		// $this->load->view('admin/v_tambah_penjualan');
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('m_kategori');
		$this->load->model('m_barang');
		$this->load->model('m_suplier');
		$this->load->model('m_penjualan');
		$this->load->model('m_pelanggan');
		$data['data']=$this->m_barang->tampil_barang();
		$data['po']=$this->m_barang->tampil_barang_po();
		$data['pelanggan']=$this->m_pelanggan->tampil_pelanggan();
		$this->load->view('admin/v_tambah_penjualan',$data);

	}

	function edit_penjualan(){
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('m_kategori');
		$this->load->model('m_barang');
		$this->load->model('m_suplier');
		$this->load->model('m_penjualan');
		$this->load->model('m_pelanggan');
		$data['detail_barang']=$this->m_penjualan->cetak_daftar_faktur();
		$data['data']=$this->m_barang->tampil_barang();
		$data['po']=$this->m_barang->tampil_barang_po();
		$data['pelanggan']=$this->m_pelanggan->tampil_pelanggan();
		$this->load->view('admin/v_edit_penjualan',$data);

	}

	function simpan_penjualan_po(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
		$total=$this->input->post('totalbel');
		$ongkir=$this->input->post('ongkir');
		$pelanggan_id=$this->input->post('pelanggan_id');
		$jml_uang=str_replace(",", "", $this->input->post('jml_uang'));
		$kembalian=$jml_uang-$total;
		$nofak=$this->m_penjualan->get_nofak();
				$this->session->set_userdata('nofak',$nofak);
				$order_proses=$this->m_penjualan->simpan_penjualan_po($nofak,$total,$jml_uang,$kembalian,$pelanggan_id,$ongkir);
				if($order_proses){
					$this->cart->destroy();
					
					// $this->session->unset_userdata('tglfak');
					// $this->session->unset_userdata('suplier');
					$this->load->view('admin/alert/alert_sukses');
				}else{
					redirect($_SERVER['HTTP_REFERER']);
				}

	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function update_barang_edit(){
	if($this->session->userdata('akses')=='1'){
		$nofak=$this->input->post('nofak');
		$kode_brg=$this->input->post('kode_brg');
		$nabar=$this->input->post('nabar');
		$satuan=$this->input->post('satuan');
		$stok=$this->input->post('stok');
		$harjul=$this->input->post('harjul');
		$diskon=$this->input->post('diskon');
		$qty=$this->input->post('qty');
		$harpok=$this->input->post('harpok');
		$subtotal=$harjul*$qty;

		$this->m_penjualan->update_barang_edit($nofak,$kode_brg,$nabar,$satuan,$stok,$harjul,$qty,$subtotal,$diskon,$harpok);
		redirect($_SERVER['HTTP_REFERER']);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function proses_edit_penjualan(){
	if($this->session->userdata('akses')=='1'){
		$nofak=$this->input->post('nofak');
		$ongkir=$this->input->post('ongkir');
		$totalbel=$this->input->post('totalbel');
		$jml_uang=str_replace(",", "", $this->input->post('jml_uang'));
		$kembalian=$jml_uang-$totalbel;
		$keterangan=$this->input->post('keterangan');
		$this->m_penjualan->proses_edit_penjualan($nofak,$ongkir,$totalbel,$jml_uang,$kembalian,$keterangan);
		redirect('admin/penjualan');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

}