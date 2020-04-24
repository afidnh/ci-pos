<?php
class Welcome extends CI_Controller{
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
		$this->load->model('m_penjualan');
		$this->load->model('m_laporan');
		$this->load->model('m_grafik');
	}
	
	function index(){
		$bulan=date("F Y");
		$x['report']=$this->m_grafik->graf_penjualan_perbulan_index();
		$x['bln']=$bulan;
		$this->load->view('admin/v_index',$x);
	}

	function graf_penjualan_perbulan_index(){
		// $bulan=$this->input->post('bln');
		$bulan = 'october 2019';
		$x['report']=$this->m_grafik->graf_penjualan_perbulan_index();
		$x['bln']=$bulan;
		$this->load->view('admin/v_index',$x);
	}
}