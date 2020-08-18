<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Tambah Mutasi

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
        $kode_default = $this->db->get('setting_gudang');
        $hasil_unit =$kode_default->row();
        $kode_unit = $hasil_unit->kode_unit;
        //$kode_unit = $this->uri->segment(3);
        $get_unit = $this->db->get_where('master_unit',array('kode_unit' => $kode_unit));
        $hasil_unit = $get_unit->result_array();

        ?>
        <div class="box-body">                   
          <div class="sukses" ></div>
          <form id="data_form" action="" method="post">

            <div class="box-body">
              <div class="callout callout-info">
              
              </div>


              <?php
              $tgl = date("Y-m-d");
              $no_belakang = 0;
              $this->db->select_max('kode_mutasi');
              $kode = $this->db->get_where('transaksi_mutasi',array('tanggal_update'=>$tgl));
              $hasil_kode = $kode->row();
                                        #$pecah_kode = explode("_",$hasil_kode_pembelian->kode_pembelian);
                                        #echo $pecah_kode[0];
                                        #echo $pecah_kode[2];
              $this->db->select('kode_mutasi');
              $kode_mutasi = $this->db->get('master_setting');
              $hasil_kode_mutasi = $kode_mutasi->row();

              if(count($hasil_kode)==0){
                $no_belakang = 1;
              }
              else{
                $pecah_kode = explode("_",$hasil_kode->kode_mutasi);
                $no_belakang = @$pecah_kode[2]+1;
              }

                                        #echo $this->db->last_query();

              ?>
              <input type="hidden" value="<?php echo @$hasil_kode_mutasi->kode_mutasi."_".date("dmyHis")."_".$no_belakang ?>" class="form-control" placeholder="Kode Transaksi" name="kode_mutasi" id="kode_mutasi" readonly/>                           

              <div class="row">
                <div class="col-md-2">
                  <h3>Posisi Asal</h3>
                </div>
                <div class="col-md-1">
                  <h3> : </h3>
                </div>
                <div class="col-md-4">
                  <label>Unit </label>
                  <?php 
                  $unit = $this->db->get_where('master_unit',array('kode_unit' => $kode_unit));
                  $hasil_posisi_unit = $unit->row();
                  ?> 
                  <!-- <select id="unit_awal" name="kode_unit_asal" class="form-control" required="">
                    <option value="">Pilih Unit</option>
                    <?php foreach($hasil_posisi_unit as $daftar){ ?>
                    <option value="<?php //echo $daftar->kode_unit ?>"><?php //echo $daftar->nama_unit ?></option>
                    <?php } ?>
                  </select> -->
                  <input type="hidden" value="<?php echo $hasil_posisi_unit->kode_unit;?>"  id="unit_awal" name="kode_unit_asal" />
                  <input type="text" readonly class="form-control" id="nama_unit_awal" name="nama_unit_asal" />
                </div>
                <div class="col-md-5">
                  <label>Rak </label>
                  <select id="rak_awal" name="kode_rak_asal" class="form-control" required="">
                    <option value="">Pilih Rak</option>
                  </select>
                  <input type="hidden" id="nama_rak_awal" name="nama_rak_asal" />
                </div>

              </div>
            </div> 
            <br>
            <div class="box-body">
              <div class="row">

                <div class="col-md-2">
                  <h3>Posisi Tujuan </h3>
                </div>
                  <div class="col-md-1">
                  <h3>: </h3>
                </div>
                <div class="col-md-4">
                  <label>Unit </label>
                  <?php 
                  $unit = $this->db->get_where('master_unit',array('status'=>'1','group'=>'stok'));
                  $hasil_posisi_unit = $unit->result();
                  ?> 
                  <select id="unit_akhir" name="kode_unit_tujuan" class="form-control" required="">
                    <option value="">Pilih Unit</option>
                    <?php foreach($hasil_posisi_unit as $daftar){ ?>
                    <option value="<?php echo $daftar->kode_unit ?>"><?php echo $daftar->nama_unit ?></option>
                    <?php } ?>
                  </select>
                  <input type="hidden" id="nama_unit_akhir" name="nama_unit_tujuan" />
                </div>
                <div class="col-md-5">
                  <label>Rak </label>
                  <select id="rak_akhir" name="kode_rak_tujuan" class="form-control" required="">
                    <option value="">Pilih Rak</option>
                  </select>
                  <input type="hidden" id="nama_rak_akhir" name="nama_rak_tujuan" />
                </div>

              </div>
            </div> 
            <div class="sukses" ></div>
            <br>
            <br>
            <div class="gagal"></div>
            <div class="box-body">
              <div class="row">
                <div class="">
                  <div class="col-md-3">
                    <label>Produk </label>
                    <select name="kategori_barang" id="kategori_barang" class="form-control" tabindex="-1" aria-hidden="true">
                      <option value="" selected="true">--Pilih Produk--</option>
                      <?php
                        $produk = $this->db->get_where('master_bahan_baku',array('status_produk'=>'produk'));
                        $hasil_produk = $produk->result();
                        foreach($hasil_produk as $daftar){
                      ?> 
                      <option value="<?php echo $daftar->kode_bahan_baku ?>"><?php echo $daftar->nama_bahan_baku ?></option>
                      <?php } ?>
                    </select>
                    
                  </div>
                  
                  
                  <div id="subproduk" class="col-md-4">
                    <label>Nama Sub Produk</label>
                    <select id="kode_bahan" name="kode_bahan" class="form-control">
                      <option value="">Pilih Bahan</option>
                    </select>
                    <!--<input type="hidden" id="nama_bahan" name="nama_bahan" />
                    <input type="hidden" id="jenis_bahan" name="jenis_bahan" />-->
                  </div>
                  
                  <div class="col-md-3">
                    <label>QTY</label>
                    <input type="text" class="form-control" placeholder="QTY" name="jumlah" id="jumlah" />
                  </div>
                  <div class="col-md-2">
                    <label>Satuan Stok</label>
                    <input type="text" readonly class="form-control" placeholder="Satuan Stok" name="nama_satuan" id="nama_satuan" />
                  </div>
                  <div class="col-md-1 pull-right" style="padding-top:10px;">
                    <div onclick="add_item()" id="add"  class="btn btn-primary btn-block">Add</div>
                    <div onclick="update_item()" id="update"  class="btn btn-primary btn-block">Update</div>
                    <input type="hidden" name="id_item_temp" id="id_item_temp" />
                  </div>
                </div>
              </div>
            </div>

            <div id="list_transaksi_pembelian">
              <div class="box-body"><br>
                <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode Bahan</th>
                      <th>Nama Bahan</th>
                      <th>QTY</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="tabel_temp_data_mutasi">

                  </tbody>
                  <tfoot>

                  </tfoot>
                </table>
              </div>

              <div class="box-body">
                <div class="row">
                  <div class="col-md-9">
                    <label>Keterangan</label>
                    <textarea class="form-control" value="" name="keterangan" id="keterangan" required=""></textarea>
                  </div>
                </div>
              </div>

            </div>
            <?php
            $pending = $this->db->get_where('transaksi_stok',array('status'=>'pending'));
            $hasil_pending = $pending->result();
            if(count($hasil_pending)>0){
              ?>
              <div class="box-body">

                <label><h4><strong>Bahan Pending</strong></h4></label>
                <table id="tabel_daftare" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Bahan</th>
                      <th>Nama Unit</th>
                      <th>Nama Rak</th>
                      <th>QTY</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no=1; foreach($hasil_pending as $daftar){

                      ?>
                      <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $daftar->nama_bahan; ?></td>
                        <td><?php echo $daftar->nama_unit_asal; ?></td>
                        <td><?php echo $daftar->nama_rak_asal; ?></td>
                        <td><?php echo $daftar->stok_keluar; ?></td>
                      </tr>
                      <?php $no++; } ?>
                    </tbody>
                    <tfoot>

                    </tfoot>
                  </table>
                </div>
                <?php } ?>
                <a id="simpan" class="btn btn-success ">Simpan</a>
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
            window.location = "<?php echo base_url().'mutasi/daftar_mutasi'; ?>";
          });
        </script>
    <script>
    $(document).ready(function(){
  //$("#tabel_daftar").dataTable();
  $("#update").hide();
  

  //$("#unit_awal").change(function(){
    var unit_awal = $("#unit_awal").val();
    var url = "<?php echo base_url().'mutasi/get_rak_unit_awal'; ?>";
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
  //});

$("#unit_akhir").change(function(){
  var unit_akhir = $("#unit_akhir").val();
  var url = "<?php echo base_url().'mutasi/get_rak_unit_akhir'; ?>";
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

$("#kategori_barang").change(function(){
  var produk = $("#kategori_barang").val();
  var kategori_barang = "bahan baku";
  var rak_awal=$("#rak_awal").val();
  var unit_awal=$("#unit_awal").val();
  var url = "<?php echo base_url().'mutasi/get_kategori_barang'; ?>";
  $.ajax({
    type: "POST",
    url: url,
    data: {kategori_barang:kategori_barang,rak_awal:rak_awal,unit_awal,unit_awal,produk:produk},
    success: function(pilihan) {
        $("#subproduk").show();
      var data = pilihan.split("|");
              //alert(unit);
              $("#kode_bahan").html(data[0]); 
              //$("#nama_bahan").html(data[1]);
              //alert(data[1]);
              
              var kode_bahan = $("#kategori_barang").val();
            var url = "<?php echo base_url().'mutasi/get_satuan'; ?>"; 
                         $.ajax({
                type: "POST",
                url: url,
                dataType:"json",
                data: {kode_bahan:kode_bahan,kategori_barang:kategori_barang},
                success: function(data) {
                        $("#nama_satuan").val(data.satuan_stok);
            
                        }
                        
                        
                      });

            }
            
            
          });
});
$("#rak_awal").change(function(){
  var rak_awal = $("#rak_awal").val();
  var url = "<?php echo base_url().'mutasi/get_nama_rak_awal'; ?>";
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
  var url = "<?php echo base_url().'mutasi/get_nama_rak_akhir'; ?>";
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

$("#rak_awal").change(function(){
  var jenis_bahan = $(this).val();
  var unit_awal = $("#unit_awal").val();
  var rak_awal = $("#rak_awal").val();  
  var unit_akhir = $("#unit_akhir").val();
  var rak_akhir = $("#rak_akhir").val();     
  var url = "<?php echo base_url().'mutasi/get_bahan'; ?>";

      //alert(unit_awal); alert(rak_awal);
      if(unit_awal=='' && rak_awal=='' && unit_akhir=='' && rak_akhir=='' ){
        alert('Posisi Gudang dan rak (asal dan tujuan) harus diisi');
      }
      else{
        $.ajax({
          type: "POST",
          url: url,
          data: {jenis_bahan:jenis_bahan,kode_unit_asal:unit_awal,kode_rak_asal:rak_awal},
          success: function(pilihan) {              
           //$("#kode_bahan").html(pilihan);
         }
       });
      }
    });

$('#kode_bahan').on('change',function(){
  var jenis_bahan = $('#kategori_bahan').val();
  var unit_awal = $('#unit_awal').val();
  var kode_bahan = $('#kode_bahan').val();
  var kategori_barang = "bahan baku";
  var url = "<?php echo base_url() . 'mutasi/get_satuan' ?>";
  $.ajax({
    type: 'POST',
    url: url,
    dataType:'json',
    data: {kode_bahan:kode_bahan,jenis_bahan:jenis_bahan,kategori_barang:kategori_barang,unit_awal:unit_awal},
    success: function(msg){
      // if(msg.satuan_pembelian){
      //   $('#nama_satuan').val(msg.satuan_pembelian);
      // }else
      if(msg.satuan_stok){
        $('#nama_satuan').val(msg.satuan_stok);
      }if(msg.jenis_bahan){
        $('#jenis_bahan').val(msg.jenis_bahan);
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
      }else if(msg.nama_barang){
        $("#nama_bahan").val(msg.nama_barang);
      }

    }
  });
});

$('#kode_bahan').on('change',function(){
  var jenis_bahan = $('#kategori_bahan').val();
  var unit_awal = $('#unit_awal').val();
  var kode_bahan = $('#kode_bahan').val();
  var kategori_barang = "bahan baku";
  var url = "<?php echo base_url() . 'mutasi/get_satuan' ?>";
  $.ajax({
    type: 'POST',
    url: url,
    dataType:'json',
    data: {kode_bahan:kode_bahan,jenis_bahan:jenis_bahan,kategori_barang:kategori_barang,unit_awal:unit_awal},
    success: function(msg){
      // if(msg.satuan_pembelian){
      //   $('#nama_satuan').val(msg.satuan_pembelian);
      // }else
      if(msg.satuan_stok){
        $('#nama_satuan').val(msg.satuan_stok);
      }if(msg.jenis_bahan){
        $('#jenis_bahan').val(msg.jenis_bahan);
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
      }else if(msg.nama_barang){
        $("#nama_bahan").val(msg.nama_barang);
      }

    }
  });
});

$("#simpan").click(function(){
  var simpan_mutasi = "<?php echo base_url().'mutasi/simpan_mutasi/'?>";
  $.ajax({
    type: "POST",
    url: simpan_mutasi,
    data: $('#data_form').serialize(),
    beforeSend:function(){
          $(".tunggu").show();  
        },
    success: function(msg)
    {
      $(".tunggu").hide();
      if(msg=="stok kurang"){
        $(".sukses").html('<div class="alert alert-warning">Mutasi lebih kecil dari bahan pending</div>');
        setTimeout(function(){$('.sukses').html('');},1800); 
      }else{
        $(".sukses").html(msg);   
        setTimeout(function(){$('.sukses').html('');
          window.location = "<?php echo base_url() . 'mutasi/daftar_mutasi' ?>";
        },1800);  
      }

    }
  });
  return false;

});

})

function add_item(){
  var kategori_bahan = "bahan baku";
  var unit_awal = $("#unit_awal").val();
  var nama_unit = $("#nama_unit_awal").val();
  var rak_awal = $("#rak_awal").val();    
  var kode_bahan = $('#kode_bahan').val();
  var nama_bahan = $('#nama_bahan').val();
  var jumlah = $('#jumlah').val();
  var nama_satuan=$('#nama_satuan').val();
  var kode_mutasi = $('#kode_mutasi').val();
  var produk = $('#kategori_barang').val();


  var url = "<?php echo base_url().'mutasi/simpan_item_mutasi_temp/'?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { 
      kategori_bahan:kategori_bahan,
      kode_bahan:kode_bahan,
      jumlah:jumlah,
      nama_unit:nama_unit,
      nama_bahan:nama_bahan,
      kode_mutasi:kode_mutasi,
      kode_unit_asal:unit_awal,
      kode_rak_asal:rak_awal,
      nama_satuan:nama_satuan,
      produk:produk
    },
    beforeSend:function(){
          $(".tunggu").show();  
        },
    success: function(hasil)
    {
      $(".tunggu").hide();
      var data = hasil.split("|");
      var num = data[0];
      var pesan = data[1];
      $("#tabel_temp_data_mutasi").load("<?php echo base_url().'mutasi/tabel_item_mutasi_temp/'; ?>"+kode_mutasi);
        //$('#kategori_bahan').val('');
        $('#kode_bahan').val('');
        $('#jumlah').val('');
      if(num==1){
        
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
  $(".tunggu").hide();
      $('#modal-confirm').modal('hide');
            // alert(id);
            $('#kode_bahan').val('');
            window.location.reload();
            $('#kategori_bahan').val('bahan baku');
          }
        });
  return false;
}

function actEdit(id) {
  var id = id;
  var kode_mutasi = $('#kode_mutasi').val();
  var url = "<?php echo base_url().'mutasi/get_temp_mutasi'; ?>";
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: {id:id},
    success: function(mutasi){
      $('#kategori_bahan').val(mutasi.kategori_bahan);
      //$("#kode_bahan").empty();
      //$('#kode_bahan').html("<option value="+mutasi.kode_bahan+" selected='true'>"+mutasi.nama_bahan+"</option>");
      $("#kode_bahan").val(mutasi.kode_bahan);
      $("#nama_bahan").val(mutasi.nama_bahan);
      $('#jumlah').val(mutasi.jumlah);
      $("#id_item_temp").val(mutasi.id);
      $("#add").hide();
      $("#update").show();
      $("#tabel_temp_data_mutasi").load("<?php echo base_url().'mutasi/tabel_item_mutasi_temp/'; ?>"+kode_mutasi);
    }
  });
}

function update_item(){
  var kategori_bahan = $('#kategori_barang').val();
  var unit_awal = $("#unit_awal").val();
  var rak_awal = $("#rak_awal").val();    
  
  var kode_mutasi = $('#kode_mutasi').val();
  //var kategori_bahan = $('#kategori_bahan').val();
  var kode_bahan = $('#kode_bahan').val();
  var jumlah = $('#jumlah').val();
  var nama_bahan = $("#nama_bahan").val();
  var id_item_temp = $("#id_item_temp").val();
  var url = "<?php echo base_url().'mutasi/ubah_item_mutasi_temp/'?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { kode_mutasi:kode_mutasi,
      kategori_bahan:kategori_bahan,
      unit_awal:unit_awal,
      rak_awal:rak_awal,
      kode_bahan:kode_bahan,
      nama_bahan:nama_bahan,
      jumlah:jumlah,
      id:id_item_temp
    },
    success: function(data)
    {
      var data_str = data.split("|");
      //alert(data_str[0]);
      if(data_str[0]==0){
        $(".sukses").html('<div class="alert alert-danger">Jumlah yang dimasukkan melebihi stok.</div>');
        setTimeout(function(){$('.sukses').html('');},1800); 
      }else{
          $("#tabel_temp_data_mutasi").load("<?php echo base_url().'mutasi/tabel_item_mutasi_temp/'; ?>"+kode_mutasi);
         // $('#kategori_bahan').val('');
         $('#kode_bahan').val('');
         $('#jumlah').val('');
         $("#nama_bahan").val('');
         $("#id_item_temp").val('');
         $("#add").show();
         $("#update").hide();
     }
   }
 });
}

function delData() {
  var id = $('#id-delete').val();
  var kode_mutasi = $('#kode_mutasi').val();
  var url = "<?php echo base_url().'mutasi/hapus_temp'; ?>";
  $.ajax({
    type: 'POST',
    url: url,
    data: {id:id},
    beforeSend:function(){
          $(".tunggu").show();  
        },
    success: function(pembelian){
      $(".tunggu").hide();
      $('#modal-confirm').modal('hide');
      $("#tabel_temp_data_mutasi").load("<?php echo base_url().'mutasi/tabel_item_mutasi_temp/'; ?>"+kode_mutasi);
      $('#kategori_bahan').val('');
      $('#kode_bahan').val('');
      $('#jumlah').val('');
    }
  });
}

</script>