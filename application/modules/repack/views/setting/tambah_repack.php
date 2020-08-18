<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Tambah Transaksi Repack
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
          <div class="row">
            <?php 
            $this->db->select_max('id');
            $get_max_po = $this->db->get('transaksi_repack');
            $max_po = $get_max_po->row();

            $this->db->where('id', $max_po->id);
            $get_po = $this->db->get('transaksi_repack');
            $po = $get_po->row();
            $tahun = substr(@$po->kode_repack, 6,4);
            if(date('Y')==$tahun){
              $nomor = substr(@$po->kode_repack, 11);
              $nomor = $nomor + 1;
              $string = strlen($nomor);
              if($string == 1){
                $kode_trans = 'RPACK_'.date('Y').'_00000'.$nomor;
              } else if($string == 2){
                $kode_trans = 'RPACK_'.date('Y').'_0000'.$nomor;
              } else if($string == 3){
                $kode_trans = 'RPACK_'.date('Y').'_000'.$nomor;
              } else if($string == 4){
                $kode_trans = 'RPACK_'.date('Y').'_00'.$nomor;
              } else if($string == 5){
                $kode_trans = 'RPACK_'.date('Y').'_0'.$nomor;
              } else if($string == 6){
                $kode_trans = 'RPACK_'.date('Y').'_'.$nomor;
              }
            } else {
              $kode_trans = 'RPACK_'.date('Y').'_000001';
            }

            ?>
            <form id="form_repack">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Kode Repack</label>
                  <input readonly="" type="text" class="form-control" value="<?php echo $kode_trans ?>" name="kode" id="kode" required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tanggal Repack</label>
                  <input type="date" class="form-control" value="" name="tanggal_repack" id="tanggal_repack" required />
                </div>
              </div>
              <?php 
              $session = $this->session->userdata('astrosession');
              //print_r($session);
              ?>
              <div class="col-md-12">
                <div class="cek_stok" ></div>
              </div>
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-4">
                    <label>Produk Direpack</label>
                    <select id="produk_direpack" name="produk_direpack" class="form-control select2">
                      <option value="">-- PILIH --</option>
                      <?php 
                      $get_bahan = $this->db->get('master_bahan_baku');
                      $hasil_menu = $get_bahan->result();
                      foreach($hasil_menu as $daftar){
                        ?>
                        <option value="<?php echo $daftar->kode_bahan_baku; ?>"><?php echo $daftar->nama_bahan_baku; ?></option>
                        <?php 
                      } ?>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <label>Qty Direpack</label>
                    <input type="text" class="form-control" value="" name="qty_direpack" id="qty_direpack" placeholder="Qty Direpack" />
                  </div>
                  <div class="col-md-2">
                    <label>Isi Direpack</label>
                    <input type="text" class="form-control" value="" name="isi_direpack" id="isi_direpack" placeholder="Isi" />
                  </div>
                  <div class="col-md-2">
                    <label>Satuan Produk Direpack</label>
                    <select id="satuan_direpack" name="satuan_direpack" class="form-control select2">
                      <option value="">-- PILIH --</option>
                      <?php 
                      $get_satuan = $this->db->get('master_satuan');
                      $hasil_satuan = $get_satuan->result();
                      foreach($hasil_satuan as $daftar){
                        ?>
                        <option value="<?php echo $daftar->kode; ?>"><?php echo $daftar->nama; ?></option>
                        <?php 
                      } ?>
                    </select>
                  </div>
                  <div class="col-md-2">
                  </div>
                </div>
              </div>  

              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-4">
                    <label>Produk Hasil Repack</label>
                    <select id="produk_hasil_repack" name="produk_hasil_repack" class="form-control select2">
                      <option value="">-- PILIH --</option>
                      <?php 
                      foreach($hasil_menu as $daftar){
                        ?>
                        <option value="<?php echo $daftar->kode_bahan_baku; ?>"><?php echo $daftar->nama_bahan_baku; ?></option>
                        <?php 
                      } ?>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <label>Qty Hasil Repack</label>
                    <input type="text" class="form-control" value="" name="qty_hasil_repack" id="qty_hasil_repack" placeholder="Qty Hasil Repack" />
                  </div>
                  <div class="col-md-2">
                    <label>Isi Hasil Repack</label>
                    <input type="text" class="form-control" value="" name="isi_hasil_repack" id="isi_hasil_repack" placeholder="Isi" />
                  </div>
                  <div class="col-md-2">
                    <label>Satuan Produk Direpack</label>
                    <select id="satuan_hasil_repack" name="satuan_hasil_repack" class="form-control select2">
                      <option value="">-- PILIH --</option>
                      <?php 
                      $get_satuan = $this->db->get('master_satuan');
                      $hasil_satuan = $get_satuan->result();
                      foreach($hasil_satuan as $daftar){
                        ?>
                        <option value="<?php echo $daftar->kode; ?>"><?php echo $daftar->nama; ?></option>
                        <?php 
                      } ?>
                    </select>
                  </div>  
                  <div class="col-md-2">

                  </div>
                </div>
              </div>  
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-2">
                    <label>Toleransi</label>
                    <input type="text" class="form-control" value="" name="toleransi" id="toleransi" placeholder="Toleransi" />
                  </div>
                  <div class="col-md-6">
                    <input type="hidden" class="form-control" value="" name="id_repack_temp" id="id_repack_temp" placeholder="Toleransi" />
                  </div>
                  <div class="col-md-2">
                    <br>
                    <br>
                    <button type="button" id="add" class="btn btn-block btn-primary">Add</button>
                    <button type="button" id="update" class="btn btn-block btn-primary">Update</button>
                  </div>
                </div>
              </div>  
              <div class="col-md-12"><br><br>
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1"  style="font-size:1.5em;">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Produk</th>
                      <th>Produk Repack</th>
                      <th>Jumlah Repack</th>
                      <th>Action</th> 

                    </tr>
                  </thead>
                  <tbody id="tabel_temp_data">

                  </tbody>                
                </table>

                <button type="submit" id="simpan" class="btn btn-primary pull-right">Simpan</button>
                <button type="button" id="batal" class="btn btn-danger pull-right">Batal</button>
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
    get_temp();
  });

  function get_temp(){
    kode_repack = $('#kode').val();
    $("#tabel_temp_data").load('<?php echo base_url().'repack/get_repack_temp/'; ?>'+kode_repack);
  }
  // function get_jumlah_dalam_satuan_pembelian(){
  //   kode_repack = $('#kode_repack').val();
  //   produk_repack = $('#produk_direpack').val();
  //   qty_direpack = $('#qty_direpack').val();
  //   isi_direpack = $('#isi_direpack').val();
  //   satuan_direpack = $('#satuan_direpack').val();
  //   produk_hasil_repack = $('#produk_hasil_repack').val();
  //   qty_hasil_repack = $('#qty_hasil_repack').val();
  //   isi_hasil_repack = $('#isi_hasil_repack').val();
  //   satuan_hasil_repack = $('#satuan_hasil_repack').val();
  //   toleransi = $('#toleransi').val();
  //   $.ajax( {  
  //     type :"post",  
  //     url : "<?php echo base_url() . 'repack/get_satuan' ?>",  
  //     cache :false,
  //     dataType : 'json',
  //     data :({kode_repack:kode_repack, produk_repack:produk_repack , qty_direpack:qty_direpack, isi_direpack:isi_direpack, satuan_direpack:satuan_direpack, produk_hasil_repack:produk_hasil_repack, qty_hasil_repack:qty_hasil_repack, isi_hasil_repack:isi_hasil_repack, satuan_hasil_repack:satuan_hasil_repack, toleransi:toleransi}),
  //     success : function(data) {  
  //       $('#sat_repack').val(data.satuan_stok);
  //       $('#jumlah_dalam_satuan_pembelian').val(data.jumlah_dalam_satuan_pembelian);
  //       $('#konversi').val(Math.round(($('#jml_in').val()*$('#jumlah_dalam_satuan_pembelian').val())/$('#jumlah_repack').val()));
  //     },  
  //     error : function() {  
  //       alert("Data gagal dimasukkan.");  
  //     }  
  //   });
  // }
  function actEdit(id){
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url() . 'repack/get_edit_data' ?>",  
      cache :false,
      dataType : 'json',
      data :({key:id}),
      success : function(data) {
        $('#id_repack_temp').val(id);
        $("#produk_direpack").select2().select2('val',data.kode_produk_repack);
        $('#qty_direpack').val(data.jumlah);
        $('#isi_direpack').val(data.isi);
        $("#satuan_direpack").select2().select2('val',data.satuan);
        $("#produk_hasil_repack").select2().select2('val',data.kode_bahan);
        $('#qty_hasil_repack').val(data.jumlah_in);
        $('#isi_hasil_repack').val(data.isi_in);
        $("#satuan_hasil_repack").select2().select2('val',data.satuan_in);
        $('#toleransi').val(data.toleransi);
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

  // $('#produk_repack').change(function() {
  //   produk_repack = $('#produk_repack').val();
  //   $.ajax( {  
  //     type :"post",  
  //     url : "<?php echo base_url() . 'repack/get_satuan' ?>",  
  //     cache :false,
  //     dataType : 'json',
  //     data :({repack:produk_repack}),
  //     success : function(data) {  
  //       $('#sat_repack').val(data.satuan_stok);
  //       $('#jumlah_dalam_satuan_pembelian').val(data.jumlah_dalam_satuan_pembelian);
  //     },  
  //     error : function() {  
  //       alert("Data gagal dimasukkan.");  
  //     }  
  //   });
  // });
  $('#add').click(function() {
    kode_repack = $('#kode').val();
    produk_direpack = $('#produk_direpack').val();
    qty_direpack = $('#qty_direpack').val();
    isi_direpack = $('#isi_direpack').val();
    satuan_direpack = $('#satuan_direpack').val();
    produk_hasil_repack = $('#produk_hasil_repack').val();
    qty_hasil_repack = $('#qty_hasil_repack').val();
    isi_hasil_repack = $('#isi_hasil_repack').val();
    satuan_hasil_repack = $('#satuan_hasil_repack').val();
    toleransi = $('#toleransi').val();
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url() . 'repack/add_repack_temp' ?>",  
      cache :false,
      data :({kode_repack:kode_repack, produk_direpack:produk_direpack , qty_direpack:qty_direpack, isi_direpack:isi_direpack, satuan_direpack:satuan_direpack, produk_hasil_repack:produk_hasil_repack, qty_hasil_repack:qty_hasil_repack, isi_hasil_repack:isi_hasil_repack, satuan_hasil_repack:satuan_hasil_repack, toleransi:toleransi}),
      success : function(data) {
        if(data.length < 10){
          $("#produk_direpack").select2().select2('val','');
          $('#qty_direpack').val('');
          $('#isi_direpack').val('');
          $("#satuan_direpack").select2().select2('val','');
          $("#produk_hasil_repack").select2().select2('val','');
          $('#qty_hasil_repack').val('');
          $('#isi_hasil_repack').val('');
          $("#satuan_hasil_repack").select2().select2('val','');
          $('#toleransi').val('');
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
    produk_direpack = $('#produk_direpack').val();
    qty_direpack = $('#qty_direpack').val();
    isi_direpack = $('#isi_direpack').val();
    satuan_direpack = $('#satuan_direpack').val();
    produk_hasil_repack = $('#produk_hasil_repack').val();
    qty_hasil_repack = $('#qty_hasil_repack').val();
    isi_hasil_repack = $('#isi_hasil_repack').val();
    satuan_hasil_repack = $('#satuan_hasil_repack').val();
    toleransi = $('#toleransi').val();
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url() . 'repack/update_repack_temp' ?>",  
      cache :false,
      data :({kode_repack:kode_repack, id_repack_temp:id_repack_temp, produk_direpack:produk_direpack , qty_direpack:qty_direpack, isi_direpack:isi_direpack, satuan_direpack:satuan_direpack, produk_hasil_repack:produk_hasil_repack, qty_hasil_repack:qty_hasil_repack, isi_hasil_repack:isi_hasil_repack, satuan_hasil_repack:satuan_hasil_repack, toleransi:toleransi}),
      success : function(data) {  
        if(data.length < 10){
          $('#id_repack_temp').val('');
          $("#produk_direpack").select2().select2('val','');
          $('#qty_direpack').val('');
          $('#isi_direpack').val('');
          $("#satuan_direpack").select2().select2('val','');
          $("#produk_hasil_repack").select2().select2('val','');
          $('#qty_hasil_repack').val('');
          $('#isi_hasil_repack').val('');
          $("#satuan_hasil_repack").select2().select2('val','');
          $('#toleransi').val('');
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
    window.location = "<?php echo base_url() . 'repack/menu' ?>";
  });
</script>
