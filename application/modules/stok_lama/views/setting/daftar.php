
<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Stok
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
          <table class="table table-striped table-hover table-bordered" id="sample_editable_1"  style="font-size:1.5em;">
            <thead>
              <tr>
                <th width="50px;">No</th>
                <th>No Transaksi</th>
                <th>Nama Anggota</th>
                <th>Kelompok</th>
                <th>Status</th>

                <th width="133px;">Action</th>
              </tr>
            </thead>
            <tbody>
             
            </tbody>                
          </table>

          
        </div>
        
        <!------------------------------------------------------------------------------------------------------>

      </div>
    </div>
  </div><!-- /.col -->
</div>
</div>    
</div>  


<script>
  $(document).ready(function() {

    setTimeout(function(){
      $("#lalal").fadeIn('slow');
    }, 1000);
    $("a#hapus").click( function() {    
      var r =confirm("Anda yakin ingin menghapus data ini ?");
      if (r==true)  
      {
        $.ajax( {  
          type :"post",  
          url :"<?php echo base_url() . 'anggota/hapus' ?>",  
          cache :false,  
          data :({key:$(this).attr('key')}),
          beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) { 
            $(".sukses").html(data);   
            setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'anggota/daftar' ?>";},1500);              
          },  
          error : function() {  
            alert("Data gagal dimasukkan.");  
          }  
        });
        return false;
      }
      else {}        
    });

    $('#tabel_daftar').dataTable();
  } );
  setTimeout(function(){
    $("#lalal").css("background-color", "white");
    $("#lalal").css("transition", "all 3000ms linear");
  }, 3000);

</script>

