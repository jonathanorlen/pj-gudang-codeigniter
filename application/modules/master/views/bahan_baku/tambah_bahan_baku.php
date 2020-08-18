<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Edit Produk
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
        $param = $this->uri->segment(4);
        if(!empty($param)){
          $bahan_baku = $this->db->get_where('master_bahan_baku',array('id'=>$param));
          $hasil_bahan_baku = $bahan_baku->row();
        }    

        ?>
        <div class="box-body">
          <div class="box-body">                   
            <div class="sukses" ></div>
            <form id="data_form" method="post">
              <div class="box-body">            
                <div class="row">
                <!--<div class="form-group  col-xs-12">
                  <label class="gedhi"><b>Header Produk</label>
                  <select  class="form-control select2" name="header_produk" id="header_produk" <?php if(!empty($param)){ echo "disabled='true'"; } ?>>
                    <option value=""> Pilih  Produk </option>
                    <?php
                    $this->db->where('status_produk','produk');
                    $kategori_bahan = $this->db->get('master_bahan_baku');
                    $hasil_bahan =$kategori_bahan->result();
                    foreach ($hasil_bahan as $value) {
                     ?>
                     <option value="<?php echo $value->kode_bahan_baku; ?>" <?php if($value->kode_bahan_baku==@$hasil_bahan_baku->kode_header_produk){ echo "selected";}?>><?php echo $value->nama_bahan_baku; ?></option>
                     <?php
                   }
                   ?>
                 </select>

               </div>
                <div class="form-group  col-xs-3">
                <label class="gedhi"><b>Kode Sub Produk</label>
                <div class="input-group">
                  <input  value="<?php echo @$hasil_bahan_baku->kode_header_produk; ?>" readonly type="text" class="form-control" id="kode_sub_produk"  />
                  <span class="input-group-addon"><b>.</b></span>

                </div>
              </div>

              <div class="form-group  col-xs-3">
                <label class="gedhi"><b><br></label>
                <input  value=""<?php if(!empty($param)){ echo "readonly='true'"; } ?> type="text" class="form-control" id="kode_sub" name="kode_sub" />
              </div> -->
              <div class="form-group  col-xs-6">

                <label><b>Kode Produk</label>

                <div class="input-group">
                  <?php
                  $this->db->select('kode_bahan_baku');
                  $bb = $this->db->get('master_setting');
                  $hasil_bb = $bb->row();
                  ?>
                  <span class="input-group-addon"><div id="test"><?php if(empty($param)){ echo $hasil_bb->kode_bahan_baku.'_'; } ?></div></span>
                  <input type="hidden" id="kode_setting" value="<?php echo @$hasil_bb->kode_bahan_baku ?>"></input>
                  <input  name="kode_bahan_baku" value="<?php echo @$hasil_bahan_baku->kode_bahan_baku ?>"  <?php if(!empty($param)){ echo "readonly='true'"; } ?> type="text" class="form-control" id="kode_bahan_baku" />
                </div>
              </div>
              <div class="form-group  col-xs-6">
                <label class="gedhi"><b>Nama Produk</label>
                <input disabled id="nama_bahan_baku"  value="<?php echo @$hasil_bahan_baku->nama_bahan_baku; ?>" type="text" class="form-control" name="nama_bahan_baku" />
              </div>
              <div class="form-group  col-xs-6">
                <label class="gedhi"><b>Kategori Produk</label>
                <select disabled  class="form-control stok select2" name="kode_kategori_produk">
                  <option>-- Pilih Kategori Produk --</option>
                  <?php
                  $kategori_produk = $this->db->get('master_kategori_menu');
                  $hasil_kategori =$kategori_produk->result();
                  foreach ($hasil_kategori as $value) {
                   ?>
                   <option value="<?php echo $value->kode_kategori_menu; ?>" <?php if($value->kode_kategori_menu==@$hasil_bahan_baku->kode_kategori_produk){ echo "selected";}?>><?php echo $value->nama_kategori_menu; ?></option>
                   <?php
                 }
                 ?>
               </select>

             </div>
             <div class="form-group  col-xs-6">
              <label class="gedhi"><b>Satuan Pembelian</label>
              <?php
              $pembelian = $this->db->get('master_satuan');
              $hasil_pembelian = $pembelian->result();
              ?>
              <select disabled  class="form-control select2 pembelian" name="id_satuan_pembelian" id="id_satuan_pembelian">
                <option selected="true" value="">--Pilih satuan pembelian--</option>
                <?php foreach($hasil_pembelian as $daftar){ ?>
                <option <?php if(@$hasil_bahan_baku->id_satuan_pembelian==$daftar->kode){ echo "selected"; } ?> value="<?php echo $daftar->kode; ?>" ><?php echo $daftar->nama; ?></option>
                <?php } ?>
              </select> 
            </div>
            <div class="form-group  col-xs-6">
              <label class="gedhi"><b>Unit</label>
              <?php
              $kode_default = $this->db->get('setting_gudang');
              $hasil_unit =$kode_default->row();
              $kode_unit=$hasil_unit->kode_unit;

              $unit = $this->db->get_where('master_unit',array('kode_unit' => $kode_unit));
              $hasil_unit = $unit->row();
              ?>
              <input   value="stok" name="jenis_bahan"  id="jenis_bahan" type="hidden" class="form-control"  />
              <input disabled required value="<?php echo @$hasil_unit->nama_unit; ?>" type="text" class="form-control"  />
              <input value="<?php echo @$hasil_unit->kode_unit; ?>" type="hidden" class="form-control" name="kode_unit" />
            </div>
            
            <div class="form-group  col-xs-6">
              <label class="gedhi"><b>Nama Blok</label>
              <?php
              $kode_default = $this->db->get('setting_gudang');
              $hasil_unit =$kode_default->row();
              $kode_unit=$hasil_unit->kode_unit;

              $unit = $this->db->get_where('master_rak',array('kode_unit' => $kode_unit));
              $hasil_rak = $unit->result();
              ?>
              <select  name="kode_rak" id="kode_rak" class="form-control ">
                
                <?php foreach($hasil_rak as $daftar){  ?>
                <option style="font-size: 15px;" <?php if(@$hasil_bahan_baku->kode_rak==$daftar->kode_rak){ echo "selected='true'"; } ?> value="<?php echo $daftar->kode_rak; ?>"><?php echo $daftar->nama_rak; ?></option>
                <?php } ?>
              </select>
              
              
            </div>
            <div class="form-group  col-xs-6">
              <label class="gedhi"><b>Isi Dalam 1 (Satuan Pembelian)</label>
              <input disabled value="<?php echo @$hasil_bahan_baku->jumlah_dalam_satuan_pembelian; ?>" type="text" class="form-control" name="jumlah_dalam_satuan_pembelian" />
            </div>
            <div class="form-group  col-xs-6">
              <?php
              $dft_satuan = $this->db->get_where('master_satuan');
              $hasil_dft_satuan = $dft_satuan->result();

              ?>
              <label class="gedhi"><b>Satuan Stok</label>
              <select disabled id="id_satuan_stok"  class="form-control stok select2" name="id_satuan_stok">
                <option selected="true" value="">--Pilih satuan stok--</option>
                <?php 
                foreach($hasil_dft_satuan as $daftar){    
                  ?>
                  <option <?php if(@$hasil_bahan_baku->id_satuan_stok==$daftar->kode){ echo "selected"; } ?> value="<?php echo $daftar->kode; ?>"><?php echo $daftar->nama; ?></option>
                  <?php } ?>
                </select> 
              </div>
              
              
              <div class="form-group  col-xs-6">
                <label class="gedhi"><b>Stok Minimal</label>
                <input disabled  type="text" class="form-control" name="stok_minimal" value="<?php echo @$hasil_bahan_baku->stok_minimal ?>" />
              </div>
              <div class="form-group  col-xs-6">
                <label class="gedhi"><b>HPP</label>
                <input disabled type="text" class="form-control" name="hpp" value="<?php echo @$hasil_bahan_baku->hpp ?>" />
              </div>
              <div class="form-group  col-xs-6">
                <label class="gedhi"><b>QTY Grosir</label>
                <input  disabled type="text" class="form-control" name="qty_grosir" value="<?php echo @$hasil_bahan_baku->qty_grosir ?>" />

              </div>
              <div class="form-group  col-xs-2">
                <label class="gedhi"><b>Harga 1</label>
                <input disabled  type="text" class="form-control" name="harga_jual_1" value="<?php echo @$hasil_bahan_baku->harga_jual_1 ?>" />
              </div>

              <div class="form-group  col-xs-2">
                <label class="gedhi"><b>Harga 2</label>
                <input disabled  type="text" class="form-control" name="harga_jual_2" value="<?php echo @$hasil_bahan_baku->harga_jual_2 ?>" />
              </div>

              <div class="form-group  col-xs-2">
                <label class="gedhi"><b>Harga 3</label>
                <input disabled  type="text" class="form-control" name="harga_jual_3" value="<?php echo @$hasil_bahan_baku->harga_jual_3 ?>" />
              </div>

              <div class="form-group  col-xs-6">
                <label class="gedhi"><b>Status Opname</label>
                <select disabled class="form-control" name="status_opname">
                 <option>--Pilih--</option>
                 <option value="Nominal" <?php if(@$hasil_bahan_baku->status_opname=="Nominal"){ echo "selected";}?>>Nominal</option>
                 <option value="View" <?php if(@$hasil_bahan_baku->status_opname=="View"){ echo "selected";}?>>View</option>
               </select>
             </div>

             
             <div class="form-group  col-xs-6">
              <label class="gedhi"><b>Status</label>
              <select disabled  class="form-control stok select2" name="status">
                <option value="Aktif" <?php if(@$hasil_bahan_baku->kode_kategori_produk=="Aktif"){ echo "selected";}?>>Aktif</option>
                <option value="Tidak Aktif" <?php if(@$hasil_bahan_baku->status=="Tidak Aktif"){ echo "selected";}?>>Tidak Aktif</option>
              </select>
            </div>


          </div>
          
        </div>
        
        
      </div>
      
      
      
      
      
    </div>

    <!--<div class="row">
      <div class="col-md-12">
       <h3>Setting Harga</h3>
       <table  class="table table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">

        

        <thead>
          <tr width="100%">
            <th>No</th>
            <th>Satuan</th>
            <th>Jumlah</th>
            <th>Harga</th>
            
          </tr>
        </thead>
        <tbody id="tabel_ecer">
          
        </tbody>
        
      </table>
    </div>
  </div>-->
  <div class="box-footer">
    <button type="submit" class="btn btn-primary">Simpan</button>
  </div>
</form>     

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
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus setting harga tersebut ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()" class="btn red">Ya</button>
      </div>
    </div>
  </div>
</div>
<!------------------------------------------------------------------------------------------------------>
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
    window.location = "<?php echo base_url().'master/bahan_baku/'; ?>";
  });
</script>
<script type="text/javascript">
  function simpan_bb(){
    var kode_satuan_stok = $("#id_satuan_stok").val();
    var kode_input = $("#kode_input").val();
    var kode_bahan_baku = $("#kode_bahan_baku").val();
    var nama_bahan_baku = $("#nama_bahan_baku").val();
    var kode_satuan = $("#satuan").val();
    var  harga = $("#harga_ecer").val();
    var jumlah = $("#jumlah").val();
    var url = "<?php echo base_url('master/bahan_baku/simpan_temp'); ?>";
    
    $.ajax({
      type: 'POST',
      url: url,
      data: {kode_input:kode_input,kode_satuan:kode_satuan,harga:harga,jumlah:jumlah,kode_bahan_baku:kode_bahan_baku,nama_bahan_baku:nama_bahan_baku,
        kode_satuan_stok:kode_satuan_stok},
        success: function(msg){
          $("#tabel_ecer").load("<?php echo base_url('master/bahan_baku/daftar_temp'); ?>/"+kode_input);
          $("#satuan").val('');
          $("#harga_ecer").val('');
          $("#jumlah").val('');
        }
      });
  }

  function actEdit(id) {
    var id = id;
    var kode_input = $("#kode_input").val();
    var url = "<?php echo base_url('master/bahan_baku/get_bb_temp'); ?>";
    $.ajax({
      type: 'POST',
      url: url,
      dataType: 'json',
      data: {id:id},
      success: function(bb){
        $("#satuan").select2().select2('val',bb.kode_satuan);
        $("#harga_ecer").val(bb.harga);
        
        $('#jumlah').val(bb.jumlah);
        $("#id_item").val(bb.id);
        $("#simpan_ecer").hide();
        $("#update_ecer").show();
        $("#tabel_ecer").load("<?php echo base_url('master/bahan_baku/daftar_temp'); ?>/"+kode_input);
      }
    });
  }

  function update_bb(){
    var kode_satuan_stok = $("#id_satuan_stok").val();
    var id = $("#id_item").val();
    var kode_satuan = $("#satuan").val();
    var kode_input = $("#kode_input").val();
    var  harga = $("#harga_ecer").val();
    var jumlah = $("#jumlah").val();
    var url = "<?php echo base_url('master/bahan_baku/update_temp'); ?>";
    
    $.ajax({
      type: 'POST',
      url: url,
      data: {kode_satuan:kode_satuan,harga:harga,jumlah:jumlah,id:id,kode_satuan_stok:kode_satuan_stok},
      success: function(msg){
        $("#tabel_ecer").load("<?php echo base_url('master/bahan_baku/daftar_temp'); ?>/"+kode_input);
        $("#satuan").val('');
        $("#harga_ecer").val('');
        $("#jumlah").val('');
        $("#update_ecer").hide();
        $("#simpan_ecer").show();
      }
    });
  }

  function actDelete(Object) {
    $('#id-delete').val(Object);
    $('#modal-confirm').modal('show');
  }

  function delData() {
    var kode_input = $("#kode_input").val();
    var id = $('#id-delete').val();
    var url = '<?php echo base_url('master/bahan_baku/hapus_temp'); ?>/delete';
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
        $("#tabel_ecer").load("<?php echo base_url('master/bahan_baku/daftar_temp'); ?>/"+kode_input);
        
      }
    });
    return false;
  }

  $(document).ready(function(){
    $("#update_ecer").hide();
    <?php
    $param = $this->uri->segment(4);
    if(!empty($param)){
      ?>
      var kode_bahan_baku = $("#kode_bahan_baku").val();
      $.ajax( {  
       type :"post",  
       url : "<?php echo base_url('master/bahan_baku/bahan_temp'); ?>",  
       cache :false,  
       data :{kode_bahan_baku:kode_bahan_baku},

       success : function(data) {
        $("#kode_input").val(data);
        $("#tabel_ecer").load("<?php echo base_url('master/bahan_baku/daftar_temp'); ?>/"+data);
      },  
      error : function(data) {  
       alert("das");  
     }  
   });
      <?php } ?>
      $(".select2").select2();



      $('#kode_bahan_baku').on('change',function(){
        var kode_input = $('#kode_bahan_baku').val();
        var kode_setting = $('#kode_setting').val();
        var kode_bahan_baku = kode_setting + "_" + kode_input ;
        var url = "<?php echo base_url() . 'master/bahan_baku/get_kode' ?>";
        $.ajax({
          type: 'POST',
          url: url,
          data: {kode_bahan_baku:kode_bahan_baku},
          success: function(msg){
            if(msg == 1){
              $(".sukses").html('<div class="alert alert-warning">Kode Telah Dipakai</div>');
              setTimeout(function(){
                $('.sukses').html('');
              },1700);              
              $('#kode_bahan_baku').val('');

            }
            else{

            }
          }
        });
      });

      $('#header_produk').on('change',function(){
        var kode_header = $('#header_produk').val();
        $('#test').html(kode_header+".");
        $('#kode_sub_produk').val(kode_header);

        var url = "<?php echo base_url() . 'master/bahan_baku/get_satuan_stok_sub' ?>";
        $.ajax({
          type: 'POST',
          url: url,
          dataType:'json',
          data: {kode_header:kode_header},
          success: function(msg){
            $("#id_satuan_pembelian").val(msg.id_satuan_stok);
          }
        });
      });

      $(".pembelian").change(function(){


      });

         // $('#kode_unit').on('change',function(){
         //    var kode_unit = $('#kode_unit').val();
         //    var url = "<?php echo base_url() . 'master/bahan_baku/get_rak'; ?>";
         //    $.ajax({
         //      type: 'POST',
         //      url: url,
         //      data: {kode_unit:kode_unit},
         //      success: function(msg){
         //        //$('#kode_rak').html(msg);
         //        //$('#kode_rak').select2().trigger('change');
         //      }
         //    });
         // // });

         $("#data_form").submit( function() {
           <?php if(!empty($param)){ ?>
            var url = "<?php echo base_url(). 'master/bahan_baku/simpan_edit'; ?>";  
            <?php }else{ ?>
              var url = "<?php echo base_url(). 'master/bahan_baku/simpan'; ?>";
              <?php } ?>
              $.ajax( {
               type:"POST", 
               url : url,  
               cache :false,  
               data :$(this).serialize(),
               
               beforeSend:function(){
                $(".tunggu").show();  
              },
              success : function(data) {
                $(".tunggu").hide();
                
                if(data==1){
                  $(".sukses").html('<div class="alert alert-success">Data Berhasil Disimpan</div>');
                  setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'master/bahan_baku/' ?>";},1000);  
                }
                else{
                 $(".sukses").html(data);
               }
               $(".loading").hide();   

             },  
             error : function(data) {  
               $(".sukses").html('<div class="alert alert-success">Data Gagal Disimpan</div>');
             }  
           });
              return false;                    
            }); 
       });
     </script>