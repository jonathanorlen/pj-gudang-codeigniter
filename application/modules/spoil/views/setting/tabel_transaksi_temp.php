<?php
$kode_default = $this->db->get('setting_gudang');
$hasil_unit =$kode_default->row();
$param =$hasil_unit->kode_unit;
$spoil =$this->db->get_where('opsi_transaksi_spoil_temp',array('kode_unit' => $param));
$list_spoil = $spoil->result();
$nomor = 1;  

foreach($list_spoil as $daftar){ 
   @$satuan_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>@$daftar->kode_bahan));
      @$hasil_satuan_bahan = $satuan_bahan->row();
      @$satuan_barang = $this->db->get_where('master_barang',array('kode_barang'=>@$daftar->kode_bahan));
      @$hasil_satuan_barang = $satuan_barang->row();
  ?> 
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $daftar->jenis_bahan; ?></td>
    <td><?php echo $daftar->nama_unit; ?></td>
    <td><?php echo $daftar->nama_rak; ?></td>
    <td><?php echo $daftar->nama_bahan; ?></td>
    <td><?php echo $daftar->jumlah; ?> <?php echo @$hasil_satuan_bahan->satuan_stok; echo @$hasil_satuan_barang->satuan_stok;?></td>
    <td><?php echo $daftar->keterangan; ?></td>
    <td align="center"><?php echo get_edit_del_id($daftar->id); ?></td>
  </tr>
  <?php 
  $nomor++; 
} 
?>