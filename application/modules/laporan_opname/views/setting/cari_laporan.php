 <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
   <thead>
    <tr>
      <th>No</th>
      <th>Kode Opname</th>
      <th>Tanggal Opanme</th>
      <th>Nama Petugas</th>
      <th>Jumlah</th>
      <th>Keterangan Opname</th>


      <th>Action</th>
    </tr>
  </thead>
  <tbody id="daftar_list_stock">

    <?php
      $param = $this->input->post();
    if(@$param['tgl_awal'] && @$param['tgl_akhir']){

      $tgl_awal = $param['tgl_awal'];
      $tgl_akhir = $param['tgl_akhir'];
      $kode_unit = $param['kode_unit'];

      $this->db->where('tanggal_opname >=', $tgl_awal);
      $this->db->where('tanggal_opname <=', $tgl_akhir);
      $this->db->where('kode_unit =', $kode_unit);

    }
     $this->db->where('validasi =', 'confirmed');
    $this->db->select('*');
    $this->db->from('transaksi_opname');
    $transaksi = $this->db->get();
    $hasil_stok = $transaksi->result_array();


    // $param= $this->input->post("kode_unit");
    // $tgl_awal = $this->input->post("tgl_awal");
    // $tgl_akhir = $this->input->post("tgl_akhir");

    // $get_stok = $this->db->query("SELECT * from transaksi_opname where tanggal_opname >= $tgl_awal and tanggal_opname >= $tgl_akhir and kode_unit='$param'and validasi='confirmed'");
    // $hasil_stok = $get_stok->result_array();

    $no = 1;
    foreach ($hasil_stok as $item) {

      ?>   
      <tr>
        <td><?php echo $no++;?></td>
        <td><?php echo $item['kode_opname'];?></td>
        <td><?php echo TanggalIndo($item['tanggal_opname']);?></td>
        <td><?php echo $item['petugas'];?></td>
        <?php 
        $get_total =$this->db->get_where("opsi_transaksi_opname",array('kode_opname'=>$item['kode_opname']));
        $hasil_total=$get_total->result();
        $total =count($hasil_total);
        ?>
        <td><?php echo $total;?></td>
        <td><?php echo @$item['keterangan'];?></td>


        <td align="center"><?php echo get_detail($item['kode_opname']);?>

        </td>
      </tr>

      <?php } ?>

    </tbody>
    <tfoot>
     <tr>
      <th>No</th>
      <th>Kode Opname</th>
      <th>Tanggal Opanme</th>
      <th>Nama Petugas</th>
      <th>Jumlah</th>
      <th>Keterangan Opname</th>


      <th>Action</th>
    </tr>
  </tfoot>
</table>