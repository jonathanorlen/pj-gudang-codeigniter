

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
       <?php
            $kode = $this->uri->segment(3);
            $unit = $this->db->get_where('master_unit',array('kode_unit' => $kode));
            $hasil_unite = $unit->row();
        ?>
      <h1>Data Stok <?php echo $hasil_unite->nama_unit; ?>  </h1>
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
                        <div class="sukses" ></div>
                        <div class="loading" style="z-index:9999999999999999; background:rgba(255,255,255,0.8); width:100%; height:100%; position:fixed; top:0; left:0; text-align:center; padding-top:25%; display:none" >
                          <img src="<?php echo base_url() . '/public/img/loading.gif' ?>">
                        </div>

                        <div style="margin-left: 5px;" class="row">
                            <?php 
                              $get_unit = $this->db->get_where('master_unit', array('group' => 'induk' ));
                              $hasil_unit = $get_unit->result_array();
                              $i = 0;
                              foreach ($hasil_unit as $item) {
                            ?> 
                              <div class="small-box bg-green menu-radius">
                                <a style="text-decoration:none" href="<?php echo base_url().'stok/daftar_stok/'.$item['kode_unit'] ; ?>">
                                <p>&nbsp;</p>
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/gudang.png'?>) no-repeat center center; background-size: 90px 90px;">
                                  <h3>&nbsp;</h3>
                                  <p>&nbsp;</p>
                                </div>
                                <div class="icon" style="margin-top:15px">
                                  <i class="ion-ios-list-outline"></i>
                                </div>
                                <a class="small-box-footer"><?php echo $item['nama_unit'];?></a></a>
                              </div>
                            <?php } ?>

                              <div class="small-box bg-green menu-radius">
                                <a style="text-decoration:none" href="<?php echo base_url().'stok/stok/daftar_mutasi'; ?>">
                                <p>&nbsp;</p>
                                <div class="inner" style="background:url(<?php echo base_url().'component/admin/img/icon/mutasi.png'?>) no-repeat center center; background-size: 90px 90px;">
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
                        <div class="sukses" ></div>
                        <div class="loading" style="z-index:9999999999999999; background:rgba(255,255,255,0.8); width:100%; height:100%; position:fixed; top:0; left:0; text-align:center; padding-top:25%; display:none" >
                          <img src="<?php echo base_url() . '/public/img/loading.gif' ?>" >
                        </div>

                        <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Kode Opname</th>
                                <th>Tanggal Opname</th>
                                <th>Petugas</th>
                                <th>Status Validasi</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                  $param = $this->uri->segment(3);
                                  $opname = $this->db->get_where('transaksi_opname',array('kode_unit' => $param));
                                  $list_opname = $opname->result();
                                  $nomor = 1;  

                                  foreach($list_opname as $daftar){ 
                                ?> 
                                    <tr>
                                      <td><?php echo @$nomor; ?></td>
                                      <td><?php echo @$daftar->kode_opname; ?></td>
                                      <td><?php echo @$daftar->tanggal_opname; ?></td>
                                      <td><?php echo @$daftar->petugas; ?></td>
                                      <td><?php echo @$daftar->validasi; ?></td>
                                      <td align="center">
                                        <?php 
                                          if (@$daftar->validasi == 'confirmed') {
                                            echo '-';
                                          } else {
                                            echo get_validasi_opname($param,@$daftar->kode_opname);
                                          }
                                        ?>
                                      </td>
                                    </tr>
                                <?php 
                                    $nomor++; 
                                  } 
                                ?>
                               
                            </tbody>
                              <tfoot>
                                <tr>
                                <th>No</th>
                                <th>Kode Opname</th>
                                <th>Tanggal Opname</th>
                                <th>Petugas</th>
                                <th>Status Validasi</th>
                                <th>Action</th>
                              </tr>
                             </tfoot>
                        </table>
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
                <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data menu tersebut ?</span>
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
  $("#tabel_daftar").dataTable();
})

function actDelete(Object) {
    $('#id-delete').val(Object);
    $('#modal-confirm').modal('show');
}

function delData() {
    var id = $('#id-delete').val();
    var url = '<?php echo base_url().'master/menu_resto/hapus_bahan_jadi'; ?>/delete';
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
   
</script>