<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class gudang extends MY_Controller {

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

	public function index()
	{
		redirect(base_url('gudang/menu'));
		
	}	

    //------------------------------------------ View Data Table----------------- --------------------//
    
	public function menu()
	{
		$data['aktif'] = 'stok';
		$data['konten'] = $this->load->view('gudang/menu', NULL, TRUE);
		$this->load->view ('main', $data);		
	}

	
	
}
