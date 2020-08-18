
<div class="row">      
  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Spoil
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
        <div class="loading" style="z-index:9999999999999999; background:rgba(255,255,255,0.8); width:100%; height:100%; position:fixed; top:0; left:0; text-align:center; padding-top:25%; display:none" >
          <img src="<?php echo base_url() . '/public/img/loading.gif' ?>" >
        </div>
      
        <div class="box-body">            
          <div class="sukses" ></div>
          <form method="post" id="data_form"> 
            <table class="table table-striped table-hover table-bordered" id="tabel_daftar" style="font-size:1.5em;">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Spoil</th>
                  <th>Tanggal Spoil</th>
                  <th>Petugas</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $param = $this->uri->segment(3);
                $spoil = $this->db->get_where('transaksi_spoil',array('kode_unit' => $param));
                $list_spoil = $spoil->result();
                $nomor = 1;  

                foreach($list_spoil as $daftar){ 
                  ?> 
                  <tr>
                    <td><?php echo $nomor; ?></td>
                    <td><?php echo $daftar->kode_spoil; ?></td>
                    <td><?php echo $daftar->tanggal_spoil; ?></td>
                    <td><?php echo $daftar->petugas; ?></td>
                    <td align="center"><?php echo get_detail_spoil($param,$daftar->kode_spoil); ?></td>
                  </tr>
                  <?php 
                  $nomor++; 
                } 
                ?>

              </tbody>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Kode Spoil</th>
                  <th>Tanggal Spoil</th>
                  <th>Petugas</th>
                  <th>Action</th>
                </tr>
              </tfoot>            
            </table>

            
          </div>

          <!------------------------------------------------------------------------------------------------------>

        </div>
      </div>
    </div><!-- /.col -->
  </div>
</div>    
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
  $("#tabel_daftar").dataTable();
})

function actDelete(Object) {
  $('#id-delete').val(Object);
  $('#modal-confirm').modal('show');
}

function delData() {
  var id = $('#id-delete').val();
  var url = '<?php echo base_url().'master/menu_resto/hapus_bahan_jadi'; ?>/delete';
  $.ajax({
    type: "POST",
    url: url,
    data: {
      id: id
    },
    beforeSend:function(){
          $(".tunggu").show();  
        },
success: function(msg) {
      $('#modal-confirm').modal('hide');
            // alert(id);
            window.location.reload();
          }
        });
  return false;
}

</script>