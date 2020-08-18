<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Setting
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
          $setting = $this->db->get('setting_gudang');
          $hasil_setting = $setting->row();
          ?>
        <div class="box-body">                   
          <div class="sukses" ></div>
          <form id="data_form">
            <div class="box-body">
              <label><h3><b><i class="fa fa-gears"></i>Setting</b></h3></label>
            <div style="padding-left: 12px;" class="row">
              <div class="col-xs-12">
                <div class="form-group">
                  <label>IP</label>
                  <input value="<?php echo @$hasil_setting->ip; ?>" type="text" value="" class="form-control" name="ip" id="ip" />
                </div>
              </div>
              
              <div class="col-xs-12">
                <div class="form-group">
                  <label>Default Unit</label>
                  <?php
                      $unit = $this->db->get('master_unit');
                      $unit = $unit->result_array();             
                  ?>
                  <select name="kode_unit" id="kode_unit_default" class="form-control"  >
                    <option value="">Pilih Unit</option>
                    <?php foreach ($unit as $unit) { ?>
                      <option <?php if(@$hasil_setting->kode_unit==$unit['kode_unit']){ echo "selected"; } ?> value="<?php echo $unit['kode_unit'];?>" ><?php echo $unit['nama_unit'];?></option>
                    <?php }?>
                  </select>
                </div>
              </div>

              <div class="col-xs-12">
                <div class="form-group">
                  <label>Nama Printer</label>
                  <input value="<?php echo @$hasil_setting->printer; ?>" type="text" class="form-control" name="printer" />
                </div>
              </div>
              
            </div>
            <input value="<?php echo @$hasil_setting->id; ?>" type="hidden" value="" class="form-control" name="id" id="id" />
             <button type="submit" class="btn btn-success pull-right">Simpan</button>
            <div class="box-footer clearfix">
             
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
</div>
<!------------------------------------------------------------------------------------------------------>

<script type="text/javascript">
$(function(){
$("#upload_foto").click( function() {    
      $(".box_foto_upload").empty(); 
      $.ajax( {  
        type :"post",  
        url : "<?php echo base_url() . 'component/upload/foto' ?>",  
        cache :false,  
        data :$(this).serialize(),
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) { 
  $(".tunggu").hide(); 
          $(".box_foto_upload").html(data);           
        },  
        error : function() {  
          alert("Data gagal dimasukkan.");  
        }  
      });
      return false;                          
    });
    
    $("#upload_file").click( function() {  
      $(".box_foto_upload").empty();   
      $.ajax( {  
        type :"post",  
        url : "<?php echo base_url() . 'component/upload/file' ?>",  
        cache :false,  
        data :$(this).serialize(),
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
   $(".tunggu").hide();
          $(".box_file_upload").html(data);           
        },  
        error : function() {  
          alert("Data gagal dimasukkan.");  
        }  
      });
      return false;                          
    });    
  $("#data_form").submit( function() {
       /* var vv = $(this).serialize();
       alert(vv);*/
       var url = "<?php echo base_url().'setting/simpan_setting'; ?>";
       $.ajax( {
         type:"POST", 
         cache :false,
         url:url,  
         data :$(this).serialize(),
         beforeSend: function(){
           $(".loading").show(); 
         },
 success : function(data) { 
  $(".tunggu").hide(); 
          if(data=="sukses"){
           $(".sukses").html('<div class="alert alert-success">Data Berhasil Disimpan</div>');
           setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'setting/' ?>";},1000);  
         }
         else{
          $(".sukses").html(data);
        }
        $(".loading").hide();             
      },  
      error : function(data) {  
        alert(data);  
      }  
    });
       return false;                    
  });

  $("#kode_unit_default").change(function(){
      var kode_unit_default = $("#kode_unit_default").val();
      var url = "<?php echo base_url().'setting/default_rak'; ?>";
      $.ajax({
            type: "POST",
            url: url,
            data: {kode_unit_default:kode_unit_default},
              success: function(pilihan) {              
                $("#kode_rak_default").html(pilihan);
              }
      });
  });

});
</script>