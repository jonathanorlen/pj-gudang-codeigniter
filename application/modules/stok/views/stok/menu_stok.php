

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
      .menn{
        text-decoration: none;
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

                        <div class="row">
                            
                        </div>

                    </div>
                </div>
            </section><!-- /.Left col -->      
        </div><!-- /.row (main row) -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->