<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class repack extends MY_Controller {

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

	public function index()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/menu_repack', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}
	public function menu()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/menu_repack', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function tambah()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/tambah_repack', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}
	public function daftar()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/daftar_repack', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}
	public function detail()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail_repack', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}
	public function get_repack_temp()
	{
		$this->load->view('setting/data_repack_temp');	
	}

	public function get_edit_data()
	{
		$id	= $this->input->post('key');
		$this->db->where('id', $id);
		$get_repack_temp = $this->db->get('opsi_transaksi_repack_temp');
		$hasil_repack = $get_repack_temp->row();

		echo json_encode($hasil_repack);
	}

	public function get_satuan()
	{
		$repack	= $this->input->post('repack');
		$this->db->where('kode_bahan_baku', $repack);
		$get_satuan = $this->db->get('master_bahan_baku');
		$hasil_satuan = $get_satuan->row();

		echo json_encode($hasil_satuan);
	}

	public function add_repack_temp()
	{
		$post = $this->input->post();

		$data['kategori_bahan'] = 'Bahan Baku';
		$data['kode_repack'] = $post['kode_repack'];
		$data['kode_produk_repack'] = $post['produk_direpack'];

		$this->db->where('kode_bahan_baku', $data['kode_produk_repack']);
		$get_produk_repack = $this->db->get('master_bahan_baku');
		$hasil_produk_repack = $get_produk_repack->row();

		$data['nama_produk_repack'] = @$hasil_produk_repack->nama_bahan_baku;
		$data['kode_bahan'] = $post['produk_hasil_repack'];

		$this->db->where('kode_bahan_baku', $data['kode_bahan']);
		$get_bahan = $this->db->get('master_bahan_baku');
		$hasil_bahan = $get_bahan->row();

		$data['nama_bahan'] = @$hasil_bahan->nama_bahan_baku;
		$data['jumlah'] = $post['qty_direpack'];
		$data['isi'] = $post['isi_direpack'];
		$data['satuan'] = $post['satuan_direpack'];
		$data['jumlah_in'] = $post['qty_hasil_repack'];
		$data['isi_in'] = $post['isi_hasil_repack'];
		$data['satuan_in'] = $post['satuan_hasil_repack'];

		$data['toleransi'] = $post['toleransi'];

		$kode_default = $this->db->get('setting_gudang');
		$hasil_unit =$kode_default->row();
		$data['kode_unit'] =$hasil_unit->kode_unit;
		$data['nama_unit'] =$hasil_unit->nama_unit;

		$this->db->where('kode_bahan_baku', $data['kode_bahan']);
		$get_stok = $this->db->get('master_bahan_baku');
		$hasil_stok = $get_stok->row();

		$cek_stok = @$hasil_stok->real_stock - $data['jumlah'];

		if($cek_stok<1){
			echo '<div class="alert alert-danger">Stok Tidak Mencukupi</div>';
		} else {
			$insert = $this->db->insert('opsi_transaksi_repack_temp', $data);
		}
	}
	public function update_repack_temp()
	{
		$post = $this->input->post();

		$id = $post['id_repack_temp'];

		$data['kategori_bahan'] = 'Bahan Baku';
		$data['kode_repack'] = $post['kode_repack'];
		$data['kode_produk_repack'] = $post['produk_direpack'];

		$this->db->where('kode_bahan_baku', $data['kode_produk_repack']);
		$get_produk_repack = $this->db->get('master_bahan_baku');
		$hasil_produk_repack = $get_produk_repack->row();

		$data['nama_produk_repack'] = @$hasil_produk_repack->nama_bahan_baku;
		$data['kode_bahan'] = $post['produk_hasil_repack'];

		$this->db->where('kode_bahan_baku', $data['kode_bahan']);
		$get_bahan = $this->db->get('master_bahan_baku');
		$hasil_bahan = $get_bahan->row();

		$data['nama_bahan'] = @$hasil_bahan->nama_bahan_baku;
		$data['jumlah'] = $post['qty_direpack'];
		$data['isi'] = $post['isi_direpack'];
		$data['satuan'] = $post['satuan_direpack'];
		$data['jumlah_in'] = $post['qty_hasil_repack'];
		$data['isi_in'] = $post['isi_hasil_repack'];
		$data['satuan_in'] = $post['satuan_hasil_repack'];

		$data['toleransi'] = $post['toleransi'];

		$kode_default = $this->db->get('setting_gudang');
		$hasil_unit =$kode_default->row();
		$data['kode_unit'] =$hasil_unit->kode_unit;
		$data['nama_unit'] =$hasil_unit->nama_unit;

		$this->db->where('kode_bahan_baku', $data['kode_bahan']);
		$get_stok = $this->db->get('master_bahan_baku');
		$hasil_stok = $get_stok->row();

		$cek_stok = @$hasil_stok->real_stock - $data['jumlah'];

		if($cek_stok<1){
			echo '<div class="alert alert-danger">Stok Tidak Mencukupi</div>';
		} else {
			$update = $this->db->update('opsi_transaksi_repack_temp', $data, array('id' => $id));
		}
	}
	public function hapus_repack_temp(){
		$kode = $this->input->post("key");
		$this->db->delete('opsi_transaksi_repack_temp', array('id' => $kode) );

		echo '<div class="alert alert-success">Sudah dihapus.</div>';            

	}
	public function simpan_repack(){
		$post = $this->input->post();
		$kode = $post['kode'];

		$data['tanggal_transaksi'] = $post['tanggal_repack'];
		$data['kode_repack'] = $post['kode'];

		$session = $this->session->userdata('astrosession');
		$data['id_petugas'] = $session->id;
		$data['petugas'] = $session->uname;

		$this->db->where('kode_repack', $kode);
		$get_temp = $this->db->get('opsi_transaksi_repack_temp');
		$hasil_temp = $get_temp->result();
		foreach ($hasil_temp as $temp) {
			$opsi_repack['kategori_bahan'] = $temp->kategori_bahan;
			$opsi_repack['kode_repack'] = $temp->kode_repack;
			$opsi_repack['kode_produk_repack'] = $temp->kode_produk_repack;
			$opsi_repack['nama_produk_repack'] = $temp->nama_produk_repack;
			$opsi_repack['kode_bahan'] = $temp->kode_bahan;
			$opsi_repack['nama_bahan'] = $temp->nama_bahan;
			$opsi_repack['jumlah'] = $temp->jumlah;
			$opsi_repack['isi'] = $temp->isi;
			$opsi_repack['satuan'] = $temp->satuan;
			$opsi_repack['jumlah_in'] = $temp->jumlah_in;
			$opsi_repack['isi_in'] = $temp->isi_in;
			$opsi_repack['satuan_in'] = $temp->satuan_in;
			$opsi_repack['toleransi'] = $temp->toleransi;
			$opsi_repack['keterangan'] = $temp->keterangan;
			$opsi_repack['kode_unit'] = $temp->kode_unit;
			$opsi_repack['nama_unit'] = $temp->nama_unit;

			$insert_opsi = $this->db->insert('opsi_transaksi_repack', $opsi_repack);

			$this->db->where('kode_bahan_baku', $temp->kode_produk_repack);
			$get_prepack = $this->db->get('master_bahan_baku');
			$hasil_prepack = $get_prepack->row();

			$this->db->where('kode_bahan_baku', $temp->kode_bahan);
			$get_stok = $this->db->get('master_bahan_baku');
			$hasil_stok = $get_stok->row();

			//$update_stok_bahan['real_stock'] = $hasil_stok->real_stock - ($temp->jumlah_in * $hasil_prepack->jumlah_dalam_satuan_pembelian);

			$hpp_baru = ($hasil_prepack->hpp * $temp->jumlah) / ($temp->jumlah_in * $temp->isi_in);
			$update_stok_bahan['hpp'] = $hpp_baru;
			$update_stok_bahan['real_stock'] = $hasil_stok->real_stock + $temp->jumlah_in;

			$update_stok = $this->db->update('master_bahan_baku', $update_stok_bahan, array('kode_bahan_baku' => $temp->kode_bahan));

			$this->db->where('kode_bahan_baku', $temp->kode_produk_repack);
			$get_stok_prepack = $this->db->get('master_bahan_baku');
			$hasil_stok_prepack = $get_stok_prepack->row();

			$update_stok_prepack['real_stock'] = $hasil_stok_prepack->real_stock - $temp->jumlah;

			$add_stok = $this->db->update('master_bahan_baku', $update_stok_prepack, array('kode_bahan_baku' => $temp->kode_produk_repack));
		}
		$insert = $this->db->insert('transaksi_repack', $data);

		$del_temp = $this->db->delete('opsi_transaksi_repack_temp', array('kode_repack' => $data['kode_repack']));

		echo '<div class="alert alert-success">Sudah Disimpan.</div>';
	}
}
