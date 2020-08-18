
<div class="row">      

  <div class="col-xs-12">


    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         List Transaksi Repack
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
        <form method="post" id="prosess" name="prosess" hidden>  
          <div class="form-group">
            <input disabled="" type="text" name="cari_balon_anggota" id="cari_balon_anggota" class="form-control" placeholder="Nomor Transaksi" style="display: table-column; width: 40%;" required />
            <a class="pull-middle btn btn-warning" id="proses">Proses<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </form>          
        <div class="sukses" ></div>
        <table class="table table-striped table-hover table-bordered" id="sample_editable_1"  style="font-size:1.5em;">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th>Tanggal</th>
              <th>Kode</th>
              <th>Petugas</th>
              <th width="10%">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $repack = $this->db->get('transaksi_repack');
            $hasil_repack = $repack->result();
            $no = 1;
            foreach($hasil_repack as $daftar){
              ?>
              <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo TanggalIndo($daftar->tanggal_transaksi); ?></td>
                <td><?php echo $daftar->kode_repack ?></td>
                <td><?php echo $daftar->petugas; ?></td>
                <td><?php echo get_detail($daftar->id); ?></td>

              </tr>
              <?php $no++; 
            } ?>
          </tbody>                
        </table>
      </div>
    </div>

    <!------------------------------------------------------------------------------------------------------>
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
    window.location = "<?php echo base_url().'repack/menu'; ?>";
  });
</script>
