
<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Produk
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
          <div class="col-md-10 row" id="opsi_filter">
            <div class="col-md-5 row" id="">
              <div class="input-group">
                <span class="input-group-addon">Kategori Produk</span>
                <select class="form-control" id="kategori_produk">
                  <?php
                  $jenis_filter = $this->db->get('master_kategori_menu');
                  $hasil_jenis_filter = $jenis_filter->result();
                  echo "<option value=''>Pilih Kategori Produk</option>";
                  foreach ($hasil_jenis_filter as  $value) {
                    echo "<option value=".$value->kode_kategori_menu.">".$value->nama_kategori_menu."</option>";
                  }
                  ?>
                </select>
              </div>
              <br>
            </div>                        
          </div>
          <div class="col-md-10 row" id="opsi_filter">
            <div class="col-md-5 row" id="">
              <div class="input-group">
                <span class="input-group-addon">Nama Produk</span>
                <input type="text" class="form-control" id="nama_produk">
              </div>
              <br>
            </div>                        
          </div>
          <div class="col-md-10 row" id="opsi_filter">
            <div class="col-md-5 row" id="">
              <button style="width: 100px" type="button" class="btn btn-warning " id="cari"><i class="fa fa-search"></i> Cari</button>
            </div>
            <br>
            <br>
            <br>
            <br>
          </div>
          <div id="cari_produk">
            <table  class="table table-striped table-hover table-bordered" id="tabel_daftarr"  style="font-size:1.5em;">

              <?php
              $kode_default = $this->db->get('setting_gudang');
              $hasil_unit =$kode_default->row();
              $param=$hasil_unit->kode_unit;
              $this->db->limit(100);
              $bahan_baku = $this->db->get_where('master_bahan_baku',array('kode_unit' => $param));
              $hasil_bahan_baku = $bahan_baku->result();
              ?>

              <thead>
                <tr width="100%">
                  <th>No</th>
                  <th>Kode Produk</th>
                  <th>Nama Produk</th>
                  <th style="display:none;">Kategori Produk</th>
                  <th>Unit</th>
                  <th>Block</th>
                  <th>Real Stock</th>
                  <th>Stok Minimal</th>
                  <th width="10%">Action</th>
                </tr>
              </thead>
              <tbody style="width: 700px;" id="posts">
                <?php
                $nomor=1;
                foreach($hasil_bahan_baku as $daftar){

                // $opsi_bahan_baku = $this->db->get_where('opsi_bahan_baku',array('kode_bahan_baku' => $daftar->kode_bahan_baku));
                // $hasil_opsi_bahan_baku = $opsi_bahan_baku->row();

                  ?>
                  <tr>
                    <td width="80px"><?php echo $nomor; ?></td>
                    <td width="150px"><?php echo $daftar->kode_bahan_baku; ?></td>
                    <td width="500px"><?php echo $daftar->nama_bahan_baku; ?></td>
                    <td style="display:none;"><?php echo $daftar->nama_kategori_produk; ?></td>
                    <td><?php echo $daftar->nama_unit; ?></td>
                    <td><?php echo $daftar->nama_rak; ?></td>
                    <td width="150px"><?php echo $daftar->real_stock; ?></td>
                    <td width="150px"><?php echo $daftar->stok_minimal; ?></td>
                    <td><?php echo get_detail_edit_delete_gudang($daftar->id); ?></td>
                  </tr>
                  <?php $nomor++; } ?>
                </tbody>
                <tfoot>
                  <tr>
                   <th>No</th>
                   <th>Kode Produk</th>
                   <th>Nama Produk</th>
                   <th style="display:none;">Kategori Produk</th>
                   <th>Unit</th>
                   <th>Block</th>
                   <th>Real Stock</th>
                   <th>Stok Minimal</th>
                   <th>Action</th>
                 </tr>
               </tfoot>
             </table>
             <br><br><br><br><br><br><br><br>
             <br><br><br><br><br><br><br><br>
             <?php 
             $get_jumlah = $this->db->get_where('master_bahan_baku', array('kode_unit' => $param));
             $jumlah = $get_jumlah->num_rows();
             $jumlah = floor($jumlah/100);
             ?>
             <input type="hidden" class="form-control rowcount" value="<?php echo $jumlah ?>">
             <input type="hidden" class="form-control pagenum" value="0">
           </div>

         </div>

         <!------------------------------------------------------------------------------------------------------>

       </div>
     </div>
   </div><!-- /.col -->
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
        <span style="font-weight:bold; font-size:12pt">Apakah anda yakin akan menghapus data bahan baku tersebut ?</span>
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
    window.location = "<?php echo base_url().'master/daftar/'; ?>";
  });
</script>

<script>
  $(window).scroll(function(){
    if (Math.floor($(window).scrollTop()) == ($(document).height() - $(window).height())){
      if(parseInt($(".pagenum").val()) <= parseInt($(".rowcount").val())) {
        var pagenum = parseInt($(".pagenum").val()) + 1;
        $(".pagenum").val(pagenum);
        load_table(pagenum);
      }
    }
  });

  function load_table(page){
    var kategori =$("#kategori_produk").val();
    var nama_produk =$("#nama_produk").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url() . 'master/bahan_baku/get_table' ?>",
      data: ({kategori:kategori,nama_produk:nama_produk, page:$(".pagenum").val()}),
      beforeSend: function(){
        $(".tunggu").show();  
      },
      success: function(msg)
      {
        $(".tunggu").hide();
        $("#posts").append(msg);

      }
    });
  }

  function actDelete(Object) {
    $('#id-delete').val(Object);
    $('#modal-confirm').modal('show');
  }

  function delData() {
    var id = $('#id-delete').val();
    var url = '<?php echo base_url().'master/bahan_baku/hapus'; ?>/delete';
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
  $(document).ready(function(){
    $("#tabel_daftar").dataTable({
      "paging":   false,
      "ordering": false,
      "searching": false,
      "info":     false
    });
  });
  $('#cari').click(function(){

    var kategori =$("#kategori_produk").val();
    var nama_produk =$("#nama_produk").val();
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url().'master/bahan_baku/cari_bahan_baku'; ?>",  
      cache :false,

      data : {kategori:kategori,nama_produk:nama_produk},
      beforeSend:function(){
        $(".tunggu").show();  
      },
      success : function(data) {
       $(".tunggu").hide();  
       $("#cari_produk").html(data);
     },  
     error : function(data) {  
       alert("das");  
     }  
   });
  });

</script>
