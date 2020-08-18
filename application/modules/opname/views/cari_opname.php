
<table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
 <thead>
  <tr>
   <th>No</th>
   <th>Kode Produk</th>
   <th>Nama Produk</th>
   <th>Nama Blok</th>
   <th align="right">Real Stok</th>

   <th>Action</th>
 </tr>
</thead>
<tbody id="">

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
  $this->db->where('status_opname','Nominal');
  $get_stok = $this->db->get('master_bahan_baku');
  $hasil_stok = $get_stok->result_array();
  $no=1;
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

    <?php } ?>

  </tbody>
  <tfoot>
    <tr>
     <th>No</th>
     <th>Kode Produk</th>
     <th>Nama Produk</th>
     <th>Nama Blok</th>
     <th align="right">Real Stok</th>

     <th>Action</th>
   </tr>
 </tfoot>
 <tbody>

 </tbody>                
</table>