<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mutasi extends MY_Controller
{

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
        if ($this->session->userdata('astrosession') == false) {
            redirect(base_url('authenticate'));
        }
        $this->load->library('form_validation');
    }

    public function index()
    {
        redirect(base_url('mutasi/daftar_mutasi'));

    }
    //------------------------------------------ View Data Table----------------- --------------------//
    public function cari_mutasi()
    {
        $this->load->view('cari_mutasi');

    }
    public function tambah_mutasi()
    {
        $data['aktif'] = 'stok';
        $data['konten'] = $this->load->view('mutasi/mutasi', null, true);
        $data['halaman'] = $this->load->view('mutasi/menu', $data, true);
        $this->load->view('main', $data);
    }

    public function daftar_mutasi()
    {
        $data['aktif'] = 'stok';
        $data['konten'] = $this->load->view('mutasi/daftar_mutasi', null, true);
        $data['halaman'] = $this->load->view('mutasi/menu', $data, true);
        $this->load->view('main', $data);
    }

    public function detail_mutasi()
    {
        $data['aktif'] = 'stok';
        $data['konten'] = $this->load->view('mutasi/detail_mutasi', null, true);
        $data['halaman'] = $this->load->view('mutasi/menu', $data, true);
        $this->load->view('main', $data);
    }
    //------------------------------------------ PROSES ----------------- --------------------//

    public function tabel_item_mutasi_temp($kode)
    {
        $data['aktif'] = 'mutasi';
        $data['kode'] = $kode;
        $this->load->view('mutasi/tabel_item_mutasi_temp', $data);
    }


    //------------------------------------------ PROSES ----------------- --------------------//

    public function get_rak_unit_awal()
    {
        $param = $this->input->post();
        $unit = $param['unit_awal'];

        if ($unit) {
            $opt = '';
            $query = $this->db->query(" SELECT * FROM master_rak where kode_unit= '$unit' and status='1' ");
            $opt = '<option value="">--Pilih Rak--</option>';
            foreach ($query->result() as $key => $value) {
                $opt .= '<option value="' . $value->kode_rak . '">' . $value->nama_rak .
                    '</option>';
            }
            $nama = $this->db->get_where('master_unit', array('kode_unit' => $unit));
            $nama_unit = $nama->row();
            $nama_unit = $nama_unit->nama_unit;

            echo $opt . '|' . $nama_unit;
        }
    }

    public function get_rak_unit_akhir()
    {
        $param = $this->input->post();
        $unit = $param['unit_akhir'];

        if ($unit) {
            $opt = '';
            $query = $this->db->get_where('master_rak', array('kode_unit' => $unit, 'status' =>
                    '1'));
            $opt = '<option value="">--Pilih Rak--</option>';
            foreach ($query->result() as $key => $value) {
                $opt .= '<option value="' . $value->kode_rak . '">' . $value->nama_rak .
                    '</option>';
            }
            $nama = $this->db->get_where('master_unit', array('kode_unit' => $unit));
            $nama_unit = $nama->row();
            $nama_unit = $nama_unit->nama_unit;

            echo $opt . '|' . $nama_unit;
        }
    }
    public function get_kategori_barang()
    {
        $param = $this->input->post('kategori_barang');
        $unit = $this->input->post('unit_awal');
        $rak_awal = $this->input->post('rak_awal');
        //$unit = $param['unit_akhir'];
        $data = $this->input->post();
        if ($param == 'bahan baku') {

            $query = $this->db->get_where('master_bahan_baku', array('kode_header_produk' =>
                    $data['produk'], 'status_produk' => 'subproduk'));
            $hasil_query = $query->result();
            if (count($hasil_query) > 0) {
                echo '<option value="">--Pilih Bahan--</option>';
                foreach ($query->result() as $key => $value) {
                    echo '<option value="' . $value->kode_bahan_baku . '">' . $value->
                        nama_bahan_baku . '</option>';
                }
                // $nama = $this->db->get_where('master_unit', array('kode_unit'=>$unit));
                // $nama_unit = $nama->row();
                // $nama_unit = $nama_unit->nama_unit;
                echo "|" . @$value->nama_bahan_baku;
            } else {
                echo '<option value="">--Tidak Memiliki Subproduk--</option>';
            }


        } elseif ($param == 'barang') {
            echo $unit;
            $query = $this->db->get_where('master_barang', array('kode_rak' => $rak_awal,
                    'position' => $unit));
            echo '<option value="">--Pilih Barang--</option>';
            foreach ($query->result() as $key => $value) {
                echo '<option value="' . $value->kode_barang . '">' . $value->nama_barang .
                    '</option>';
            }
            echo "|" . $value->nama_barang;
        }


    }

    public function get_nama_rak_awal()
    {
        $param = $this->input->post();
        $rak_awal = $param['rak_awal'];

        if ($rak_awal) {
            $nama = $this->db->get_where('master_rak', array('kode_rak' => $rak_awal));
            $nama_rak = $nama->row();
            $nama_rak = $nama_rak->nama_rak;
            echo $nama_rak;
        }
    }

    public function get_nama_rak_akhir()
    {
        $param = $this->input->post();
        $rak_akhir = $param['rak_akhir'];

        if ($rak_akhir) {
            $nama = $this->db->get_where('master_rak', array('kode_rak' => $rak_akhir));
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

        if ($jenis == 'bahan baku') {
            $opt = '';
            $query = $this->db->get_where('master_bahan_baku', array('kode_unit' => $kode_unit_asal,
                    'kode_rak' => $kode_rak_asal));
            $opt = '<option value="">--Pilih Bahan Baku--</option>';
            foreach ($query->result() as $key => $value) {
                $opt .= '<option value="' . $value->kode_bahan_baku . '">' . $value->
                    nama_bahan_baku . '</option>';
            }
            echo $opt;

        } else
            if ($jenis == 'bahan jadi') {
                $opt = '';
                $query = $this->db->get_where('master_bahan_jadi', array('kode_unit' => $kode_unit_asal,
                        'kode_rak' => $kode_rak_asal));
                $opt = '<option value="">--Pilih Bahan Jadi--</option>';
                foreach ($query->result() as $key => $value) {
                    $opt .= '<option value="' . $value->kode_bahan_jadi . '">' . $value->
                        nama_bahan_jadi . '</option>';
                }
                echo $opt;
            }
    }

    public function get_satuan()
    {
        $kode_bahan = $this->input->post('kode_bahan');
        $unit_awal = $this->input->post('unit_awal');
        //$jenis_bahan = $this->input->post('jenis_bahan');
        $kategori_barang = $this->input->post('kategori_barang');
        //echo "$kategori_barang";
        if ($kategori_barang == 'bahan baku') {
            $nama_bahan = $this->db->get_where('master_bahan_baku', array('kode_bahan_baku' =>
                    $kode_bahan));
            $hasil_bahan = $nama_bahan->row();
            #$bahan = $hasil_bahan->satuan_pembelian;
        } elseif ($kategori_barang == 'bahan jadi') {
            $nama_bahan = $this->db->get_where('master_bahan_jadi', array('kode_bahan_jadi' =>
                    $kode_bahan));
            $hasil_bahan = $nama_bahan->row();
        } elseif ($kategori_barang == 'barang') {
            $nama_barang = $this->db->get_where('master_barang', array('kode_barang' => $kode_bahan,
                    'position' => $unit_awal));
            $hasil_bahan = $nama_barang->row();
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
        $this->form_validation->set_rules('jumlah', 'Qty ', 'required');
        $this->form_validation->set_rules('kode_unit_asal', 'kode_unit_asal', 'required');
        $this->form_validation->set_rules('kode_rak_asal', 'kode_rak_asal ', 'required');

        if ($this->form_validation->run() == false) {
            echo "0|" . warn_msg(validation_errors());
        } else {
            if ($kategori_bahan == 'bahan baku') {
                if($kode_bahan!=""){
                    $query = $this->db->get_where('master_bahan_baku', array(
                    'kode_bahan_baku' => $masukan['produk'],
                    'kode_unit' => $kode_unit_asal,
                    'kode_rak' => $kode_rak_asal));
                $cek = $query->row()->real_stock;

                $cek_produk = $this->db->get_where('master_bahan_baku', array('kode_bahan_baku' =>
                        $kode_bahan));
                $hasil_produk = $cek_produk->row();
                $jml_stok = $cek * $hasil_produk->jumlah_dalam_satuan_pembelian;
                if ($jml_stok < $jumlah) {
                    echo '0|<div class="alert alert-danger">Jumlah yang dimasukkan melebihi stok.</div>';
                } else {
                    $get_temp = $this->db->get_where('opsi_transaksi_mutasi_temp', array('kode_bahan' =>
                            $kode_bahan, 'kode_unit' => $kode_unit_asal));
                    $cek_temp = $get_temp->num_rows();
                    //$masukan['jumlah']=$masukan['jumlah'].' '.$masukan['nama_satuan'];
                    $masukan['kode_unit'] = $masukan['kode_unit_asal'];
                    $masukan['nama_bahan'] = $hasil_produk->nama_bahan_baku;
                    unset($masukan['kode_unit_asal']);
                    unset($masukan['kode_rak_asal']);
                    unset($masukan['nama_satuan']);
                    unset($masukan['produk']);

                    if ($cek_temp == 1) {
                        $update['jumlah'] = $get_temp->row()->jumlah + $jumlah;
                        $this->db->update("opsi_transaksi_mutasi_temp", $update, array('kode_bahan' => $kode_bahan,
                                'kode_unit' => $kode_unit_asal));

                    } else {
                        $input = $this->db->insert('opsi_transaksi_mutasi_temp', $masukan);

                    }
                    echo "1|";
                }
                }else{
                    $query = $this->db->get_where('master_bahan_baku', array(
                    'kode_bahan_baku' => $masukan['produk'],
                    'kode_unit' => $kode_unit_asal,
                    'kode_rak' => $kode_rak_asal));
                $cek = $query->row()->real_stock;

                $cek_produk = $this->db->get_where('master_bahan_baku', array('kode_bahan_baku' =>
                        $masukan['produk']));
                $hasil_produk = $cek_produk->row();
                $jml_stok = $cek * $hasil_produk->jumlah_dalam_satuan_pembelian;
                if ($jml_stok < $jumlah) {
                    echo '0|<div class="alert alert-danger">Jumlah yang dimasukkan melebihi stok.</div>';
                } else {
                    $get_temp = $this->db->get_where('opsi_transaksi_mutasi_temp', array('kode_bahan' =>
                            $masukan['produk'], 'kode_unit' => $kode_unit_asal));
                    $cek_temp = $get_temp->num_rows();
                    //$masukan['jumlah']=$masukan['jumlah'].' '.$masukan['nama_satuan'];
                    $masukan['kode_bahan'] = $masukan['produk'];
                    $masukan['kode_unit'] = $masukan['kode_unit_asal'];
                    $masukan['nama_bahan'] = $hasil_produk->nama_bahan_baku;
                    unset($masukan['kode_unit_asal']);
                    unset($masukan['kode_rak_asal']);
                    unset($masukan['nama_satuan']);
                    unset($masukan['produk']);

                    if ($cek_temp == 1) {
                        $update['jumlah'] = $get_temp->row()->jumlah + $jumlah;
                        $this->db->update("opsi_transaksi_mutasi_temp", $update, array('kode_bahan' => $masukan['produk'],
                                'kode_unit' => $kode_unit_asal));

                    } else {
                        $input = $this->db->insert('opsi_transaksi_mutasi_temp', $masukan);

                    }
                    echo "1|";
                }
                }
                
            } else
                if ($kategori_bahan == 'bahan jadi') {
                    $query = $this->db->get_where('master_bahan_jadi', array(
                        'kode_bahan_jadi' => $kode_bahan,
                        'kode_unit' => $kode_unit_asal,
                        'kode_rak' => $kode_rak_asal));
                    $cek = $query->row()->real_stock;
                    if ($cek < $jumlah) {
                        echo '0|<div class="alert alert-danger">Jumlah yang dimasukkan melebihi stok.</div>';
                    } else {
                        $masukan['kode_unit'] = $masukan['kode_unit_asal'];
                        unset($masukan['kode_unit_asal']);
                        unset($masukan['kode_rak_asal']);
                        unset($masukan['nama_satuan']);

                        $input = $this->db->insert('opsi_transaksi_mutasi_temp', $masukan);
                        echo "1|";
                    }
                } else
                    if ($kategori_bahan == 'barang') {
                        $query = $this->db->get_where('master_barang', array(
                            'kode_barang' => $kode_bahan,
                            'position' => $kode_unit_asal,
                            'kode_rak' => $kode_rak_asal));
                        $cek = $query->row()->real_stok;

                        if ($cek < $jumlah) {
                            echo '0|<div class="alert alert-danger">Jumlah yang dimasukkan melebihi stok.</div>';
                        } else {
                            //$masukan['jumlah']=$masukan['jumlah'].' '.$masukan['nama_satuan'];
                            $get_temp = $this->db->get_where('opsi_transaksi_mutasi_temp', array('kode_bahan' =>
                                    $kode_bahan, 'kode_unit' => $kode_unit_asal));
                            $cek_temp = $get_temp->num_rows();
                            echo $cek_temp;
                            echo $this->db->last_query();
                            $masukan['kode_unit'] = $masukan['kode_unit_asal'];
                            unset($masukan['kode_unit_asal']);
                            unset($masukan['kode_rak_asal']);
                            unset($masukan['nama_satuan']);

                            if ($cek_temp == 1) {
                                $update['jumlah'] = $get_temp->row()->jumlah + $jumlah;
                                $this->db->update("opsi_transaksi_mutasi_temp", $update, array('kode_bahan' => $kode_bahan,
                                        'kode_unit' => $kode_unit_asal));

                            } else {
                                $input = $this->db->insert('opsi_transaksi_mutasi_temp', $masukan);

                            }

                            echo "1|";
                        }
                    }
        }
    }

    public function get_temp_mutasi()
    {
        $id = $this->input->post('id');
        $mutasi = $this->db->get_where('opsi_transaksi_mutasi_temp', array('id' => $id));
        $hasil_mutasi = $mutasi->row();
        echo json_encode($hasil_mutasi);
    }

    public function ubah_item_mutasi_temp()
    {

        $masukan = $this->input->post();
        $kategori_bahan = $masukan['kategori_bahan'];
        $kode_unit_asal = $masukan['unit_awal'];
        $kode_rak_asal = $masukan['rak_awal'];
        //$kategori_bahan = $masukan['kategori_bahan'];
        $kode_bahan = $masukan['kode_bahan'];
        $jumlah = $masukan['jumlah'];

        if ($kategori_bahan == 'bahan baku') {
            $query = $this->db->get_where('master_bahan_baku', array(
                'kode_bahan_baku' => $kode_bahan,
                'kode_unit' => $kode_unit_asal,
                'kode_rak' => $kode_rak_asal));
            $cek = $query->row()->real_stock;
            if ($cek < $jumlah) {
                echo '0|<div class="alert alert-danger">Jumlah yang dimasukkan melebihi stok.</div>';
            } else {
                //$masukan['jumlah']=$masukan['jumlah'].' '.$masukan['nama_satuan'];
                unset($masukan['kategori_bahan']);
                unset($masukan['unit_awal']);
                unset($masukan['rak_awal']);
                unset($masukan['kategori_barang']);
                unset($masukan['kode_bahan']);
                unset($masukan['nama_bahan']);
                $input = $this->db->update('opsi_transaksi_mutasi_temp', $masukan, array('id' =>
                        $masukan['id']));
                echo "1|";
            }
        } else
            if ($kategori_bahan == 'barang') {
                $query = $this->db->get_where('master_barang', array(
                    'kode_barang' => $kode_bahan,
                    'position' => $kode_unit_asal,
                    'kode_rak' => $kode_rak_asal));
                $cek = $query->row()->real_stok;
                if ($cek < $jumlah) {
                    echo '0|<div class="alert alert-danger">Jumlah yang dimasukkan melebihi stok.</div>';
                } else {
                    //$masukan['jumlah']=$masukan['jumlah'].' '.$masukan['nama_satuan'];
                    unset($masukan['kategori_bahan']);
                    unset($masukan['unit_awal']);
                    unset($masukan['rak_awal']);
                    unset($masukan['kategori_barang']);
                    unset($masukan['kode_bahan']);
                    unset($masukan['nama_bahan']);

                    $input = $this->db->update('opsi_transaksi_mutasi_temp', $masukan, array('id' =>
                            $masukan['id']));
                    echo "1|";
                }
            }

        //$input = $this->db->update('opsi_transaksi_mutasi_temp',$masukan, array('id'=> $masukan['id']));
        // echo "1|";

    }

    public function simpan_mutasi()
    {
        $input = $this->input->post();
        $kode_mutasi = $input['kode_mutasi'];

        $get_id_petugas = $this->session->userdata('astrosession');
        $id_petugas = $get_id_petugas->id;
        $nama_petugas = $get_id_petugas->uname;

        $this->db->select('*');
        $query_mutasi_temp = $this->db->get_where('opsi_transaksi_mutasi_temp', array('kode_mutasi' =>
                $kode_mutasi));

        $total = 0;
        foreach ($query_mutasi_temp->result() as $item) {
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

            if ($kategori_bahan == 'bahan baku') {
                $this->db->select('*');
                $cek_bahan = $this->db->get_where('master_bahan_baku', array(
                    'kode_bahan_baku' => $kode_bahan,
                    'kode_unit' => $input['kode_unit_tujuan'],
                    'kode_rak' => $input['kode_rak_tujuan']));
                $hasil_cek_bahan = $cek_bahan->num_rows();
                #echo "Cek Bahan ".$hasil_cek_bahan;
                if ($hasil_cek_bahan == 0) {
                    $cek_produk = $this->db->get_where('master_bahan_baku', array('kode_bahan_baku' =>
                            $kode_bahan));
                    $hasil_produk = $cek_produk->row();
                    if ($hasil_produk->status_produk == "produk") {
                        $this->db->select('*');
                        $lihat_bahan = $this->db->get_where('master_bahan_baku', array(
                            'kode_bahan_baku' => $hasil_produk->kode_header_produk,
                            'kode_unit' => $input['kode_unit_asal'],
                            'kode_rak' => $input['kode_rak_asal']));
                        $hasil_lihat_bahan = $lihat_bahan->row();
                        $jumlah_asli = $hasil_lihat_bahan->real_stock;

                        $juml_stok['real_stock'] = $jumlah_asli - $stok_mutasi;


                        $update_stok_asal = $this->db->update("master_bahan_baku", $juml_stok, array(
                            'kode_bahan_baku' => $kode_bahan,
                            'kode_unit' => $input['kode_unit_asal'],
                            'kode_rak' => $input['kode_rak_asal']));

                        $data_baru['kode_bahan_baku'] = $hasil_lihat_bahan->kode_bahan_baku;
                        $data_baru['nama_bahan_baku'] = $hasil_lihat_bahan->nama_bahan_baku;
                        $data_baru['kode_unit'] = $input['kode_unit_tujuan'];
                        $data_baru['nama_unit'] = $input['nama_unit_tujuan'];
                        $data_baru['kode_rak'] = $input['kode_rak_tujuan'];
                        $data_baru['nama_rak'] = $input['nama_rak_tujuan'];
                        $data_baru['jenis_bahan'] = $input['jenis_bahan'];
                        $data_baru['id_satuan_pembelian'] = $hasil_lihat_bahan->id_satuan_pembelian;
                        $data_baru['satuan_pembelian'] = $hasil_lihat_bahan->satuan_pembelian;
                        $data_baru['id_satuan_stok'] = $hasil_lihat_bahan->id_satuan_stok;
                        $data_baru['satuan_stok'] = $hasil_lihat_bahan->satuan_stok;
                        $data_baru['jumlah_dalam_satuan_pembelian'] = $hasil_lihat_bahan->
                            jumlah_dalam_satuan_pembelian;
                        $data_baru['stok_minimal'] = $hasil_lihat_bahan->stok_minimal;
                        $data_baru['real_stock'] = $stok_mutasi;
                        $data_baru['hpp'] = $hasil_lihat_bahan->hpp;
                        $insert_baru = $this->db->insert("master_bahan_baku", $data_baru);
                    } else
                        if ($hasil_produk->status_produk == "subproduk") {
                            $this->db->select('*');
                            $lihat_bahan = $this->db->get_where('master_bahan_baku', array(
                                'kode_bahan_baku' => $kode_bahan,
                                'kode_unit' => $input['kode_unit_asal'],
                                'kode_rak' => $input['kode_rak_asal']));
                            $hasil_lihat_bahan = $lihat_bahan->row();
                            $jumlah_asli = $hasil_lihat_bahan->real_stock;
                            $saiki = ($stok_mutasi / $hasil_produk->jumlah_dalam_satuan_pembelian);
                            $juml_stok['real_stock'] = $jumlah_asli - $saiki;


                            $update_stok_asal = $this->db->update("master_bahan_baku", $juml_stok, array(
                                'kode_bahan_baku' => $hasil_produk->kode_header_produk,
                                'kode_unit' => $input['kode_unit_asal'],
                                'kode_rak' => $input['kode_rak_asal']));

                            $data_baru['kode_bahan_baku'] = $hasil_lihat_bahan->kode_bahan_baku;
                            $data_baru['nama_bahan_baku'] = $hasil_lihat_bahan->nama_bahan_baku;
                            $data_baru['kode_header_produk'] = $hasil_produk->kode_bahan_baku;
                            $data_baru['kode_unit'] = $input['kode_unit_tujuan'];
                            $data_baru['nama_unit'] = $input['nama_unit_tujuan'];
                            $data_baru['kode_rak'] = $input['kode_rak_tujuan'];
                            $data_baru['nama_rak'] = $input['nama_rak_tujuan'];
                            $data_baru['jenis_bahan'] = 'stok';
                            $data_baru['id_satuan_pembelian'] = $hasil_lihat_bahan->id_satuan_pembelian;
                            $data_baru['satuan_pembelian'] = $hasil_lihat_bahan->satuan_pembelian;
                            $data_baru['id_satuan_stok'] = $hasil_lihat_bahan->id_satuan_stok;
                            $data_baru['satuan_stok'] = $hasil_lihat_bahan->satuan_stok;
                            $data_baru['jumlah_dalam_satuan_pembelian'] = $hasil_lihat_bahan->
                                jumlah_dalam_satuan_pembelian;
                            $data_baru['stok_minimal'] = $hasil_lihat_bahan->stok_minimal;
                            $data_baru['real_stock'] = $stok_mutasi;
                            $data_baru['hpp'] = $hasil_lihat_bahan->hpp;
                            $data_baru['harga_jual_1'] = $hasil_lihat_bahan->harga_jual_1;
                            $data_baru['harga_jual_2'] = $hasil_lihat_bahan->harga_jual_2;
                            $data_baru['harga_jual_3'] = $hasil_lihat_bahan->harga_jual_3;
                            $data_baru['kode_kategori_produk'] = $hasil_lihat_bahan->kode_kategori_produk;
                            $data_baru['nama_kategori_produk'] = $hasil_lihat_bahan->nama_kategori_produk;
                            $data_baru['status'] = "Aktif";
                            $data_baru['status_produk'] = "subproduk";
                            $insert_baru = $this->db->insert("master_bahan_baku", $data_baru);
                        }


                } else
                    if ($hasil_cek_bahan > 0) {
                        $cek_produk = $this->db->get_where('master_bahan_baku', array('kode_bahan_baku' =>
                                $kode_bahan));
                        $hasil_produk = $cek_produk->row();
                        if ($hasil_produk->status_produk == "produk") {
                            $this->db->select('*');
                            $lihat_bahan = $this->db->get_where('master_bahan_baku', array(
                                'kode_bahan_baku' => $kode_bahan,
                                'kode_unit' => $input['kode_unit_asal'],
                                'kode_rak' => $input['kode_rak_asal']));
                            $hasil_lihat_bahan = $lihat_bahan->row();
                            $jumlah_asli_asal = $hasil_lihat_bahan->real_stock;
                            
                            echo $jumlah_asli_asal . "|" . $stok_mutasi;

                            $juml_stok['real_stock'] = $jumlah_asli_asal - $stok_mutasi;

                            $update_stok_asal = $this->db->update("master_bahan_baku", $juml_stok, array(
                                'kode_bahan_baku' => $kode_bahan,
                                'kode_unit' => $input['kode_unit_asal'],
                                'kode_rak' => $input['kode_rak_asal']));

                            $this->db->select('*');
                            $lihat_bahan = $this->db->get_where('master_bahan_baku', array(
                                'kode_bahan_baku' => $kode_bahan,
                                'kode_unit' => $input['kode_unit_tujuan'],
                                'kode_rak' => $input['kode_rak_tujuan']));
                            $hasil_lihat_bahan = $lihat_bahan->row();
                            $jumlah_asli = $hasil_lihat_bahan->real_stock;
                            #echo $this->db->last_query();
                            #$hasil_cek = $cek_pending->result();
                            $juml_stok['real_stock'] = $jumlah_asli + ($stok_mutasi);
                            $update_stok_baru = $this->db->update("master_bahan_baku", $juml_stok, array(
                                'kode_bahan_baku' => $kode_bahan,
                                'kode_unit' => $input['kode_unit_tujuan'],
                                'kode_rak' => $input['kode_rak_tujuan']));
                        } elseif ($hasil_produk->status_produk == "subproduk") {
                            $this->db->select('*');
                            $lihat_bahan = $this->db->get_where('master_bahan_baku', array(
                                'kode_bahan_baku' => $hasil_produk->kode_header_produk,
                                'kode_unit' => $input['kode_unit_asal'],
                                'kode_rak' => $input['kode_rak_asal']));
                            $hasil_lihat_bahan = $lihat_bahan->row();
                            $jumlah_asli_asal = $hasil_lihat_bahan->real_stock;
                            $saiki = ($stok_mutasi / $hasil_produk->jumlah_dalam_satuan_pembelian);
                            echo $jumlah_asli_asal . "|" . $saiki . "|" . $hasil_produk->
                                jumlah_dalam_satuan_pembelian;

                            $juml_stok_gudang['real_stock'] = $jumlah_asli_asal - $saiki;

                            $update_stok_asal = $this->db->update("master_bahan_baku", $juml_stok_gudang,
                                array(
                                'kode_bahan_baku' => $hasil_produk->kode_header_produk,
                                'kode_unit' => $input['kode_unit_asal'],
                                'kode_rak' => $input['kode_rak_asal']));
                            #echo $this->db->last_query();
                            $this->db->select('*');
                            $lihat_bahan = $this->db->get_where('master_bahan_baku', array(
                                'kode_bahan_baku' => $kode_bahan,
                                'kode_unit' => $input['kode_unit_tujuan'],
                                'kode_rak' => $input['kode_rak_tujuan']));
                            $hasil_lihat_bahan = $lihat_bahan->row();
                            $jumlah_asli = $hasil_lihat_bahan->real_stock;
                            #echo $this->db->last_query();
                            #$hasil_cek = $cek_pending->result();
                            $juml_stok['real_stock'] = $jumlah_asli + ($stok_mutasi);
                            $update_stok_baru = $this->db->update("master_bahan_baku", $juml_stok, array(
                                'kode_bahan_baku' => $kode_bahan,
                                'kode_unit' => $input['kode_unit_tujuan'],
                                'kode_rak' => $input['kode_rak_tujuan']));
                        }


                    }

                if (@$update_stok_asal) {
                    $stok['jenis_transaksi'] = 'mutasi';
                    $stok['kode_transaksi'] = $kode_mutasi;
                    $stok['kategori_bahan'] = $kategori_bahan;
                    $stok['kode_bahan'] = $kode_bahan;
                    $stok['nama_bahan'] = $nama_bahan;
                    $stok['stok_keluar'] = $stok_mutasi;
                    $stok['stok_masuk'] = '';
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
                    $stok['tanggal_transaksi'] = date("Y-m-d");

                    $transaksi_stok = $this->db->insert("transaksi_stok", $stok);

                    $stok['jenis_transaksi'] = 'mutasi';
                    $stok['kode_transaksi'] = $kode_mutasi;
                    $stok['kategori_bahan'] = $kategori_bahan;
                    $stok['kode_bahan'] = $kode_bahan;
                    $stok['nama_bahan'] = $nama_bahan;
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
                    $stok['tanggal_transaksi'] = date("Y-m-d");
                    $stok['sisa_stok'] = $stok_mutasi;

                    $transaksi_stok = $this->db->insert("transaksi_stok", $stok);

                } else {
                    #echo '<div class="alert alert-danger">Gagal Melakukan Mutasi (detail_Mutasi).</div>';
                }
            }

        }

        if (@$transaksi_stok) {
            unset($input['kategori_bahan']);
            unset($input['jenis_bahan']);
            unset($input['nama_satuan']);
            unset($input['kategori_barang']);
            unset($input['kode_bahan']);
            unset($input['nama_bahan']);
            unset($input['jumlah']);
            unset($input['id_item_temp']);

            $input['tanggal_update'] = date("Y-m-d");
            $input['tanggal_transaksi'] = date("Y-m-d");
            $input['petugas'] = $nama_petugas;

            $tabel_transaksi_mutasi = $this->db->insert("transaksi_mutasi", $input);
            if ($tabel_transaksi_mutasi) {
                echo '<div class="alert alert-success">Berhasil Melakukan Mutasi.</div>';
                $delete_temp = $this->db->delete("opsi_transaksi_mutasi_temp", array('kode_mutasi' =>
                        $kode_mutasi));
            } else {
                # echo '<div class="alert alert-danger">Gagal Melakukan Mutasi (Trx_Mutasi) .</div>';
            }
        } else {
            # echo '<div class="alert alert-danger">Gagal Melakukan Mutasi (update_stok).</div>';
        }
    }

    public function hapus_temp()
    {
        $id = $this->input->post('id');
        $this->db->delete('opsi_transaksi_mutasi_temp', array('id' => $id));
    }


}
