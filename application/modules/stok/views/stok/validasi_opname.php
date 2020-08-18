

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Data Stok </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin').'/dasboard' ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
    </section>
<style type="text/css">
 .ombo{
  width: 400px;
 } 

</style>    
    <!-- Main content -->
    <section class="content">             
      <!-- Main row -->
      
        <div class="row">
        <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
                <div class="box box-info">
                    <div class="box-header">
                        <!-- tools box -->
                        <div class="pull-right box-tools"></div><!-- /. tools -->
                    </div>
                    
                    <div class="box-body">          
                        <div class="loading" style="z-index:9999999999999999; background:rgba(255,255,255,0.8); width:100%; height:100%; position:fixed; top:0; left:0; text-align:center; padding-top:25%; display:none" >
                          <img src="<?php echo base_url() . '/public/img/loading.gif' ?>">
                        </div>

                        <div class="row">
                            <?php 
                              $get_unit = $this->db->get('master_unit');
                              $hasil_unit = $get_unit->result_array();
                              $i = 0;
                              foreach ($hasil_unit as $item) {
                            ?> 
                            <div class="col-lg-3 col-xs-6">
                              <div class="small-box bg-green">
                                <a style="text-decoration:none" href="<?php echo base_url().'stok/daftar_stok/'.$item['kode_unit'] ; ?>">
                                <p>&nbsp;</p>
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/gudang.png'?>) no-repeat center center;">
                                  <h3>&nbsp;</h3>
                                  <p>&nbsp;</p>
                                </div>
                                <div class="icon" style="margin-top:15px">
                                  <i class="ion-ios-list-outline"></i>
                                </div>
                                <a class="small-box-footer"><?php echo $item['nama_unit'];?></a></a>
                              </div>
                            </div>
                            <?php } ?>

                            <div class="col-lg-3 col-xs-6">
                              <div class="small-box bg-green">
                                <a style="text-decoration:none" href="<?php echo base_url().'stok/stok/daftar_mutasi'; ?>">
                                <p>&nbsp;</p>
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/mutasi.png'?>) no-repeat center center;">
                                  <h3>&nbsp;</h3>
                                  <p>&nbsp;</p>
                                </div>
                                <div class="icon" style="margin-top:15px">
                                  <i class="ion-ios-list-outline"></i>
                                </div>
                                <a class="small-box-footer">Mutasi</a></a>
                              </div>
                            </div>

                        </div>

                    </div>
                </div>
            </section><!-- /.Left col -->      
        </div><!-- /.row (main row) -->

        <div class="row">
        <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
                <div class="box box-info">
                    <div class="box-header">
                        <!-- tools box -->
                        <div class="pull-right box-tools"></div><!-- /. tools -->
                        <?php
                          $param = $this->uri->segment(3);
                          $get_unit = $this->db->get_where('master_unit',array('kode_unit' => $param));
                          $hasil_unit = $get_unit->result_array();
                          foreach ($hasil_unit as $item) {
                        ?>
                        <a style="padding:13px; margin-bottom:10px" class="btn btn-app green" href="<?php echo base_url().'stok/daftar_stok/'.$item['kode_unit'] ; ?>">
                          <i class="fa fa-cube"></i> Stok
                        </a>
                        
                        <a style="padding:13px; margin-bottom:10px" class="btn btn-app blue" href="<?php echo base_url().'stok/daftar_opname/'.$item['kode_unit'] ; ?>">
                          <i class="fa fa-cubes"></i> Opname
                        </a>
                        
                        <a style="padding:13px; margin-bottom:10px" class="btn btn-app red" href="<?php echo base_url().'stok/daftar_spoil/'.$item['kode_unit'] ; ?>">
                          <i class="fa fa-minus"></i> Spoil
                        </a>

                        <?php } ?>
                    </div>

                    <div class="box-body">
                      <div class="box box-info">
                        <div class="box-header">
                            <!-- tools box -->
                            <div class="pull-right box-tools"></div><!-- /. tools -->
                            <div class="row"> 
                              <a style="padding:13px; margin-bottom:10px" class="btn btn-app yellow" href="<?php echo base_url().'stok/tambah_opname/'.$item['kode_unit'] ; ?>">
                                <i class="fa fa-plus"></i> Tambah Opname
                              </a>
                            </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="box-body">           
                        <div class="box box-info">
                        <div class="box-header">
                            <!-- tools box -->
                            <div class="pull-right box-tools"></div><!-- /. tools -->
                        </div>
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
                                      <div class="callout callout-info">
                                        <span style="font-weight:bold;"><i class="fa fa-barcode"></i>&nbsp;&nbsp;&nbsp; Kode Opname &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                                        <span style="text-align:right;"><?php echo @$daftar->kode_opname; ?></span>
                                        <input readonly="true" type="hidden" value="<?php echo @$daftar->kode_opname; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_opname" id="kode_opname" />
                                      </div>
                                    </div>
                                </div>

                                 <div class="col-md-6">
                                    <div class="box-body">
                                      <div class="callout callout-info">
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

                            <div id="list_transaksi_pembelian">
                              <div class="box-body">
                                <table id="tabel_daftar" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Jenis Bahan</th>
                                      <th>Nama Bahan</th>
                                      <th>Qty Stok</th>
                                      <th>Qty Fisik</th>
                                      <th>Selisih</th>
                                      <th>Status</th>
                                      <th>Keterangan</th>
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
                                          <td><?php echo $daftar->jenis_bahan; ?></td>
                                          <td><?php echo $daftar->nama_bahan; ?></td>
                                          <td><?php echo $daftar->stok_awal; ?></td>
                                          <td><?php echo $daftar->stok_akhir; ?></td>
                                          <td><?php echo $daftar->selisih; ?></td>
                                          <td><?php echo $daftar->status; ?></td>
                                          <td><?php echo $daftar->keterangan; ?></td>
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

                              <div class="box-footer">
                                <button type="submit" class="btn btn-danger pull-right" id="jangan_sesuaikan"><i class="fa fa-remove"></i>  Jangan Sesuaikan</button>
                                <button type="submit" class="btn btn-success pull-right" id="sesuaikan"><i class="fa fa-check"></i>  Sesuaikan</button>
                              </div>
                        </form>

                      </div>  
                    </div>
                </div>
            </section><!-- /.Left col -->      
        </div><!-- /.row (main row) -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:grey">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
            </div>
            <div class="modal-body">
                <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data opname tersebut ?</span>
                <input id="id-delete" type="hidden">
            </div>
            <div class="modal-footer" style="background-color:#eee">
                <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
                <button onclick="delData()" class="btn red">Ya</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
  //$("#tabel_daftar").dataTable();
  $('#jangan_sesuaikan').on('click',function(){
    var kode_opname = $('#kode_opname').val();
    var url = "<?php echo base_url().'stok/stok/jangan_sesuaikan'?>";
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
          window.location = "<?php echo base_url() . 'stok/daftar_opname/'.$item['kode_unit'] ; ?>";
        },1500); 
      }
    });
    return false;
  });

  $('#sesuaikan').on('click',function(){
    var kode_opname = $('#kode_opname').val();
    var url = "<?php echo base_url().'stok/stok/sesuaikan'?>";
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
          window.location = "<?php echo base_url() . 'stok/daftar_opname/'.$item['kode_unit'] ; ?>";
        },1500);
      }
    });
    return false;
  });


}) 
</script>