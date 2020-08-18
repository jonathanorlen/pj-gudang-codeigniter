

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Data Menu </h1>
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
                        <div class="sukses" ></div>
                        
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
                    <div class="box-body"> 
                      <a style="padding:13px; margin-bottom:10px" class="btn btn-app green" href="<?php echo base_url().'stok/stok/mutasi'; ?>">
                        <i class="fa fa-plus"></i> Tambah Mutasi
                      </a>
                      
                      <a style="padding:13px; margin-bottom:10px" class="btn btn-app blue" href="<?php echo base_url().'stok/stok/daftar_mutasi'; ?>">
                        <i class="fa fa-list"></i> Daftar Mutasi
                      </a>

                        <table id="tabel_daftar" class="table table-bordered table-striped">
                            <?php
                              $this->db->group_by('kode_mutasi','desc');
                              $mutasi = $this->db->get('opsi_transaksi_mutasi');
                              $hasil_mutasi = $mutasi->result();
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
                                      ?> 
                                    <tr>
                                      <td><?php echo $nomor; ?></td>
                                      <td><?php echo @$daftar->kode_mutasi; ?></td>
                                      <td><?php echo @$daftar->tanggal_update; ?></td>
                                      <td><?php echo @$daftar->petugas; ?></td>
                                      <td><?php echo get_detail_mutasi($daftar->kode_mutasi); ?></td>
                                    </tr>
                                <?php $nomor++; } ?>
                               
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
<script>
$(document).ready(function(){
  //$("#tabel_daftar").dataTable();
  $("#update").hide();


  $("#unit_awal").change(function(){
      var unit_awal = $("#unit_awal").val();
      var url = "<?php echo base_url().'stok/mutasi/get_rak_unit_awal'; ?>";
      $.ajax({
          type: "POST",
          url: url,
          data: {unit_awal:unit_awal},
            success: function(pilihan) {   
              var data = pilihan.split("|");
              var rak = data[0];
              var unit = data[1];  
              $("#rak_awal").html(rak);
              //alert(unit);
              $("#nama_unit_awal").val(unit);
            }
      });
  });

  $("#unit_akhir").change(function(){
      var unit_akhir = $("#unit_akhir").val();
      var url = "<?php echo base_url().'stok/mutasi/get_rak_unit_akhir'; ?>";
      $.ajax({
          type: "POST",
          url: url,
          data: {unit_akhir:unit_akhir},
            success: function(pilihan) {   
              var data = pilihan.split("|");
              var rak = data[0];
              var unit = data[1];  
              $("#rak_akhir").html(rak);
              //alert(unit);
              $("#nama_unit_akhir").val(unit);          
            }
      });
  });

  $("#rak_awal").change(function(){
      var rak_awal = $("#rak_awal").val();
      var url = "<?php echo base_url().'stok/mutasi/get_nama_rak_awal'; ?>";
      $.ajax({
          type: "POST",
          url: url,
          data: {rak_awal:rak_awal},
            success: function(rak) {   
              //alert(rak);
              $("#nama_rak_awal").val(rak);
            }
      });
  });

  $("#rak_akhir").change(function(){
      var rak_akhir = $("#rak_akhir").val();
      var url = "<?php echo base_url().'stok/mutasi/get_nama_rak_akhir'; ?>";
      $.ajax({
          type: "POST",
          url: url,
          data: {rak_akhir:rak_akhir},
            success: function(rak) {   
              //alert(rak);
              $("#nama_rak_akhir").val(rak);
            }
      });
  });

  $("#kategori_bahan").change(function(){
      var jenis_bahan = $(this).val();
      var unit_awal = $("#unit_awal").val();
      var rak_awal = $("#rak_awal").val();     
      var url = "<?php echo base_url().'stok/mutasi/get_bahan'; ?>";

      //alert(unit_awal); alert(rak_awal);
      if(unit_awal=='' && rak_awal==''){
          alert('Posisi Gudang dan rak asal harus diisi');
      }
      else{
          $.ajax({
                type: "POST",
                url: url,
                data: {jenis_bahan:jenis_bahan,kode_unit_asal:unit_awal,kode_rak_asal:rak_awal},
                  success: function(pilihan) {              
                   $("#kode_bahan").html(pilihan);
                  }
          });
      }
  });

  $('#kode_bahan').on('change',function(){
          var jenis_bahan = $('#kategori_bahan').val();
          var kode_bahan = $('#kode_bahan').val();
          var url = "<?php echo base_url() . 'stok/mutasi/get_satuan' ?>";
          $.ajax({
              type: 'POST',
              url: url,
              dataType:'json',
              data: {kode_bahan:kode_bahan,jenis_bahan:jenis_bahan},
              success: function(msg){
                if(msg.satuan_pembelian){
                    $('#nama_satuan').val(msg.satuan_pembelian);
                }else if(msg.satuan_stok){
                    $('#nama_satuan').val(msg.satuan_stok);
                }
                if(msg.id_satuan_pembelian){
                    $("#kode_satuan").val(msg.id_satuan_pembelian);
                }else if(msg.kode_satuan_stok){
                    $("#kode_satuan").val(msg.kode_satuan_stok);
                }
                if(msg.nama_bahan_baku){
                    $("#nama_bahan").val(msg.nama_bahan_baku);
                }else if(msg.nama_bahan_jadi){
                    $("#nama_bahan").val(msg.nama_bahan_jadi);
                }
                
              }
          });
  });

  $("#data_form").submit(function(){
          var simpan_mutasi = "<?php echo base_url().'stok/mutasi/simpan_mutasi/'?>";
          $.ajax({
              type: "POST",
              url: simpan_mutasi,
              data: $('#data_form').serialize(),
              success: function(msg)
              {
                $(".sukses").html(msg);   
                setTimeout(function(){$('.sukses').html('');
                  window.location = "<?php echo base_url() . 'stok/menu_stok/' ?>";
                },1800);        
              }
          });
          return false;

  });

})

function add_item(){
      var kategori_bahan = $('#kategori_bahan').val();
      var unit_awal = $("#unit_awal").val();
      var rak_awal = $("#rak_awal").val();    
      var kode_bahan = $('#kode_bahan').val();
      var nama_bahan = $('#nama_bahan').val();
      var jumlah = $('#jumlah').val();
      var kode_mutasi = $('#kode_mutasi').val();

      var url = "<?php echo base_url().'stok/mutasi/simpan_item_mutasi_temp/'?> ";

      $.ajax({
          type: "POST",
          url: url,
          data: { 
                  kategori_bahan:kategori_bahan,
                  kode_bahan:kode_bahan,
                  jumlah:jumlah,
                  nama_bahan:nama_bahan,
                  kode_mutasi:kode_mutasi,
                  kode_unit_asal:unit_awal,
                  kode_rak_asal:rak_awal
                },
          success: function(hasil)
          {
              var data = hasil.split("|");
              var num = data[0];
              var pesan = data[1];
              if(num==1){
                $("#tabel_temp_data_mutasi").load("<?php echo base_url().'stok/mutasi/tabel_item_mutasi_temp/'; ?>"+kode_mutasi);
                $('#kategori_bahan').val('');
                $('#kode_bahan').val('');
                $('#jumlah').val('');
              }
              else {
                $(".gagal").html(pesan);   
                setTimeout(function(){
                    $('.gagal').html('');
                },1500);
              }               
          }
      });
}

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
  
function actEdit(id) {
  var id = id;
  var kode_mutasi = $('#kode_mutasi').val();
  var url = "<?php echo base_url().'stok/mutasi/get_temp_mutasi'; ?>";
  $.ajax({
          type: 'POST',
          url: url,
          dataType: 'json',
          data: {id:id},
          success: function(mutasi){
            $('#kategori_bahan').val(mutasi.kategori_bahan);
            $("#kode_bahan").empty();
            $('#kode_bahan').html("<option value="+mutasi.kode_bahan+" selected='true'>"+mutasi.nama_bahan+"</option>");
            $("#nama_bahan").val(mutasi.nama_bahan);
            $('#jumlah').val(mutasi.jumlah);
            $("#id_item_temp").val(mutasi.id);
            $("#add").hide();
            $("#update").show();
            $("#tabel_temp_data_mutasi").load("<?php echo base_url().'stok/mutasi/tabel_item_mutasi_temp/'; ?>"+kode_mutasi);
          }
      });
}

function update_item(){
      var kode_mutasi = $('#kode_mutasi').val();
      var kategori_bahan = $('#kategori_bahan').val();
      var kode_bahan = $('#kode_bahan').val();
      var jumlah = $('#jumlah').val();
      var nama_bahan = $("#nama_bahan").val();
      var id_item_temp = $("#id_item_temp").val();
      var url = "<?php echo base_url().'stok/mutasi/ubah_item_mutasi_temp/'?> ";

      $.ajax({
          type: "POST",
          url: url,
          data: { kode_mutasi:kode_mutasi,
                  kategori_bahan:kategori_bahan,
                  kode_bahan:kode_bahan,
                  nama_bahan:nama_bahan,
                  jumlah:jumlah,
                  id:id_item_temp
                },
          success: function(data)
          {
              $("#tabel_temp_data_mutasi").load("<?php echo base_url().'stok/mutasi/tabel_item_mutasi_temp/'; ?>"+kode_mutasi);
              $('#kategori_bahan').val('');
              $('#kode_bahan').val('');
              $('#jumlah').val('');
              $("#nama_bahan").val('');
              $("#id_item_temp").val('');
              $("#add").show();
              $("#update").hide();
              
          }
      });
  }

function delData() {
  var id = $('#id-delete').val();
  var kode_mutasi = $('#kode_mutasi').val();
  var url = "<?php echo base_url().'stok/mutasi/hapus_temp'; ?>";
  $.ajax({
          type: 'POST',
          url: url,
          data: {id:id},
          success: function(pembelian){
              $('#modal-confirm').modal('hide');
              $("#tabel_temp_data_mutasi").load("<?php echo base_url().'stok/mutasi/tabel_item_mutasi_temp/'; ?>"+kode_mutasi);
              $('#kategori_bahan').val('');
              $('#kode_bahan').val('');
              $('#jumlah').val('');
          }
      });
}

</script>