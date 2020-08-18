<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Tambah Opname

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
        <?php
        //$kode_unit = $this->uri->segment(3);
        $kode_default = $this->db->get('setting_gudang');
        $hasil_unit =$kode_default->row();
        $kode_unit = $hasil_unit->kode_unit;
        //echo 'kode unit '.$kode_unit;

        ?>
        <div class="box-body">                   
          <div class="sukses" ></div>
          <form id="data_form" action="" method="post">
            <div class="box-body">
              <div class="row">
                <?php
                $tgl = date("Y-m-d");
                $no_belakang = 0;
                $this->db->select_max('kode_opname');
                $kode = $this->db->get_where('transaksi_opname',array('tanggal_opname'=>$tgl,'status_opname'=>'view'));
                $hasil_kode = $kode->row();
                                        #$pecah_kode = explode("_",$hasil_kode_pembelian->kode_pembelian);
                                        #echo $pecah_kode[0];
                                        #echo $pecah_kode[2];
                $this->db->select('kode_opname');
                $kode_opname = $this->db->get('master_setting');
                $hasil_kode_opname = $kode_opname->row();

                if(count($hasil_kode)==0){
                  $no_belakang = 1;
                }
                else{
                  $pecah_kode = explode("_",$hasil_kode->kode_opname);
                  $no_belakang = @$pecah_kode[2]+1;
                }

                                        #echo $this->db->last_query();

                ?>
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="btn btn-app blue">
                      <span style="font-weight:bold;"><i class="fa fa-barcode"></i>&nbsp;&nbsp;&nbsp; Kode Opname &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                      <span style="text-align:right;"><?php echo @$hasil_kode_opname->kode_opname."_".date("dmyHis")."_".$no_belakang ?></span>
                      <input readonly="true" type="hidden" value="<?php echo @$hasil_kode_opname->kode_opname."_".date("dmyHis")."_".$no_belakang ?>" class="form-control" placeholder="Kode Transaksi" name="kode_opname" id="kode_opname" />
                    </div>
                  </div>
                </div>

                <div class="col-md-6 ">
                  <div class="box-body">
                    <div class="btn btn-app blue pull-right">
                      <span style="font-weight:bold;"><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp; Tanggal Opname &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                      <span style="text-align:right;" id="tanggal_opname"><?php echo TanggalIndo(date("Y-m-d")); ?></span>
                    </div>
                  </div>
                </div>
              </div>
            </div> 
            <br><br>
            

          <div id="list_transaksi_pembelian">
            <div class="box-body"><br>
              <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size: 1.5em;">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Nama Unit</th>
                    <th>Nama Blok</th>
                    
                    <th>Qty opname</th>
                     <th>Qty Fisik</th> 
                     <th>Selisih</th>
                    <th>Status</th>
                   <!--  <th>Keterangan</th> -->
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="tabel_temp_data_opname">

                </tbody>
                <tfoot>

                </tfoot>
              </table>
            </div>
          </div>
          <button type="submit" class="btn btn-success">Simpan</button>
          <div class="box-footer clearfix">

          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<!------------------------------------------------------------------------------------------------------>

<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data opname tersebut ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()" class="btn red">Ya</button>
      </div>
    </div>
  </div>
</div>
<div id="modal-confirm-print" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi Print</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:14pt">Apakah anda ingin akan mencetak data opname tersebut ?</span>
        <input id="kode_opname_print" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button onclick="daftar_opname()"class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="print()" class="btn red">Ya</button>
      </div>
    </div>
  </div>
</div>
<style type="text/css" media="screen">
        .btn-back
          {
            position: fixed;
            bottom: 10px;
             left: 10px;
            z-index: 999999999999999;
                vertical-align: middle;
                cursor:pointer
          }
        </style>
                <img class="btn-back" src="<?php echo base_url().'component/img/back_icon.png'?>" style="width: 70px;height: 70px;">


        <script>
          $('.btn-back').click(function(){
$(".tunggu").show();
            window.location = "<?php echo base_url().'opname/daftar_opname'; ?>";
          });
        </script>
<script>
$(document).ready(function(){
  //$("#tabel_daftar").dataTable();
  
  $("#update").hide();
   $("#tabel_temp_data_opname").load("<?php echo base_url().'opname/opname/get_opname_v/View'; ?>");

  // $("#jenis_bahan").change(function(){
  //   var jenis_bahan = $(this).val();
  //   var url = "<?php echo base_url().'opname/opname/get_bahan/'.$kode_unit; ?>";
  //   $.ajax({
  //     type: "POST",
  //     url: url,
  //     data: {jenis_bahan:jenis_bahan},
  //     success: function(pilihan) {              
  //      $("#kode_bahan").html(pilihan);
  //    }
  //  });
  // });

// $("#stok_akhir").keyup(function() {
//   var stok_akhir = $('#stok_akhir').val();
//   var kode_bahan = $('#kode_bahan').val();
//   var kode_opname = $('#kode_opname').val();
//   var url = "<?php echo base_url() . 'opname/opname/get_nama_bahan/'.$kode_unit; ?>";
//   $.ajax({
//     type: 'POST',
//     url: url,
//     dataType:'json',
//     data: {kode_bahan:kode_bahan,stok_akhir:stok_akhir,kode_opname:kode_opname},
//     success: function(msg){
//       alert(kode_bahan);
//      $("#tabel_temp_data_opname").load("<?php echo base_url().'opname/opname/get_opname_v'; ?>");
//     }
//   });
// });

$("#data_form").submit(function(){
  var kode_opname = $('#kode_opname').val();
  var simpan_opname = "<?php echo base_url().'opname/opname/simpan_opname'?>";
  $.ajax({
    type: "POST",
    url: simpan_opname,
    data: $('#data_form').serialize(),
    beforeSend:function(){
          $(".tunggu").show();  
        },
    success: function(msg)
    {
        $(".tunggu").hide();
      $(".sukses").html(msg);   
      setTimeout(function(){$('.sukses').html('');
        //window.location = "<?php //echo base_url() . 'opname/daftar_opname/'.$kode_unit ; ?>";
      $('#kode_opname_print').val(kode_opname);
      $('#modal-confirm-print').modal('show');
      },1500);        
    }
  });
  return false;

});

})


function add_item(){
  var kode_opname = $('#kode_opname').val();
  var jenis_bahan = $('#jenis_bahan').val();
  var kode_bahan = $('#kode_bahan').val();
  var stok_akhir = $('#stok_akhir').val();
  var nama_bahan = $("#nama_bahan").val();
  var kode_unit = $("#kode_unit").val();
  var nama_unit = $("#nama_unit").val();
  var kode_rak = $("#kode_rak").val();
  var nama_rak = $("#nama_rak").val();
  var keterangan = $("#keterangan").val();
  var url = "<?php echo base_url().'opname/opname/simpan_item_opname_temp'?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { kode_opname:kode_opname,
      jenis_bahan:jenis_bahan,
      kode_bahan:kode_bahan,
      nama_bahan:nama_bahan,
      stok_akhir:stok_akhir,
      kode_unit:kode_unit,
      nama_unit:nama_unit,
      kode_rak:kode_rak,
      nama_rak:nama_rak,
      keterangan:keterangan
    },
    beforeSend:function(){
          $(".tunggu").show();  
        },
    success: function(data)
    {
      $(".tunggu").hide();
       $("#tabel_temp_data_opname").load("<?php echo base_url().'opname/opname/get_opname_v/View'; ?>");
      
      //$('#jenis_bahan').val('');
      $('#kode_bahan').val('');
      $('#stok_akhir').val('');
      $("#kode_rak").val('');
      $('#nama_rak').val('');
      $("#kode_unit").val('');
      $('#nama_unit').val('');
      $("#nama_bahan").val('');
      $("#keterangan").val('');

    }
  });
}

function actEdit(id) {
  var id = id;
  var url = "<?php echo base_url().'opname/opname/get_temp_opname'; ?>";
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: {id:id},
    success: function(opname){
      $('#jenis_bahan').val(opname.jenis_bahan);
      //$("#kode_bahan").empty();
      //$('#kode_bahan').html("<option value="+opname.kode_bahan+" selected='true'>"+opname.nama_bahan+"</option>");
      $("#kode_bahan").val(opname.kode_bahan);
      $("#nama_bahan").val(opname.nama_bahan);
      $('#stok_akhir').val(opname.stok_akhir);
      $('#kode_unit').val(opname.kode_unit);
      $('#nama_unit').val(opname.nama_unit);
      $('#kode_rak').val(opname.kode_rak);
      $('#nama_rak').val(opname.nama_rak);
      $('#keterangan').val(opname.keterangan);
      $("#id_item").val(opname.id);
      $("#add").hide();
      $("#update").show();
       $("#tabel_temp_data_opname").load("<?php echo base_url().'opname/opname/get_opname_v/View'; ?>");
    }
  });
}

function update_item(){
  var kode_opname = $('#kode_opname').val();
  var jenis_bahan = $('#jenis_bahan').val();
  var kode_bahan = $('#kode_bahan').val();
  var stok_akhir = $('#stok_akhir').val();
  var kode_unit = $("#kode_unit").val();
  var nama_unit = $("#nama_unit").val();
  var kode_rak = $('#kode_rak').val();
  var nama_rak = $("#nama_rak").val();
  var nama_bahan = $("#nama_bahan").val();
  var keterangan = $("#keterangan").val();
  var id_item = $("#id_item").val();
  var url = "<?php echo base_url().'opname/opname/update_item_opname_temp/'.$kode_unit; ?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { kode_opname:kode_opname,
      jenis_bahan:jenis_bahan,
      kode_bahan:kode_bahan,
      nama_bahan:nama_bahan,
      stok_akhir:stok_akhir,
      kode_unit:kode_unit,
      nama_unit:nama_unit,
      kode_rak:kode_rak,
      nama_rak:nama_rak,
      keterangan:keterangan,
      id:id_item
    },
    beforeSend:function(){
          $(".tunggu").show();  
        },
    success: function(data)
    {
      $(".tunggu").hide();
       $("#tabel_temp_data_opname").load("<?php echo base_url().'opname/opname/get_opname_v/View'; ?>");
      //$('#jenis_bahan').val('');
      $('#kode_bahan').val('');
      $('#stok_akhir').val('');
      $("#kode_rak").val('');
      $('#nama_rak').val('');
      $("#kode_unit").val('');
      $('#nama_unit').val('');
      $("#nama_bahan").val('');
      $("#keterangan").val('');
      $("#id_item").val('');
      $("#add").show();
      $("#update").hide();
    }
  });
}

function actDelete(Object) {
  $('#id-delete').val(Object);
  $('#modal-confirm').modal('show');
}

function delData() {
  var id = $('#id-delete').val();
  var url = '<?php echo base_url().'opname/opname/hapus_bahan_opname_temp'; ?>/delete';
  $.ajax({
    type: "POST",
    url: url,
    data: {
      id:id
    },
    beforeSend:function(){
          $(".tunggu").show();  
        },
success: function(msg) {
  $(".tunggu").hide();
      $('#modal-confirm').modal('hide');
      $("#tabel_temp_data_opname").load("<?php echo base_url().'opname/opname/get_opname_v/View'; ?>");
      $('#kode_bahan').val('');
    }
  });
  return false;
}
function print() {
  var kode_opname = $('#kode_opname').val();
  window.open("<?php echo base_url() . 'opname/print_opname/' ; ?>"+kode_opname);
  $('#modal-confirm-print').modal('hide');
window.location = "<?php echo base_url() . 'opname/daftar_opname/'.$kode_unit ; ?>";
}
function daftar_opname(Object) {
window.location = "<?php echo base_url() . 'opname/daftar_opname/'.$kode_unit ; ?>";
$('#modal-confirm-print').modal('hide');
}
</script>