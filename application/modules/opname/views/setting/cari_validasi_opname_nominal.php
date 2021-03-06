  <br>
  <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
   <thead>
    <tr>
      <th>No</th>
      <th>Kode Opname</th>
      <th>Tanggal Opanme</th>
      <th>Nama Petugas</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id="daftar_list_stock">

    <?php

    $kode_default = $this->db->get('setting_gudang');
    $hasil_unit =$kode_default->row();
    $param=$hasil_unit->kode_unit;

    $tgl_awal=$this->input->post('tgl_awal');
    $tgl_akhir=$this->input->post('tgl_akhir');

    if(!empty($tgl_awal) and !empty($tgl_akhir)){
      $this->db->where('tanggal_opname >=',$tgl_awal);
      $this->db->where('tanggal_opname <=',$tgl_akhir);
      $this->db->where('status_opname  ','Nominal');
      $this->db->order_by('tanggal_opname  ','ASC');
    }
    $get_stok=$this->db->get('transaksi_opname');
    //$get_stok = $this->db->query("SELECT * from transaksi_opname where tanggal_opname='$sekarang' and kode_unit='$param'  and status_opname='Nominal' order by tanggal_opname ASC");
    $hasil_stok = $get_stok->result_array();
    $no=1;
    foreach ($hasil_stok as $item) {

      ?>   
      <tr>
        <td><?php echo $no++;?></td>
        <td><?php echo $item['kode_opname'];?></td>
        <td><?php echo TanggalIndo($item['tanggal_opname']);?></td>
        <td><?php echo $item['petugas'];?></td>


        <td align="center"><?php if($item['validasi']=="" or empty($item['validasi'])){echo get_validasi($item['kode_unit'],$item['kode_opname']);} else{ echo"";}?>
          <a  data-toggle="tooltip" onclick="print('<?php echo $item['kode_opname'];?>')" key="<?php echo $item['kode_opname'];?>" title="Validasi" class="btn btn-xs blue"><i class="fa fa-print"></i>  Print</a>
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


      <th>Action</th>
    </tr>
  </tfoot>
</table>