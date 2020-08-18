<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Detail Transaksi Repack
        </div>
        <div class="tools">
          <a href="javascript:;" class="collapse">
          </a>
          <a href="javascript:;" class="reload">
          </a>

        </div>
      </div>
      <?php 
      $id = $this->uri->segment(3);
      $this->db->where('id', $id);
      $get_data = $this->db->get('transaksi_repack');
      $hasil_data = $get_data->row();
      ?>
      <div class="portlet-body">
        <!------------------------------------------------------------------------------------------------------>
        <div class="box-body">
          <div class="sukses" ></div>
          <div class="row">
            <form id="form_repack">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Kode Repack</label>
                  <input readonly="" type="text" class="form-control" value="<?php echo $hasil_data->kode_repack ?>" name="kode" id="kode" required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tanggal Repack</label>
                  <input readonly="" type="text" class="form-control" value="<?php echo TanggalIndo($hasil_data->tanggal_transaksi) ?>" name="tanggal_repack" id="tanggal_repack" required />
                </div>
              </div>
              
              <div class="col-md-12">
                <div class="cek_stok" ></div>
              </div>


              <div class="col-md-12">
                <table class="table table-striped table-hover table-bordered" id=""  style="font-size:1.5em;">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Produk</th>
                      <th>Produk Repack</th>
                      <th>Jumlah Repack</th>

                    </tr>
                  </thead>
                  <tbody id="tabel_temp_data">
                    <?php 

                    $kode = $hasil_data->kode_repack;
                    $repack_temp = $this->db->get_where('opsi_transaksi_repack',array('kode_repack'=>$kode));

                    $hasil_repack_temp = $repack_temp->result();
                    $no=1;
                    foreach ($hasil_repack_temp as $list) {
                      ?>

                      <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $list->nama_bahan; ?></td>
                        <td><?php echo $list->nama_produk_repack; ?></td>
                        <td><?php echo $list->jumlah_in; ?></td>
                      </tr>
                      <?php   
                    } ?>
                  </tbody>                
                </table>

              </div>
            </form>
          </div>

        </div>
      </div>

      <!------------------------------------------------------------------------------------------------------>
    </div>
  </div>
</div>
<div id="modal_delete_temp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">

        <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan Menghapus Data Ini?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn red" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delete_data()" class="btn green">Ya</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2();
    $('#update').hide();
  });

  function get_temp(){
    kode_repack = $('#kode').val();
    $("#tabel_temp_data").load('<?php echo base_url().'repack/get_repack_temp/'; ?>'+kode_repack);
  }
  function get_jumlah_dalam_satuan_pembelian(){
    produk_repack = $('#produk_repack').val();
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url() . 'repack/get_satuan' ?>",  
      cache :false,
      dataType : 'json',
      data :({repack:produk_repack}),
      success : function(data) {  
        $('#sat_repack').val(data.satuan_stok);
        $('#jumlah_dalam_satuan_pembelian').val(data.jumlah_dalam_satuan_pembelian);
        $('#konversi').val(Math.round(($('#jml_in').val()*$('#jumlah_dalam_satuan_pembelian').val())/$('#jumlah_repack').val()));
      },  
      error : function() {  
        alert("Data gagal dimasukkan.");  
      }  
    });
  }
  function actEdit(id){
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url() . 'repack/get_edit_data' ?>",  
      cache :false,
      dataType : 'json',
      data :({key:id}),
      success : function(data) {
        $("#produk").select2().select2('val', data.kode_bahan);
        $("#produk_repack").select2().select2('val', data.kode_produk_repack);
        get_jumlah_dalam_satuan_pembelian();
        $('#jml_in').val(data.jumlah_in);
        $('#jumlah_repack').val(data.jumlah);
        $('#id_repack_temp').val(data.id);
        $('#add').hide();
        $('#update').show();
      },  
      error : function() {  
        alert("Data gagal dimasukkan.");  
      }  
    });
  }
  function actDelete(id){
    $('#id-delete').val(id);
    $("#modal_delete_temp").modal('show');
  }
  function delete_data(){
    id = $('#id-delete').val();
    $("#modal_delete_temp").modal('hide');
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url() . 'repack/hapus_repack_temp' ?>",  
      cache :false,
      data :({key:id}),
      success : function(data) {  
        get_temp();
      },  
      error : function() {  
        alert("Data gagal dimasukkan.");  
      }  
    });
  }

  $('#produk_repack').change(function() {
    produk_repack = $('#produk_repack').val();
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url() . 'repack/get_satuan' ?>",  
      cache :false,
      dataType : 'json',
      data :({repack:produk_repack}),
      success : function(data) {  
        $('#sat_repack').val(data.satuan_stok);
        $('#jumlah_dalam_satuan_pembelian').val(data.jumlah_dalam_satuan_pembelian);
      },  
      error : function() {  
        alert("Data gagal dimasukkan.");  
      }  
    });
  });
  $('#add').click(function() {
    kode_repack = $('#kode').val();
    produk = $('#produk').val();
    produk_repack = $('#produk_repack').val();
    jumlah_satuan = $('#jumlah_dalam_satuan_pembelian').val();
    konversi = $('#konversi').val();
    jml_repack = $('#jumlah_repack').val();
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url() . 'repack/add_repack_temp' ?>",  
      cache :false,
      data :({kode_repack:kode_repack, produk:produk, produk_repack:produk_repack, jumlah_satuan:jumlah_satuan, konversi:konversi, jml_repack:jml_repack}),
      success : function(data) {
        if(data.length < 10){
          $("#produk").select2().select2('val','');
          $("#produk_repack").select2().select2('val','');
          $('#sat_repack').val('');
          $('#jumlah_dalam_satuan_pembelian').val('');
          $('#konversi').val('');
          $('#jumlah_repack').val('');
        }else{
          $('.cek_stok').html(data);
          setTimeout(function(){$('.cek_stok').html('');},1500);
        }
        get_temp();
      },  
      error : function() {  
        alert("Data gagal dimasukkan.");  
      }  
    });
  });
  $('#update').click(function() {
    kode_repack = $('#kode').val();
    id_repack_temp = $('#id_repack_temp').val();
    produk = $('#produk').val();
    produk_repack = $('#produk_repack').val();
    jumlah_satuan = $('#jumlah_dalam_satuan_pembelian').val();
    konversi = $('#konversi').val();
    jml_repack = $('#jumlah_repack').val();
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url() . 'repack/update_repack_temp' ?>",  
      cache :false,
      data :({kode_repack:kode_repack, produk:produk, id_repack_temp:id_repack_temp, produk_repack:produk_repack, jumlah_satuan:jumlah_satuan, konversi:konversi, jml_repack:jml_repack}),
      success : function(data) {  
        if(data.length < 10){
          $("#produk").select2().select2('val','');
          $("#produk_repack").select2().select2('val','');
          $('#sat_repack').val('');
          $('#jumlah_dalam_satuan_pembelian').val('');
          $('#konversi').val('');
          $('#jumlah_repack').val('');
          $('#id_repack_temp').val('');
          $('#add').show();
          $('#update').hide();
        }else{
          $('.cek_stok').html(data);
          setTimeout(function(){$('.cek_stok').html('');},1500);
        }
        get_temp();
      },  
      error : function() {  
        alert("Data gagal dimasukkan.");  
      }  
    });
  });
  $('#form_repack').submit(function() {
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url() . 'repack/simpan_repack' ?>",  
      cache :false,
      data :$(this).serialize(),
      success : function(data) {  
        $(".sukses").html(data);   
        setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'repack/daftar' ?>";},1500);              
      },  
      error : function() {  
        alert("Data gagal dimasukkan.");  
      }  
    });
    return false;
  });
  $('#batal').click(function() {
    window.location = "<?php echo base_url() . 'repack/daftar' ?>";
  });
</script>
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
    window.location = "<?php echo base_url().'repack/daftar'; ?>";
  });
</script>