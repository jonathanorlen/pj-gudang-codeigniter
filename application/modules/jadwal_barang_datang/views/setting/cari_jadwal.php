      
<?php
$param = $this->input->post();
if(@$param['tgl_awal'] && @$param['tgl_akhir']){
  $tgl_awal = $param['tgl_awal'];
  $tgl_akhir = $param['tgl_akhir'];

  $this->db->where('tanggal_barang_datang >=', $tgl_awal);
  $this->db->where('tanggal_barang_datang <=', $tgl_akhir);
}

$this->db->select('*');
$this->db->from('input_jadwal_barang_datang');

$jadwal = $this->db->get();
$hasil_jadwal = $jadwal->result_array();

$total=0;

?>
<div class="row">
  <div class="col-md-4">

  </div>

</div>         
<div class="">
 <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
  <thead>

    <tr>
      <th width="50px;">No</th>
      <th>Kode Transaksi</th>
      <th>Kode PO</th>
      <th>Tanggal Barang Datang</th>
      <th>Keterangan</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php

    $no=0;
    foreach ($hasil_jadwal as $list) {
      $no++;
      ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $list['kode_transaksi']; ?></td>
        <td><?php echo $list['kode_po']; ?></td>
        <td><?php echo TanggalIndo($list['tanggal_barang_datang']);?></td>
        <td><?php echo $list['keterangan']; ?></td>
        <td><?php echo get_detail_belum_datang($list['kode_transaksi']);  ?></td>
      </tr>
      <?php  } ?>
    </tbody>                
  </table>
</div>

<script type="text/javascript">
$("#tabel_daftar").dataTable({
  "paging":   false,
  "ordering": false,
  "info":     false
});
</script>