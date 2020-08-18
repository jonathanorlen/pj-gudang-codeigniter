

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Data Pembelian </h1>
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
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app green" href="<?php echo base_url().'pembelian/pembelian/tambah'; ?>">
              <i class="fa fa-plus"></i> Tambah Pembelian
            </a>
            
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app blue" href="<?php echo base_url().'pembelian/pembelian/daftar_pembelian'; ?>">
              <i class="fa fa-list"></i> Daftar Pembelian
            </a>
            
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app green" href="<?php echo base_url().'pembelian/retur/tambah'; ?>">
              <i class="fa fa-plus"></i> Tambah Retur Pembelian
            </a>
            
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app blue" href="<?php echo base_url().'pembelian/retur/daftar_retur_pembelian'; ?>">
              <i class="fa fa-list"></i> Daftar Retur Pembelian
            </a>
            <div class="small-box bg-aqua pull-right">
              <div class="inner">
                <h4 style="font-size:25px; font-family:arial; font-weight:bold">Total Pembelian</h4>

                <p>Rp.</p>
              </div>
            </div>
              <br><br><br>
                <div class="box box-info">
                    <div class="box-header">
                        <!-- tools box -->
                        <div class="pull-right box-tools"></div><!-- /. tools -->
                    </div>
                    
                    <div class="box-body">            
                        <div class="sukses" ></div>
                        <div class="loading" style="z-index:9999999999999999; background:rgba(255,255,255,0.8); width:100%; height:100%; position:fixed; top:0; left:0; text-align:center; padding-top:25%; display:none" >
                          <img src="<?php echo base_url() . '/public/img/loading.gif' ?>" >
                        </div>
                        <table id="tabel_daftar" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Tanggal Pembelian</th>
                                <th>Kode Pembelian</th>
                                <th>Nota Ref</th>
                                <th>Supplier</th>
                                <th>Total</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                               
                            </tbody>
                              <tfoot>
                                <tr>
                                <th>No</th>
                                <th>Tanggal Pembelian</th>
                                <th>Kode Pembelian</th>
                                <th>Nota Ref</th>
                                <th>Supplier</th>
                                <th>Total</th>
                                <th>Action</th>
                              </tr>
                             </tfoot>
                        </table>

            </section><!-- /.Left col -->      
        </div><!-- /.row (main row) -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script>
$(document).ready(function(){
  $("#tabel_daftar").dataTable();
})
   
</script>