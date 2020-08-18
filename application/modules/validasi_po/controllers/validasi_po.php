<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class validasi_po extends MY_Controller {

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
		$this->load->library('session');
	}	

    //------------------------------------------ View Data Table----------------- --------------------//
	public function cari_validasi_order(){
		$this->load->view('setting/cari_validasi_order');

	}
	public function index()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/daftar', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function coba()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/coba', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);	
	}


	public function daftar_validasi()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/daftar', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);	
	}

	public function pendaftaran()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/form', $data, TRUE);
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

	public function validasi()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);			
	}
	public function validasi2()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);			
	}
	public function tabel_validasi()
	{
		$this->load->view('setting/tabel_validasi');
	}
	public function detail()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail_validasi', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);			
	}
	public function update_transaksi(){
		$kode_ro=$this->input->post("kode_ro");
		$data['status']='2';
		$query=$this->db->update( "transaksi_ro", $data, array('kode_ro' => $kode_ro) );
		echo $this->db->last_query();
		
	}
	public function panding_transaksi(){
		$kode_ro=$this->input->post("kode_ro");
		$data['status']='0';
		$query=$this->db->update( "transaksi_ro", $data, array('kode_ro' => $kode_ro) );
		echo $this->db->last_query();
		
	}
	public function proses_transaksi(){
		$kode_ro=$this->input->post("kode_ro");
		#$data['status']='1';
		#$query=$this->db->update( "transaksi_ro", $data, array('kode_ro' => $kode_ro) );
		//echo $this->db->last_query();
		$update['status_validasi'] = 'proses';
		$this->db->update('opsi_transaksi_ro',$update,array('kode_ro'=>$kode_ro,'jenis_bahan'=>'stok'));
		$this->db->delete('opsi_transaksi_validasi_ro_temp',array('kode_ro'=>$kode_ro));
	}

	public function hasil_nama_unit(){
		$kode_ro=$this->input->post("kode_ro");
		$update['status_validasi'] = 'batal';
		$this->db->update('opsi_transaksi_ro',$update,array('kode_ro'=>$kode_ro,'jenis_bahan'=>'stok'));
		$this->db->delete('opsi_transaksi_validasi_ro_temp',array('kode_ro'=>$kode_ro));
		echo '<div class="alert alert-danger">Berhasil Membatalkan Request Order</div>';
	}

	public function simpan_ubah()

	{
		$data['no_transaksi']      = $this->input->post("no_transaksi");
		$data['nomor_anggota']	   = $this->input->post("nomor_anggota");
		$data2['no_anggota']	   = $this->input->post("nomor_anggota");
		$data['nama'] 			   = $this->input->post("nama_anggota");
		$data['tempat_lahir'] 	   = $this->input->post("tempat_lahir");//fild nama anggota
		$data['tanggal_lahir'] 	   = $this->input->post("tanggal_lahir");
		$data['no_ktp']            = $this->input->post("no_ktp");//fild nama ktp	
		$data['alamat']            = $this->input->post("alamat");
		$data['jabatan']		   = $this->input->post("jabatan");
		$data['kode_kelompok']	   = $this->input->post("kelompok");

		$cari_data_kelompok = $this->db->get_where('kelompok_anggota', array('kode_kelompok'=>$data['kode_kelompok']));
		$hasil_data_kelompok = $cari_data_kelompok->row();

		$data['nama_kelompok']= $hasil_data_kelompok->nama_kelompok;
		$data['kode_pos_penampungan_susu']= $hasil_data_kelompok->kode_pos_penampungan_susu;
		$data['nama_pos_penampungan_susu']= $hasil_data_kelompok->nama_pos_penampungan_susu;

		$data['kode_jenis_anggota']= $this->input->post("jenis_anggota");
		$cari_data_jenis_anggota = $this->db->get_where('jenis_anggota', array('kode_jenis_anggota'=>$data['kode_jenis_anggota']));
		$hasil_data_jenis_anggota = $cari_data_jenis_anggota->row();
		
		$data['nama_jenis_anggota']= $hasil_data_jenis_anggota->nama_jenis_anggota;


		//$data['validasi']            = 'belum_divalidasi';

		$tipe_sapi = $this->db->get('tipe_sapi');
		$hasil_tipe_sapi = $tipe_sapi->result_array();

		$insert_opsi = $this->db->update( "opsi_sapi_anggota", $data2, array('no_anggota' => $data2['no_anggota']) );
		foreach($hasil_tipe_sapi as $item){
			$tipe_sapi = str_replace(" ","_",$item['tipe']);
			$milik_sendiri = $tipe_sapi.'_milik_sendiri';
			$rumatan = $tipe_sapi.'_rumatan';

			$input_milik_sendiri = 'milik_sendiri'.$tipe_sapi;
			$input_rumatan = 'rumatan'.$tipe_sapi;
			$input_jumlah = 'jumlah'.$tipe_sapi;
			$total = @$total + $this->input->post($input_jumlah);

			$data2['jumlah_sapi'] = $total;
			$data2[$milik_sendiri] = $this->input->post($input_milik_sendiri);
			$data2[$rumatan] = $this->input->post($input_rumatan);
			$data2['kondisi_kandang'] = $this->input->post("kondisi_kandang");
			
			$query=$this->db->update( "opsi_sapi_anggota", $data2, array('no_anggota' => $data2['no_anggota']) );
		}
		
		$insert = $this->db->update( "anggota", $data, array('no_transaksi' => $data['no_transaksi']) );
		echo '<div class="alert alert-success">Sudah tersimpan.</div>';
		$this->session->set_flashdata('message', $data['no_transaksi']);
	}

	function simpan_edit(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama_anggota', 'Nama Anggota', 'required'); 
		$this->form_validation->set_rules('alamat', 'Alamat', 'required'); 
		$this->form_validation->set_rules('no_transaksi_anggota', 'No Transaksi Anggota', 'required'); 
		$this->form_validation->set_rules('no_ktp', 'No KTP Anggota', 'required'); 
		$this->form_validation->set_rules('kode_jenis_anggota', 'Kode Jenis Anggota', 'required'); 
		$this->form_validation->set_rules('kode_kelompok', 'Kode Kelompok', 'required');
		$this->form_validation->set_rules('jabatan_anggota', 'Jabatan Anggota', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required'); 

		if ($this->form_validation->run() == FALSE) {
			echo '<div class="alert alert-warning">Gagal tersimpan.</div>';
		} 
		else {
			$kode = $this->input->post("nomor_anggota");
			$data['no_transaksi'] = $this->input->post("no_transaksi_anggota");
			$data['nama'] = $this->input->post("nama_anggota");
			$data['alamat'] = $this->input->post("alamat");
			$data['no_ktp'] = $this->input->post("no_ktp");
			$data['kode_jenis_anggota'] = $this->input->post("kode_jenis_anggota");
			$kode_jenis_anggota = $this->input->post("kode_jenis_anggota");
			$ambil_kode_jenis_anggota = $this->db->query(" SELECT * FROM jenis_anggota where kode_jenis_anggota='$kode_jenis_anggota' ");
			$hasil_ambil_kode_jenis_anggota = $ambil_kode_jenis_anggota->row();
			$data['nama_jenis_anggota'] = $hasil_ambil_kode_jenis_anggota->nama_jenis_anggota;

			$data['kode_kelompok'] = $this->input->post("kode_kelompok");
			$kode_kelompok = $this->input->post("kode_kelompok");
			$ambil_kode_kelompok= $this->db->query(" SELECT * FROM kelompok where kode_kelompok='$kode_kelompok' ");
			$hasil_ambil_kode_kelompok = $ambil_kode_kelompok->row();
			$data['nama_pos_penampungan_susu'] = $hasil_ambil_kode_kelompok->nama_pos_penampungan_susu;
			$data['kode_pos_penampungan_susu'] = $hasil_ambil_kode_kelompok->kode_pos_penampungan_susu;
			$data['nama_kelompok'] 		= $hasil_ambil_kode_kelompok->nama_kelompok;
			$data['kode_cooling_unit']  = $hasil_ambil_kode_kelompok->kode_cooling_unit;
			$data['nama_cooling_unit']  = $hasil_ambil_kode_kelompok->nama_cooling_unit;
			$data['jabatan'] = $this->input->post("jabatan_anggota");
			$data['status'] = $this->input->post("status");
			$query=$this->db->update( "anggota", $data, array('nomor_anggota' => $kode) );
			$this->session->set_flashdata('message', $data['no_transaksi']);  
			echo '<div class="alert alert-success">Sudahe Tersimpan.</div>';         
		}

	}

	public function get_po($kode){
		$data['kode'] = $kode ;
		$this->load->view('validasi_po/setting/tabel_transaksi_opsi',$data);
	}
	public function get_kode_nota()
	{
		$nomor_nota = $this->input->post('nomor_nota');
		$query = $this->db->get_where('transaksi_po',array('nomor_nota' => $nomor_nota, 'tanggal_input'=> date('Y-m-d') ))->num_rows();

		if($query > 0){
			echo "1";
		}
		else{
			echo "0";
		}
	}

	public function get_bahan()
	{
		$param = $this->input->post();
		echo $param;
		$jenis = $param['jenis_bahan'];

		if($jenis == 'bahan baku'){
			$opt = '';
			$query = $this->db->get_where('master_bahan_baku',array('kode_unit'=> 'U002'));
			$opt = '<option value="">--Pilih Bahan Baku--</option>';
			foreach ($query->result() as $key => $value) {
				$opt .= '<option value="'.$value->kode_bahan_baku.'">'.$value->nama_bahan_baku.'</option>';  
			}
			echo $opt;

		}else if ($jenis == 'bahan jadi') {
			$opt = '';
			$query = $this->db->get_where('master_bahan_jadi',array('kode_unit'=> '01'));
			$opt = '<option value="">--Pilih Bahan Jadi--</option>';
			foreach ($query->result() as $key => $value) {
				$opt .= '<option value="'.$value->kode_bahan_jadi.'">'.$value->nama_bahan_jadi.'</option>';  
			}
			echo $opt;
		}
	}
	public function get_satuan()
	{
		$kode_bahan = $this->input->post('kode_bahan');
		$jenis_bahan = $this->input->post('jenis_bahan');
		if($jenis_bahan=='bahan baku'){
			$nama_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku' => $kode_bahan));
			$hasil_bahan = $nama_bahan->row();
                #$bahan = $hasil_bahan->satuan_pembelian;
		}elseif($jenis_bahan=='bahan jadi'){
			$nama_bahan = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi' => $kode_bahan));
			$hasil_bahan = $nama_bahan->row();
            #$bahan = $hasil_bahan->satuan_stok;
		}
		echo json_encode($hasil_bahan);

	}

	public function print_ro($kode)
	{
		$session = $this->session->userdata('astrosession');
		$setting = $this->db->get('master_setting')->row();
		$po = $this->db->get_where('transaksi_ro',array('kode_ro' => $kode))->row();

		$data['kode'] = $kode;
		$data['session'] = $session;
		$data['setting'] = $setting ;
		$data['po'] = $po ;

		$data['konten'] = $this->load->view('request_order/setting/print_ro', $data, TRUE);
		//$this->load->view ('main_no_bar', $data);		
	}

	public function simpan_validasi()
	{
		$input = $this->input->post();
		$kode_ro = $input['kode_ro'];
		$get_id_petugas = $this->session->userdata('astrosession');
		

		$nama_petugas = $get_id_petugas->uname;

		$cek_validasi_ro = $this->db->get_where('opsi_transaksi_validasi_ro_temp',array('kode_ro'=>$kode_ro));
		$hasil_ro = $cek_validasi_ro->result();
		echo count($hasil_ro);
		if(count($hasil_ro)<1){
			$query_pembelian_temp = $this->db->get_where('opsi_transaksi_ro',array('kode_ro'=>$kode_ro,'jenis_bahan'=>'stok','status_validasi !='=>'selesai','status_validasi !='=>'batal'));

			$total = 0;
			foreach ($query_pembelian_temp->result() as $item){
				$data_opsi['kode_ro'] = $item->kode_ro;
				$data_opsi['kategori_bahan'] = $item->kategori_bahan;
				$data_opsi['kode_bahan'] = $item->kode_bahan;
				$data_opsi['nama_bahan'] = $item->nama_bahan;
				$data_opsi['jumlah'] = $item->jumlah;
				$data_opsi['jenis_bahan'] = $item->jenis_bahan;
				$data_opsi['kode_satuan'] = $item->kode_satuan;
				$data_opsi['nama_satuan'] = $item->nama_satuan;
				$data_opsi['keterangan'] = $item->keterangan;
				$data_opsi['position'] = $item->position;
				$data_opsi['status_validasi'] = $item->status_validasi;
			     	// $data_opsi['status'] = '0';

				$tabel_opsi_transaksi_pembelian = $this->db->insert("opsi_transaksi_validasi_ro_temp", $data_opsi);
			}

		}else{

		}

		 //    if($tabel_opsi_transaksi_pembelian){

		 //    	$data_po['kode_ro'] = $kode_ro;
		 //    	$data_po['tanggal_input'] = date('Y-m-d');
		 //    	$data_po['petugas'] = $nama_petugas;
		 //    	//$data_po['id_petugas'] = $id_petugas;
		 //    	$data_po['position'] = 'kitchen';
			// 	$insert_transaksi_po = $this->db->insert("transaksi_ro", $data_po);
			// 	$this->db->truncate('opsi_transaksi_ro_temp');
			// 	echo '0|<div class="alert alert-success">Berhasil melakukan PO.</div>';  
			// }
			// else{
			// 	echo '1|<div class="alert alert-danger">Gagal Melakukan PO (rincian barang).</div>';  
			// }		
	}

	public function print_ro_1($kode)
	{
		$session = $this->session->userdata('astrosession');
		$setting = $this->db->get('master_setting')->row();
		$po = $this->db->get_where('transaksi_ro',array('kode_ro' => $kode))->row();

		$data['kode'] = $kode;
		$data['session'] = $session;
		$data['setting'] = $setting ;
		$data['po'] = $po ;

		$data['konten'] = $this->load->view('request_order/setting/print_ro', $data, TRUE);
		//$this->load->view ('main_no_bar', $data);		
	}

	public function simpan_pembelian_sesuai()
	{
		$validasi_ke = $this->uri->segment(3);
		$tgl = date("Y-m-d");
		$no_belakang = 0;
		$this->db->select_max('kode_pembelian');
		$kode = $this->db->get_where('transaksi_pembelian',array('tanggal_pembelian'=>$tgl));
		$hasil_kode = $kode->row();

		$this->db->select('kode_pembelian');
		$kode_pembelian = $this->db->get('master_setting');
		$hasil_kode_pembelian = $kode_pembelian->row();

		if(count($hasil_kode)==0){
			$no_belakang = 1;
		}
		else{
			$pecah_kode = explode("_",$hasil_kode->kode_pembelian);
			$no_belakang = @$pecah_kode[2]+1;
		}

		$this->db->select_max('id');
		$get_max_po = $this->db->get('transaksi_pembelian');
		$max_po = $get_max_po->row();

		$this->db->where('id', $max_po->id);
		$get_po = $this->db->get('transaksi_pembelian');
		$po = $get_po->row();
		$tahun = substr(@$po->kode_pembelian, 4,4);
		if(date('Y')==$tahun){
			$nomor = substr(@$po->kode_pembelian, 9);
			$nomor = $nomor + 1;
			$string = strlen($nomor);
			if($string == 1){
				$kode_trans = 'PEM_'.date('Y').'_00000'.$nomor;
			} else if($string == 2){
				$kode_trans = 'PEM_'.date('Y').'_0000'.$nomor;
			} else if($string == 3){
				$kode_trans = 'PEM_'.date('Y').'_000'.$nomor;
			} else if($string == 4){
				$kode_trans = 'PEM_'.date('Y').'_00'.$nomor;
			} else if($string == 5){
				$kode_trans = 'PEM_'.date('Y').'_0'.$nomor;
			} else if($string == 6){
				$kode_trans = 'PEM_'.date('Y').'_'.$nomor;
			}
		} else {
			$kode_trans = 'PEM_'.date('Y').'_000001';
		}
		$kode_pembelian=@$kode_trans;

		$get_id_petugas = $this->session->userdata('astrosession');
		$id_petugas = $get_id_petugas->id;
		$nama_petugas = $get_id_petugas->uname;


		$kode_po = $this->input->post("kode_po");
		$validasi = $this->input->post("validasi_ke");
		if($validasi=='validasi2'){
			$this->db->where('validasi','validasi2');
		}
		$this->db->select('*') ;
		$query_pembelian_temp = $this->db->get_where('opsi_transaksi_po',array('kode_po'=>$kode_po));

		
		
		$grand_total_retur=0;
		$cek_all = 0;
		$cek = 0;
		$cek_tidak_sesuai = 0;
		$cek_belum_datang = 0;
		foreach ($query_pembelian_temp->result() as $item){
			$cek_all++;
			if($item->status_sesuai=='Sesuai'){
				$cek++;
			}
			if($item->status_sesuai=='Tidak Sesuai'){
				$cek++;
				$cek_tidak_sesuai = 1;
			}
			if($item->status=='Belum Datang' && $item->status_sesuai==''){
				$cek++;
				$cek_belum_datang = 1;
			}
		}
		$validasi = $this->input->post("validasi_ke");
		if($validasi=='validasi2'){
			$this->db->where('validasi','validasi2');
		}
		//$this->db->select('*') ;
		$query_po_temp = $this->db->get_where('opsi_transaksi_po',array('kode_po'=>$kode_po));
		//echo $this->db->last_query();
		
		$kode_supplier=$this->input->post("kode_supplier");
		$supplier = $this->db->get_where('master_supplier',array('kode_supplier'=>$kode_supplier));
		$hasil_supplier = $supplier->row();
		
		$total=0;
		$grand_total=0;
		foreach ($query_po_temp->result() as $item){
			if(($item->status !='Belum Datang' and $validasi!='validasi2') or ($item->status =='Belum Datang' and $validasi=='validasi2')){
				$data_opsi['kode_pembelian'] = $kode_pembelian;
				$data_opsi['kode_po'] = $kode_po;
				$data_opsi['kategori_bahan'] = $item->kategori_bahan;
				$data_opsi['kode_bahan'] = $item->kode_bahan;
				$data_opsi['nama_bahan'] = $item->nama_bahan;
				$data_opsi['jumlah'] = $item->jumlah - @$item->jumlah_retur;
				$data_opsi['jumlah_retur'] = @$item->jumlah_retur;
				$data_opsi['kode_satuan'] = $item->kode_satuan;
				$data_opsi['nama_satuan'] = $item->nama_satuan;
				$data_opsi['harga_satuan'] = $item->harga_satuan;
		     	//$data_opsi['diskon_item'] = $item->diskon_item;
				$data_opsi['kode_supplier'] = $kode_supplier;
				$data_opsi['nama_supplier'] = $hasil_supplier->nama_supplier;
				$data_opsi['subtotal'] = $item->subtotal - @$item->subtotal_retur;
				$data_opsi['subtotal_retur'] =  @$item->subtotal_retur;
				$data_opsi['position'] = 'gudang';
				$data_opsi['status'] = 'Sudah Datang' ;
				$data_opsi['status_sesuai'] = 'Sesuai' ;
				$tabel_opsi_transaksi_pembelian = $this->db->insert("opsi_transaksi_pembelian", $data_opsi);
				$grand_total +=($item->subtotal - @$item->subtotal_retur);
			}
		}
		$this->db->select_max('urut');
		$result = $this->db->get_where('transaksi_pembelian');
		$hasil = @$result->result();
		if($result->num_rows()) $no = ($hasil[0]->urut)+1;
		else $no = 1;

		if($no<10)$no = '000'.$no;
		else if($no<100)$no = '00'.$no;
		else if($no<1000)$no = '0'.$no;
		else if($no<10000)$no = ''.$no;

		$code = $no;

		$this->db->select('kode_pembelian');
		$get_kode_pembelian = $this->db->get('master_setting');
		$hasil_kode_pembelian = $get_kode_pembelian->row();

		$input['kode_transaksi'] = @$hasil_kode_pembelian->kode_pembelian."_".date("dmYhis")."_".$code;
		$input['urut'] = $no;
		$input['kode_po'] = $kode_po;
		$input['kode_pembelian'] = $kode_pembelian;
		$input['tanggal_pembelian'] = date("Y-m-d") ;
		$input['total_nominal'] = @$grand_total ;
		$input['grand_total'] = @$grand_total - @$input['diskon_rupiah'];
		$input['petugas'] = $nama_petugas ;
		$input['id_petugas'] = $id_petugas;
		$input['keterangan'] = '' ;
		$input['kode_supplier'] = $hasil_supplier->kode_supplier;
		$input['nama_supplier'] = $hasil_supplier->nama_supplier;
		$input['position'] = 'gudang' ;
		$input['status'] = 'sesuai' ;

		$tabel_transaksi_pembelian = $this->db->insert("transaksi_pembelian", $input);
		//$kode_pembelian = $this->input->post("kode_pembelian");
		
		if($cek_all == $cek){
			foreach ($query_pembelian_temp->result() as $item){

				$grand_total = $total + $item->subtotal;
				$harga_satuan = $item->harga_satuan;
				$nama_bahan = $item->nama_bahan;
				if($item->status_sesuai=='Sesuai'){
					$stok_masuk = $item->jumlah;
				} else {
					$stok_masuk = $item->jumlah - $item->jumlah_retur;
				}
				$kode_pembelian = $kode_pembelian;
				$kategori_bahan = $item->kategori_bahan;
				$kode_bahan = $item->kode_bahan;
				$nama_supplier = $hasil_supplier->nama_supplier;
				$kode_supplier = $hasil_supplier->kode_supplier;
				$kode_default = $this->db->get('setting_gudang');
				$hasil_kode_default = $kode_default->row();

				$this->db->select('*') ;
				$real_stock = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$hasil_kode_default->kode_unit));
				$stok_real = $real_stock->row()->real_stock ;
				$konversi_stok = $real_stock->row()->jumlah_dalam_satuan_pembelian;

				if($validasi_ke == 'validasi'){
					if($item->status_sesuai!=''){
						if($item->status_sesuai=='Tidak Sesuai'){
							$tdk['kode_retur'] = 'R_'.$kode_pembelian;
							$tdk['kategori_bahan'] = $real_stock->row()->nama_kategori_produk;
							$tdk['kode_bahan'] = $item->kode_bahan;
							$tdk['nama_bahan'] = $item->nama_bahan;
							$tdk['jumlah'] = $item->jumlah_retur;
							$tdk['kode_satuan'] = $item->kode_satuan;	
							$tdk['nama_satuan'] = $item->nama_satuan;	
							$tdk['harga_satuan'] = $item->harga_satuan;	
							$tdk['kode_supplier'] = $hasil_supplier->kode_supplier;
							$tdk['nama_supplier'] = $hasil_supplier->nama_supplier;
							$tdk['subtotal'] = $item->subtotal_retur;

							$grand_total_retur += $tdk['subtotal'];

							$this->db->insert('opsi_transaksi_retur', $tdk);
						}

						if(empty($stok_real)){

							$data_stok['real_stock'] = $stok_masuk * $konversi_stok;
							$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan));

							$this->db->select('kode_unit');
							$kode_default = $this->db->get('setting_gudang');
							$hasil_kode_default = $kode_default->row();
							$kode_unit = @$hasil_kode_default->kode_unit;
							$kode_rak = @$hasil_kode_default->kode_rak_default;

							$this->db->select('nama_unit');
							$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
							$hasil_master_unit = $master_unit->row();
							$nama_unit = @$hasil_master_unit->nama_unit;

							$this->db->select('nama_rak');
							$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
							$hasil_master_rak = $master_rak->row();
							$nama_rak = @$hasil_master_rak->nama_rak;

							$harga_satuan_stok = $harga_satuan / $konversi_stok;

							$stok['jenis_transaksi'] = 'pembelian' ;
							$stok['kode_transaksi'] = $kode_pembelian ;
							$stok['kategori_bahan'] = $kategori_bahan ;
							$stok['kode_bahan'] = $kode_bahan ;
							$stok['nama_bahan'] = $nama_bahan ;
							$stok['stok_keluar'] = '';
							$stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
							$stok['posisi_awal'] = 'supplier';
							$stok['posisi_akhir'] = 'gudang';
							$stok['hpp'] = $harga_satuan_stok ;
							$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
							$stok['kode_unit_tujuan'] = $kode_unit;
							$stok['nama_unit_tujuan'] = $nama_unit;
							$stok['kode_rak_tujuan'] = $kode_rak;
							$stok['nama_rak_tujuan'] = $nama_rak;
							$stok['id_petugas'] = $id_petugas;
							$stok['nama_petugas'] = $nama_petugas;
							$stok['tanggal_transaksi'] = date("Y-m-d") ;

							$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

						}
						else{
							$this->db->select('*') ;
							$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$hasil_kode_default->kode_unit));
							$jumlah_stok = $jumlah_stok->row()->real_stock ;

							$data_stok['real_stock'] = ($stok_masuk * $konversi_stok)  + $jumlah_stok;
							$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan));

							$this->db->select('kode_unit');
							$kode_default = $this->db->get('setting_gudang');
							$hasil_kode_default = $kode_default->row();
							$kode_unit = @$hasil_kode_default->kode_unit_default;
							$kode_rak = @$hasil_kode_default->kode_rak_default;

							$this->db->select('nama_unit');
							$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
							$hasil_master_unit = $master_unit->row();
							$nama_unit = @$hasil_master_unit->nama_unit;

							$this->db->select('nama_rak');
							$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
							$hasil_master_rak = $master_rak->row();
							$nama_rak = @$hasil_master_rak->nama_rak;

							$harga_satuan_stok = $harga_satuan / $konversi_stok;

							$stok['jenis_transaksi'] = 'pembelian' ;
							$stok['kode_transaksi'] = $kode_pembelian ;
							$stok['kategori_bahan'] = $kategori_bahan ;
							$stok['kode_bahan'] = $kode_bahan ;
							$stok['nama_bahan'] = $nama_bahan ;
							$stok['stok_keluar'] = '';
							$stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
							$stok['posisi_awal'] = 'supplier';
							$stok['posisi_akhir'] = 'gudang';
							$stok['hpp'] = $harga_satuan_stok ;
							$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
							$stok['kode_unit_tujuan'] = $kode_unit;
							$stok['nama_unit_tujuan'] = $nama_unit;
							$stok['kode_rak_tujuan'] = $kode_rak;
							$stok['nama_rak_tujuan'] = $nama_rak;
							$stok['id_petugas'] = $id_petugas;
							$stok['nama_petugas'] = $nama_petugas;
							$stok['tanggal_transaksi'] = date("Y-m-d") ;

							$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

						}
					}
				}
				if($validasi_ke == 'validasi2'){
					if($item->status_sesuai!='' && $item->status=="Belum Datang"){
						if($item->status_sesuai=='Tidak Sesuai'){
							$tdk['kode_retur'] = 'R_'.$kode_pembelian;
							$tdk['kategori_bahan'] = $real_stock->row()->nama_kategori_produk;
							$tdk['kode_bahan'] = $item->kode_bahan;
							$tdk['nama_bahan'] = $item->nama_bahan;
							$tdk['jumlah'] = $item->jumlah_retur;
							$tdk['kode_satuan'] = $item->kode_satuan;	
							$tdk['nama_satuan'] = $item->nama_satuan;	
							$tdk['harga_satuan'] = $item->harga_satuan;	
							$tdk['kode_supplier'] = $hasil_supplier->kode_supplier;
							$tdk['nama_supplier'] = $hasil_supplier->nama_supplier;
							$tdk['subtotal'] = $item->subtotal_retur;

							$grand_total_retur += $tdk['subtotal'];

							$this->db->insert('opsi_transaksi_retur', $tdk);
						}

						if(empty($stok_real)){

							$data_stok['real_stock'] = $stok_masuk * $konversi_stok;
							$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan));

							$this->db->select('kode_unit');
							$kode_default = $this->db->get('setting_gudang');
							$hasil_kode_default = $kode_default->row();
							$kode_unit = @$hasil_kode_default->kode_unit;
							$kode_rak = @$hasil_kode_default->kode_rak_default;

							$this->db->select('nama_unit');
							$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
							$hasil_master_unit = $master_unit->row();
							$nama_unit = @$hasil_master_unit->nama_unit;

							$this->db->select('nama_rak');
							$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
							$hasil_master_rak = $master_rak->row();
							$nama_rak = @$hasil_master_rak->nama_rak;

							$harga_satuan_stok = $harga_satuan / $konversi_stok;

							$stok['jenis_transaksi'] = 'pembelian' ;
							$stok['kode_transaksi'] = $kode_pembelian ;
							$stok['kategori_bahan'] = $kategori_bahan ;
							$stok['kode_bahan'] = $kode_bahan ;
							$stok['nama_bahan'] = $nama_bahan ;
							$stok['stok_keluar'] = '';
							$stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
							$stok['posisi_awal'] = 'supplier';
							$stok['posisi_akhir'] = 'gudang';
							$stok['hpp'] = $harga_satuan_stok ;
							$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
							$stok['kode_unit_tujuan'] = $kode_unit;
							$stok['nama_unit_tujuan'] = $nama_unit;
							$stok['kode_rak_tujuan'] = $kode_rak;
							$stok['nama_rak_tujuan'] = $nama_rak;
							$stok['id_petugas'] = $id_petugas;
							$stok['nama_petugas'] = $nama_petugas;
							$stok['tanggal_transaksi'] = date("Y-m-d") ;

							$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

						}
						else{
							$this->db->select('*') ;
							$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$hasil_kode_default->kode_unit));
							$jumlah_stok = $jumlah_stok->row()->real_stock ;

							$data_stok['real_stock'] = ($stok_masuk * $konversi_stok)  + $jumlah_stok;
							$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan));

							$this->db->select('kode_unit');
							$kode_default = $this->db->get('setting_gudang');
							$hasil_kode_default = $kode_default->row();
							$kode_unit = @$hasil_kode_default->kode_unit_default;
							$kode_rak = @$hasil_kode_default->kode_rak_default;

							$this->db->select('nama_unit');
							$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
							$hasil_master_unit = $master_unit->row();
							$nama_unit = @$hasil_master_unit->nama_unit;

							$this->db->select('nama_rak');
							$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
							$hasil_master_rak = $master_rak->row();
							$nama_rak = @$hasil_master_rak->nama_rak;

							$harga_satuan_stok = $harga_satuan / $konversi_stok;

							$stok['jenis_transaksi'] = 'pembelian' ;
							$stok['kode_transaksi'] = $kode_pembelian ;
							$stok['kategori_bahan'] = $kategori_bahan ;
							$stok['kode_bahan'] = $kode_bahan ;
							$stok['nama_bahan'] = $nama_bahan ;
							$stok['stok_keluar'] = '';
							$stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
							$stok['posisi_awal'] = 'supplier';
							$stok['posisi_akhir'] = 'gudang';
							$stok['hpp'] = $harga_satuan_stok ;
							$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
							$stok['kode_unit_tujuan'] = $kode_unit;
							$stok['nama_unit_tujuan'] = $nama_unit;
							$stok['kode_rak_tujuan'] = $kode_rak;
							$stok['nama_rak_tujuan'] = $nama_rak;
							$stok['id_petugas'] = $id_petugas;
							$stok['nama_petugas'] = $nama_petugas;
							$stok['tanggal_transaksi'] = date("Y-m-d") ;

							$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

						}
					}
				}
			}

			if($cek_tidak_sesuai==1 && $cek_belum_datang==0){
				$this->db->where('kode_pembelian', $kode_pembelian);
				$get_pembelian = $this->db->get('transaksi_pembelian');
				$hasil_pembelian = $get_pembelian->row();

				$trans_retur['kode_retur'] = 'R_'.$kode_pembelian;
				$trans_retur['tanggal_retur_keluar'] = date('Y-m-d');
				$trans_retur['nomor_nota'] = $hasil_pembelian->nomor_nota;
				$trans_retur['kode_supplier'] = $hasil_pembelian->kode_supplier;
				$trans_retur['nama_supplier'] = $hasil_pembelian->nama_supplier;
				$trans_retur['grand_total'] = $grand_total_retur;
				$trans_retur['proses_pembayaran'] = 'tunai';
				$trans_retur['status_retur'] = 'sesuai';

				$this->db->insert('transaksi_retur', $trans_retur);
			}
			//echo "cek_blum datang".$cek_belum_datang;
			if($cek_belum_datang==1){
				$sesuai['status_validasi'] = "belum divalidasi 2";
			} else{
				$sesuai['status_validasi'] = "sesuai";
				$sesuai['status'] = "selesai";
			}
			$this->db->update('transaksi_po', $sesuai, array('kode_po' => $kode_po));
			//echo $this->db->last_query();
		} else {
			echo $cek_all;
			echo $cek;
			echo '<div style="font-size:1.5em" class="alert alert-warning">Validasi Gagal</div>';
		}
	}

	public function simpan_pembelian_tidak_sesuai()
	{
		$kode_pembelian = $this->input->post("kode_pembelian");
		if($kode_pembelian){
			$object['status'] = "menunggu";
			$this->db->update('transaksi_pembelian', $object, array('kode_pembelian' => $kode_pembelian));
			echo '<div style="font-size:1.5em" class="alert alert-success">Pembelian Tidak Sesuai Berhasil</div>';
		} else {
			echo '<div style="font-size:1.5em" class="alert alert-warning">Pembelian Tidak Sesuai Gagal</div>';
		}
		
	}
	public function hapus_transaksi_pembelian()
	{
		$kode_pembelian = $this->input->post("kode_pembelian");
		if($kode_pembelian){
			$this->db->delete('transaksi_pembelian', array('kode_pembelian' => $kode_pembelian));
			$this->db->delete('opsi_transaksi_pembelian', array('kode_pembelian' => $kode_pembelian));
			echo '<div style="font-size:1.5em" class="alert alert-success">PO Berhasil dihapus</div>';
		} else {
			echo '<div style="font-size:1.5em" class="alert alert-warning">PO gagal dihapus</div>';
		}
		
	}

	public function simpan_transaksi_validasi(){
		$kode_po = $this->input->post('kode_po');

		$produk = $this->db->get_where('opsi_transaksi_pembelian',array('kode_po'=>$kode_po,'status'=>'sesuai'));
		$hasil_produk = $produk->result();

		$user = $this->session->userdata('astrosession');


		foreach($hasil_produk as $daftar){
			$master_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$daftar->kode_bahan));
			$hasil_bahan = $master_bahan->row();
			$stok['real_stock'] = $hasil_bahan->real_stock + ($daftar->jumlah * $hasil_bahan->jumlah_dalam_satuan_pembelian);
			$this->db->update('master_bahan_baku',$stok,array('kode_bahan_baku'=>$daftar->kode_bahan));

			$status_po['status'] = 'sesuai';
			$this->db->update('opsi_transaksi_po',$status_po,array('kode_po'=>$kode_po));

			$transaksi_stok_masuk['jenis_transaksi'] = "pre_order";
			$transaksi_stok_masuk['kode_transaksi'] = $daftar->kode_po;
			$transaksi_stok_masuk['kategori_bahan'] = "bahan baku";
			$transaksi_stok_masuk['kode_bahan'] = $daftar->kode_bahan;
			$transaksi_stok_masuk['nama_bahan'] = $daftar->nama_bahan;
			$transaksi_stok_masuk['stok_masuk'] = $daftar->jumlah;
			$transaksi_stok_masuk['id_petugas'] =  $user->id;
			$transaksi_stok_masuk['nama_petugas'] = $user->uname;
			$transaksi_stok_masuk['tanggal_transaksi'] = date("Y-m-d");
			$transaksi_stok_masuk['posisi_awal'] = "supplier";
			$transaksi_stok_masuk['posisi_akhir'] = "gudang";
					    # $transaksi_stok_masuk['kode_rak_tujuan'] = "102";
					     #$transaksi_stok_masuk['nama_rak_tujuan'] = "bahan baku kitchen";
			$this->db->insert('transaksi_stok',$transaksi_stok_masuk);
		}
		$status['status'] = 'valid';
		$this->db->update('transaksi_po',$status,array('kode_po'=>$kode_po)); 

		echo '<div style="font-size:1.5em" class="alert alert-success">Berhasil Validasi Pre Order.</div>';
	}

	public function simpan_item_temp()
	{
		$masukan = $this->input->post(); 
		print_r($masukan);  
		$this->db->insert('opsi_transaksi_validasi_ro_temp',$masukan);
		echo "sukses";				 				
	}

	public function get_temp_ro(){
		$id = $this->input->post('id');
		$po = $this->db->get_where('opsi_transaksi_validasi_ro_temp',array('id'=>$id));
		$hasil_po = $po->row();
		echo json_encode($hasil_po);
	}

	public function update_item_temp(){
		$update = $this->input->post();
		$this->db->update('opsi_transaksi_validasi_ro_temp',$update,array('id'=>$update['id']));
		echo "sukses";
	}
	public function hapus_bahan_opsi(){
		$id = $this->input->post('id');
		$kode_ro = $this->input->post('kode_ro');
		$get_bahan = $this->db->get_where('opsi_transaksi_validasi_ro_temp',array('id'=>$id));
		$hasil_bahan = $get_bahan->row();

		$update_status['status_validasi'] = "batal";
		$this->db->update('opsi_transaksi_ro',$update_status,array('kode_ro'=>$kode_ro,'jenis_bahan'=>'stok','kode_bahan'=>$hasil_bahan->kode_bahan));

		$this->db->delete('opsi_transaksi_validasi_ro_temp',array('id'=>$id));
	}

	public function simpan_sesuai(){
		$data = $this->input->post();

		$sesuai['status'] = 'sesuai';
		$this->db->update('opsi_transaksi_pembelian',$sesuai,array('kode_po'=>$data['kode_po'],'kode_bahan'=>$data['kode_bahan']));
	}

	public function simpan_tidak_sesuai(){
		$data = $this->input->post();

		$sesuai['status'] = 'tidak sesuai';
		$this->db->update('opsi_transaksi_pembelian',$sesuai,array('kode_po'=>$data['kode_po'],'kode_bahan'=>$data['kode_bahan']));
	}

	public function batal_po(){
		$data = $this->input->post();
		$status['status'] = "";
		$this->db->update('opsi_transaksi_pembelian',$status,array('kode_po'=>$data['kode_ro']));
		echo '<div style="font-size:1.5em" class="alert alert-success">Berhasil Membatalkan Pre Order.</div>';
	}
	public function ubah_pembelian(){
		$id = $this->input->post('id');	
		$data['status_sesuai'] = 'Tidak Sesuai';
		
		$data['jumlah_retur'] = $this->input->post('retur');

		$this->db->where('id', $id);
		$get_stretur = $this->db->get('opsi_transaksi_po');
		$hasil_stretur = $get_stretur->row();

		$data['subtotal_retur'] = $hasil_stretur->harga_satuan * $data['jumlah_retur'];

		$this->db->update('opsi_transaksi_po', $data, array('id' => $id));
	}
	public function batal_pembelian(){
		$id = $this->input->post('id');
		$this->db->where('id', $id);
		$get_otp = $this->db->get('opsi_transaksi_po');
		$otp = $get_otp->row();

		if($otp->status == 'Sudah Datang'){
			$this->db->where('kode_bahan', $otp->kode_bahan);
			$this->db->where('status', 'Belum Datang');
			$get_otp_bd = $this->db->get('opsi_transaksi_po');
			$otp_bd = $get_otp_bd->row();

			$otp_batal['jumlah'] = $otp->jumlah + $otp_bd->jumlah;
			$otp_batal['subtotal'] = $otp->subtotal + $otp_bd->subtotal;
			$otp_batal['status_sesuai'] = '';
			$update_otp_batal = $this->db->update('opsi_transaksi_po', $otp_batal, array('id' => $id));
			$delete_otp_bd = $this->db->delete('opsi_transaksi_po', array('id' => $otp_bd->id));
		} else{
			$data['status_sesuai'] = '';
			$data['jumlah_retur'] = '';
			$data['subtotal_retur'] = '';
			$this->db->update('opsi_transaksi_po', $data, array('id' => $id));
		}
	}
	public function pembelian_sesuai(){
		$id = $this->input->post('id');
		$data['status_sesuai'] = 'Sesuai';
		//$data['status'] = 'Sudah Datang';
		$this->db->update('opsi_transaksi_po', $data, array('id' => $id));
	}
	public function ubah_barang_datang(){
		$id = $this->input->post('id');

		$this->db->where('id', $id);
		$get_otp = $this->db->get('opsi_transaksi_po');
		$otp = $get_otp->row();

		$data['jumlah'] = $this->input->post('datang');
		if($otp->jenis_diskon == 'persen'){
			$diskon = (($otp->harga_satuan * $data['jumlah']) * $otp->diskon_item) / 100;
			$data['subtotal'] = ($otp->harga_satuan * $data['jumlah']) - $diskon;
		} else if($otp->jenis_diskon == 'rupiah'){
			$diskon = $otp->diskon_rupiah;
			$data['subtotal'] = ($otp->harga_satuan * $data['jumlah']) - $diskon;
		} else {
			$data['subtotal'] = ($otp->harga_satuan * $data['jumlah']);
		}
		$data['status'] = 'Sudah Datang';
		$data['status_sesuai'] = 'Sesuai';
		$this->db->update('opsi_transaksi_po', $data, array('id' => $id));

		$otp_baru['kode_po'] = $otp->kode_po;
		$otp_baru['kode_po'] = $otp->kode_po;
		$otp_baru['kategori_bahan'] = $otp->kategori_bahan;
		$otp_baru['kode_bahan'] = $otp->kode_bahan;
		$otp_baru['nama_bahan'] = $otp->nama_bahan;
		$otp_baru['jumlah'] = $this->input->post('belum_datang');
		$otp_baru['kode_satuan'] = $otp->kode_satuan;
		$otp_baru['nama_satuan'] = $otp->nama_satuan;
		$otp_baru['harga_satuan'] = $otp->harga_satuan;
		$otp_baru['jenis_diskon'] = $otp->jenis_diskon;
		$otp_baru['diskon_item'] = $otp->diskon_item;
		$otp_baru['diskon_rupiah'] = $otp->diskon_rupiah;
		// $otp_baru['kode_supplier'] = $otp->kode_supplier;
		// $otp_baru['nama_supplier'] = $otp->nama_supplier;
		if($otp->jenis_diskon == 'persen'){
			$diskon = (($otp->harga_satuan * $otp_baru['jumlah']) * $otp->diskon_item) / 100;
			$otp_baru['subtotal'] = ($otp->harga_satuan * $otp_baru['jumlah']) - $diskon;
		} else if($otp->jenis_diskon == 'rupiah'){
			$diskon = $otp->diskon_rupiah;
			$otp_baru['subtotal'] = ($otp->harga_satuan * $otp_baru['jumlah']) - $diskon;
		} else {
			$otp_baru['subtotal'] = ($otp->harga_satuan * $otp_baru['jumlah']);
		}
		$otp_baru['position'] = $otp->position;
		$otp_baru['status'] = 'Belum Datang';
		$otp_baru['validasi'] = 'validasi2';

		$insert_otp = $this->db->insert('opsi_transaksi_po', $otp_baru);
	}
}
