<?php 

$kode = $this->uri->segment(3);
$repack_temp = $this->db->get_where('opsi_transaksi_repack_temp',array('kode_repack'=>$kode));

$hasil_repack_temp = $repack_temp->result();
$no=1;
foreach ($hasil_repack_temp as $list) {
  ?>

  <tr>
    <td><?php echo $no++; ?></td>
    <td><?php echo $list->nama_bahan; ?></td>
    <td><?php echo $list->nama_produk_repack; ?></td>
    <td><?php echo $list->jumlah_in; ?></td>
    <td><?php echo get_edit_del_id($list->id); ?></td>
  </tr>
  <?php   
} ?>