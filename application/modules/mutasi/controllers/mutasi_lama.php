<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi extends MY_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
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

    //------------------------------------------ view ----------------- --------------------//

    public function tabel_item_mutasi_temp($kode)
    {
        $data['aktif'] = 'stok';
        $data['kode'] = $kode;
        $this->load->view ('stok/mutasi/tabel_item_mutasi_temp',$data);     
    }


    //------------------------------------------ PROSES ----------------- --------------------//
    
    public function get_rak_unit_awal()
    {
        $param = $this->input->post();
        $unit = $param['unit_awal'];

        if($unit){
            $opt = '';
            $query = $this->db->get_where('master_rak', array('kode_unit'=>$unit));
                $opt = '<option value="">--Pilih Unit--</option>';
                foreach ($query->result() as $key => $value) {
                    $opt .= '<option value="'.$value->kode_rak.'">'.$value->nama_rak.'</option>';  
                }
            $nama = $this->db->get_where('master_unit', array('kode_unit'=>$unit));
            $nama_unit = $nama->row();
            $nama_unit = $nama_unit->nama_unit;

            echo $opt.'|'.$nama_unit;
        }
    }

    public function get_rak_unit_akhir()
    {
        $param = $this->input->post();
        $unit = $param['unit_akhir'];

        if($unit){
            $opt = '';
            $query = $this->db->get_where('master_rak', array('kode_unit'=>$unit));
                $opt = '<option value="">--Pilih Unit--</option>';
                foreach ($query->result() as $key => $value) {
                    $opt .= '<option value="'.$value->kode_rak.'">'.$value->nama_rak.'</option>';  
                }
            $nama = $this->db->get_where('master_unit', array('kode_unit'=>$unit));
            $nama_unit = $nama->row();
            $nama_unit = $nama_unit->nama_unit;

            echo $opt.'|'.$nama_unit;
        }
    }

    public function get_nama_rak_awal()
    {
        $param = $this->input->post();
        $rak_awal = $param['rak_awal'];

        if($rak_awal){
            $nama = $this->db->get_where('master_rak', array('kode_rak'=>$rak_awal));
            $nama_rak = $nama->row();
            $nama_rak = $nama_rak->nama_rak;
            echo $nama_rak;
        }
    }

    public function get_nama_rak_akhir()
    {
        $param = $this->input->post();
        $rak_akhir = $param['rak_akhir'];

        if($rak_akhir){
            $nama = $this->db->get_where('master_rak', array('kode_rak'=>$rak_akhir));
            $nama_rak = $nama->row();
            $nama_rak = $nama_rak->nama_rak;
            echo $nama_rak;
        }
    }

    public function get_bahan()
    {
        $param = $this->input->post();
        $jenis = $param['jenis_bahan'];
        $kode_unit_asal = $param['kode_unit_asal'];
        $kode_rak_asal = $param['kode_rak_asal'];

        if($jenis == 'bahan baku'){
            $opt = '';
            $query = $this->db->get_where('master_bahan_baku',array('kode_unit'=>$kode_unit_asal, 'kode_rak'=>$kode_rak_asal));
                $opt = '<option value="">--Pilih Bahan Baku--</option>';
                foreach ($query->result() as $key => $value) {
                    $opt .= '<option value="'.$value->kode_bahan_baku.'">'.$value->nama_bahan_baku.'</option>';  
                }
            echo $opt;
            
        }else if ($jenis == 'bahan jadi') {
            $opt = '';
            $query = $this->db->get_where('master_bahan_jadi',array('kode_unit'=>$kode_unit_asal, 'kode_rak'=>$kode_rak_asal));
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
        }
        echo json_encode($hasil_bahan);
    }
    
    public function simpan_item_mutasi_temp()
    {
       $masukan = $this->input->post();
        $kode_unit_asal = $masukan['kode_unit_asal'];
        $kode_rak_asal = $masukan['kode_rak_asal'];
        $kategori_bahan = $masukan['kategori_bahan'];
        $kode_bahan = $masukan['kode_bahan'];
        $jumlah = $masukan['jumlah'];

       $this->load->library('form_validation');
            $this->form_validation->set_rules('kode_mutasi', 'kode_mutasi', 'required');
            $this->form_validation->set_rules('kategori_bahan', 'Jenis Bahan', 'required');
            $this->form_validation->set_rules('kode_bahan', 'Nama Bahan', 'required');
            $this->form_validation->set_rules('jumlah', 'Qty ', 'required');
            $this->form_validation->set_rules('kode_unit_asal', 'kode_unit_asal', 'required');
            $this->form_validation->set_rules('kode_rak_asal', 'kode_rak_asal ', 'required');

        if ($this->form_validation->run() == FALSE) {
                echo "0|".warn_msg(validation_errors());
        } 
        else {
            if($kategori_bahan=='bahan baku'){
                $query = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan, 'kode_unit'=>$kode_unit_asal, 'kode_rak'=>$kode_rak_asal));
                $cek = $query->row()->real_stock;
                if($cek < $jumlah){
                    echo '0|<div class="alert alert-danger">Jumlah yang dimasukkan melebihi stok.</div>';
                }
                else{
                    unset($masukan['kode_unit_asal']);
                    unset($masukan['kode_rak_asal']);

                    $input = $this->db->insert('opsi_transaksi_mutasi_temp',$masukan);
                    echo "1|";
                }
            }
            else if ($kategori_bahan=='bahan jadi'){
                $query = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan, 'kode_unit'=>$kode_unit_asal, 'kode_rak'=>$kode_rak_asal));
                $cek = $query->row()->real_stock;
                if($cek < $jumlah){
                    echo '0|<div class="alert alert-danger">Jumlah yang dimasukkan melebihi stok.</div>';
                }
                else{
                    unset($masukan['kode_unit_asal']);
                    unset($masukan['kode_rak_asal']);
                    
                    $input = $this->db->insert('opsi_transaksi_mutasi_temp',$masukan);
                    echo "1|";
                }
            }
        }
    }

    public function get_temp_mutasi(){
        $id = $this->input->post('id');
        $mutasi = $this->db->get_where('opsi_transaksi_mutasi_temp',array('id'=>$id));
        $hasil_mutasi = $mutasi->row();
        echo json_encode($hasil_mutasi);
    }

    public function ubah_item_mutasi_temp()
    {
        $masukan = $this->input->post();
        $input = $this->db->update('opsi_transaksi_mutasi_temp',$masukan, array('id'=> $masukan['id']));
        echo "1|";

    }

    public function simpan_mutasi()
    {
        $input = $this->input->post();
        $kode_mutasi = $input['kode_mutasi'];

        $get_id_petugas = $this->session->userdata('astrosession');
        $id_petugas = $get_id_petugas->id;
        $nama_petugas = $get_id_petugas->uname;
        
                             $this->db->select('*') ;
        $query_mutasi_temp = $this->db->get_where('opsi_transaksi_mutasi_temp',array('kode_mutasi'=>$kode_mutasi));

        $total = 0;
        foreach ($query_mutasi_temp->result() as $item){
            $data_opsi['kode_mutasi'] = $item->kode_mutasi;
            $data_opsi['kategori_bahan'] = $item->kategori_bahan;
            $data_opsi['kode_bahan'] = $item->kode_bahan;
            $data_opsi['nama_bahan'] = $item->nama_bahan;
            $data_opsi['jumlah'] = $item->jumlah;

            $tabel_opsi_transaksi_mutasi = $this->db->insert("opsi_transaksi_mutasi", $data_opsi);

            $nama_bahan = $item->nama_bahan;
            $stok_mutasi = $item->jumlah;
            $kode_mutasi = $item->kode_mutasi;
            $kategori_bahan = $item->kategori_bahan;
            $kode_bahan = $item->kode_bahan;
            
            if($kategori_bahan=='bahan baku'){
                              $this->db->select('*') ;
                $cek_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan, 'kode_unit'=>$input['kode_unit_tujuan'],'kode_rak'=>$input['kode_rak_tujuan'] ));
                $hasil_cek_bahan = $cek_bahan->num_rows();
                #echo "Cek Bahan ".$hasil_cek_bahan;
                if($hasil_cek_bahan==0){
                                   $this->db->select('*') ;
                    $lihat_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan, 'kode_unit'=>$input['kode_unit_asal'],'kode_rak'=>$input['kode_rak_asal'] ));
                    $hasil_lihat_bahan = $lihat_bahan->row();
                    $jumlah_asli = $hasil_lihat_bahan->real_stock;

                    $juml_stok['real_stock'] = $jumlah_asli - $stok_mutasi ;
                    $this->db->select_sum('stok_keluar');
                    $cek_pending = $this->db->get_where('transaksi_stok',array('status'=>'pending',
                    'kode_bahan'=>$hasil_lihat_bahan->kode_bahan_baku,'kode_unit_asal'=>$input['kode_unit_tujuan'],
                    'kode_rak_asal'=>$input['kode_rak_tujuan'],'posisi_akhir'=>'klien'));
                    #echo $this->db->last_query();
                    $hasil_cek = $cek_pending->row();
                    if($hasil_cek->stok_keluar>$stok_mutasi){
                        echo "stok kurang";
                    }else{
                        $update_stok_asal = $this->db->update("master_bahan_baku", $juml_stok, array('kode_bahan_baku'=>$kode_bahan, 'kode_unit'=>$input['kode_unit_asal'],'kode_rak'=>$input['kode_rak_asal'] ));
                    
                        $data_baru['kode_bahan_baku'] = $hasil_lihat_bahan->kode_bahan_baku ;
                        $data_baru['nama_bahan_baku'] = $hasil_lihat_bahan->nama_bahan_baku ;
                        $data_baru['kode_unit'] = $input['kode_unit_tujuan'];
                        $data_baru['nama_unit'] = $input['nama_unit_tujuan'];
                        $data_baru['kode_rak'] = $input['kode_rak_tujuan'];
                        $data_baru['nama_rak'] = $input['nama_rak_tujuan'];
                        $data_baru['id_satuan_pembelian'] = $hasil_lihat_bahan->id_satuan_pembelian ;
                        $data_baru['satuan_pembelian'] = $hasil_lihat_bahan->satuan_pembelian ;
                        $data_baru['id_satuan_stok'] = $hasil_lihat_bahan->id_satuan_stok ;
                        $data_baru['satuan_stok'] = $hasil_lihat_bahan->satuan_stok ;
                        $data_baru['jumlah_dalam_satuan_pembelian'] = $hasil_lihat_bahan->jumlah_dalam_satuan_pembelian ;
                        $data_baru['stok_minimal'] = $hasil_lihat_bahan->stok_minimal ;
                        $data_baru['real_stock'] = $stok_mutasi - $hasil_cek->stok_keluar;
                        $data_baru['hpp'] = $hasil_lihat_bahan->hpp ;
                        $insert_baru = $this->db->insert("master_bahan_baku", $data_baru);
                        
                        $status['status'] = 'selesai';
                        $this->db->update('transaksi_stok',$status,array('status'=>'pending',
                    'kode_bahan'=>$hasil_lihat_bahan->kode_bahan_baku,'kode_unit_asal'=>$input['kode_unit_tujuan'],
                    'kode_rak_asal'=>$input['kode_rak_tujuan'],'posisi_akhir'=>'klien'));
                    }
                    
                        
                    
                }
                else if($hasil_cek_bahan > 0){
                                   $this->db->select('*') ;
                    $lihat_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan, 'kode_unit'=>$input['kode_unit_asal'],'kode_rak'=>$input['kode_rak_asal'] ));
                    $hasil_lihat_bahan = $lihat_bahan->row();
                    $jumlah_asli_asal = $hasil_lihat_bahan->real_stock;

                    $juml_stok['real_stock'] = $jumlah_asli_asal - $stok_mutasi ;
                    
                    $this->db->select_sum('stok_keluar');
                    $cek_pending = $this->db->get_where('transaksi_stok',array('status'=>'pending',
                    'kode_bahan'=>$hasil_lihat_bahan->kode_bahan_baku,'kode_unit_asal'=>$input['kode_unit_tujuan'],
                    'kode_rak_asal'=>$input['kode_rak_tujuan'],'posisi_akhir'=>'klien'));
                    $hasil_cek = $cek_pending->row();
                    if($hasil_cek->stok_keluar>$stok_mutasi){
                        echo "stok kurang";
                    }else{
                        $update_stok_asal = $this->db->update("master_bahan_baku", $juml_stok, array('kode_bahan_baku'=>$kode_bahan, 'kode_unit'=>$input['kode_unit_asal'],'kode_rak'=>$input['kode_rak_asal'] ));
                        
                        $this->db->select('*') ;
                        $lihat_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan, 'kode_unit'=>$input['kode_unit_tujuan'],'kode_rak'=>$input['kode_rak_tujuan'] ));
                        $hasil_lihat_bahan = $lihat_bahan->row();
                        $jumlah_asli = $hasil_lihat_bahan->real_stock;
                        #echo $this->db->last_query();
                        #$hasil_cek = $cek_pending->result();
                        $juml_stok['real_stock'] = $jumlah_asli + ($stok_mutasi - $hasil_cek->stok_keluar);
                        $update_stok_baru = $this->db->update("master_bahan_baku", $juml_stok, array('kode_bahan_baku'=>$kode_bahan, 'kode_unit'=>$input['kode_unit_tujuan'],'kode_rak'=>$input['kode_rak_tujuan'] ));

                    }
                    

                    
                }

                if(@$update_stok_asal){
                    $stok['jenis_transaksi'] = 'mutasi' ;
                    $stok['kode_transaksi'] = $kode_mutasi ;
                    $stok['kategori_bahan'] = $kategori_bahan ;
                    $stok['kode_bahan'] = $kode_bahan ;
                    $stok['nama_bahan'] = $nama_bahan ;
                    $stok['stok_keluar'] = $stok_mutasi;
                    $stok['stok_masuk'] = '' ;
                    $stok['posisi_awal'] = $input['nama_unit_asal'];
                    $stok['kode_unit_asal'] = $input['kode_unit_asal'];
                    $stok['nama_unit_asal'] = $input['nama_unit_asal'];
                    $stok['kode_rak_asal'] = $input['kode_rak_asal'];
                    $stok['nama_rak_asal'] = $input['nama_rak_asal'];
                    $stok['posisi_akhir'] = $input['nama_unit_tujuan'];
                    $stok['kode_unit_tujuan'] = $input['kode_unit_tujuan'];
                    $stok['nama_unit_tujuan'] = $input['nama_unit_tujuan'];
                    $stok['kode_rak_tujuan'] = $input['kode_rak_tujuan'];
                    $stok['nama_rak_tujuan'] = $input['nama_rak_tujuan'];
                    $stok['id_petugas'] = $id_petugas;
                    $stok['nama_petugas'] = $nama_petugas;
                    $stok['tanggal_transaksi'] = date("Y-m-d") ;

                    $transaksi_stok = $this->db->insert("transaksi_stok", $stok);

                    $stok['jenis_transaksi'] = 'mutasi' ;
                    $stok['kode_transaksi'] = $kode_mutasi ;
                    $stok['kategori_bahan'] = $kategori_bahan ;
                    $stok['kode_bahan'] = $kode_bahan ;
                    $stok['nama_bahan'] = $nama_bahan ;
                    $stok['stok_keluar'] = '';
                    $stok['stok_masuk'] = $stok_mutasi;
                    $stok['posisi_awal'] = $input['nama_unit_asal'];
                    $stok['kode_unit_asal'] = $input['kode_unit_asal'];
                    $stok['nama_unit_asal'] = $input['nama_unit_asal'];
                    $stok['kode_rak_asal'] = $input['kode_rak_asal'];
                    $stok['nama_rak_asal'] = $input['nama_rak_asal'];
                    $stok['posisi_akhir'] = $input['nama_unit_tujuan'];
                    $stok['kode_unit_tujuan'] = $input['kode_unit_tujuan'];
                    $stok['nama_unit_tujuan'] = $input['nama_unit_tujuan'];
                    $stok['kode_rak_tujuan'] = $input['kode_rak_tujuan'];
                    $stok['nama_rak_tujuan'] = $input['nama_rak_tujuan'];
                    $stok['id_petugas'] = $id_petugas;
                    $stok['nama_petugas'] = $nama_petugas;
                    $stok['tanggal_transaksi'] = date("Y-m-d") ;
                    $stok['sisa_stok'] = $stok_mutasi;

                    $transaksi_stok = $this->db->insert("transaksi_stok", $stok);

                }
                else{
                    #echo '<div class="alert alert-danger">Gagal Melakukan Mutasi (detail_Mutasi).</div>';  
                }
            }

            if($kategori_bahan=='bahan jadi'){
                              $this->db->select('*') ;
                $cek_bahan = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan, 'kode_unit'=>$input['kode_unit_tujuan'],'kode_rak'=>$input['kode_rak_tujuan'] ));
                $hasil_cek_bahan = $cek_bahan->num_rows();

                if($hasil_cek_bahan==0){
                                   $this->db->select('*') ;
                    $lihat_bahan = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan, 'kode_unit'=>$input['kode_unit_asal'],'kode_rak'=>$input['kode_rak_asal'] ));
                    $hasil_lihat_bahan = $lihat_bahan->row();
                    $jumlah_asli = $hasil_lihat_bahan->real_stock;

                    $juml_stok['real_stock'] = $jumlah_asli - $stok_mutasi ;
                    $cek_pending = $this->db->get_where('transaksi_stok',array('status'=>'pending',
                    'kode_bahan'=>$hasil_lihat_bahan->kode_bahan_jadi,'kode_unit_asal'=>$input['kode_unit_tujuan'],
                    'kode_rak_asal'=>$input['kode_rak_tujuan'],'posisi_akhir'=>'klien'));
                    #echo $this->db->last_query();
                    $hasil_cek = $cek_pending->row();
                    if($hasil_cek->stok_keluar>$stok_mutasi){
                        echo "stok kurang";
                    }else{
                       $update_stok_asal = $this->db->update("master_bahan_jadi", $juml_stok, array('kode_bahan_jadi'=>$kode_bahan, 'kode_unit'=>$input['kode_unit_asal'],'kode_rak'=>$input['kode_rak_asal'] ));
                       
                        $data_baru['kode_bahan_jadi'] = $hasil_lihat_bahan->kode_bahan_jadi ;
                        $data_baru['nama_bahan_jadi'] = $hasil_lihat_bahan->nama_bahan_jadi ;
                        $data_baru['kode_unit'] = $input['kode_unit_tujuan'];
                        $data_baru['nama_unit'] = $input['nama_unit_tujuan'];
                        $data_baru['kode_rak'] = $input['kode_rak_tujuan'];
                        $data_baru['nama_rak'] = $input['nama_rak_tujuan'];
                        $data_baru['kode_proses'] = $hasil_lihat_bahan->kode_proses ;
                        $data_baru['proses'] = $hasil_lihat_bahan->proses ;
                        $data_baru['kode_satuan_stok'] = $hasil_lihat_bahan->kode_satuan_stok ;
                        $data_baru['satuan_stok'] = $hasil_lihat_bahan->satuan_stok ;
                        $data_baru['stok_minimal'] = $hasil_lihat_bahan->stok_minimal ;
                        $data_baru['real_stock'] = $stok_mutasi - $hasil_cek->stok_keluar ;
                        $data_baru['hpp'] = $hasil_lihat_bahan->hpp ;
                        $data_baru['harga_jual'] = $hasil_lihat_bahan->harga_jual ;
                        $insert_baru = $this->db->insert("master_bahan_jadi", $data_baru);
                    
                    

                    $get_opsi_bahan_jadi = $this->db->get_where('opsi_bahan_jadi',array('kode_unit_bahan_jadi'=>$input['kode_unit_asal'],'kode_rak_bahan_jadi'=>$input['kode_rak_asal'],'kode_bahan_jadi' => $kode_bahan));
                    foreach ($get_opsi_bahan_jadi->result() as $item) {
                        $opsi_bahan_jadi_lama['kode_bahan_jadi'] = $item->kode_bahan_jadi;    
                        $opsi_bahan_jadi_lama['kode_bahan_baku'] = $item->kode_bahan_baku; 
                        $opsi_bahan_jadi_lama['nama_bahan_baku'] = $item->nama_bahan_baku;
                        $opsi_bahan_jadi_lama['kode_unit'] = $item->kode_unit;
                        $opsi_bahan_jadi_lama['nama_unit'] = $item->nama_unit;
                        $opsi_bahan_jadi_lama['kode_rak'] = $item->kode_rak;
                        $opsi_bahan_jadi_lama['nama_rak'] = $item->nama_rak;
                        $opsi_bahan_jadi_lama['kode_unit_bahan_jadi'] = $input['kode_unit_tujuan'];;
                        $opsi_bahan_jadi_lama['nama_unit_bahan_jadi'] = $input['nama_unit_tujuan'];
                        $opsi_bahan_jadi_lama['kode_rak_bahan_jadi'] = $input['kode_rak_tujuan'];
                        $opsi_bahan_jadi_lama['nama_rak_bahan_jadi'] = $input['nama_rak_tujuan']; 
                        $opsi_bahan_jadi_lama['jumlah'] = $item->jumlah;   
                        $opsi_bahan_jadi_lama['kode_satuan_stok_bahan_baku'] = $item->kode_satuan_stok_bahan_baku; 
                        $opsi_bahan_jadi_lama['satuan_stok_bahan_baku'] = $item->satuan_stok_bahan_baku;  

                        $insert_bahan_jadi_baru = $this->db->insert("opsi_bahan_jadi", $opsi_bahan_jadi_lama);  
                    }
                    
                    }
                    
                        
                    

                }
                else if($hasil_cek_bahan > 0){

                                   $this->db->select('*') ;
                    $lihat_bahan = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan, 'kode_unit'=>$input['kode_unit_asal'],'kode_rak'=>$input['kode_rak_asal'] ));
                    $hasil_lihat_bahan = $lihat_bahan->row();
                    $jumlah_asli_asal = $hasil_lihat_bahan->real_stock;

                    $juml_stok['real_stock'] = $jumlah_asli_asal - $stok_mutasi ;
                    
                    $cek_pending = $this->db->get_where('transaksi_stok',array('status'=>'pending',
                    'kode_bahan'=>$hasil_lihat_bahan->kode_bahan_jadi,'kode_unit_asal'=>$input['kode_unit_tujuan'],
                    'kode_rak_asal'=>$input['kode_rak_tujuan'],'posisi_akhir'=>'klien'));
                    #echo $this->db->last_query();
                    $hasil_cek = $cek_pending->row();
                    if($hasil_cek->stok_keluar>$stok_mutasi){
                        echo "stok kurang";
                    }else{
                        $update_stok_asal = $this->db->update("master_bahan_jadi", $juml_stok, array('kode_bahan_jadi'=>$kode_bahan, 'kode_unit'=>$input['kode_unit_asal'],'kode_rak'=>$input['kode_rak_asal'] ));
                        $this->db->select('*') ;
                        $lihat_bahan = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan, 'kode_unit'=>$input['kode_unit_tujuan'],'kode_rak'=>$input['kode_rak_tujuan'] ));
                        $hasil_lihat_bahan = $lihat_bahan->row();
                        $jumlah_asli = $hasil_lihat_bahan->real_stock;
    
                       $cek_pending = $this->db->get_where('transaksi_stok',array('status'=>'pending',
                        'kode_bahan'=>$hasil_lihat_bahan->kode_bahan_baku,'kode_unit_asal'=>$input['kode_unit_tujuan'],
                        'kode_rak_asal'=>$input['kode_rak_tujuan'],'posisi_akhir'=>'klien'));
                        #echo $this->db->last_query();
                        $hasil_cek = $cek_pending->result();
                        $juml_stok['real_stock'] = $jumlah_asli + ($stok_mutasi - $hasil_cek->stok_keluar) ;
    
                        $update_stok_baru = $this->db->update("master_bahan_jadi", $juml_stok, array('kode_bahan_jadi'=>$kode_bahan, 'kode_unit'=>$input['kode_unit_tujuan'],'kode_rak'=>$input['kode_rak_tujuan'] ));
                        $get_opsi_bahan_jadi = $this->db->get_where('opsi_bahan_jadi',array('kode_unit_bahan_jadi'=>$input['kode_unit_asal'],'kode_rak_bahan_jadi'=>$input['kode_rak_asal'],'kode_bahan_jadi' => $kode_bahan));
                    
                        foreach ($get_opsi_bahan_jadi->result() as $item) {
                        $opsi_bahan_jadi_lama['kode_bahan_jadi'] = $item->kode_bahan_jadi;    
                        $opsi_bahan_jadi_lama['kode_bahan_baku'] = $item->kode_bahan_baku; 
                        $opsi_bahan_jadi_lama['nama_bahan_baku'] = $item->nama_bahan_baku;
                        $opsi_bahan_jadi_lama['kode_unit'] = $item->kode_unit;
                        $opsi_bahan_jadi_lama['nama_unit'] = $item->nama_unit;
                        $opsi_bahan_jadi_lama['kode_rak'] = $item->kode_rak;
                        $opsi_bahan_jadi_lama['nama_rak'] = $item->nama_rak;
                        $opsi_bahan_jadi_lama['kode_unit_bahan_jadi'] = $input['kode_unit_tujuan'];;
                        $opsi_bahan_jadi_lama['nama_unit_bahan_jadi'] = $input['nama_unit_tujuan'];
                        $opsi_bahan_jadi_lama['kode_rak_bahan_jadi'] = $input['kode_rak_tujuan'];
                        $opsi_bahan_jadi_lama['nama_rak_bahan_jadi'] = $input['nama_rak_tujuan'];
                        $opsi_bahan_jadi_lama['jumlah'] = $item->jumlah;   
                        $opsi_bahan_jadi_lama['kode_satuan_stok_bahan_baku'] = $item->kode_satuan_stok_bahan_baku; 
                        $opsi_bahan_jadi_lama['satuan_stok_bahan_baku'] = $item->satuan_stok_bahan_baku;  

                        $insert_bahan_jadi_baru = $this->db->update("opsi_bahan_jadi", $opsi_bahan_jadi_lama,array('kode_unit_bahan_jadi'=>$input['kode_unit_asal'],'kode_rak_bahan_jadi'=>$input['kode_rak_asal'],'kode_bahan_jadi' => $kode_bahan));  
                        }
                    }
                    

                                   
                    

                }

                if(@$update_stok_asal){
                    $stok['jenis_transaksi'] = 'mutasi' ;
                    $stok['kode_transaksi'] = $kode_mutasi ;
                    $stok['kategori_bahan'] = $kategori_bahan ;
                    $stok['kode_bahan'] = $kode_bahan ;
                    $stok['nama_bahan'] = $nama_bahan ;
                    $stok['stok_keluar'] = $stok_mutasi;
                    $stok['stok_masuk'] = '' ;
                    $stok['posisi_awal'] = $input['nama_unit_asal'];
                    $stok['kode_unit_asal'] = $input['kode_unit_asal'];
                    $stok['nama_unit_asal'] = $input['nama_unit_asal'];
                    $stok['kode_rak_asal'] = $input['kode_rak_asal'];
                    $stok['nama_rak_asal'] = $input['nama_rak_asal'];
                    $stok['posisi_akhir'] = $input['nama_unit_tujuan'];
                    $stok['kode_unit_tujuan'] = $input['kode_unit_tujuan'];
                    $stok['nama_unit_tujuan'] = $input['nama_unit_tujuan'];
                    $stok['kode_rak_tujuan'] = $input['kode_rak_tujuan'];
                    $stok['nama_rak_tujuan'] = $input['nama_rak_tujuan'];
                    $stok['id_petugas'] = $id_petugas;
                    $stok['nama_petugas'] = $nama_petugas;
                    $stok['tanggal_transaksi'] = date("Y-m-d") ;

                    $transaksi_stok = $this->db->insert("transaksi_stok", $stok);

                    $stok['jenis_transaksi'] = 'mutasi' ;
                    $stok['kode_transaksi'] = $kode_mutasi ;
                    $stok['kategori_bahan'] = $kategori_bahan ;
                    $stok['kode_bahan'] = $kode_bahan ;
                    $stok['nama_bahan'] = $nama_bahan ;
                    $stok['stok_keluar'] = '';
                    $stok['stok_masuk'] = $stok_mutasi;
                    $stok['posisi_awal'] = $input['nama_unit_asal'];
                    $stok['kode_unit_asal'] = $input['kode_unit_asal'];
                    $stok['nama_unit_asal'] = $input['nama_unit_asal'];
                    $stok['kode_rak_asal'] = $input['kode_rak_asal'];
                    $stok['nama_rak_asal'] = $input['nama_rak_asal'];
                    $stok['posisi_akhir'] = $input['nama_unit_tujuan'];
                    $stok['kode_unit_tujuan'] = $input['kode_unit_tujuan'];
                    $stok['nama_unit_tujuan'] = $input['nama_unit_tujuan'];
                    $stok['kode_rak_tujuan'] = $input['kode_rak_tujuan'];
                    $stok['nama_rak_tujuan'] = $input['nama_rak_tujuan'];
                    $stok['id_petugas'] = $id_petugas;
                    $stok['nama_petugas'] = $nama_petugas;
                    $stok['tanggal_transaksi'] = date("Y-m-d") ;
                    $stok['sisa_stok'] = $stok_mutasi;
                    $transaksi_stok = $this->db->insert("transaksi_stok", $stok);

                }
                else{
                    echo '<div class="alert alert-danger">Gagal Melakukan Mutasi (detail_Mutasi).</div>';  
                }
            }
        }

        if(@$transaksi_stok){
            unset($input['kategori_bahan']);
            unset($input['kode_bahan']);
            unset($input['nama_bahan']);
            unset($input['jumlah']);
            unset($input['id_item_temp']);

            $input['tanggal_update'] = date("Y-m-d") ;
            $input['petugas'] = $nama_petugas ;

            $tabel_transaksi_mutasi = $this->db->insert("transaksi_mutasi", $input);
            if($tabel_transaksi_mutasi){
                echo '<div class="alert alert-success">Berhasil Melakukan Mutasi.</div>';  
                $delete_temp = $this->db->delete("opsi_transaksi_mutasi_temp", array('kode_mutasi'=>$kode_mutasi));
            }
            else{
               # echo '<div class="alert alert-danger">Gagal Melakukan Mutasi (Trx_Mutasi) .</div>';  
            }
        }
        else{
           # echo '<div class="alert alert-danger">Gagal Melakukan Mutasi (update_stok).</div>';  
        }
    }

    public function hapus_temp(){
        $id = $this->input->post('id');
        $this->db->delete('opsi_transaksi_mutasi_temp',array('id'=>$id));
    }

}
