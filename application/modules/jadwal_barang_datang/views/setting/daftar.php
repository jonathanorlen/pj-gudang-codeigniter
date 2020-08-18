
<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Daftar Jadwal Barang Datang
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
            <div class="col-md-5" id="">
              <div class="input-group">
                <span class="input-group-addon">Tanggal Awal</span>
                <input type="text" class="form-control tgl" id="tgl_awal">
              </div>
            </div>

            <div class="col-md-5" id="">
              <div class="input-group">
                <span class="input-group-addon">Tanggal Akhir</span>
                <input type="text" class="form-control tgl" id="tgl_akhir">
              </div>
            </div>                        
            <div class="col-md-2 pull-left">
              <button style="width: 148px" type="button" class="btn btn-warning pull-right" id="cari"><i class="fa fa-search"></i> Cari</button>
            </div>
          </div>
          <br><br>
          <div id="cari_transaksi">
            <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
              <thead>

                <tr>
                  <th width="50px;">No</th>
                  <th>Kode Transaksi</th>
                  <th>Kode PO</th>
                  <th>Nama Supplier</th>
                  <th>Tanggal Barang Datang</th>
                  <th>Keterangan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $jadwal = $this->db->get('input_jadwal_barang_datang');
                $hasil_jadwal = $jadwal->result();
                $tgl = date("Y-m-d");
                $total = 0;
                $no=1;
                foreach ($hasil_jadwal as $daftar) {
                  $invoice = date('Y-m-d', strtotime(date($daftar->tanggal_barang_datang) . '- 1 day '));
                  if($invoice==$tgl OR $tgl==$daftar->tanggal_barang_datang){
                    ?>
                    <tr>
                      <td><?php echo $no++ ?></td>
                      <td><?php echo $daftar->kode_transaksi;  ?></td>
                      <td><?php echo $daftar->kode_po;  ?></td>
                      <?php 
                      $get_po=$this->db->get_where('transaksi_po',array('kode_transaksi'=>$daftar->kode_po));
                      $hasil_get=$get_po->row();
                      ?>

                      <td><?php echo @$hasil_get->nama_supplier;  ?></td>
                      <td><?php echo tanggalIndo($daftar->tanggal_barang_datang);  ?></td>
                      <td><?php echo $daftar->keterangan;  ?></td>
                      <td><?php echo get_detail_belum_datang($daftar->kode_po);  ?></td>
                    </tr>
                    <?php
                    $total++;
                  }
                } 

                ?>
              </tbody>                
            </table>

          </div>

        </div>

        <!------------------------------------------------------------------------------------------------------>

      </div>
    </div>
  </div><!-- /.col -->
</div>
</div>    
</div>

<div id="modal-validasi-menunggu" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <form id="sesuai_modal" method="post">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color:grey">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title" style="color:#fff;">Notifikasi</h4>
        </div>
        <div class="modal-body">
          <span style="font-weight:bold; font-size:14pt" id="text-notif">Apakah anda yakin akan menvalidasi PO ini ?</span>
          <input id="id-validasi" name="kode_pembelian" type="hidden">
        </div>
        <div class="modal-footer" style="background-color:#eee">
          <button class="btn green" data-dismiss="modal" aria-hidden="true" id="sesuai">YA</button>
          <button class="btn red" data-dismiss="modal" aria-hidden="true" id="hapus_transaksi">Tidak</button>
        </div>
      </div>
    </div>
  </form>
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
    window.location = "<?php echo base_url().'order/daftar/'; ?>";
  });
</script>  
<script src="<?php echo base_url().'component/lib/jquery.min.js'?>"></script>
<script src="<?php echo base_url().'component/lib/zebra_datepicker.js'?>"></script>
<link rel="stylesheet" href="<?php echo base_url().'component/lib/css/default.css'?>"/>
<script type="text/javascript">

 $('.tgl').Zebra_DatePicker({});


 $('#cari').click(function(){

  var tgl_awal =$("#tgl_awal").val();
  var tgl_akhir =$("#tgl_akhir").val();

  if (tgl_awal=='' || tgl_akhir==''){ 
    alert('Masukan Tanggal Awal & Tanggal Akhir..!')
  }
  else{
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url().'jadwal_barang_datang/cari_jadwal'; ?>",  
      cache :false,

      data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir},
      beforeSend:function(){
        $(".tunggu").show();  
      },
      success : function(data) {
       $(".tunggu").hide();  
       $("#cari_transaksi").html(data);
     },  
     error : function(data) {  
         // alert("das");  
       }  
     });
  }

  $('#tgl_awal').val('');
  $('#tgl_akhir').val('');

});
</script>

<script>
  $(document).ready(function() {
    $("#tabel_daftar").dataTable({
      "paging":   false,
      "ordering": true,
      "info":     false
    });
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
  });
  setTimeout(function(){
    $("#lalal").css("background-color", "white");
    $("#lalal").css("transition", "all 3000ms linear");
  }, 3000);
  $('#belum_validasi').click(function(){
    $("#modal-validasi-menunggu").modal("show");
    $("#id-validasi").val($(this).attr("key"));
  });
  $('#sesuai').click(function(){
    $(".tunggu").show();
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url() . 'validasi_po/simpan_pembelian_sesuai' ?>",  
      cache :false,
      beforeSend:function(){
        $(".tunggu").show();  
      },
      data :$("#sesuai_modal").serialize(),
      success : function(data) {  
        $(".sukses").html(data);   
        setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'validasi_po/daftar_validasi' ?>";},1);              
      },  
      error : function() {  
        alert("Data gagal dimasukkan.");  
      }  
    });
  });
  $('#hapus_transaksi').click(function(){
    $(".tunggu").show();
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url() . 'validasi_po/hapus_transaksi_pembelian' ?>",  
      cache :false,
      beforeSend:function(){
        $(".tunggu").show();  
      },
      data :$("#sesuai_modal").serialize(),
      success : function(data) {  
        $(".sukses").html(data);   
        setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'validasi_po/daftar_validasi' ?>";},1);              
      },  
      error : function() {  
        alert("Data gagal dimasukkan.");  
      }  
    });
  });
</script>


