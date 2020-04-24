<?php
class Pembelian extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('m_kategori');
		$this->load->model('m_barang');
		$this->load->model('m_suplier');
		$this->load->model('m_pembelian');
	}
	function index(){
	if($this->session->userdata('akses')=='1'){
		// $x['data']=$this->m_barang->tampil_barang();
		$x['sup']=$this->m_suplier->tampil_suplier();
		$x['data']=$this->m_pembelian->tampil_pembelian();
		$this->load->view('admin/v_pembelian',$x);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function get_barang(){
	if($this->session->userdata('akses')=='1'){
		$kobar=$this->input->post('kode_brg');
		$x['brg']=$this->m_barang->get_barang($kobar);
		$this->load->view('admin/v_detail_barang_beli',$x);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function add_to_cart(){
	if($this->session->userdata('akses')=='1'){
		$nofak=$this->input->post('nofak');
		$tgl=$this->input->post('tgl');
		$suplier=$this->input->post('suplier');
		$this->session->set_userdata('nofak',$nofak);
		$this->session->set_userdata('tglfak',$tgl);
		$this->session->set_userdata('suplier',$suplier);
		$kobar=$this->input->post('kode_brg');
		$produk=$this->m_barang->get_barang($kobar);
		$i=$produk->row_array();
		$data = array(
               'id'       => $i['barang_id'],
               'name'     => $i['barang_nama'],
               'satuan'   => $i['barang_satuan'],
               'price'    => $this->input->post('harpok'),
               'harga'    => $this->input->post('harjul'),
               'qty'      => $this->input->post('jumlah')
            );

		$this->cart->insert($data); 
		redirect($_SERVER['HTTP_REFERER']);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function remove(){
	if($this->session->userdata('akses')=='1'){
		$row_id=$this->uri->segment(4);
		$this->cart->update(array(
               'rowid'      => $row_id,
               'qty'     => 0
            ));
		redirect('admin/pembelian/tambah_data');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function simpan_pembelian(){
	if($this->session->userdata('akses')=='1'){
		$nofak=$this->input->post('nofak');
		$tglfak=$this->input->post('tgl');
		$suplier=$this->input->post('suplier');
		if(!empty($nofak) && !empty($tglfak) && !empty($suplier)){
			$beli_kode=$this->m_pembelian->get_kobel();
			$order_proses=$this->m_pembelian->simpan_pembelian($nofak,$tglfak,$suplier,$beli_kode);
			if($order_proses){
				$this->cart->destroy();
				$this->session->unset_userdata('nofak');
				$this->session->unset_userdata('tglfak');
				$this->session->unset_userdata('suplier');
				echo $this->session->set_flashdata('msg','<label class="label label-success">Pembelian Berhasil di Simpan ke Database</label>');
				redirect('admin/pembelian');	
			}else{
				redirect('admin/pembelian');
			}
		}else{
			echo $this->session->set_flashdata('msg','<label class="label label-danger">Pembelian Gagal di Simpan, Mohon Periksa Kembali Semua Inputan Anda!</label>').$nofak.$tglfak.$suplier;
			redirect('admin/pembelian');
			
		}
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
		$this->load->model('m_pembelian');
		$this->load->model('m_pelanggan');
		$data['data']=$this->m_barang->tampil_barang();
		$data['sup']=$this->m_suplier->tampil_suplier();
		$this->load->view('admin/v_tambah_pembelian',$data);

	}

	function tampil_pembelian_detail(){
		$beli_kode=$this->input->get('beli_kode');
		$x['data']=$this->m_pembelian->tampil_pembelian_detail($beli_kode);
		$this->load->view('admin/v_detail_pembelian',$x);
	}
	function hapus(){
		$beli_kode=$this->input->get('beli_kode');
		$this->m_pembelian->hapus($beli_kode);
		redirect('admin/pembelian');
	}
}