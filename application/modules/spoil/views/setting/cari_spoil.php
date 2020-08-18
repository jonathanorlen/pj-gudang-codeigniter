      
<?php



            $kode_default = $this->db->get('setting_gudang');
            $hasil_unit =$kode_default->row();
            $param=$hasil_unit->kode_unit;
            
            $jenis_filter=$this->input->post('jenis_filter');
            $kategori_filter=$this->input->post('kategori_filter');
            $nama_produk=$this->input->post('nama_produk');
            if($kategori_filter=='kategori' and !empty($jenis_filter) and empty($nama_produk)){
              
              $this->db->where('kode_kategori_produk',$jenis_filter);
              //$this->db->where('nama_bahan_baku',$nama_produk);

            }elseif ($kategori_filter=='blok' and !empty($jenis_filter) and empty($nama_produk)) {
              
              $this->db->where('kode_rak',$jenis_filter);
              //$this->db->where('nama_bahan_baku',$nama_produk);
            }else{
               $this->db->like('nama_bahan_baku',$nama_produk,'both');
            }

            $this->db->where('kode_unit',$param);
$this->db->select('*');
$this->db->from('master_bahan_baku');
$transaksi = $this->db->get();
$hasil_transaksi = $transaksi->result();

$total=0;
$kode_default = $this->db->get('setting_gudang');
$hasil_unit =$kode_default->row();
$param =$hasil_unit->kode_unit;
?>
<br>
<br>
<br>
<a style="padding:13px; margin-bottom:10px; margin-right:0px;" id="spoil_tambah" class="btn btn-app green pull-right" ><i class="fa fa-edit"></i> Spoil </a>
<form method="post" id="opsi_spoil"> 
  <table class="table table-striped table-hover table-bordered" id="tabel_daftar" style="font-size:1.5em;">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Jumlah</th>
        <th>Nama Blok</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php

      $nomor = 1;  

      foreach($hasil_transaksi as $daftar){ 
        ?> 
        <tr>
          <td><?php echo $nomor; ?></td>
          <td><?php echo $daftar->nama_bahan_baku; ?></td>
          <td><?php echo $daftar->real_stock.' '.$daftar->satuan_stok; ?></td>
          <td><?php echo $daftar->nama_rak; ?></td>
          <td align="center"><input name="opsi_spoil[]" type="checkbox" id="opsi_pilihan" value="<?php echo $daftar->kode_bahan_baku; ?>"></td>
        </tr>
        <?php 
        $nomor++; 
      } 
      ?>

    </tbody>
    <tfoot>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Jumlah</th>
        <th>Nama Blok</th>
        <th>Action</th>
      </tr>
    </tfoot>            
  </table>
  <input type="hidden" name="kode_unit" id="kode_unit" value="<?php echo $param ?>">
  <?php
  $tgl = date("Y-m-d");
  $no_belakang = 0;
  $this->db->select_max('kode_spoil');
  $kode = $this->db->get_where('transaksi_spoil',array('tanggal_spoil'=>$tgl));
  $hasil_kode = $kode->row();
  $this->db->select('kode_spoil');
  $kode_spoil = $this->db->get('master_setting');
  $hasil_kode_spoil = $kode_spoil->row();

  if(count($hasil_kode)==0){
    $no_belakang = 1;
  }
  else{
    $pecah_kode = explode("_",$hasil_kode->kode_spoil);
    $no_belakang = @$pecah_kode[2]+1;
  }

  $this->db->select_max('id');
  $get_max_po = $this->db->get('transaksi_spoil');
  $max_po = $get_max_po->row();

  $this->db->where('id', $max_po->id);
  $get_po = $this->db->get('transaksi_spoil');
  $po = $get_po->row();
  $tahun = substr(@$po->kode_spoil, 3,4);
  if(date('Y')==$tahun){
    $nomor = substr(@$po->kode_spoil, 8);
    $nomor = $nomor + 1;
    $string = strlen($nomor);
    if($string == 1){
      $kode_trans = 'SP_'.date('Y').'_00000'.$nomor;
    } else if($string == 2){
      $kode_trans = 'SP_'.date('Y').'_0000'.$nomor;
    } else if($string == 3){
      $kode_trans = 'SP_'.date('Y').'_000'.$nomor;
    } else if($string == 4){
      $kode_trans = 'SP_'.date('Y').'_00'.$nomor;
    } else if($string == 5){
      $kode_trans = 'SP_'.date('Y').'_0'.$nomor;
    } else if($string == 6){
      $kode_trans = 'SP_'.date('Y').'_'.$nomor;
    }
  } else {
    $kode_trans = 'SP_'.date('Y').'_000001';
  }
  @$hasil_kode_spoil->kode_spoil."_".date("dmyHis")."_".$no_belakang
  ?>
  <input type="hidden" name="kode_spoil" id="kode_spoil" value="<?php echo $kode_trans ?>">
</form>
<script type="text/javascript">
  $('#spoil_tambah').click(function(){
    checkedValue = $('#opsi_pilihan:checked').val();
    kode_spoil = $('#kode_spoil').val();
    if(!checkedValue){
      alert("Pilih Barang Yang Akan Di Spoil");
    } else {
      $.ajax( {  
        type :"post",  
        url : "<?php echo base_url().'spoil/simpan_spoil_temp_baru'; ?>",  
        cache :false,
        data : $("#opsi_spoil").serialize(),
        beforeSend:function(){
          $(".tunggu").show();  
        },
        success : function(data) {
          $(".tunggu").hide();  
          setTimeout(function(){
            window.location = "<?php echo base_url() . 'spoil/tambah_spoil/'; ?>"+kode_spoil;
          },15);       
        },  
        error : function(data) {
        }  
      });
    }

  });
</script>