<div class="row">      
  <div class="col-xs-12">
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Stok Barang
        </div>
        <div class="tools">
          <a href="javascript:;" class="collapse">
          </a>
          <a href="javascript:;" class="reload">
          </a>
        </div>
      </div>
      <div class="portlet-body">
        <!------------------------------------------------------------------------------------------------------>

        <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url().'stok/daftar_stok'; ?>"><i class="fa fa-list"></i> Bahan Baku </a>
        <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url().'stok/daftar_barang'; ?>"><i class="fa fa-list"></i> Barang </a>
        <div class="box-body">            
          <div class="sukses" ></div>

          <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
           <thead>
            <tr>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th align="right">Real Stok</th>
              <th>HPP</th>
              <th>Aset</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="daftar_list_stock">

            <?php

                  $kode_default = $this->db->get('setting_gudang');
                  $hasil_unit =$kode_default->row();
                  $param=$hasil_unit->kode_unit;
                   //$kode_unit =$this->uri->segment(3);
                  // $get_rak = $this->db->get_where('master_rak',array('kode_unit' => $kode_unit));
                  // $hasil_rak = $get_rak->row();

                  $get_stok = $this->db->query("SELECT * from master_barang where position='$param'");
                  $hasil_stok = $get_stok->result_array();
                  foreach ($hasil_stok as $item) {

                    $kode_bahan = $item['kode_barang']; 
              $this->db->select_max('id');                       
              $get_kode_bahan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan,'jenis_transaksi'=>'pembelian'));
              $hasil_hpp_bahan = $get_kode_bahan->row();
              #echo $this->db->last_query();

              $get_hpp = $this->db->get_where('transaksi_stok',array('id'=>$hasil_hpp_bahan->id));
              $hasil_get_hpp = $get_hpp->row();

              $get_stok_min = $this->db->get_where('master_bahan_baku',array('id'=>$item['id']));
              $hasil_stok_min = $get_stok_min->row();
                                 
              ?>   
              <tr>
                <td><?php echo $item['kode_barang'];?></td>
                <td><?php echo $item['nama_barang'];?></td>
                <td align="right"><?php echo $item['real_stok'];?></td>
                <td><?php echo format_rupiah(@$hasil_get_hpp->hpp);?></td>
                <td><?php echo format_rupiah((@$item['real_stok'] <= 0) ? (@$hasil_get_hpp->hpp * 0) : (@$hasil_get_hpp->hpp * $item['real_stok']));?></td>
                <td align="center"><?php echo get_detail_barang($item['id']); ?></td>
              </tr>
              <?php } ?>       
            </tbody>
            <tfoot>
              <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th align="right">Real Stok</th>      
                <th>HPP</th>
                <th>Aset</th>
                <th>Action</th>
              </tr>
            </tfoot>
            <tbody>

            </tbody>                
          </table>

          
        </div>
        
        <!------------------------------------------------------------------------------------------------------>

      </div>
    </div>
  </div><!-- /.col -->
</div>
</div>    
</div>  
<!-- /.content-wrapper -->
<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data menu tersebut ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()" class="btn red">Ya</button>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
  $("#tabel_daftar").dataTable({
    "paging":   false,
    "ordering": false,
    "info":     false
  });
})


function list_stock(){
  var kode_rak = $('#kode_rak').val();
  var kode_unit = $('#kode_unit').val();
  var url = "<?php echo base_url(). 'stok/stok/list_stock'; ?>";
  $.ajax({
    type: "POST",
    url: url,
    data: {kode_rak:kode_rak,kode_unit,kode_unit},
    beforeSend:function(){
          $(".tunggu").show();  
        },
success: function(msg) {
                // alert(msg);
                $('#daftar_list_stock').html(msg);
              }
            });
}
$(".stok_min").css("background-color", "red");
</script>