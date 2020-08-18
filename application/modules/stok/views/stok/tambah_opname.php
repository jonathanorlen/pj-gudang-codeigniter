

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
       <?php
            $kode = $this->uri->segment(3);
            $unit = $this->db->get_where('master_unit',array('kode_unit' => $kode));
            $hasil_unite = $unit->row();
        ?>
      <h1>Data Stok <?php echo $hasil_unite->nama_unit; ?>  </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin').'/dasboard' ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
    </section>
<style type="text/css">
 .ombo{
  width: 400px;
 } 

</style>    
    <!-- Main content -->
    <section class="content">             
      <!-- Main row -->
      
        <div class="row">
        <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
                <div class="box box-info">
                    <div class="box-header">
                        <!-- tools box -->
                        <div class="pull-right box-tools"></div><!-- /. tools -->
                    </div>
                    
                    <div class="box-body">          
                        <div class="loading" style="z-index:9999999999999999; background:rgba(255,255,255,0.8); width:100%; height:100%; position:fixed; top:0; left:0; text-align:center; padding-top:25%; display:none" >
                          <img src="<?php echo base_url() . '/public/img/loading.gif' ?>">
                        </div>

                        <div style="margin-left: 5px;" class="row">
                            <?php 
                              $get_unit = $this->db->get_where('master_unit', array('group' => 'induk' ));
                              $hasil_unit = $get_unit->result_array();
                              $i = 0;
                              foreach ($hasil_unit as $item) {
                            ?> 
                              <div class="small-box bg-green menu-radius">
                                <a style="text-decoration:none" href="<?php echo base_url().'stok/daftar_stok/'.$item['kode_unit'] ; ?>">
                                <p>&nbsp;</p>
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/gudang.png'?>) no-repeat center center; background-size: 90px 90px;">
                                  <h3>&nbsp;</h3>
                                  <p>&nbsp;</p>
                                </div>
                                <div class="icon" style="margin-top:15px">
                                  <i class="ion-ios-list-outline"></i>
                                </div>
                                <a class="small-box-footer"><?php echo $item['nama_unit'];?></a></a>
                              </div>
                            <?php } ?>

                              <div class="small-box bg-green menu-radius">
                                <a style="text-decoration:none" href="<?php echo base_url().'stok/stok/daftar_mutasi'; ?>">
                                <p>&nbsp;</p>
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/mutasi.png'?>) no-repeat center center; background-size: 90px 90px;">
                                  <h3>&nbsp;</h3>
                                  <p>&nbsp;</p>
                                </div>
                                <div class="icon" style="margin-top:15px">
                                  <i class="ion-ios-list-outline"></i>
                                </div>
                                <a class="small-box-footer">Mutasi</a></a>
                              </div>

                        </div>

                    </div>
                </div>
            </section><!-- /.Left col -->      
        </div><!-- /.row (main row) -->

        <div class="row">
        <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
                <div class="box box-info">
                    <div class="box-header">
                        <!-- tools box -->
                        <div class="pull-right box-tools"></div><!-- /. tools -->
                        <?php
                          $kode_unit = $this->uri->segment(3);
                          $get_unit = $this->db->get_where('master_unit',array('kode_unit' => $kode_unit));
                          $hasil_unit = $get_unit->result_array();
                          foreach ($hasil_unit as $item) {
                        ?>
                        <a style="padding:13px; margin-bottom:10px" class="btn btn-app green" href="<?php echo base_url().'stok/daftar_stok/'.$item['kode_unit'] ; ?>">
                          <i class="fa fa-cube"></i> Stok
                        </a>
                        
                        <a style="padding:13px; margin-bottom:10px" class="btn btn-app blue" href="<?php echo base_url().'stok/daftar_opname/'.$item['kode_unit'] ; ?>">
                          <i class="fa fa-cubes"></i> Opname
                        </a>
                        
                        <a style="padding:13px; margin-bottom:10px" class="btn btn-app red" href="<?php echo base_url().'stok/daftar_spoil/'.$item['kode_unit'] ; ?>">
                          <i class="fa fa-minus"></i> Spoil
                        </a>

                        <?php } ?>
                    </div>

                    <div class="box-body">
                      <div class="box box-info">
                        <div class="box-header">
                            <!-- tools box -->
                            <div class="pull-right box-tools"></div><!-- /. tools -->
                            <div class="row"> 
                              <a style="padding:13px; margin-bottom:10px" class="btn btn-app yellow" href="<?php echo base_url().'stok/tambah_opname/'.$item['kode_unit'] ; ?>">
                                <i class="fa fa-plus"></i> Tambah Opname
                              </a>
                            </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="box-body">           
                        <div class="box box-info">
                        <div class="box-header">
                            <!-- tools box -->
                            <div class="pull-right box-tools"></div><!-- /. tools -->
                        </div>
                    <div class="sukses" ></div>
                        <form id="data_form" action="" method="post">
                            <div class="box-body">
                              <label><h3><b>Tambah Opname</b></h3></label>
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
                                      <div class="callout callout-info">
                                        <span style="font-weight:bold;"><i class="fa fa-barcode"></i>&nbsp;&nbsp;&nbsp; Kode Opname &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                                        <span style="text-align:right;"><?php echo @$hasil_kode_opname->kode_opname."_".date("dmyHis")."_".$no_belakang ?></span>
                                        <input readonly="true" type="hidden" value="<?php echo @$hasil_kode_opname->kode_opname."_".date("dmyHis")."_".$no_belakang ?>" class="form-control" placeholder="Kode Transaksi" name="kode_opname" id="kode_opname" />
                                      </div>
                                    </div>
                                  </div>

                                  <div class="col-md-6">
                                      <div class="box-body">
                                        <div class="callout callout-info">
                                          <span style="font-weight:bold;"><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp; Tanggal Opname &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                                          <span style="text-align:right;" id="tanggal_opname"><?php echo TanggalIndo(date("Y-m-d")); ?></span>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                            </div> 

                            <div class="box-body">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="col-md-2">
                                    <label>Jenis Bahan</label>
                                    <select name="jenis_bahan" id="jenis_bahan" class="form-control" tabindex="-1" aria-hidden="true">
                                      <option value="" selected="true">--Pilih Jenis Bahan--</option>
                                      <option value="bahan baku">Bahan Baku</option>                     
                                      <option value="bahan jadi">Bahan Jadi</option> 
                                    </select>
                                  </div>
                                  <div class="col-md-3">
                                    <label>Nama Bahan</label>
                                    <select id="kode_bahan" name="kode_bahan" class="form-control">
                                      <option value="">Pilih Bahan</option>
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
                                  <div class="col-md-3">
                                    <label>Keterangan</label>
                                    <input type="text" class="form-control" placeholder="Keterangan" name="keterangan" id="keterangan" />
                                  </div>
                                  <div class="col-md-2" style="padding:25px;">
                                    <div onclick="add_item()" id="add"  class="btn btn-primary">Add</div>
                                    <div onclick="update_item()" id="update"  class="btn btn-primary">Update</div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div id="list_transaksi_pembelian">
                              <div class="box-body">
                                <table id="tabel_daftar" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Jenis Bahan</th>
                                      <th>Nama Unit</th>
                                      <th>Nama Rak</th>
                                      <th>Nama Bahan</th>
                                      <th>Qty Stok</th>
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

                              <div class="box-footer">
                                <button type="submit" class="btn btn-success pull-right">Simpan</button>
                              </div>
                        </form>

                      </div>  
                    </div>
                </div>
            </section><!-- /.Left col -->      
        </div><!-- /.row (main row) -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
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
<script>
$(document).ready(function(){
  //$("#tabel_daftar").dataTable();
  $("#update").hide();
  $("#tabel_temp_data_opname").load("<?php echo base_url().'stok/stok/get_opname'; ?>");

  $("#jenis_bahan").change(function(){
      var jenis_bahan = $(this).val();
      var url = "<?php echo base_url().'stok/stok/get_bahan/'.$kode_unit; ?>";
      $.ajax({
      type: "POST",
      url: url,
      data: {jenis_bahan:jenis_bahan},
        success: function(pilihan) {              
         $("#kode_bahan").html(pilihan);
        }
    });
  });

  $('#kode_bahan').on('change',function(){
    var jenis_bahan = $('#jenis_bahan').val();
    var kode_bahan = $('#kode_bahan').val();
    var url = "<?php echo base_url() . 'stok/stok/get_nama_bahan/'.$kode_unit; ?>";
    $.ajax({
        type: 'POST',
        url: url,
        dataType:'json',
        data: {kode_bahan:kode_bahan,jenis_bahan:jenis_bahan},
        success: function(msg){
          if(msg.nama_bahan_baku){
              $("#nama_bahan").val(msg.nama_bahan_baku);
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
          var simpan_opname = "<?php echo base_url().'stok/stok/simpan_opname'?>";
          $.ajax({
              type: "POST",
              url: simpan_opname,
              data: $('#data_form').serialize(),
              success: function(msg)
              {
                $(".sukses").html(msg);   
                setTimeout(function(){$('.sukses').html('');
                  window.location = "<?php echo base_url() . 'stok/daftar_opname/'.$item['kode_unit'] ; ?>";
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
      var url = "<?php echo base_url().'stok/stok/simpan_item_opname_temp'?> ";

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
          success: function(data)
          {
              $("#tabel_temp_data_opname").load("<?php echo base_url().'stok/stok/get_opname'; ?>");
              $('#jenis_bahan').val('');
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
  var url = "<?php echo base_url().'stok/stok/get_temp_opname'; ?>";
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: {id:id},
    success: function(opname){
      $('#jenis_bahan').val(opname.jenis_bahan);
      $("#kode_bahan").empty();
      $('#kode_bahan').html("<option value="+opname.kode_bahan+" selected='true'>"+opname.nama_bahan+"</option>");
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
      $("#tabel_temp_data_opname").load("<?php echo base_url().'stok/stok/get_opname'; ?>");
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
    var url = "<?php echo base_url().'stok/stok/update_item_opname_temp/'.$kode_unit; ?> ";

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
      success: function(data)
      {
          $("#tabel_temp_data_opname").load("<?php echo base_url().'stok/stok/get_opname'; ?>");
          $('#jenis_bahan').val('');
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
    var url = '<?php echo base_url().'stok/stok/hapus_bahan_opname_temp'; ?>/delete';
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
            $('#modal-confirm').modal('hide');
            $("#tabel_temp_data_opname").load("<?php echo base_url().'stok/stok/get_opname'; ?>");
           
        }
    });
    return false;
}
   
</script>