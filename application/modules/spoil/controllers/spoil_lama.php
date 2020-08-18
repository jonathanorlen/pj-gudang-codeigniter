<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class spoil extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();		
		if ($this->session->userdata('astrosession') == FALSE) {
			redirect(base_url('authenticate'));			
		}
		$this->load->library('form_validation');
		$this->cname = 'spoil';
	}	

    //------------------------------------------ View Data Table----------------- --------------------//
	
	public function index()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/daftar', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);			
	}


	public function ubah()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/form', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);	
	}

	public function hapus(){
		$kode = $this->input->post("id");
		$this->db->delete( 'cooling_unit', array('id' => $kode) );

		echo '<div class="alert alert-success">Sudah dihapus.</div>';            

	}
	public function simpan()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('kode_cooling', 'Kode Jenis Anggota', 'required'); 
		$this->form_validation->set_rules('nama_cooling', 'Nama Jenis Anggota', 'required'); 
		$this->form_validation->set_rules('status', 'Status', 'required'); 

		if ($this->form_validation->run() == FALSE) {
			echo '<div class="alert alert-warning">Gagal tersimpan.</div>';
		} 
		else {
			$data['kode_cooling_unit'] = $this->input->post("kode_cooling");
			$data['nama_cooling_unit'] = $this->input->post("nama_cooling");
			$data['status'] = $this->input->post("status");
			$insert = $this->db->insert("cooling_unit", $data); 
			echo '<div class="alert alert-success">Sudah tersimpan.</div>';
			$this->session->set_flashdata('message', $data['kode_cooling_unit']);     
		}
	}
	public function simpan_ubah()
	{	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('kode_cooling', 'Kode Jenis Anggota', 'required'); 
		$this->form_validation->set_rules('nama_cooling', 'Nama Jenis Anggota', 'required'); 
		$this->form_validation->set_rules('status', 'Status', 'required'); 

		if ($this->form_validation->run() == FALSE) {
			echo '<div class="alert alert-warning">Gagal tersimpan.</div>';
		} 
		else {
			$kode= $this->input->post("id");
			$data['kode_cooling_unit'] = $this->input->post("kode_cooling");
			$data['nama_cooling_unit'] = $this->input->post("nama_cooling");
			$data['status'] = $this->input->post("status");
			$query=$this->db->update( "cooling_unit", $data, array('id' => $kode) );
			echo '<div class="alert alert-success">Sudah tersimpan.</div>';
	   // echo $this->db->last_query();
			$this->session->set_flashdata('message', $data['kode_cooling_unit']); 
			
		}
		
	}
	
	public function daftar()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/daftar', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}
	public function tambah()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/form', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}
	public function detail()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);


		
	}

	
}
