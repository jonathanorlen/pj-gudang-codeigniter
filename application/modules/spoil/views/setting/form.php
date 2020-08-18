<div class="row">      
  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Tambah Spoil
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
        $kode_spoil = $this->uri->segment(3);

        $kode_default = $this->db->get('setting_gudang');
        $hasil_unit =$kode_default->row();
        $kode_unit = $hasil_unit->kode_unit; 
        $unit = $this->db->get_where('master_unit',array('kode_unit' => $kode_unit));
        $hasil_unite = $unit->row();

        $this->db->select_max('id');
        $get_max_po = $this->db->get('transaksi_spoil');
        $max_po = $get_max_po->row();

        $this->db->where('id', $max_po->id);
        $get_po = $this->db->get('transaksi_spoil');
        $po = $get_po->row();
        $tahun = substr(@$po->kode_spoil, 3,4);
        if(date('Y')==$tahun){
          $nomor = substr(@$po->kode_spoil, 8);
          $nomor = $nomor + 1;
          $string = strlen($nomor);
          if($string == 1){
            $kode_trans = 'SP_'.date('Y').'_00000'.$nomor;
          } else if($string == 2){
            $kode_trans = 'SP_'.date('Y').'_0000'.$nomor;
          } else if($string == 3){
            $kode_trans = 'SP_'.date('Y').'_000'.$nomor;
          } else if($string == 4){
            $kode_trans = 'SP_'.date('Y').'_00'.$nomor;
          } else if($string == 5){
            $kode_trans = 'SP_'.date('Y').'_0'.$nomor;
          } else if($string == 6){
            $kode_trans = 'SP_'.date('Y').'_'.$nomor;
          }
        } else {
          $kode_trans = 'SP_'.date('Y').'_000001';
        }

        ?>
        

        <div class="box-body">    

          <div class="sukses" ></div>
          <form id="data_form" action="" method="post">
            <div class="box-body">
              <div class="row">


                <div class="col-md-4">
                  <div class="box-body">
                    <div class="btn btn-app blue" style="display: block;">
                      <span style="font-weight:bold;"><i class="fa fa-barcode"></i>&nbsp;&nbsp;&nbsp; Kode Spoil &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                      <span style="text-align:right;"><?php echo $kode_trans ?></span>
                      <input readonly="true" type="hidden" value="<?php echo $kode_trans ?>" class="form-control" placeholder="Kode Transaksi" name="kode_spoil" id="kode_spoil" />
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="btn btn-app blue"  style="display: block;">
                      <span style="font-weight:bold;"><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp; Tanggal Spoil &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                      <span style="text-align:right;" id="tanggal_spoil"><?php echo TanggalIndo(date("Y-m-d")); ?></span>
                    </div>
                  </div>
                </div>

              </div>
            </div> 
            <br><br>
            <div id="list_transaksi_pembelian">
              <div class="box-body">
                <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size: 1.5em;"> 
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
                      <th>Jumlah</th>
                      <th style="width:10%">Jumlah Spoil</th>
                      <th>Sisa</th>
                    </tr>
                  </thead>
                  <tbody id="">
                    <?php
                    $kode_default = $this->db->get('setting_gudang');
                    $hasil_unit =$kode_default->row();
                    $param =$hasil_unit->kode_unit;
                    $spoil =$this->db->get_where('opsi_transaksi_spoil_temp',array('kode_unit' => $param, 'kode_spoil' => $kode_spoil));
                    $list_spoil = $spoil->result();
                    $nomor = 1;  

                    foreach($list_spoil as $daftar){ 
                      @$satuan_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>@$daftar->kode_bahan));
                      @$hasil_satuan_bahan = $satuan_bahan->row();
                      ?> 
                      <tr>
                        <td><?php echo $nomor; ?></td>
                        <td><?php echo $daftar->kode_bahan; ?></td>
                        <td><?php echo $daftar->nama_bahan; ?></td>
                        <td>
                          <?php echo @$hasil_satuan_bahan->real_stock." ".@$hasil_satuan_bahan->satuan_stok;?>
                          <input name="<?php echo "stok".$daftar->kode_bahan; ?>" type="hidden" class="form-control <?php echo "stok".$daftar->kode_bahan; ?>" id="" value="<?php echo @$hasil_satuan_bahan->real_stock ?>" />
                        </td>
                        <td><input name="<?php echo $daftar->kode_bahan; ?>" type="text" class="form-control <?php echo "input".$daftar->kode_bahan; ?>" id="" value="" /></td>
                        <td>
                          <div class="<?php echo "visual".$daftar->kode_bahan; ?>"><?php echo @$hasil_satuan_bahan->real_stock." ".@$hasil_satuan_bahan->satuan_stok;?></div>
                          <input name="<?php echo "sisa".$daftar->kode_bahan; ?>" type="hidden" class="form-control <?php echo "sisa".$daftar->kode_bahan; ?>" id="" value="<?php echo @$hasil_satuan_bahan->real_stock ?>" />
                          <input name="<?php echo "satuan".$daftar->kode_bahan; ?>" type="hidden" class="form-control <?php echo "satuan".$daftar->kode_bahan; ?>" id="" value="<?php echo @$hasil_satuan_bahan->satuan_stok ?>" />
                        </td>
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
            
            <button type="submit" class="btn btn-success pull-right" >Simpan</button>

            <div class="box-footer clearfix"></div>

          </form>

          <!------------------------------------------------------------------------------------------------------>
        </div>
      </div><!-- /.col -->
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
          <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data spoil tersebut ?</span>
          <input id="id-delete" type="hidden">
        </div>
        <div class="modal-footer" style="background-color:#eee">
          <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
          <button onclick="delData()" class="btn red">Ya</button>
        </div>
      </div>
    </div>
  </div>
  <div id="modal-notif-input" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color:grey">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title" style="color:#fff;">Notifikasi</h4>
        </div>
        <div class="modal-body">
          <span style="font-weight:bold; font-size:14pt" id="text-notif">Apakah anda yakin akan menghapus data spoil tersebut ?</span>
          <input id="id-delete" type="hidden">
        </div>
        <div class="modal-footer" style="background-color:#eee">
          <button class="btn green" data-dismiss="modal" aria-hidden="true">OK</button>
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


  <script type="text/javascript">
    <?php
    foreach($list_spoil as $daftar){ ?>
      $(".<?php echo "input".$daftar->kode_bahan; ?>").keyup(function(){
        stok_awal = $(".<?php echo "stok".$daftar->kode_bahan; ?>").val();
        jumlah_spoil =  $(".<?php echo "input".$daftar->kode_bahan; ?>").val();
        satuan =  $(".<?php echo "satuan".$daftar->kode_bahan; ?>").val();

        hasil_akhir = stok_awal - jumlah_spoil;
        $(".<?php echo "sisa".$daftar->kode_bahan; ?>").val(hasil_akhir);
        $(".<?php echo "visual".$daftar->kode_bahan; ?>").text(hasil_akhir+" "+satuan);
      }); 
      <?php 
    } ?>
    $("#data_form").submit(function(){
      notif = 0;
      <?php
      foreach($list_spoil as $daftar){ ?>
        if($(".<?php echo "input".$daftar->kode_bahan; ?>").val()==""){
          $("#text-notif").text("Masukkan jumlah produk <?php echo $daftar->nama_bahan; ?> yang akan di spoil !");
          $("#modal-notif-input").modal("show");
          notif = 1;
        }
        <?php 
      } ?>
      if(notif == 0){
        var simpan_spoil = "<?php echo base_url().'spoil/spoil/simpan_spoil_baru'?>";
        $.ajax({
          type: "POST",
          url: simpan_spoil,
          data: $('#data_form').serialize(),
          beforeSend:function(){
            $(".tunggu").show();  
          },
          success: function(msg)
          {
            $(".tunggu").hide();
            $(".sukses").html(msg);   
            setTimeout(function(){$('.sukses').html('');
             window.location = "<?php echo base_url() . 'spoil/'; ?>";
           },1500);        
          }
        });
      }
      return false;
    });
  </script>