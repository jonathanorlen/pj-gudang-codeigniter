<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Detail Pembelian

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



        <div class="box-body">                   
          <div class="sukses" ></div>
          <form id="data_form" action="" method="post">
            <div class="box-body">
              <label><h3><b>Detail Transaksi Pembelian</b></h3></label>
              <div class="row">
                <div class="col-md-6">
                
                  
                    <?php
                    $kode = $this->uri->segment(3);
                    $jvalidasi = $this->uri->segment(2);

                    $transaksi_po = $this->db->get_where('transaksi_po',array('kode_po'=>$kode));
                    $hasil_transaksi_po = $transaksi_po->row();
                    ?>

                    <input readonly="true" type="hidden" value="<?php echo @$hasil_transaksi_po->kode_po; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_po" id="kode_po" />
                    <input readonly="true" type="hidden" value="<?php echo $jvalidasi;?>"  name="validasi_ke" id="validasi_ke" />
                  
                  <div class="form-group">
                    <label class="gedhi">Kode PO</label>
                    <?php 
                      $get_po=$this->db->get_where('transaksi_po',array('kode_po'=>$hasil_transaksi_po->kode_po));
                      $hasil_get=$get_po->row();
                    ?>
                    <input type="text" value="<?php echo $hasil_get->kode_transaksi; ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="kode_po" id="kode_po"/>
                    <input type="hidden" value="<?php echo $hasil_transaksi_po->kode_po; ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="kode_po" id="kode_po"/>
                  </div>
                  <div class="form-group">
                    <label class="gedhi">Tanggal Transaksi</label>
                    <input type="text" value="<?php echo TanggalIndo($hasil_transaksi_po->tanggal_input); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_pembelian" id="tanggal_pembelian"/>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group" hidden>
                    <label>Nota Referensi</label>
                    <input readonly="true" type="text" value="<?php echo @$hasil_transaksi_po->nomor_nota ?>" class="form-control" placeholder="Nota Referensi" name="nomor_nota" id="nomor_nota" />
                  </div>
                  <div class="form-group">
                    <label>Supplier</label>
                    <?php
                    $supplier = $this->db->get('master_supplier');
                    $supplier = $supplier->result();
                   // echo $hasil_transaksi_po->kode_supplier;
                    ?>
                    <select disabled="true" class="form-control select2" name="kode_supplier" id="kode_supplier">
                      <option selected="true" value="">--Pilih Supplier--</option>
                      <?php foreach($supplier as $daftar){ ?>
                        <option <?php if($hasil_transaksi_po->kode_supplier==$daftar->kode_supplier){ echo "selected='true'"; } ?> value="<?php echo $daftar->kode_supplier ?>"><?php echo $daftar->nama_supplier ?></option>
                        <?php } ?>
                      </select> 

                      <input type="hidden" name="kode_supplier" value="<?php echo $hasil_transaksi_po->kode_supplier;?>">
                    </div>
                  </div>

                </div>
              </div> 

              <div id="list_transaksi_pembelian">
                <div class="box-body">
                  <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th width="30%">Nama Produk</th>
                        <th width="10%">QTY</th>
                        <th style="display: none">Harga Satuan</th>
                        <th style="display: none">Subtotal</th>
                        <th width="30%">Action</th>
                      </tr>
                    </thead>
                    <tbody id="tabel_temp_data_transaksi">

                    </tbody>
                    <tfoot>

                    </tfoot>
                  </table>
                  <br>
                  <button style="width: 148px" type="button" class="btn btn-success" id="validasi"><i class="fa fa-check"></i> Validasi</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="modal-validasi-menunggu" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <form id="sesuai_modal" method="post">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background-color:grey">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title" style="color:#fff;">Konfirmasi Bahan Sesuai</h4>
          </div>
          <div class="modal-body">
            <span style="font-weight:bold; font-size:14pt" id="text-notif">Apakah anda yakin transaksi ini telah sesuai ?</span>
            <input id="id-validasi" name="kode_pembelian" type="hidden">
          </div>
          <div class="modal-footer" style="background-color:#eee">
            <button class="btn red" data-dismiss="modal" aria-hidden="true">Tidak</button>
            <button class="btn green" data-dismiss="modal" aria-hidden="true" id="sesuailah">YA</button>
          </div>
        </div>
      </div>
    </form>
  </div>

  <div id="modal-validasi-tidak" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <form id="sesuai_modal" method="post">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background-color:grey">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title" style="color:#fff;">Konfirmasi Bahan Tidak Sesuai</h4>
          </div>
          <div class="modal-body">
            <span style="font-weight:bold; font-size:14pt" id="text-notif">Apakah anda yakin transaksi ini tidak sesuai ?</span>
            <input id="id-validasi" name="kode_pembelian" type="hidden">
          </div>
          <div class="modal-footer" style="background-color:#eee">
            <button class="btn red" data-dismiss="modal" aria-hidden="true">Tidak</button>
            <button class="btn green" data-dismiss="modal" aria-hidden="true" id="tidak_sesuai">YA</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="input_sesuai" style="display: none;">
    <table class="table table">
      <tr>
        <td colspan="3">
        </td>
        <td>
          <label>Jumlah Sesuai</label>
          <input type="text" value="" class="form-control" placeholder="" name="jumlah_sesuai" id="" />
        </td>
        <td>
          <label>Qty Retur</label>
          <input type="text" value="" class="form-control" placeholder="" name="qty_retur" id="" />
        </td>
        <td>
          <br>
          <button type="button" value="" class="btn btn-info" name="simpan" id="" >Simpan</button>
        </td>
      </tr>
    </table>
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
    function reload_table(){
      $('#tabel_temp_data_transaksi').load('<?php echo base_url().'validasi_po/tabel_validasi/'.$jvalidasi.'/'.$kode; ?>')
    }
    $(document).ready(function(){
      reload_table();
    });
    $('.btn-back').click(function(){
      $(".tunggu").show();
      window.location = "<?php echo base_url().'validasi_po/daftar_validasi'; ?>";
    });
    $('#validasi').click(function(){
      $("#modal-validasi-menunggu").modal('show');

    });
    $('.tidak_sesuai').click(function(){
      key = $(this).attr('key');
      $("#form_ts_"+key).css('display', '');

    });
    $('.belum_datang').click(function(){
      key = $(this).attr('key');
      $("#form_bd_"+key).css('display', '');

    });
    $('.simpan_perubahan').click(function(){
      id = $(this).attr('key');
      sesuai = $("#jumlah_sesuai_"+id).val();
      retur = $("#qty_retur_"+id).val();
      $.ajax( {  
        type :"post",  
        url : "<?php echo base_url() . 'validasi_po/ubah_pembelian' ?>",  
        cache :false,
        beforeSend:function(){
          $(".tunggu").show();  
        },
        data :({id:id, sesuai:sesuai, retur:retur}),
        success : function(data) {
          $(".tunggu").hide();  
          $("#form_ts_"+id).css('display', 'none');
          $("#sesuai_"+id).css('display', 'none');
          $("#tidak_sesuai_"+id).css('display', 'none');
          $("#batal_"+id).css('display', '');
          reload_table();         
        },  
        error : function() {  
          $(".tunggu").hide();
          alert("Data gagal dimasukkan.");
          $("#form_ts_"+id).css('display', 'none');
        }  
      });
    });
    $('.batal').click(function(){
      id = $(this).attr('key');
      $.ajax( {  
        type :"post",  
        url : "<?php echo base_url() . 'validasi_po/batal_pembelian' ?>",  
        cache :false,
        beforeSend:function(){
          $(".tunggu").show();  
        },
        data :({id:id}),
        success : function(data) {
          $(".tunggu").hide();  
          $("#form_ts_"+id).css('display', 'none');
          $("#sesuai_"+id).css('display', 'none');
          $("#tidak_sesuai_"+id).css('display', 'none');
          $("#batal_"+id).css('display', '');
          reload_table();         
        },  
        error : function() {  
          $(".tunggu").hide();
          alert("Data gagal dimasukkan.");
          $("#form_ts_"+id).css('display', 'none');
        }  
      });
    });
    $('.sesuai').click(function(){
      id = $(this).attr('key');
      $.ajax( {  
        type :"post",  
        url : "<?php echo base_url() . 'validasi_po/pembelian_sesuai' ?>",  
        cache :false,
        beforeSend:function(){
          $(".tunggu").show();  
        },
        data :({id:id}),
        success : function(data) {
          $(".tunggu").hide();  
          $("#form_ts_"+id).css('display', 'none');
          $("#sesuai_"+id).css('display', 'none');
          $("#tidak_sesuai_"+id).css('display', 'none');
          $("#batal_"+id).css('display', '');
          reload_table();         
        },  
        error : function() {  
          $(".tunggu").hide();
          alert("Data gagal dimasukkan.");
          $("#form_ts_"+id).css('display', 'none');
        }  
      });
    });
    $('.jumlah_sesuai').keyup(function(){
      id = $(this).attr('key');
      sesuai = $(this).val();
      awal = $("#jumlah_awal_"+id).val();
      $("#qty_retur_"+id).val(Math.round(awal - sesuai));
    });


    $("#sesuailah").click(function(){
      $.ajax( {  
        type :"post",  
        url : "<?php echo base_url() . 'validasi_po/simpan_pembelian_sesuai/'.$jvalidasi ?>",  
        cache :false,
        beforeSend:function(){
          $(".tunggu").show();  
        },
        data :$("#data_form").serialize(),
        success : function(data) {  
          $(".sukses").html(data);   
          setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'validasi_po/daftar_validasi' ?>";},1500);              
        },  
        error : function() {  
          alert("Data gagal dimasukkan.");  
        }  
      });
    })
  </script>

