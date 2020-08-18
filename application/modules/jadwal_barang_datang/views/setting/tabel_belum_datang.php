<?php 
  $kode=$this->uri->segment(4);
  #echo $kode;
  $get_opsi_pembelian=$this->db->query("SELECT * from opsi_transaksi_pembelian where kode_pembelian='$kode' or status=''");
  $hasil=$get_opsi_pembelian->result();
  $no=1;
  foreach ($hasil as $list) { ?>
   <tr>
     <td><?php echo $no++; ?></td>
     <td><?php echo $list->nama_bahan ?></td>
     <td><?php echo $list->jumlah ?></td>
   </tr>

<?php } ?>