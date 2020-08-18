
<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Mutasi
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
        
      
        <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url() . 'mutasi/tambah_mutasi' ?>"><i class="fa fa-edit"></i> Tambah </a>
      <!-- <a style="padding:13px; margin-bottom:10px;" class="btn btn-app blue" href="<?php echo base_url() . 'mutasi/daftar_mutasi' ?>"><i class="fa fa-list"></i> Daftar </a> -->
        <div class="box-body">            
          <div class="sukses" ></div>
          <div class="row">
          <div class="col-md-5" id="">
            <div class="input-group">
              <span class="input-group-addon">Tanggal Awal</span>
              <input type="text" class="form-control tgl" id="tgl_awal">
            </div>
          </div>
          
          <div class="col-md-5" id="">
            <div class="input-group">
              <span class="input-group-addon">Tanggal Akhir</span>
              <input type="text" class="form-control tgl" id="tgl_akhir">
            </div>
          </div>                        
          <div class="col-md-2 pull-left">
            <button style="width: 148px" type="button" class="btn btn-warning pull-right" id="cari"><i class="fa fa-search"></i> Cari</button>
          </div>
        </div><br><br>
          <div id="cari_transaksi">
          <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
            <?php
            $this->db->group_by('kode_mutasi','desc');
            $mutasi = $this->db->get('opsi_transaksi_mutasi');
            $hasil_mutasi = $mutasi->result();
            $kode_default = $this->db->get('setting_gudang');
            $hasil_unit =$kode_default->row();
            
            $kode_unit = $hasil_unit->kode_unit; 
            ?>
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Tanggal Mutasi</th>
                <th>Petugas</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $nomor = 1;
              foreach($hasil_mutasi as $daftar){ 
               $query = $this->db->query(" SELECT * FROM transaksi_stok where kode_transaksi= '$daftar->kode_mutasi' and kode_unit_asal='$kode_unit' ");
               $cek=$query->num_rows();
               $petugas=$query->row();
               if($cek>0){
                            //echo "$kode_unit";

                ?> 
                <tr>
                  <td><?php echo $nomor; ?></td>
                  <td><?php echo @$daftar->kode_mutasi; ?></td>
                  <td><?php echo @$daftar->tanggal_update; ?></td>
                  <td><?php echo @$petugas->nama_petugas; ?></td>
                  <td align="center"><?php echo get_detail_mutasi($daftar->kode_mutasi); ?></td>
                </tr>
                <?php $nomor++; }} ?>

              </tbody>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Tanggal Mutasi</th>
                  <th>Petugas</th>
                  <th>Action</th>
                </tr>
              </tfoot>

            </table>
            <input type="hidden" name="kode_unit" id="kode_unit" value="<?php echo $kode_unit ?>">
            </div>
          </div>

          <!------------------------------------------------------------------------------------------------------>

        </div>
      </div>
    </div><!-- /.col -->
  </div>
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
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data tersebut ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()" class="btn red">Ya</button>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url().'component/lib/jquery.min.js'?>"></script>
<script src="<?php echo base_url().'component/lib/zebra_datepicker.js'?>"></script>
<link rel="stylesheet" href="<?php echo base_url().'component/lib/css/default.css'?>"/>
<script type="text/javascript">

       $('.tgl').Zebra_DatePicker({});


  $('#cari').click(function(){

      var tgl_awal =$("#tgl_awal").val();
      var tgl_akhir =$("#tgl_akhir").val();
      var kode_unit =$("#kode_unit").val();
      if (tgl_awal=='' || tgl_akhir==''){ 
        alert('Masukan Tanggal Awal & Tanggal Akhir..!')
      }
      else{
    $.ajax( {  
        type :"post",  
        url : "<?php echo base_url().'mutasi/cari_mutasi'; ?>",  
        cache :false,
          
        data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir,kode_unit:kode_unit},
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {
           $(".tunggu").hide();  
             $("#cari_transaksi").html(data);
        },  
        error : function(data) {  
         // alert("das");  
        }  
      });
    }
   
    $('#tgl_awal').val('');
    $('#tgl_akhir').val('');

  });
</script>
<script>
$(document).ready(function(){
  $("#tabel_daftar").dataTable({
    "paging":   false,
    "ordering": true,
    "info":     false
  });
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