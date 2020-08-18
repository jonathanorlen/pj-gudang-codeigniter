<table  class="table table-striped table-hover table-bordered" id="tabel_daftarr"  style="font-size:1.5em;">

  <?php
  $kode_default = $this->db->get('setting_gudang');
  $hasil_unit =$kode_default->row();
  $param=$hasil_unit->kode_unit;
  $this->db->limit(100);
  if($this->input->post('kategori')!=""){
    $kategori = $this->input->post('kategori');
    $this->db->where('kode_kategori_produk', $kategori);
  }
  if($this->input->post('nama_produk')!=""){
    $nama_produk = $this->input->post('nama_produk');
    $this->db->like('nama_bahan_baku', $nama_produk);
  }
  $bahan_baku = $this->db->get_where('master_bahan_baku',array('kode_unit' => $param));
  $hasil_bahan_baku = $bahan_baku->result();
  ?>

  <thead>
    <tr width="100%">
      <th>No</th>
      <th>Kode Produk</th>
      <th>Nama Produk</th>
      <th style="display:none;">Kategori Produk</th>
      <th>Unit</th>
      <th>Block</th>
      <th>Real Stock</th>
      <th>Stok Minimal</th>
      <th width="10%">Action</th>
    </tr>
  </thead>
  <tbody style="width: 700px;" id="posts">
    <?php
    $nomor=1;
    foreach($hasil_bahan_baku as $daftar){

                // $opsi_bahan_baku = $this->db->get_where('opsi_bahan_baku',array('kode_bahan_baku' => $daftar->kode_bahan_baku));
                // $hasil_opsi_bahan_baku = $opsi_bahan_baku->row();

      ?>
      <tr>
        <td width="80px"><?php echo $nomor; ?></td>
        <td width="150px"><?php echo $daftar->kode_bahan_baku; ?></td>
        <td width="500px"><?php echo $daftar->nama_bahan_baku; ?></td>
        <td style="display:none;"><?php echo $daftar->nama_kategori_produk; ?></td>
        <td><?php echo $daftar->nama_unit; ?></td>
        <td><?php echo $daftar->nama_rak; ?></td>
        <td width="150px"><?php echo $daftar->real_stock; ?></td>
        <td width="150px"><?php echo $daftar->stok_minimal; ?></td>
        <td><?php echo get_detail_edit_delete_gudang($daftar->id); ?></td>
      </tr>
      <?php $nomor++; } ?>
    </tbody>
    <tfoot>
      <tr>
       <th>No</th>
       <th>Kode Produk</th>
       <th>Nama Produk</th>
       <th style="display:none;">Kategori Produk</th>
       <th>Unit</th>
       <th>Block</th>
       <th>Real Stock</th>
       <th>Stok Minimal</th>
       <th>Action</th>
     </tr>
   </tfoot>
 </table>
 <br><br><br><br><br><br><br><br>
 <br><br><br><br><br><br><br><br>
 <?php 
 if($this->input->post('kategori')!=""){
  $kategori = $this->input->post('kategori');
  $this->db->where('kode_kategori_produk', $kategori);
}
if($this->input->post('nama_produk')!=""){
  $nama_produk = $this->input->post('nama_produk');
  $this->db->like('nama_bahan_baku', $nama_produk);
}
$get_jumlah = $this->db->get_where('master_bahan_baku', array('kode_unit' => $param));
$jumlah = $get_jumlah->num_rows();
$jumlah = floor($jumlah/100);
?>
<input type="hidden" class="form-control rowcount" value="<?php echo $jumlah ?>">
<input type="hidden" class="form-control pagenum" value="0">