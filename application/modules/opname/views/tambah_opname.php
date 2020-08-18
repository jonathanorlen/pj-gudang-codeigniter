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
                $kode = $this->db->get_where('transaksi_opname',array('tanggal_opname'=>$tgl));
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
            <div class="box-body">
              <div class="row">
                <div class="">
                  <!-- <div class="col-md-2">
                    <label>Jenis Bahan</label>
                    <select name="jenis_bahan" id="jenis_bahan" class="form-control" tabindex="-1" aria-hidden="true">
                      <option value="" selected="true">--Pilih Jenis Bahan--</option>
                      <option value="bahan baku">Bahan Baku</option>                     
                      <option value="bahan jadi">Bahan Jadi</option> 
                    </select>
                  </div> -->
                  <input type="hidden" class="form-control" value="bahan baku" placeholder="jenis_bahan" name="jenis_bahan" id="jenis_bahan" />
                  <div class="col-md-4">
                    <label>Nama Bahan</label>
                    <select id="kode_bahan" name="kode_bahan" class="form-control select2">
                      <option value="">Pilih Bahan</option>
                      <?php 
                      
                      $ambil_data = $this->db->get_where('master_bahan_baku',array('kode_unit'=>$kode_unit));
                      $hasil_ambil_data = $ambil_data->result();
                      foreach ($hasil_ambil_data as $key => $value) {
                       ?>
                       <option value="<?php echo $value->kode_bahan_baku ;?>"><?php echo $value->nama_bahan_baku ;?></option>
                       <?php
                     }
                     ?>
                   </select>
                 </div>
                 <input type="hidden" id="nama_bahan" name="nama_bahan" />
                 <input type="hidden" id="kode_rak" name="kode_rak" />
                 <input type="hidden" id="nama_rak" name="nama_rak" />
                 <input type="hidden" name="id_item" id="id_item" />
                 <input type="hidden" id="kode_unit" name="kode_unit" />
                 <input type="hidden" id="nama_unit" name="nama_unit" />
                 <div class="col-md-2">
                  <label>QTY</label>
                  <input type="text" class="form-control" placeholder="QTY" name="stok_akhir" id="stok_akhir" />
                </div>
                <div class="col-md-2">
                  <label>Satuan Stok</label>
                  <input type="text" readonly class="form-control" placeholder="Satuan Stok"  id="satuan_stok" />
                </div>
                <div class="col-md-4">
                  <label>Keterangan</label>
                  <input type="text" class="form-control" placeholder="Keterangan" name="keterangan" id="keterangan" />
                </div>
                <div class="col-md-1 pull-right" style="padding-top:10px;">
                  <div onclick="add_item()" id="add"  class="btn btn-primary btn-block pull-right">Add</div>
                  <div onclick="update_item()" id="update"  class="btn btn-primary btn-block pull-right">Update</div>
                </div>
              </div>
            </div>
          </div>

          <div id="list_transaksi_pembelian">
            <div class="box-body"><br>
              <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size: 1.5em;">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Jenis Bahan</th>
                    <th>Nama Unit</th>
                    <th>Nama Rak</th>
                    <th>Nama Bahan</th>
                    <th>Qty opname</th>
                    <th>Qty Fisik</th>
                    <th>Selisih</th>
                    <th>Status</th>
                    <th>Keterangan</th>
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
  $("#tabel_temp_data_opname").load("<?php echo base_url().'opname/opname/get_opname'; ?>");

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

$('#kode_bahan').on('change',function(){
  var jenis_bahan = $('#jenis_bahan').val();
  var kode_bahan = $('#kode_bahan').val();
  var url = "<?php echo base_url() . 'opname/opname/get_nama_bahan/'.$kode_unit; ?>";
  $.ajax({
    type: 'POST',
    url: url,
    dataType:'json',
    data: {kode_bahan:kode_bahan,jenis_bahan:jenis_bahan},
    success: function(msg){
      if(msg.nama_bahan_baku){
        $("#nama_bahan").val(msg.nama_bahan_baku);
        $("#satuan_stok").val(msg.satuan_stok);
      }else if(msg.nama_bahan_jadi){
        $("#nama_bahan").val(msg.nama_bahan_jadi);
      }

      if(msg.kode_rak){
        $('#kode_rak').val(msg.kode_rak);
      }else if(msg.kode_rak){
        $('#kode_rak').val(msg.kode_rak);
      }

      if(msg.nama_rak){
        $("#nama_rak").val(msg.nama_rak);
      }else if(msg.nama_rak){
        $("#nama_rak").val(msg.nama_rak);
      }

      if(msg.kode_unit){
        $('#kode_unit').val(msg.kode_unit);
      }else if(msg.kode_unit){
        $('#kode_unit').val(msg.kode_unit);
      }

      if(msg.nama_unit){
        $("#nama_unit").val(msg.nama_unit);
      }else if(msg.nama_unit){
        $("#nama_unit").val(msg.nama_unit);
      }

    }
  });
});

$("#data_form").submit(function(){
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
        window.location = "<?php echo base_url() . 'opname/daftar_opname/'.$kode_unit ; ?>";
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
      $("#tabel_temp_data_opname").load("<?php echo base_url().'opname/opname/get_opname'; ?>");
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
      $("#tabel_temp_data_opname").load("<?php echo base_url().'opname/opname/get_opname'; ?>");
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
      $("#tabel_temp_data_opname").load("<?php echo base_url().'opname/opname/get_opname'; ?>");
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
      $("#tabel_temp_data_opname").load("<?php echo base_url().'opname/opname/get_opname'; ?>");
      $('#kode_bahan').val('');
    }
  });
  return false;
}

</script>