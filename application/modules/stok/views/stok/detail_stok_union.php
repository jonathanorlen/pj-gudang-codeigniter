

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Data Menu </h1>
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
                $kode_unit = $this->uri->segment(3);
                $get_unit = $this->db->get_where('master_unit',array('kode_unit' => $kode_unit));
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
                  <div class="row">
                    <?php 
                    $kode_unit = $this->uri->segment(3);
                    $kode_rak = $this->uri->segment(4);
                    $kode_bahan = $this->uri->segment(5);

                    $get_stok = $this->db->query("SELECT kode, nama, kode_rak, nama_rak, real_stock FROM (
                      SELECT kode_bahan_baku as kode, nama_bahan_baku as nama, kode_rak as kode_rak, nama_rak as nama_rak, real_stock as real_stock, kode_unit as kode_unit
                      FROM master_bahan_baku 
                      UNION 
                      SELECT kode_bahan_jadi as kode, nama_bahan_jadi as nama, kode_rak as kode_rak, nama_rak as nama_rak, real_stock as real_stock, kode_unit as kode_unit 
                      FROM master_bahan_jadi ) 
                    AS all_table  WHERE all_table.kode = '$kode_bahan' AND all_table.kode_unit = '$kode_unit' AND all_table.kode_rak = '$kode_rak' ");
                    $hasil_stok = $get_stok->result_array();
                    foreach ($hasil_stok as $item) {
                      ?> 
                      <div class="col-md-3">
                        <div class="box-header with-border"></div>
                        <div class="box-body">
                          <div class="callout callout-info">
                            <span style="font-weight:bold;"><i class="fa fa-barcode"></i>&nbsp;&nbsp;&nbsp;Kode</span>
                            <p align="right"><?php echo @$item['kode'];?></p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="box-header with-border"></div>
                        <div class="box-body">
                          <div class="callout callout-info">
                            <span style="font-weight:bold;"><i class="fa fa-cube"></i>&nbsp;&nbsp;&nbsp;Nama Bahan</span>
                            <p align="right"><?php echo @$item['nama'];?></p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="box-header with-border"></div>
                        <div class="box-body">
                          <div class="callout callout-info">
                            <span style="font-weight:bold;"><i class="fa fa-tasks"></i>&nbsp;&nbsp;&nbsp;Rak</span>
                            <p align="right"><?php echo @$item['nama_rak'];?></p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="box-header with-border"></div>
                        <div class="box-body">
                          <div class="callout callout-info">
                            <span style="font-weight:bold;"><i class="fa fa-cubes"></i>&nbsp;&nbsp;&nbsp;Real Stock</span>
                            <p align="right"><?php echo @$item['real_stock'];?></p>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                    <?php
                        $kode_unit = $this->uri->segment(3);
                      $kode_rak = $this->uri->segment(4);
                      $kode_bahan = $this->uri->segment(5);
                    
                        $this->db->select('kategori_bahan');
                        $cek_stok = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan));
                        $hasil_cek = $cek_stok->row();
                        if(@$hasil_cek->kategori_bahan=="bahan jadi"){
                            $jadi = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan,
                            'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
                            $hasil_jadi = $jadi->row();
                            $sisa_stok = $hasil_jadi->real_stock;
                            $satuan_stok = $hasil_jadi->satuan_stok;
                        }elseif(@$hasil_cek->kategori_bahan=="bahan baku"){
                            $baku = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,
                            'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
                            $hasil_baku = $baku->row();
                            $sisa_stok = $hasil_baku->real_stock;
                            $satuan_stok = $hasil_baku->satuan_stok;
                        }else{
                            $konsi = $this->db->get_where('master_menu',array('kode_menu'=>$kode_bahan));
                            $hasil_konsi = $konsi->row();
                            $sisa_stok = $hasil_konsi->real_stok;
                            $satuan_stok = $hasil_konsi->satuan_stok;
                        }
                      ?>
                  <div class="box-body">
                    <?php 
                      

                      $get_pengeluaran_stok = $this->db->query("SELECT 
                        SUM(stok_keluar) as stok_keluar , tanggal_transaksi
                        FROM transaksi_stok
                        WHERE kode_bahan='$kode_bahan' AND kode_unit_asal='$kode_unit' GROUP BY tanggal_transaksi");
                      $hasil_pengeluaran_stok = $get_pengeluaran_stok->row();
                      ?>
                      <!--<h4>Pengeluaran hari ini : <?php #echo $hasil_pengeluaran_stok->stok_keluar;?></h4>-->
                      <?php

                      $get_pengeluaran_stok = $this->db->query("SELECT 
                        SUM(stok_keluar) as stok_keluar
                        FROM transaksi_stok
                        WHERE kode_bahan='$kode_bahan'");
                      $hasil_pengeluaran_stok = $get_pengeluaran_stok->row();
                      ?>
                      <h4>Total pengeluaran :<?php echo $hasil_pengeluaran_stok->stok_keluar." ".$satuan_stok; ?></h4>
                      <?php 

                      $get_pemasukan_stok = $this->db->query("SELECT 
                        SUM(stok_masuk) as stok_masuk
                        FROM transaksi_stok
                        WHERE kode_bahan='$kode_bahan'");
                      $hasil_pemasukan_stok = $get_pemasukan_stok->row();
                      ?>           
                      <!--<h4>Pemasukan hari ini :</h4>--> 
                      <h4>Total pemasukan : <?php echo $hasil_pemasukan_stok->stok_masuk." ".$satuan_stok; ?></h4>
                                  
                      <h4>Sisa stok : <?php echo $sisa_stok." ".$satuan_stok; ?></h4>   
                    </br>
                    <div class="sukses" ></div>
                    <div class="loading" style="z-index:9999999999999999; background:rgba(255,255,255,0.8); width:100%; height:100%; position:fixed; top:0; left:0; text-align:center; padding-top:25%; display:none" >
                      <img src="<?php echo base_url() . '/public/img/loading.gif' ?>" >
                    </div>

                    <table id="tabel_daftar" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Tanggal Transaksi</th>
                          <th>Jenis Transaksi</th>
                          <th>Kode Transaksi</th>
                          <th>Stok Keluar</th>
                          <th>Stok Masuk</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php 
                          $kode_unit = $this->uri->segment(3);
                          $kode_rak = $this->uri->segment(4);
                          $kode_bahan = $this->uri->segment(5);
                          $get_transaksi_stok = $this->db->query("SELECT  *
                                                                  FROM transaksi_stok
                                                                  WHERE kode_bahan = '$kode_bahan' AND jenis_transaksi != 'mutasi'

                                                                  UNION

                                                                  SELECT  *
                                                                  FROM transaksi_stok
                                                                  WHERE kode_bahan = '$kode_bahan' AND kode_unit_asal = '$kode_unit' AND stok_keluar != ''
                                                                  
                                                                  UNION

                                                                  SELECT  *
                                                                  FROM transaksi_stok
                                                                  WHERE kode_bahan = '$kode_bahan' AND kode_unit_tujuan = '$kode_unit' AND stok_masuk != ''     
                                                                  ORDER BY tanggal_transaksi                                                                     
                                                                 "
                                                                );
                          $hasil_transaksi_stok = $get_transaksi_stok->result_array();
                          foreach ($hasil_transaksi_stok as $item) {

                        ?>   
                          <tr>
                            <td><?php echo tanggalIndo(@$item['tanggal_transaksi']);?></td>
                            <td><?php echo @$item['jenis_transaksi'];?></td>
                            <td><?php echo @$item['kode_transaksi'];?></td>
                            <td align="center">
                              <?php 
                                  if (empty($item['stok_keluar'])) {
                                    echo '-';
                                  } else {
                                    echo @$item['stok_keluar']." ".$satuan_stok;
                                  }
                              ?>
                            </td>
                            <td align="center">
                              <?php 
                                  if (empty($item['stok_masuk'])) {
                                    echo '-';
                                  } else {
                                    echo @$item['stok_masuk']." ".$satuan_stok;
                                  }
                              ?>
                            </td>
                          </tr>

                        <?php 
                          } 
                        ?>

                        </tbody>
                        <tfoot>
                          <tr>
                            <th>Tanggal Transaksi</th>
                            <th>Jenis Transaksi</th>
                            <th>Kode Transaksi</th>
                            <th>Stok Keluar</th>
                            <th>Stok Masuk</th>
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