<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class setting extends MY_Controller {

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
	}	

    //------------------------------------------ View Data Table----------------- --------------------//

	public function index()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/setting/form_setting', NULL, TRUE);
		$data['halaman'] = $this->load->view('menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function simpan_setting(){
		$data = $this->input->post();
		unset($data['foto_name_upload']);
		unset($data['file_name_upload']);
		$logo = $this->input->post('foto_name_upload');
		$bg = $this->input->post('file_name_upload');
		if(!empty($logo)){
			$data['logo_resto'] = $logo[0];
		}
		else{
			unset($data['logo_resto']);
		}
		if(!empty($bg)){
			$data['background'] = $bg[0];
		}
		else{
			unset($data['background']);
		}
		$cari_setting = $this->db->get('setting_gudang');
		$hasil_cari = $cari_setting->result();
		if(count($hasil_cari)<1){
			$this->db->insert('setting_gudang',$data);
		}else{
			$this->db->update('setting_gudang',$data,array('id'=>$data['id']));
		}
		echo "sukses";
	}

	public function default_rak()
	{
		$kode_unit_default = $this->input->post('kode_unit_default');
		$query = $this->db->get_where('master_rak',array('kode_unit'=>$kode_unit_default));
		$opt = '';
		$opt = '<option value="">--Pilih Rak--</option>';
		foreach ($query->result() as $key => $value) {
			$opt .= '<option value="'.$value->kode_rak.'">'.$value->nama_rak.'</option>';  
		}
		echo $opt;
	}



	
	
}
