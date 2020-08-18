<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Validasi Opname

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
        $kode_unit = $this->uri->segment(3);
        $get_unit = $this->db->get_where('master_unit',array('kode_unit' => $kode_unit));
        $hasil_unit = $get_unit->result_array();

        ?>
        <div class="box-body">                   
          <div class="sukses" ></div>
          <form id="data_form" action="" method="post">
            <div class="box-body">
              <label><h3><b>Validasi Opname</b></h3></label>
              <div class="row">
                <?php
                $param = $this->uri->segment(3);
                $kode_opname = $this->uri->segment(4);
                $opname = $this->db->get_where('transaksi_opname',array('kode_opname' => $kode_opname));
                $list_opname = $opname->result();

                foreach($list_opname as $daftar){ 
                  ?>

                  <div class="col-md-6">
                    <div class="box-body">
                      <div class="btn btn-app blue">
                        <span style="font-weight:bold;"><i class="fa fa-barcode"></i>&nbsp;&nbsp;&nbsp; Kode Opname &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                        <span style="text-align:right;"><?php echo @$daftar->kode_opname; ?></span>
                        <input readonly="true" type="hidden" value="<?php echo @$daftar->kode_opname; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_opname" id="kode_opname" />
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="box-body">
                      <div class="btn btn-app blue">
                        <span style="font-weight:bold;"><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp; Tanggal Opname &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                        <span style="text-align:right;" id="tanggal_opname"><?php echo tanggalIndo(@$daftar->tanggal_opname); ?></span>
                      </div>
                    </div>
                  </div>

                  <?php 
                } 
                ?>
              </div>
            </div> 
            <br><br>
            <div id="list_transaksi_pembelian">
              <div class="box-body">
                <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">
                  <thead>
                    <tr>
                      <th>No</th>
                      
                      <th>Nama Bahan</th>
                      <th>Qty Stok</th>
                       <th>Qty Fisik</th>
                      <th>Selisih</th>
                      <th>Status</th>
                      <th>Nominal</th>
                      <th>Action</th>
                       
                     <!--  <th>Keterangan</th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $param = $this->uri->segment(3);
                    $kode_opname = $this->uri->segment(4);
                    $opname = $this->db->get_where('opsi_transaksi_opname',array('kode_opname' => $kode_opname));
                    $list_opname = $opname->result();
                    $nomor = 1;  

                    foreach($list_opname as $daftar){ 
                      ?> 
                      <tr>
                        <td><?php echo $nomor; ?></td>
                        
                        <td><?php echo $daftar->nama_bahan; ?></td>
                        <?php 
                        $kode_bahan=$daftar->kode_bahan;

                        $query=$this->db->query("SELECT * from master_bahan_baku where kode_bahan_baku = '$kode_bahan'");
                        $hasil_satuan=$query->row();


                        ?>
                        <td><?php echo $daftar->stok_awal. " ".$hasil_satuan->satuan_stok; ?></td>
                         <td><?php echo $daftar->stok_akhir. " ".$hasil_satuan->satuan_stok; ?></td> 
                        <td><?php echo $daftar->selisih. " ".$hasil_satuan->satuan_stok; ?></td>
                        <td><?php echo $daftar->status; ?></td>
                        <td><?php if($daftar->status=="Tidak Cukup"){
                            echo format_rupiah($daftar->selisih * $hasil_satuan->hpp);
                        }else{
                            echo "-";
                        } ?></td>
                        <td><a bb="<?php echo $kode_bahan ?>" op="<?php echo $daftar->kode_opname; ?>" class="btn btn-md btn-danger hapus"><i class="fa fa-trash"></i> Delete</a></td>
                         
                        <!--<td><?php #echo $daftar->keterangan; ?></td> -->

                      </tr>
                      <?php 
                      $nomor++; 
                    } 
                    ?>
                  </tbody>
                  <tfoot>

                  </tfoot>
                </table>
              </div>
            </div>
            <div class="row" id="input_nominal">
             <div class="col-md-4">
              <label>Nominal Opname</label>
              <input type="text" class="form-control" placeholder="Nominal Opname" name="nominal_opname" id="nominal_opname" />

            </div>
            <br><br>
            <a class="btn blue pull-left" id="simpan"><i class="fa fa-save"></i>  Simpan</a>
          </div>

          <button type="submit" class="btn btn-danger pull-right" id="dihibahkan"><i class="fa fa-remove"></i>  Dihibahkan</button>
          <a class="btn btn-success pull-right" id="sesuaikan"><i class="fa fa-check"></i>  Ditindak Lanjuti</a>
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
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data opname tersebut ?</span>
         <input id="kode_bahan" type="hidden">
        <input id="kode_transaksi" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn red" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()" class="btn green">Ya</button>
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
  window.location = "<?php echo base_url().'opname/daftar_opname'; ?>";
});
</script>
<script>
function delData(){
  var kode_bahan_baku = $("#kode_bahan").val();
  var kode_opname = $("#kode_transaksi").val();
  var url = "<?php echo base_url().'opname/opname/hapus_opsi_opname_view'?>";
   $.ajax({
      type: "POST",
      url: url,
      data: {kode_opname:kode_opname,kode_bahan_baku:kode_bahan_baku},
      success: function(msg)
      {
        $(".sukses").html(msg);   
        window.location.reload();
      }
    });
}
$(document).ready(function(){
   $(".hapus").click(function(){
    var kode_opname = $(this).attr('op');
    var kode_bahan_baku = $(this).attr('bb');
    $("#kode_bahan").val(kode_bahan_baku);
    $("#kode_transaksi").val(kode_opname);
    $("#modal-confirm").modal('show');
  });
  //$("#tabel_daftar").dataTable();
  $('#input_nominal').hide();
  $('#sesuaikan').on('click',function(){
    $('#input_nominal').show();
  });

  $('#jangan_sesuaikan').on('click',function(){
    var kode_opname = $('#kode_opname').val();
    var url = "<?php echo base_url().'opname/opname/jangan_sesuaikan'?>";
    var form_data = {
      kode_opname: kode_opname
    };
    $.ajax({
      type: "POST",
      url: url,
      data: form_data,
      success: function(msg)
      {
        $(".sukses").html(msg);   
        setTimeout(function(){$('.sukses').html('');
          window.location = "<?php echo base_url() . 'opname/daftar_opname/'.$kode_unit; ?>";
        },1500); 
      }
    });
    return false;
  });

  $('#sesuaikan').on('click',function(){
    $('#input_nominal').show();
  });
  
  $('#simpan').on('click',function(){
    var kode_opname = $('#kode_opname').val();
     var nominal_opname = $('#nominal_opname').val();
    var url = "<?php echo base_url().'opname/opname/sesuaikan_view'?>";
    var form_data = {
      kode_opname: kode_opname,
      nominal_opname:nominal_opname
    };
    $.ajax({
      type: "POST",
      url: url,
      data: form_data,
      success: function(msg)
      {
        $(".sukses").html(msg);   
        setTimeout(function(){$('.sukses').html('');
          window.location = "<?php echo base_url() . 'opname/daftar_opname/'; ?>";
        },1500);
      }
    });
    return false;
  });
$('#dihibahkan').on('click',function(){
    var kode_opname = $('#kode_opname').val();
    var url = "<?php echo base_url().'opname/opname/dihibahkan_view'?>";
    var form_data = {
      kode_opname: kode_opname
    };
    $.ajax({
      type: "POST",
      url: url,
      data: form_data,
      success: function(msg)
      {
        $(".sukses").html(msg);   
        setTimeout(function(){$('.sukses').html('');
          window.location = "<?php echo base_url() . 'opname/daftar_opname/'.$kode_unit; ?>";
        },1500);
      }
    });
    return false;
  });


}) 
</script>