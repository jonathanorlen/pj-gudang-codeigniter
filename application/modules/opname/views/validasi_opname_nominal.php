<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Validasi Opname Nominal
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
      <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url().'opname/daftar_opname'; ?>"><i class="fa fa-list"></i> Opname Nominal </a>
        <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url().'opname/daftar_validasi_nominal'; ?>"><i class="fa fa-check"></i> Validasi Nominal </a>
        <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url().'opname/daftar_opname_view'; ?>"><i class="fa fa-list"></i> Opname View </a>
        <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url().'opname/daftar_validasi_view'; ?>"><i class="fa fa-check"></i> Validasi View </a><br><br> <br>
        <div class="box-body">            
          <div class="sukses" ></div>
          <form id="data_form" method="post" >
            <div class="box-body">            
               <div class="row">
            <div class="col-md-5" id="">
              <div class="input-group">
                <span class="input-group-addon">Tanggal Awal</span>
                <input type="date" class="form-control tgl" id="tgl_awal">
              </div>
            </div>

            <div class="col-md-5" id="">
              <div class="input-group">
                <span class="input-group-addon">Tanggal Akhir</span>
                <input type="date" class="form-control tgl" id="tgl_akhir">
              </div>
            </div>                        
            <div class="col-md-2 pull-left">
              <button style="width: 148px" type="button" class="btn btn-warning pull-right" id="cari"><i class="fa fa-search"></i> Cari</button>
            </div>
          </div>
            </div>
          </div>
        </form>
        <form id="data_opname">
              <div id="cari_transaksi">

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
             
                  $sekarang=date('Y-m-d');
                  $get_stok = $this->db->query("SELECT * from transaksi_opname where tanggal_opname='$sekarang' and kode_unit='$param'  and status_opname='Nominal' order by tanggal_opname ASC");
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
              </div>
            </form>
            <div class="row">
            <!-- <a style="padding:13px; margin-bottom:10px; margin-right:15px;" id="opname" class="btn btn-app green pull-right" ><i class="fa fa-edit"></i> Opname </a> -->
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
<script src="<?php echo base_url().'component/lib/jquery.min.js'?>"></script>
<script src="<?php echo base_url().'component/lib/zebra_datepicker.js'?>"></script>
<link rel="stylesheet" href="<?php echo base_url().'component/lib/css/default.css'?>"/>
<script type="text/javascript">

//$('.tgl').Zebra_DatePicker({});


// $('#cari').click(function(){

//   var tgl_awal =$("#tgl_awal").val();
//   var tgl_akhir =$("#tgl_akhir").val();
//   var kode_unit =$("#kode_unit").val();

//     $.ajax( {  
//       type :"post",  
//       url : "<?php echo base_url().'opname/cari_opname'; ?>",  
//       cache :false,

//       data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir,kode_unit:kode_unit},
//       beforeSend:function(){
//         $(".tunggu").show();  
//       },
//       success : function(data) {
//        $(".tunggu").hide();  
//        $("#cari_transaksi").html(data);
//      },  
//      error : function(data) {  
//          // alert("das");  
//        }  
//      });
//   }

//   $('#tgl_awal').val('');
//   $('#tgl_akhir').val('');

// });
</script>
<script>
$(document).ready(function(){
  $("#tabel_daftar").dataTable({
    "paging":   false,
    "ordering": true,
    "info":     false,
    "searching":     false
  });
  $('#opsi_filter').hide();
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

$('#kategori_filter').on('change',function(){
  var kategori_filter = $('#kategori_filter').val();

  var url = "<?php echo base_url() . 'opname/get_jenis_filter' ?>";
  $.ajax({
    type: 'POST',
    url: url,
    data: {kategori_filter:kategori_filter},
    success: function(msg){
      $('#opsi_filter').show();
      $('#jenis_filter').html(msg);
    }
  });
});

 $('#cari').click(function(){

  var tgl_awal =$("#tgl_awal").val();
  var tgl_akhir =$("#tgl_akhir").val();

  if (tgl_awal=='' || tgl_akhir==''){ 
    alert('Masukan Tanggal Awal & Tanggal Akhir..!')
  }
  else{
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url().'opname/cari_validasi_opname_nominal'; ?>",  
      cache :false,

      data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir},
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
$('#opname').click(function(){


  $.ajax( {  
    type :"post",  
    url : "<?php echo base_url().'opname/simpan_opname_temp_baru'; ?>",  
    cache :false,

    data :$('#data_opname').serialize(),
    beforeSend:function(){
      $(".tunggu").show();  
    },
    success : function(data) {
     $(".tunggu").hide();  
     window.location = "<?php echo base_url() . 'opname/tambah_opname_baru/' ; ?>";
     // $("#cari_transaksi").html(data);
     // // $('#jenis_filter').val('');
     // // $('#kategori_filter').val('');
   },  
   error : function(data) {  
         // alert("das");  
       }  
     });
});
function print(Object) {
  var kode_opname = Object;
  window.open("<?php echo base_url() . 'opname/print_opname_nominal/' ; ?>"+kode_opname);
  $('#modal-confirm-print').modal('hide');
}
</script>