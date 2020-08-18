<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class opname extends MY_Controller {

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
		redirect(base_url('opname/daftar_opname'));
		
	}

    //------------------------------------------ View Data Table----------------- --------------------//
	public function cari_opname(){
		$this->load->view('cari_opname');

	}
	public function cari_opname_view(){
		$this->load->view('cari_opname_view');

	}

	public function cari_validasi_opname_nominal(){
		$this->load->view('opname/setting/cari_validasi_opname_nominal');

	}

	public function cari_validasi_opname_view(){
		$this->load->view('opname/setting/cari_validasi_opname_view');

	}

	
	public function menu_stok()
	{
		$data['aktif'] = 'stok';
		$data['konten'] = $this->load->view('stok/stok/menu_stok', NULL, TRUE);
		$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function daftar_stok()
	{
		$data['aktif'] = 'stok';
		$data['konten'] = $this->load->view('stok/stok/daftar_stok', NULL, TRUE);
		$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function list_stock(){
		$kode_unit = $this->input->post('kode_unit');
		$kode_rak = $this->input->post('kode_rak');
		
		$get_stok = $this->db->query("SELECT * from master_bahan_baku where kode_rak='$kode_rak'");

		#echo $this->db->last_query();
		$table = '';
		foreach ($get_stok->result() as $key => $value) {
			$kode_bahan = $value->kode_bahan_baku; 
			$this->db->select('*, min(id) id');                       
			$get_kode_bahan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan));
			$hasil_hpp_bahan = $get_kode_bahan->row();
			$get_stok_min = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan));
			$hasil_stok_min = $get_stok_min->row();
			if ($value->real_stock <= $hasil_stok_min->stok_minimal){
				$table.='<tr class="danger">';
			}else{
				$table.='<tr>';
			}
			$table .= 
			'<td>'.$value->kode_bahan_baku.'</td>
			<td>'.$value->nama_bahan_baku.'</td>
			<td>'.$value->kode_rak.'</td>
			<td>'.$value->nama_rak.'</td>
			<td>'.$value->real_stock.'</td>
			<td>'.$value->satuan_stok.'</td>
			<td>'.format_rupiah($hasil_hpp_bahan->hpp).'</td>
			<td>'.format_rupiah($hasil_hpp_bahan->hpp * $value->real_stock).'</td>
			<td>'.get_detail_stok($kode_unit,$value->kode_rak,$value->kode_bahan_baku).'</td>		</tr>';
		}
		echo $table; 
	}

	public function detail()
	{
		$data['aktif'] = 'stok';
		$data['konten'] = $this->load->view('stok/stok/detail_stok', NULL, TRUE);
		$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function daftar_opname()
	{
		$data['aktif'] = 'opname';
		$data['konten'] = $this->load->view('opname/daftar_opname', NULL, TRUE);
		$data['halaman'] = $this->load->view('opname/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}
	public function get_table_nominal()
	{
		$kode_default = $this->db->get('setting_gudang');
		$hasil_unit =$kode_default->row();
		$param =$hasil_unit->kode_unit;
		$start = (100*$this->input->post('page'));
		$this->db->limit(100, $start);
		$get_stok = $this->db->get_where("master_bahan_baku", array('kode_unit' => $param, 'status'=>'Aktif', 'status_opname'=>'Nominal'));
		$hasil_stok = $get_stok->result_array();
		$no=$start+1;
		foreach ($hasil_stok as $item) {

			$kode_bahan = $item['kode_bahan_baku']; 
			$this->db->select_max('id');                       
			$get_kode_bahan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan,'jenis_transaksi'=>'pembelian'));
			$hasil_hpp_bahan = $get_kode_bahan->row();
              #echo $this->db->last_query();

			$get_hpp = $this->db->get_where('transaksi_stok',array('id'=>$hasil_hpp_bahan->id));
			$hasil_get_hpp = $get_hpp->row();

			$get_stok_min = $this->db->get_where('master_bahan_baku',array('id'=>$item['id']));
			$hasil_stok_min = $get_stok_min->row();
                                  //echo count($hasil_stok_min);
			?>   
			<tr <?php if($item['real_stock']<=$hasil_stok_min->stok_minimal){echo'class="danger"';}?>>
				<td><?php echo $no++;?></td>
				<td><?php echo $item['kode_bahan_baku'];?></td>
				<td><?php echo $item['nama_bahan_baku'];?></td>
				<td><?php echo $item['nama_rak'];?></td>
				<td align="right"><?php echo $item['real_stock'];?> <?php echo $item['satuan_stok'];?></td>

				<td align="center"><input type="checkbox" id="opsi_pilihan" name="bahan_opname[]" value="<?php echo $item['kode_bahan_baku']; ?>"></td>
			</tr>

			<?php 
		}
	}
	public function get_table_view()
	{
		$kode_default = $this->db->get('setting_gudang');
		$hasil_unit =$kode_default->row();
		$param =$hasil_unit->kode_unit;
		$start = (100*$this->input->post('page'));
		$this->db->limit(100, $start);
		$get_stok = $this->db->get_where("master_bahan_baku", array('kode_unit' => $param, 'status'=>'Aktif', 'status_opname'=>'View'));
		$hasil_stok = $get_stok->result_array();
		$no=$start+1;
		foreach ($hasil_stok as $item) {

			$kode_bahan = $item['kode_bahan_baku']; 
			$this->db->select_max('id');                       
			$get_kode_bahan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan,'jenis_transaksi'=>'pembelian'));
			$hasil_hpp_bahan = $get_kode_bahan->row();
              #echo $this->db->last_query();

			$get_hpp = $this->db->get_where('transaksi_stok',array('id'=>$hasil_hpp_bahan->id));
			$hasil_get_hpp = $get_hpp->row();

			$get_stok_min = $this->db->get_where('master_bahan_baku',array('id'=>$item['id']));
			$hasil_stok_min = $get_stok_min->row();
                                  //echo count($hasil_stok_min);
			?>   
			<tr <?php if($item['real_stock']<=$hasil_stok_min->stok_minimal){echo'class="danger"';}?>>
				<td><?php echo $no++;?></td>
				<td><?php echo $item['kode_bahan_baku'];?></td>
				<td><?php echo $item['nama_bahan_baku'];?></td>
				<td><?php echo $item['nama_rak'];?></td>
				<td align="right"><?php echo $item['real_stock'];?> <?php echo $item['satuan_stok'];?></td>

				<td align="center"><input type="checkbox" id="opsi_pilihan" name="bahan_opname[]" value="<?php echo $item['kode_bahan_baku']; ?>"></td>
			</tr>

			<?php }
		}
		public function daftar_opname_view()
		{
			$data['aktif'] = 'opname';
			$data['konten'] = $this->load->view('opname/daftar_opname_view', NULL, TRUE);
			$data['halaman'] = $this->load->view('opname/menu', $data, TRUE);
			$this->load->view('main', $data);		
		}

		public function tambah_opname()
		{
			$data['aktif'] = 'opname';
			$data['konten'] = $this->load->view('opname/tambah_opname', NULL, TRUE);
			$data['halaman'] = $this->load->view('opname/menu', $data, TRUE);
			$this->load->view('main', $data);		
		}
		public function tambah_opname_baru()
		{
			$data['aktif'] = 'opname';
			$data['konten'] = $this->load->view('opname/tambah_opname_baru', NULL, TRUE);
			$data['halaman'] = $this->load->view('opname/menu', $data, TRUE);
			$this->load->view('main', $data);		
		}

		public function tambah_opname_view()
		{
			$data['aktif'] = 'opname';
			$data['konten'] = $this->load->view('opname/tambah_opname_view', NULL, TRUE);
			$data['halaman'] = $this->load->view('opname/menu', $data, TRUE);
			$this->load->view('main', $data);		
		}


		public function detail_opname()
		{
			$data['aktif'] = 'opname';
			$data['konten'] = $this->load->view('opname/detail_opname', NULL, TRUE);
			$data['halaman'] = $this->load->view('opname/menu', $data, TRUE);
			$this->load->view('main', $data);		
		}

		public function tabel_temp_data_opname()
		{
		//$data['diskon'] = $this->diskon_tabel();
			$this->load->view ('opname/tabel_opname_temp');		
		}


		public function get_opname(){
			$this->load->view('opname/tabel_opname_temp');
		}
		public function get_opname_v(){
			$this->load->view('opname/tabel_opname_view_temp');
		}

		public function validasi()
		{
			$data['aktif'] = 'opname';
			$data['konten'] = $this->load->view('opname/validasi_opname', NULL, TRUE);
			$data['halaman'] = $this->load->view('opname/menu', $data, TRUE);
			$this->load->view('main', $data);		
		}
		public function validasi_view()
		{
			$data['aktif'] = 'opname';
			$data['konten'] = $this->load->view('opname/form_validasi_view', NULL, TRUE);
			$data['halaman'] = $this->load->view('opname/menu', $data, TRUE);
			$this->load->view('main', $data);		
		}
		public function daftar_validasi_nominal()
		{
			$data['aktif'] = 'opname';
			$data['konten'] = $this->load->view('opname/validasi_opname_nominal', NULL, TRUE);
			$data['halaman'] = $this->load->view('opname/menu', $data, TRUE);
			$this->load->view('main', $data);		
		}
		public function daftar_validasi_view()
		{
			$data['aktif'] = 'opname';
			$data['konten'] = $this->load->view('opname/validasi_opname_view', NULL, TRUE);
			$data['halaman'] = $this->load->view('opname/menu', $data, TRUE);
			$this->load->view('main', $data);		
		}
		public function get_jenis_filter()
		{
			$kategori_filter = $this->input->post('kategori_filter');

			if($kategori_filter=='kategori'){
				$jenis_filter = $this->db->get('master_kategori_menu');
				$hasil_jenis_filter = $jenis_filter->result();
				echo "<option value=''>Pilih Kategori Produk</option>";
				foreach ($hasil_jenis_filter as  $value) {
					echo "<option value=".$value->kode_kategori_menu.">".$value->nama_kategori_menu."</option>";
				}

			}elseif($kategori_filter=='blok'){
				$jenis_filter = $this->db->get('master_rak');
				$hasil_jenis_filter = $jenis_filter->result();
				echo "<option value=''>Pilih Blok</option>";
				foreach ($hasil_jenis_filter as  $value) {
					echo "<option value=".$value->kode_rak.">".$value->nama_rak."</option>";
				}
			}


		}
		public function simpan_opname_temp_baru()
		{
			$input=$this->input->post('bahan_opname');

			$this->db->select('kode_opname');
			$get_kode_opname = $this->db->get('master_setting');
			$hasil_kode_oopname = $get_kode_opname->row();

			$this->db->select_max('urut');
			$result = $this->db->get_where('transaksi_opname');
			$hasil = @$result->result();
			if($result->num_rows()) $no = ($hasil[0]->urut)+1;
			else $no = 1;

			if($no<10)$no = '000'.$no;
			else if($no<100)$no = '00'.$no;
			else if($no<1000)$no = '0'.$no;
			else if($no<10000)$no = ''.$no;
                  //else if($no<100000)$no = $no;
			$code = $no;

			$tgl = date("Y-m-d");
			$no_belakang = 0;
			$this->db->select_max('kode_opname');
			$kode = $this->db->get_where('transaksi_opname',array('tanggal_opname'=>$tgl));
			$hasil_kode = $kode->row();
                                        #$pecah_kode = explode("_",$hasil_kode_pembelian->kode_pembelian);
                                        #echo $pecah_kode[0];
                                        #echo $pecah_kode[2];
			$this->db->select('kode_opname');
			$kode_opname = $this->db->get('master_setting');
			$hasil_kode_opname = $kode_opname->row();

			if(count($hasil_kode)==0){
				$no_belakang = 1;
			}
			else{
				$pecah_kode = explode("_",$hasil_kode->kode_opname);
				$no_belakang = @$pecah_kode[2]+1;
			}
			foreach ($input as $value) {
			//echo $value;
				$bahan=$this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$value));
				$hasil_bahan=$bahan->row();
			//$data['kode_opname']=$hasil_kode_opname->kode_opname."_".date("dmyHis")."_".$no_belakang;
				$data['kode_bahan']=$hasil_bahan->kode_bahan_baku;
				$data['nama_bahan']=$hasil_bahan->nama_bahan_baku;
				$data['jenis_bahan']=$hasil_bahan->jenis_bahan;
				$data['kode_unit']=$hasil_bahan->kode_unit;
				$data['nama_unit']=$hasil_bahan->nama_unit;
				$data['kode_rak']=$hasil_bahan->kode_rak;
				$data['nama_rak']=$hasil_bahan->nama_rak;
				$data['stok_awal']=$hasil_bahan->real_stock;
				$data['status_opname']=$hasil_bahan->status_opname;
				echo $data['status_opname']=$hasil_bahan->status_opname;
			// $data['stok_akhir']=
			// $data['selisih']=
			// $data['status']=
			// $data['keterangan']=
				$cek_temp=$this->db->get_where('opsi_transaksi_opname_temp',array('kode_bahan'=>$hasil_bahan->kode_bahan_baku,'nama_bahan'=>$hasil_bahan->nama_bahan_baku));
				if($cek_temp->num_rows()==0){
					$this->db->insert('opsi_transaksi_opname_temp',$data);
				}else{
			//echo "truncate".$cek_temp->num_rows();
					$update['stok_awal'] = $hasil_bahan->real_stock;
					$update['stok_akhir'] ='';
					$update['selisih'] ='';
					$update['status'] ='';
					$update['kode_opname'] ='';
					$this->db->update('opsi_transaksi_opname_temp',$update,array('kode_bahan'=>$hasil_bahan->kode_bahan_baku,'nama_bahan'=>$hasil_bahan->nama_bahan_baku));
			// $this->db->truncate('opsi_transaksi_opname_temp');
			// $this->db->insert('opsi_transaksi_opname_temp',$data);
				}


			}
		}
		public function update_opname_temp(){

			$kode_bahan = $this->input->post('kode_bahan');
			$stok_akhir = $this->input->post('stok_akhir');
			$id = $this->input->post('id');
			$kode_opname = $this->input->post('kode_opname');
			$status_view = $this->input->post('status');		

			$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan));
			$jumlah_stok = $jumlah_stok->row()->real_stock ;
			$update['kode_opname']=$kode_opname;
			$update['stok_akhir']=$stok_akhir;
			$update['stok_awal'] = $jumlah_stok;
			$selisih = $jumlah_stok - $update['stok_akhir'];
			if(!empty($status_view)){
				$status=$status_view;
			}else{
				if($selisih == 0){
					$status = 'cocok';
				} elseif ($selisih > 0) {
					$status = 'kurang';
				} else {
					$status = 'lebih';
				}

			}

			$update['selisih'] = abs($selisih);
			$update['status'] = $status;

			$this->db->update('opsi_transaksi_opname_temp',$update,array('id'=>$id));
			echo "sukses";

		}
		public function simpan_item_opname_temp()
		{
			$masukan = $this->input->post();
			$jenis_bahan = $masukan['jenis_bahan'];
			$kode_unit = $masukan['kode_unit'];
			$kode_rak = $masukan['kode_rak'];

			if ($jenis_bahan == 'bahan baku') {
				$kode_bahan = $masukan['kode_bahan'];
				$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
				$jumlah_stok = $jumlah_stok->row()->real_stock ;

				$get_temp = $this->db->get_where('opsi_transaksi_opname_temp',array('kode_bahan'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
				$cek_temp=$get_temp->num_rows();
				if($cek_temp==1){
					$masukan['stok_akhir']=$get_temp->row()->stok_akhir + $masukan['stok_akhir'];
				}

				$masukan['stok_awal'] = $jumlah_stok;
				$selisih = $jumlah_stok - $masukan['stok_akhir'];

				if($selisih == 0){
					$status = 'cocok';
				} elseif ($selisih > 0) {
					$status = 'kurang';
				} else {
					$status = 'lebih';
				}

				$masukan['selisih'] = abs($selisih);
				$masukan['status'] = $status;

			} 

			if ($jenis_bahan == 'bahan jadi') {
				$kode_bahan = $masukan['kode_bahan'];
				$jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
				$jumlah_stok = $jumlah_stok->row()->real_stock ;

				$masukan['stok_awal'] = $jumlah_stok;
				$selisih = $jumlah_stok - $masukan['stok_akhir'];

				if($selisih == 0){
					$status = 'cocok';
				} elseif ($selisih > 0) {
					$status = 'kurang';
				} else {
					$status = 'lebih';
				}

				$masukan['selisih'] = abs($selisih);
				$masukan['status'] = $status;

			}
			$get_temp = $this->db->get_where('opsi_transaksi_opname_temp',array('kode_bahan'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
			$cek_temp=$get_temp->num_rows();
			if($cek_temp==1){
				$update['stok_akhir']=$masukan['stok_akhir'];
				$update['selisih']=$masukan['selisih'];
				$update['status']=$masukan['status'];
				$this->db->update( "opsi_transaksi_opname_temp", $update, array('kode_bahan'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak) );
			}else{ 

				$this->db->insert('opsi_transaksi_opname_temp',$masukan);
			}
			echo "sukses";


		}

		public function update_item_opname_temp(){
			$update = $this->input->post();
			$jenis_bahan = $update['jenis_bahan'];
			$kode_rak = $update['kode_rak'];
			$kode_unit = $this->uri->segment(4);

			if ($jenis_bahan == 'bahan baku') {
				$kode_bahan = $update['kode_bahan'];
				$kode_unit = $this->uri->segment(4);
				$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
				$jumlah_stok = $jumlah_stok->row()->real_stock ;

				$update['stok_awal'] = $jumlah_stok;
				$selisih = $jumlah_stok - $update['stok_akhir'];

				if($selisih == 0){
					$status = 'cocok';
				} elseif ($selisih > 0) {
					$status = 'kurang';
				} else {
					$status = 'lebih';
				}

				$update['selisih'] = abs($selisih);
				$update['status'] = $status;

			} 

			if ($jenis_bahan == 'bahan jadi') {
				$kode_bahan = $update['kode_bahan'];
				$kode_unit = $this->uri->segment(4);
				$jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
				$jumlah_stok = $jumlah_stok->row()->real_stock ;

				$update['stok_awal'] = $jumlah_stok;
				$selisih = $jumlah_stok - $update['stok_akhir'];

				if($selisih == 0){
					$status = 'cocok';
				} elseif ($selisih > 0) {
					$status = 'kurang';
				} else {
					$status = 'lebih';
				}

				$update['selisih'] = abs($selisih);
				$update['status'] = $status;

			}
			$this->db->update('opsi_transaksi_opname_temp',$update,array('id'=>$update['id']));
			echo "sukses";
		}

		public function simpan_opname()
		{
			$input = $this->input->post();
			$kode_opname = $input['kode_opname'];

			$this->db->select('kode_opname');
			$get_kode_opname = $this->db->get('master_setting');
			$hasil_kode_oopname = $get_kode_opname->row();

			$this->db->select_max('urut');
			$result = $this->db->get_where('transaksi_opname');
			$hasil = @$result->result();
			if($result->num_rows()) $no = ($hasil[0]->urut)+1;
			else $no = 1;

			if($no<10)$no = '000'.$no;
			else if($no<100)$no = '00'.$no;
			else if($no<1000)$no = '0'.$no;
			else if($no<10000)$no = ''.$no;
                  //else if($no<100000)$no = $no;
			$code = $no;

			$get_id_petugas = $this->session->userdata('astrosession');
			$id_petugas = $get_id_petugas->id;
			$nama_petugas = $get_id_petugas->uname;

			$this->db->select('*') ;
			$query_opname_temp = $this->db->get_where('opsi_transaksi_opname_temp',array('kode_opname'=>$kode_opname));

			$total = 0;
			foreach ($query_opname_temp->result() as $item){
				$data_opsi['kode_opname'] = $item->kode_opname;
				$data_opsi['jenis_bahan'] = $item->jenis_bahan;
				$data_opsi['kode_bahan'] = $item->kode_bahan;
				$data_opsi['nama_bahan'] = $item->nama_bahan;
				$data_opsi['kode_unit'] = $item->kode_unit;
				$data_opsi['nama_unit'] = $item->nama_unit;
				$data_opsi['kode_rak'] = $item->kode_rak;
				$data_opsi['nama_rak'] = $item->nama_rak;
				$data_opsi['stok_awal'] = $item->stok_awal;
				$data_opsi['stok_akhir'] = @$item->stok_akhir;
				$data_opsi['selisih'] = $item->selisih;
				$data_opsi['status'] = $item->status;
				$data_opsi['keterangan'] = $item->keterangan;
				$data_opsi['status_opname'] = $item->status_opname;
				$tabel_opsi_transaksi_opname = $this->db->insert("opsi_transaksi_opname", $data_opsi);


				//P. Dion
				if ($item->status == 'Tidak Cukup'){
					$update['status_view_opname'] = 'Tidak Cukup';
					$this->db->update('master_bahan_baku',$update,array('kode_bahan_baku'=>$item->kode_bahan));
					//echo $this->db->last_query();
				}
				

			}

			if($tabel_opsi_transaksi_opname){
				unset($input['jenis_bahan']);
				unset($input['status']);
				unset($input['kode_bahan']);
				unset($input['nama_bahan']);
				unset($input['stok_akhir']);
				unset($input['kode_rak']);
				unset($input['nama_rak']);
				unset($input['keterangan']);
				unset($input['id_item']);
				unset($input['id']);

				$kode_opnamee = $input['kode_opname'];

				$this->db->select('*') ;
				$query_opname_temp = $this->db->get_where('opsi_transaksi_opname_temp',array('kode_opname'=>$kode_opname));
				$opname_temp = $query_opname_temp->row();

				$kode_rak = $opname_temp->kode_rak;
				$get_rak = $this->db->get_where('master_rak',array('kode_rak'=>$kode_rak));
				$get_rak = $get_rak->row();

				$kode_unit = $get_rak->kode_unit;
				$nama_unit = $get_rak->nama_unit;


				$tgl = date("Y-m-d");
				$no_belakang = 0;
				$this->db->select_max('kode_opname');
				$kode = $this->db->get_where('transaksi_opname',array('tanggal_opname'=>$tgl));
				$hasil_kode = $kode->row();
                                        #$pecah_kode = explode("_",$hasil_kode_pembelian->kode_pembelian);
                                        #echo $pecah_kode[0];
                                        #echo $pecah_kode[2];
				$this->db->select('kode_opname');
				$kode_opname = $this->db->get('master_setting');
				$hasil_kode_opname = $kode_opname->row();

				if(count($hasil_kode)==0){
					$no_belakang = 1;
				}
				else{
					$pecah_kode = explode("_",@$hasil_kode->kode_transaksi);
					$no_belakang = @$pecah_kode[2]+1;
				}

				$input['kode_opname'] = $kode_opnamee;
				$input['tanggal_opname'] = date("Y-m-d") ;
				$input['id_petugas'] = $id_petugas ;
				$input['petugas'] = $nama_petugas ;
				$input['keterangan'] = $opname_temp->keterangan;
				$input['status_opname'] = $opname_temp->status_opname ;
				$input['kode_unit'] = $kode_unit ;
				$input['nama_unit'] = $nama_unit ;
				$input['validasi'] = '' ;
				$input['urut'] = $code;
				$input['kode_transaksi'] = $hasil_kode_opname->kode_opname."_".date("dmyHis")."_".$no_belakang;
				$tabel_transaksi_opname = $this->db->insert("transaksi_opname", $input);
				if($tabel_transaksi_opname){
					$this->db->delete( 'opsi_transaksi_opname_temp', array('kode_opname' => $kode_opnamee) );
			     //$this->db->truncate('opsi_transaksi_opname_temp');
					echo '<div class="alert alert-success">Berhasil Melakukan Opname.</div>';  
				}
				else{
					echo '<div class="alert alert-danger">Gagal Melakukan Opname (Trx_opname) .</div>';  
				}
			}
			else{
				echo '<div class="alert alert-danger">Gagal Melakukan Opname (update_stok).</div>';  
			}

		// $this->sesuaikan();
		}

		public function jangan_sesuaikan()
		{
			$param = $this->input->post();
			$kode_opname = $param['kode_opname'];

			$update['validasi'] = 'confirmed';
			$this->db->update('transaksi_opname',$update,array('kode_opname'=>$param['kode_opname']));
			echo '<div class="alert alert-success">Berhasil, tidak menyesuaikan stok opname.</div>';
		}

		public function hapus_opsi_opname(){
			$data = $this->input->post();
			$this->db->delete('opsi_transaksi_opname',array('kode_opname'=>$data['kode_opname'],
				'kode_bahan'=>$data['kode_bahan_baku'],'status_opname'=>'Nominal'));
			#echo $this->db->last_query();
		}

		public function hapus_opsi_opname_view(){
			$data = $this->input->post();
			$this->db->delete('opsi_transaksi_opname',array('kode_opname'=>$data['kode_opname'],
				'kode_bahan'=>$data['kode_bahan_baku'],'status_opname'=>'View'));
		}

		public function sesuaikan()
		{
			$param = $this->input->post();
			$kode_opname = $param['kode_opname'];
			$nominal_opname = $param['nominal_opname'];

			$get_id_petugas = $this->session->userdata('astrosession');
			$id_petugas = $get_id_petugas->id;
			$nama_petugas = $get_id_petugas->uname;

			$update['validasi'] = 'confirmed';
			$update['nominal_opname'] = $nominal_opname;
			//$update['keterangan'] = 'Dihibahkan';
			$update['keterangan'] = 'Ditindak Lanjuti';
			$update_opname = $this->db->update('transaksi_opname',$update,array('kode_opname'=>$param['kode_opname']));

			if($update_opname == TRUE){
				$data = $this->db->get_where('opsi_transaksi_opname',array('kode_opname' => $kode_opname ));
				foreach ($data->result_array() as $item) {

				//if ($item['jenis_bahan'] == 'stok') {
					if($item['status']=='kurang'){
						$stok_keluar = $item['selisih'];
						$stok_masuk = 0;

						$kode_rak = $item['kode_rak'];
	                    //$get_unit = $this->db->get_where('master_bahan_baku',array('kode_rak'=>$kode_rak));
						//$get_unit = $get_unit->row();

						$kode_unit = $item['kode_unit'];

						$kode_bahan = $item['kode_bahan'];
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

						//$data_stok['real_stock'] = $jumlah_stok - $stok_keluar;
						$data_stok['real_stock'] = $item['stok_akhir'];
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					} elseif ($item['status']=='lebih') {
						$stok_keluar = 0;
						$stok_masuk = $item['selisih'];

						$kode_rak = $item['kode_rak'];
	                    //$get_unit = $this->db->get_where('master_bahan_baku',array('kode_rak'=>$kode_rak));
						//$get_unit = $get_unit->row();

						$kode_unit = $item['kode_unit'];

						$kode_bahan = $item['kode_bahan'];
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

						//$data_stok['real_stock'] = $jumlah_stok + $stok_masuk;
						$data_stok['real_stock'] = $item['stok_akhir'];
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					} elseif ($item['status']=='cocok') {
						$stok_keluar = $stok_masuk = 0;

						$kode_rak = $item['kode_rak'];
	                    //$get_unit = $this->db->get_where('master_bahan_baku',array('kode_rak'=>$kode_rak));
						//$get_unit = $get_unit->row();

						$kode_unit = $item['kode_unit'];

						$kode_bahan = $item['kode_bahan'];
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

						//$data_stok['real_stock'] = $jumlah_stok + $stok_masuk + $stok_keluar;
						$data_stok['real_stock'] = $item['stok_akhir'];
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					}elseif($item['status']=='Cukup'){

						$stok_keluar = $stok_masuk = 0;

						$kode_rak = $item['kode_rak'];

						$kode_unit = $item['kode_unit'];

						$kode_bahan = $item['kode_bahan'];
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

						//$data_stok['real_stock'] = $jumlah_stok + $stok_masuk + $stok_keluar;
						$data_stok['real_stock'] = $item['stok_akhir'];
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					}elseif($item['status']=='Tidak Cukup'){
						$stok_keluar = $stok_masuk = 0;

						$kode_rak = $item['kode_rak'];

						$kode_unit = $item['kode_unit'];

						$kode_bahan = $item['kode_bahan'];
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

						//$data_stok['real_stock'] = $jumlah_stok + $stok_masuk + $stok_keluar;
						$data_stok['real_stock'] = $item['stok_akhir'];
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					}

					$kode_bahan = $item['kode_bahan'];

					$this->db->select('*, min(id) id');
					$harga_satuan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan));
					$harga_satuan = $harga_satuan->row()->hpp ;

					$stok['jenis_transaksi'] = 'opname' ;
					$stok['kode_transaksi'] = $kode_opname ;
					$stok['kategori_bahan'] = $item['jenis_bahan'] ;
					$stok['kode_bahan'] = $kode_bahan ;
					$stok['nama_bahan'] = $item['nama_bahan'] ;
					$stok['stok_keluar'] = $stok_keluar;
					$stok['stok_masuk'] = $stok_masuk ;
					$stok['posisi_awal'] = 'gudang';
					$stok['posisi_akhir'] = '';
					$stok['hpp'] = $harga_satuan ;
					$stok['kode_unit_asal'] = $item['kode_unit'];;
					$stok['nama_unit_asal'] = $item['nama_unit'];;
					$stok['kode_rak_asal'] = $item['kode_rak'];
					$stok['nama_rak_asal'] = $item['nama_rak'];
					$stok['id_petugas'] = $id_petugas;
					$stok['nama_petugas'] = $nama_petugas;
					$stok['tanggal_transaksi'] = date("Y-m-d") ;
				//}

				}

				$transaksi_stok = $this->db->insert("transaksi_stok", $stok);
				if($transaksi_stok == TRUE){
					$get_keuangan_sub_kategori_akun = $this->db->get_where('keuangan_sub_kategori_akun',array('kode_sub_kategori_akun'=>'1.3.1'));
					$get_keuangan_sub_kategori_akun = $get_keuangan_sub_kategori_akun->row();

					$data_keuangan['id_petugas'] = $id_petugas ;
					$data_keuangan['petugas'] = $nama_petugas ;
					$data_keuangan['kode_referensi'] = $kode_opname ;
					$data_keuangan['tanggal_transaksi'] = date("Y-m-d") ;
					$data_keuangan['keterangan'] = 'opname' ;
					$data_keuangan['nominal'] = $nominal_opname;
					$data_keuangan['kode_jenis_keuangan'] = $get_keuangan_sub_kategori_akun->kode_jenis_akun;
					$data_keuangan['nama_jenis_keuangan'] = $get_keuangan_sub_kategori_akun->nama_jenis_akun;
					$data_keuangan['kode_kategori_keuangan'] = $get_keuangan_sub_kategori_akun->kode_kategori_akun;
					$data_keuangan['nama_kategori_keuangan'] = $get_keuangan_sub_kategori_akun->nama_kategori_akun;
					$data_keuangan['kode_sub_kategori_keuangan'] = $get_keuangan_sub_kategori_akun->kode_sub_kategori_akun;
					$data_keuangan['nama_sub_kategori_keuangan'] = $get_keuangan_sub_kategori_akun->nama_sub_kategori_akun;

					$keuangan = $this->db->insert("keuangan_masuk", $data_keuangan);

					echo '<div class="alert alert-success">Berhasil, menyesuaikan stok opname.</div>';
				} else {
					echo '<div class="alert alert-danger">Gagal, menyesuaikan stok opname .</div>'; 
				}
			} else {
				echo '<div class="alert alert-danger">Gagal, update data approve.</div>'; 
			}
		}
		public function sesuaikan_view()
		{
			$param = $this->input->post();
			$kode_opname = $param['kode_opname'];
			$nominal_opname = $param['nominal_opname'];

			$get_id_petugas = $this->session->userdata('astrosession');
			$id_petugas = $get_id_petugas->id;
			$nama_petugas = $get_id_petugas->uname;

			$update['validasi'] = 'confirmed';
			$update['keterangan'] = 'Ditindak Lanjuti';
			$update['nominal_opname'] = $nominal_opname;
			$update_opname = $this->db->update('transaksi_opname',$update,array('kode_opname'=>$param['kode_opname']));

			if($update_opname == TRUE){
				$data = $this->db->get_where('opsi_transaksi_opname',array('kode_opname' => $kode_opname ));
				foreach ($data->result_array() as $item) {
					
					$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$item['kode_bahan']));
					$jumlah_stok = $jumlah_stok->row()->real_stock;
					if($jumlah_stok > @$item['stok_akhir']){

						$stok_keluar = @$item['selisih'] ;
						$stok_masuk = 0;
					}elseif ($jumlah_stok < @$item['stok_akhir']) {
						$stok_keluar = 0;
						$stok_masuk = @$item['selisih'] ;
					}else{
						$stok_keluar = $stok_masuk = 0;
					}
					$data_stok['real_stock'] = @$item['stok_akhir'];
					$data_stok['status_view_opname'] = @$item['status'];
					$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$item['kode_bahan']));

				//if ($item['jenis_bahan'] == 'stok') {
					// if($item['status']=='Tidak Cukup'){
					// 	$stok_keluar = $item['selisih'];
					// 	$stok_masuk = 0;

					// 	$kode_rak = $item['kode_rak'];
	    //                 //$get_unit = $this->db->get_where('master_bahan_baku',array('kode_rak'=>$kode_rak));
					// 	//$get_unit = $get_unit->row();

					// 	$kode_unit = $item['kode_unit'];

					// 	$kode_bahan = $item['kode_bahan'];
					// 	$this->db->select('*') ;
					// 	$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					// 	$jumlah_stok = $jumlah_stok->row()->real_stock;

					// 	$data_stok['real_stock'] = $jumlah_stok - $stok_keluar;
					// 	$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					// } elseif ($item['status']=='Lebih') {
					// 	$stok_keluar = 0;
					// 	$stok_masuk = $item['selisih'];

					// 	$kode_rak = $item['kode_rak'];
	    //                 //$get_unit = $this->db->get_where('master_bahan_baku',array('kode_rak'=>$kode_rak));
					// 	//$get_unit = $get_unit->row();

					// 	$kode_unit = $item['kode_unit'];

					// 	$kode_bahan = $item['kode_bahan'];
					// 	$this->db->select('*') ;
					// 	$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					// 	$jumlah_stok = $jumlah_stok->row()->real_stock;

					// 	$data_stok['real_stock'] = $jumlah_stok + $stok_masuk;
					// 	$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					// } elseif ($item['status']=='Cukup') {
					// 	$stok_keluar = $stok_masuk = 0;

					// 	$kode_rak = $item['kode_rak'];
	    //                 //$get_unit = $this->db->get_where('master_bahan_baku',array('kode_rak'=>$kode_rak));
					// 	//$get_unit = $get_unit->row();

					// 	$kode_unit = $item['kode_unit'];

					// 	$kode_bahan = $item['kode_bahan'];
					// 	$this->db->select('*') ;
					// 	$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					// 	$jumlah_stok = $jumlah_stok->row()->real_stock;

					// 	$data_stok['real_stock'] = $jumlah_stok + $stok_masuk + $stok_keluar;
					// 	$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					// }elseif($item['status']=='Cukup'){

					// 	$stok_keluar = $stok_masuk = 0;

					// 	$kode_rak = $item['kode_rak'];

					// 	$kode_unit = $item['kode_unit'];

					// 	$kode_bahan = $item['kode_bahan'];
					// 	$this->db->select('*') ;
					// 	$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					// 	$jumlah_stok = $jumlah_stok->row()->real_stock;

					// 	$data_stok['real_stock'] = $jumlah_stok + $stok_masuk + $stok_keluar;
					// 	$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					// }elseif($item['status']=='Tidak Cukup'){
					// 	$stok_keluar = $stok_masuk = 0;

					// 	$kode_rak = $item['kode_rak'];

					// 	$kode_unit = $item['kode_unit'];

					// 	$kode_bahan = $item['kode_bahan'];
					// 	$this->db->select('*') ;
					// 	$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					// 	$jumlah_stok = $jumlah_stok->row()->real_stock;

					// 	$data_stok['real_stock'] = $jumlah_stok + $stok_masuk + $stok_keluar;
					// 	$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					// }

					$kode_bahan = $item['kode_bahan'];

					$this->db->select('*, min(id) id');
					$harga_satuan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan));
					$harga_satuan = $harga_satuan->row()->hpp ;

					$stok['jenis_transaksi'] = 'opname' ;
					$stok['kode_transaksi'] = $kode_opname ;
					$stok['kategori_bahan'] = $item['jenis_bahan'] ;
					$stok['kode_bahan'] = $kode_bahan ;
					$stok['nama_bahan'] = $item['nama_bahan'] ;
					$stok['stok_keluar'] = $stok_keluar;
					$stok['stok_masuk'] = $stok_masuk ;
					$stok['posisi_awal'] = 'gudang';
					$stok['posisi_akhir'] = '';
					$stok['hpp'] = $harga_satuan ;
					$stok['kode_unit_asal'] = $item['kode_unit'];;
					$stok['nama_unit_asal'] = $item['nama_unit'];;
					$stok['kode_rak_asal'] = $item['kode_rak'];
					$stok['nama_rak_asal'] = $item['nama_rak'];
					$stok['id_petugas'] = $id_petugas;
					$stok['nama_petugas'] = $nama_petugas;
					$stok['tanggal_transaksi'] = date("Y-m-d") ;
				//}
					$transaksi_stok = $this->db->insert("transaksi_stok", $stok);
				}

				
				if($transaksi_stok == TRUE){
					$get_keuangan_sub_kategori_akun = $this->db->get_where('keuangan_sub_kategori_akun',array('kode_sub_kategori_akun'=>'1.3.1'));
					$get_keuangan_sub_kategori_akun = $get_keuangan_sub_kategori_akun->row();

					$data_keuangan['id_petugas'] = $id_petugas ;
					$data_keuangan['petugas'] = $nama_petugas ;
					$data_keuangan['kode_referensi'] = $kode_opname ;
					$data_keuangan['tanggal_transaksi'] = date("Y-m-d") ;
					$data_keuangan['keterangan'] = 'opname' ;
					$data_keuangan['nominal'] = $nominal_opname;
					$data_keuangan['kode_jenis_keuangan'] = $get_keuangan_sub_kategori_akun->kode_jenis_akun;
					$data_keuangan['nama_jenis_keuangan'] = $get_keuangan_sub_kategori_akun->nama_jenis_akun;
					$data_keuangan['kode_kategori_keuangan'] = $get_keuangan_sub_kategori_akun->kode_kategori_akun;
					$data_keuangan['nama_kategori_keuangan'] = $get_keuangan_sub_kategori_akun->nama_kategori_akun;
					$data_keuangan['kode_sub_kategori_keuangan'] = $get_keuangan_sub_kategori_akun->kode_sub_kategori_akun;
					$data_keuangan['nama_sub_kategori_keuangan'] = $get_keuangan_sub_kategori_akun->nama_sub_kategori_akun;

					$keuangan = $this->db->insert("keuangan_masuk", $data_keuangan);

					echo '<div class="alert alert-success">Berhasil, menyesuaikan stok opname.</div>';
				} else {
					echo '<div class="alert alert-danger">Gagal, menyesuaikan stok opname .</div>'; 
				}
			} else {
				echo '<div class="alert alert-danger">Gagal, update data approve.</div>'; 
			}
		}
		public function dihibahkan()
		{
			$param = $this->input->post();
			$kode_opname = $param['kode_opname'];

			$get_id_petugas = $this->session->userdata('astrosession');
			$id_petugas = $get_id_petugas->id;
			$nama_petugas = $get_id_petugas->uname;

			$update['validasi'] = 'confirmed';
			$update['keterangan'] = 'Dihibahkan';
			$update_opname = $this->db->update('transaksi_opname',$update,array('kode_opname'=>$param['kode_opname']));

			if($update_opname == TRUE){
				$data = $this->db->get_where('opsi_transaksi_opname',array('kode_opname' => $kode_opname ));
				foreach ($data->result_array() as $item) {

				//if ($item['jenis_bahan'] == 'stok') {
					if($item['status']=='kurang'){
						$stok_keluar = $item['selisih'];
						$stok_masuk = 0;

						$kode_rak = $item['kode_rak'];
	                    //$get_unit = $this->db->get_where('master_bahan_baku',array('kode_rak'=>$kode_rak));
						//$get_unit = $get_unit->row();

						$kode_unit = $item['kode_unit'];

						$kode_bahan = $item['kode_bahan'];
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

						//$data_stok['real_stock'] = $jumlah_stok - $stok_keluar;
						$data_stok['real_stock'] = $item['stok_akhir'];
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					} elseif ($item['status']=='lebih') {
						$stok_keluar = 0;
						$stok_masuk = $item['selisih'];

						$kode_rak = $item['kode_rak'];
	                    //$get_unit = $this->db->get_where('master_bahan_baku',array('kode_rak'=>$kode_rak));
						//$get_unit = $get_unit->row();

						$kode_unit = $item['kode_unit'];

						$kode_bahan = $item['kode_bahan'];
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

						//$data_stok['real_stock'] = $jumlah_stok + $stok_masuk;
						$data_stok['real_stock'] = $item['stok_akhir'];
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					} elseif ($item['status']=='cocok') {
						$stok_keluar = $stok_masuk = 0;

						$kode_rak = $item['kode_rak'];
	                    //$get_unit = $this->db->get_where('master_bahan_baku',array('kode_rak'=>$kode_rak));
						//$get_unit = $get_unit->row();

						$kode_unit = $item['kode_unit'];

						$kode_bahan = $item['kode_bahan'];
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

						//$data_stok['real_stock'] = $jumlah_stok + $stok_masuk + $stok_keluar;
						$data_stok['real_stock'] = $item['stok_akhir'];
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					}elseif($item['status']=='Cukup'){

						$stok_keluar = $stok_masuk = 0;

						$kode_rak = $item['kode_rak'];

						$kode_unit = $item['kode_unit'];

						$kode_bahan = $item['kode_bahan'];
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

						//$data_stok['real_stock'] = $jumlah_stok + $stok_masuk + $stok_keluar;
						$data_stok['real_stock'] = $item['stok_akhir'];
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					}elseif($item['status']=='Tidak Cukup'){
						$stok_keluar = $stok_masuk = 0;

						$kode_rak = $item['kode_rak'];

						$kode_unit = $item['kode_unit'];

						$kode_bahan = $item['kode_bahan'];
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

						//$data_stok['real_stock'] = $jumlah_stok + $stok_masuk + $stok_keluar;
						$data_stok['real_stock'] = $item['stok_akhir'];
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					}

					$kode_bahan = $item['kode_bahan'];

					$this->db->select('*, min(id) id');
					$harga_satuan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan));
					$harga_satuan = $harga_satuan->row()->hpp ;

					$stok['jenis_transaksi'] = 'opname' ;
					$stok['kode_transaksi'] = $kode_opname ;
					$stok['kategori_bahan'] = $item['jenis_bahan'] ;
					$stok['kode_bahan'] = $kode_bahan ;
					$stok['nama_bahan'] = $item['nama_bahan'] ;
					$stok['stok_keluar'] = $stok_keluar;
					$stok['stok_masuk'] = $stok_masuk ;
					$stok['posisi_awal'] = 'gudang';
					$stok['posisi_akhir'] = '';
					$stok['hpp'] = $harga_satuan ;
					$stok['kode_unit_asal'] = $item['kode_unit'];;
					$stok['nama_unit_asal'] = $item['nama_unit'];;
					$stok['kode_rak_asal'] = $item['kode_rak'];
					$stok['nama_rak_asal'] = $item['nama_rak'];
					$stok['id_petugas'] = $id_petugas;
					$stok['nama_petugas'] = $nama_petugas;
					$stok['tanggal_transaksi'] = date("Y-m-d") ;
				//}

				}

				$transaksi_stok = $this->db->insert("transaksi_stok", $stok);
				if($transaksi_stok == TRUE){
					echo '<div class="alert alert-success">Berhasil, menyesuaikan stok opname.</div>';
				} else {
					echo '<div class="alert alert-danger">Gagal, menyesuaikan stok opname .</div>'; 
				}
			} else {
				echo '<div class="alert alert-danger">Gagal, update data approve.</div>'; 
			}
		}

		public function dihibahkan_view()
		{
			$param = $this->input->post();
			$kode_opname = $param['kode_opname'];

			$get_id_petugas = $this->session->userdata('astrosession');
			$id_petugas = $get_id_petugas->id;
			$nama_petugas = $get_id_petugas->uname;
			$update['keterangan'] = 'Dihibahkan';
			$update['validasi'] = 'confirmed';
			$update_opname = $this->db->update('transaksi_opname',$update,array('kode_opname'=>$param['kode_opname']));

			if($update_opname == TRUE){
				$data = $this->db->get_where('opsi_transaksi_opname',array('kode_opname' => $kode_opname ));
				foreach ($data->result_array() as $item) {

				//if ($item['jenis_bahan'] == 'stok') {
					if($item['status']=='Tidak Cukup'){
						$stok_keluar = $item['selisih'];
						$stok_masuk = 0;

						$kode_rak = $item['kode_rak'];
	                    //$get_unit = $this->db->get_where('master_bahan_baku',array('kode_rak'=>$kode_rak));
						//$get_unit = $get_unit->row();

						$kode_unit = $item['kode_unit'];

						$kode_bahan = $item['kode_bahan'];
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

						
						$data_stok['real_stock'] = $item['stok_akhir'];
						#$data_stok['real_stock'] = $jumlah_stok - $stok_keluar;
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					} /*elseif ($item['status']=='Lebih') {
						$stok_keluar = 0;
						$stok_masuk = $item['selisih'];

						$kode_rak = $item['kode_rak'];
	                    //$get_unit = $this->db->get_where('master_bahan_baku',array('kode_rak'=>$kode_rak));
						//$get_unit = $get_unit->row();

						$kode_unit = $item['kode_unit'];

						$kode_bahan = $item['kode_bahan'];
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

						$data_stok['real_stock'] = $jumlah_stok + $stok_masuk;
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					}*/ elseif ($item['status']=='Cukup') {
						$stok_keluar = $stok_masuk = 0;

						$kode_rak = $item['kode_rak'];
	                    //$get_unit = $this->db->get_where('master_bahan_baku',array('kode_rak'=>$kode_rak));
						//$get_unit = $get_unit->row();

						$kode_unit = $item['kode_unit'];

						$kode_bahan = $item['kode_bahan'];
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

						$data_stok['real_stock'] = $item['stok_akhir'];
						#$data_stok['real_stock'] = $jumlah_stok + $stok_masuk + $stok_keluar;
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					}

					if($jumlah_stok > @$item['stok_akhir']){

						$stok_keluar = @$item['selisih'] ;
						$stok_masuk = 0;
					}elseif ($jumlah_stok < @$item['stok_akhir']) {
						$stok_keluar = 0;
						$stok_masuk = @$item['selisih'] ;
					}else{
						$stok_keluar = $stok_masuk = 0;
					}
					$kode_bahan = $item['kode_bahan'];

					$this->db->select('*, min(id) id');
					$harga_satuan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan));
					$harga_satuan = $harga_satuan->row()->hpp ;

					$stok['jenis_transaksi'] = 'opname' ;
					$stok['kode_transaksi'] = $kode_opname ;
					$stok['kategori_bahan'] = $item['jenis_bahan'] ;
					$stok['kode_bahan'] = $kode_bahan ;
					$stok['nama_bahan'] = $item['nama_bahan'] ;
					$stok['stok_keluar'] = $stok_keluar;
					$stok['stok_masuk'] = $stok_masuk ;
					$stok['posisi_awal'] = 'gudang';
					$stok['posisi_akhir'] = '';
					$stok['hpp'] = $harga_satuan ;
					$stok['kode_unit_asal'] = $item['kode_unit'];;
					$stok['nama_unit_asal'] = $item['nama_unit'];;
					$stok['kode_rak_asal'] = $item['kode_rak'];
					$stok['nama_rak_asal'] = $item['nama_rak'];
					$stok['id_petugas'] = $id_petugas;
					$stok['nama_petugas'] = $nama_petugas;
					$stok['tanggal_transaksi'] = date("Y-m-d") ;
				//}

				}

				$transaksi_stok = $this->db->insert("transaksi_stok", $stok);
				if($transaksi_stok == TRUE){
					echo '<div class="alert alert-success">Berhasil, menyesuaikan stok opname.</div>';
				} else {
					echo '<div class="alert alert-danger">Gagal, menyesuaikan stok opname .</div>'; 
				}
			} else {
				echo '<div class="alert alert-danger">Gagal, update data approve.</div>'; 
			}
		}

		public function hapus_bahan_opname_temp(){
			$id = $this->input->post('id');
			$this->db->delete('opsi_transaksi_opname_temp',array('id'=>$id));
		}

		public function get_temp_opname(){
			$id = $this->input->post('id');
			$opname = $this->db->get_where('opsi_transaksi_opname_temp',array('id'=>$id));
			$hasil_opname = $opname->row();
			echo json_encode($hasil_opname);
		}

		public function daftar_spoil()
		{
			$data['aktif'] = 'stok';
			$data['konten'] = $this->load->view('stok/stok/daftar_spoil', NULL, TRUE);
			$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
			$this->load->view('main', $data);		
		}

		public function tambah_spoil()
		{
			$data['aktif'] = 'stok';
			$data['konten'] = $this->load->view('stok/stok/tambah_spoil', NULL, TRUE);
			$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
			$this->load->view('main', $data);		
		}

		public function detail_spoil()
		{
			$data['aktif'] = 'stok';
			$data['konten'] = $this->load->view('stok/stok/detail_spoil', NULL, TRUE);
			$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
			$this->load->view('main', $data);		
		}

		public function tabel_temp_data_transaksi()
		{
		//$data['diskon'] = $this->diskon_tabel();
			$this->load->view ('stok/stok/tabel_transaksi_temp');		
		}

		public function get_spoil(){
			$this->load->view('stok/stok/tabel_transaksi_temp');
		}

		public function get_bahan()
		{
			$param = $this->input->post();
			$kode_unit = $this->uri->segment(4);
        //echo $kode_unit;
			$jenis = $param['jenis_bahan'];

			if($jenis == 'bahan baku'){
				$opt = '';
				$query = $this->db->get_where('master_bahan_baku',array('kode_unit' => $kode_unit));
				$opt = '<option value="">--Pilih Bahan Baku--</option>';
				foreach ($query->result() as $key => $value) {
					$opt .= '<option value="'.$value->kode_bahan_baku.'">'.$value->nama_bahan_baku.'</option>';  
				}
				echo $opt;

			}else if ($jenis == 'bahan jadi') {
				$opt = '';
				$query = $this->db->get_where('master_bahan_jadi',array('kode_unit' => $kode_unit));
				$opt = '<option value="">--Pilih Bahan Jadi--</option>';
				foreach ($query->result() as $key => $value) {
					$opt .= '<option value="'.$value->kode_bahan_jadi.'">'.$value->nama_bahan_jadi.'</option>';  
				}
				echo $opt;
			}
		}

		public function get_nama_bahan()
		{
			$kode_bahan = $this->input->post('kode_bahan');
			$jenis_bahan = $this->input->post('jenis_bahan');
			$kode_unit = $this->uri->segment(4);
        //echo $kode_unit;
			if($jenis_bahan=='bahan baku'){
				$nama_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku' => $kode_bahan, 'kode_unit' => $kode_unit));
				$hasil_bahan = $nama_bahan->row();
                #$bahan = $hasil_bahan->satuan_pembelian;
			}elseif($jenis_bahan=='bahan jadi'){
				$nama_bahan = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi' => $kode_bahan, 'kode_unit' => $kode_unit));
				$hasil_bahan = $nama_bahan->row();
            #$bahan = $hasil_bahan->satuan_stok;
			}
			echo json_encode($hasil_bahan);

		}

		public function simpan_item_temp()
		{
			$masukan = $this->input->post();

			$kode_bahan = $this->input->post('kode_bahan');
			$kode_unit = $this->input->post('kode_unit');
			$kode_rak = $this->input->post('kode_rak');
			$jumlah = $this->input->post('jumlah');
			$jenis_bahan = $this->input->post('jenis_bahan');

			if ($jenis_bahan == 'bahan baku') {
				$get_bahan_baku = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
				$kesalahan = 0;
				foreach ($get_bahan_baku->result() as $get_bahan_baku) {
					$kode_bahan_baku = $get_bahan_baku->kode_bahan_baku;
					$kode_unit_bahan_baku = $get_bahan_baku->kode_unit;
					$kode_rak_bahan_baku = $get_bahan_baku->kode_rak;

					$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan_baku,'kode_unit'=>$kode_unit_bahan_baku,'kode_rak'=>$kode_rak_bahan_baku));
					$jumlah_stok = $jumlah_stok->row()->real_stock ;

					if ($jumlah_stok < $jumlah) {
						$kesalahan = $kesalahan+1;
					}

				}
			} 

			if ($jenis_bahan == 'bahan jadi') {
				$get_bahan_jadi = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
				$kesalahan = 0;
				foreach ($get_bahan_jadi->result() as $get_bahan_jadi) {
					$kode_bahan_jadi = $get_bahan_jadi->kode_bahan_jadi;
					$kode_unit_bahan_jadi = $get_bahan_jadi->kode_unit;
					$kode_rak_bahan_jadi = $get_bahan_jadi->kode_rak;

					$jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan_jadi,'kode_unit'=>$kode_unit_bahan_jadi,'kode_rak'=>$kode_rak_bahan_jadi));
					$jumlah_stok = $jumlah_stok->row()->real_stock ;

					if ($jumlah_stok < $jumlah) {
						$kesalahan = $kesalahan+1;
					}

				}
			}

			if ($kesalahan > 0) {
				echo '<div class="alert alert-danger">Bahan tidak mencukupi</div>';		
			}else{
				$this->db->insert('opsi_transaksi_spoil_temp',$masukan);
				echo '<div class="alert alert-success">Berhasil menambahkan data.</div>';
			}


		}

		public function update_item_temp(){
			$update = $this->input->post();

			$kode_bahan = $this->input->post('kode_bahan');
			$kode_unit = $this->input->post('kode_unit');
			$kode_rak = $this->input->post('kode_rak');
			$jumlah = $this->input->post('jumlah');
			$jenis_bahan = $this->input->post('jenis_bahan');

			if ($jenis_bahan == 'bahan baku') {
				$get_bahan_baku = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
				$kesalahan = 0;
				foreach ($get_bahan_baku->result() as $get_bahan_baku) {
					$kode_bahan_baku = $get_bahan_baku->kode_bahan_baku;
					$kode_unit_bahan_baku = $get_bahan_baku->kode_unit;
					$kode_rak_bahan_baku = $get_bahan_baku->kode_rak;

					$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan_baku,'kode_unit'=>$kode_unit_bahan_baku,'kode_rak'=>$kode_rak_bahan_baku));
					$jumlah_stok = $jumlah_stok->row()->real_stock ;

					if ($jumlah_stok < $jumlah) {
						$kesalahan = $kesalahan+1;
					}

				}
			} 

			if ($jenis_bahan == 'bahan jadi') {
				$get_bahan_jadi = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
				$kesalahan = 0;
				foreach ($get_bahan_jadi->result() as $get_bahan_jadi) {
					$kode_bahan_jadi = $get_bahan_jadi->kode_bahan_jadi;
					$kode_unit_bahan_jadi = $get_bahan_jadi->kode_unit;
					$kode_rak_bahan_jadi = $get_bahan_jadi->kode_rak;

					$jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan_jadi,'kode_unit'=>$kode_unit_bahan_jadi,'kode_rak'=>$kode_rak_bahan_jadi));
					$jumlah_stok = $jumlah_stok->row()->real_stock ;

					if ($jumlah_stok < $jumlah) {
						$kesalahan = $kesalahan+1;
					}

				}
			}


			if ($kesalahan > 0) {
				echo '<div class="alert alert-danger">Bahan tidak mencukupi</div>';		
			}else{
				$this->db->update('opsi_transaksi_spoil_temp',$update,array('id'=>$update['id']));
				echo '<div class="alert alert-success">Berhasil menambahkan data.</div>';
			}
		}

		public function hapus_bahan_temp(){
			$id = $this->input->post('id');
			$this->db->delete('opsi_transaksi_spoil_temp',array('id'=>$id));
		}

		public function get_temp_spoil(){
			$id = $this->input->post('id');
			$spoil = $this->db->get_where('opsi_transaksi_spoil_temp',array('id'=>$id));
			$hasil_spoil = $spoil->row();
			echo json_encode($hasil_spoil);
		}

		public function simpan_spoil()
		{
			$input = $this->input->post();
			$kode_spoil = $input['kode_spoil'];

			$get_id_petugas = $this->session->userdata('astrosession');
			$id_petugas = $get_id_petugas->id;
			$nama_petugas = $get_id_petugas->uname;

			$this->db->select('*') ;
			$query_spoil_temp = $this->db->get_where('opsi_transaksi_spoil_temp',array('kode_spoil'=>$kode_spoil));

			$grand_total_harga_satuan = 0;
			foreach ($query_spoil_temp->result() as $item){
				$data_opsi['kode_spoil'] = $item->kode_spoil;
				$data_opsi['jenis_bahan'] = $item->jenis_bahan;
				$data_opsi['kode_bahan'] = $item->kode_bahan;
				$data_opsi['nama_bahan'] = $item->nama_bahan;
				$data_opsi['jumlah'] = $item->jumlah;
				$data_opsi['kode_unit'] = $item->kode_unit;
				$data_opsi['nama_unit'] = $item->nama_unit;
				$data_opsi['kode_rak'] = $item->kode_rak;
				$data_opsi['nama_rak'] = $item->nama_rak;
				$data_opsi['keterangan'] = $item->keterangan;

				$kode_spoil = $item->kode_spoil;
				$kode_bahan = $item->kode_bahan;
				$nama_bahan = $item->nama_bahan;
				$kode_unit = $item->kode_unit;
				$nama_unit = $item->nama_unit;
				$kode_rak = $item->kode_rak;
				$nama_rak = $item->nama_rak;
				$jenis_bahan = $item->jenis_bahan;
				$stok_keluar = $item->jumlah;

				if ($jenis_bahan == 'bahan baku') {
					$this->db->select('*') ;
					$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					$jumlah_stok = $jumlah_stok->row()->real_stock ;

					$data_stok['real_stock'] = $jumlah_stok - $stok_keluar;
					$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));

					$this->db->select('*, min(id) id');
					$harga_satuan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan,'jenis_transaksi'=>'pembelian'));
					$harga_satuan = $harga_satuan->row()->hpp ;

					$total_harga_satuan = $stok_keluar * $harga_satuan;

					$stok['jenis_transaksi'] = 'spoil' ;
					$stok['kode_transaksi'] = $kode_spoil ;
					$stok['kategori_bahan'] = $jenis_bahan ;
					$stok['kode_bahan'] = $kode_bahan ;
					$stok['nama_bahan'] = $nama_bahan ;
					$stok['stok_keluar'] = $stok_keluar;
					$stok['stok_masuk'] = '' ;
					$stok['posisi_awal'] = 'gudang';
					$stok['posisi_akhir'] = '';
					$stok['hpp'] = $harga_satuan ;
					$stok['kode_unit_asal'] = $kode_unit;
					$stok['nama_unit_asal'] = $nama_unit;
					$stok['kode_rak_asal'] = $kode_rak;
					$stok['nama_rak_asal'] = $nama_rak;
					$stok['id_petugas'] = $id_petugas;
					$stok['nama_petugas'] = $nama_petugas;
					$stok['tanggal_transaksi'] = date("Y-m-d") ;

					$transaksi_stok = $this->db->insert("transaksi_stok", $stok);
				} 

				if ($jenis_bahan == 'bahan jadi') {
					$this->db->select('*') ;
					$jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
					$jumlah_stok = $jumlah_stok->row()->real_stock ;

					$data_stok['real_stock'] = $jumlah_stok - $stok_keluar;
					$this->db->update('master_bahan_jadi',$data_stok,array('kode_bahan_jadi'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));

					$this->db->select('*, min(id) id');
					$harga_satuan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan));
					$harga_satuan = $harga_satuan->row()->hpp ;

					$total_harga_satuan = $stok_keluar * $harga_satuan;

					$stok['jenis_transaksi'] = 'spoil' ;
					$stok['kode_transaksi'] = $kode_spoil ;
					$stok['kategori_bahan'] = $jenis_bahan ;
					$stok['kode_bahan'] = $kode_bahan ;
					$stok['nama_bahan'] = $nama_bahan ;
					$stok['stok_keluar'] = $stok_keluar;
					$stok['stok_masuk'] = '' ;
					$stok['posisi_awal'] = 'gudang';
					$stok['posisi_akhir'] = '';
					$stok['hpp'] = $harga_satuan ;
					$stok['kode_unit_asal'] = $kode_unit;
					$stok['nama_unit_asal'] = $nama_unit;
					$stok['kode_rak_asal'] = $kode_rak;
					$stok['nama_rak_asal'] = $nama_rak;
					$stok['id_petugas'] = $id_petugas;
					$stok['nama_petugas'] = $nama_petugas;
					$stok['tanggal_transaksi'] = date("Y-m-d") ;

					$transaksi_stok = $this->db->insert("transaksi_stok", $stok);
				}

				$tabel_opsi_transaksi_spoil = $this->db->insert("opsi_transaksi_spoil", $data_opsi); 

				$grand_total_harga_satuan += $total_harga_satuan;
			}

			if($transaksi_stok){
				unset($input['jenis_bahan']);
				unset($input['kode_bahan']);
				unset($input['nama_bahan']);
				unset($input['jumlah']);
				unset($input['kode_unit_temp']);
				unset($input['kode_rak_temp']);
				unset($input['kode_rak']);
				unset($input['satuan']);
				unset($input['nama_rak']);
				unset($input['nama_satuan']);
				unset($input['id_item']);

				$kode_spoil = $input['kode_spoil'];

				$this->db->select('*') ;
				$query_spoil_temp = $this->db->get_where('opsi_transaksi_spoil_temp',array('kode_spoil'=>$kode_spoil));
				$spoil_temp = $query_spoil_temp->row();

				$input['kode_spoil'] = $kode_spoil;
				$input['tanggal_spoil'] = date("Y-m-d") ;
				$input['petugas'] = $nama_petugas ;
				$input['keterangan'] = $spoil_temp->keterangan;
				$input['kode_unit'] = $spoil_temp->kode_unit;
				$input['nama_unit'] = $spoil_temp->nama_unit;

				$tabel_transaksi_spoil = $this->db->insert("transaksi_spoil", $input);

				if($tabel_transaksi_spoil){
					$get_keuangan_sub_kategori_akun = $this->db->get_where('keuangan_sub_kategori_akun',array('kode_sub_kategori_akun'=>'2.5.1'));
					$get_keuangan_sub_kategori_akun = $get_keuangan_sub_kategori_akun->row();

					$data_keuangan['petugas'] = $nama_petugas ;
					$data_keuangan['kode_referensi'] = $kode_spoil ;
					$data_keuangan['tanggal_transaksi'] = date("Y-m-d") ;
					$data_keuangan['keterangan'] = 'spoil' ;
					$data_keuangan['nominal'] = $total_harga_satuan;
					$data_keuangan['kode_jenis_keuangan'] = $get_keuangan_sub_kategori_akun->kode_jenis_akun;
					$data_keuangan['nama_jenis_keuangan'] = $get_keuangan_sub_kategori_akun->nama_jenis_akun;
					$data_keuangan['kode_kategori_keuangan'] = $get_keuangan_sub_kategori_akun->kode_kategori_akun;
					$data_keuangan['nama_kategori_keuangan'] = $get_keuangan_sub_kategori_akun->nama_kategori_akun;
					$data_keuangan['kode_sub_kategori_keuangan'] = $get_keuangan_sub_kategori_akun->kode_sub_kategori_akun;
					$data_keuangan['nama_sub_kategori_keuangan'] = $get_keuangan_sub_kategori_akun->nama_sub_kategori_akun;

					$keuangan = $this->db->insert("keuangan_keluar", $data_keuangan);

					$this->db->truncate('opsi_transaksi_spoil_temp');

					echo '<div class="alert alert-success">Berhasil Melakukan Spoil.</div>';  
				}
				else{
					echo '<div class="alert alert-danger">Gagal Melakukan Spoil (Trx_spoil) .</div>';  
				}
			}
			else{
				echo '<div class="alert alert-danger">Gagal Melakukan Spoil (update_stok).</div>';  
			}
		}

		public function mutasi()
		{
			$data['aktif'] = 'stok';
			$data['konten'] = $this->load->view('stok/mutasi/mutasi', NULL, TRUE);
			$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
			$this->load->view('main', $data);		
		}

		public function daftar_mutasi()
		{
			$data['aktif'] = 'stok';
			$data['konten'] = $this->load->view('stok/mutasi/daftar_mutasi', NULL, TRUE);
			$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
			$this->load->view('main', $data);		
		}

		public function detail_mutasi()
		{
			$data['aktif'] = 'stok';
			$data['konten'] = $this->load->view('stok/mutasi/detail_mutasi', NULL, TRUE);
			$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
			$this->load->view('main', $data);		
		}
	//------------------------------------------ PROSES ----------------- --------------------//
		public function print_opname()
		{
			$this->load->view ('opname/print_opname');
			$html=$this->output->get_output();
			$this->load->library('dompdf_gen');
		// $this->dompdf->set_paper('A4');
			$this->dompdf->load_html($html);
			$this->dompdf->render();
			$this->dompdf->stream('opname.pdf',array('Attachment'=>0));
		}
		public function print_opname_nominal()
		{
			$this->load->view ('opname/print_opname_nominal');
			$html=$this->output->get_output();
			$this->load->library('dompdf_gen');
		// $this->dompdf->set_paper('A4');
			$this->dompdf->load_html($html);
			$this->dompdf->render();
			$this->dompdf->stream('opname.pdf',array('Attachment'=>0));
		}


	}
