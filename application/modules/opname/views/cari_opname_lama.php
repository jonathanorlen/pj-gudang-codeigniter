
 </script>
<?php
             

             $param = $this->input->post();
              // $kode = $this->input->post('kode_transaksi');

            // if(@$param['tgl_awal'] && @$param['tgl_akhir'] && @$param['nama']){
            //   $nama = $param['nama'];
            //   $tgl_awal = $param['tgl_awal'];
            //   $tgl_akhir = $param['tgl_akhir'];
            // $this->db->where('nama', $nama);
            // $this->db->where('tanggal_order >=', $tgl_awal);
            // $this->db->where('tanggal_order <=', $tgl_akhir);
            // }

           if(@$param['tgl_awal'] && @$param['tgl_akhir']){
              
              $tgl_awal = $param['tgl_awal'];
              $tgl_akhir = $param['tgl_akhir'];
              $kode_unit = $param['kode_unit'];
           
            $this->db->where('tanggal_opname >=', $tgl_awal);
            $this->db->where('tanggal_opname <=', $tgl_akhir);
            $this->db->where('kode_unit =', $kode_unit);
            
            }
            $this->db->select('*');
            $this->db->from('transaksi_opname');
            $transaksi = $this->db->get();
            $hasil_transaksi = $transaksi->result();

              $total=0;

?>
     <br>
     <div class="row">
       <!--  <div class="col-md-2 pull-right">
              <div class="" style="background-color: #428bca ;width:auto;">
                            <a style="padding:13px; margin-bottom:10px;color:white;margin-left:0px;" class="btn"> Total Transaksi RO : <span style="font-size:20px;"><?php echo count( $hasil_transaksi); ?></span></a>
                             
              </div>
              </div> -->
         
          <div class="col-md-4">
          
          </div>
         
      </div>
      <br>
         
          <div class="">
          <table class="table table-striped table-hover table-bordered" id="tabel_daftar" style="font-size:1.5em;">
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
              
              
              $nomor = 1;  

              foreach($hasil_transaksi as $daftar){ 
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
                      echo get_validasi_opname_gudang($kode_unit,@$daftar->kode_opname);
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
<!-- <div class="row">
    <div class="">
       <div class="col-md-6">
       </div>
          <div class="col-md-6 text-right"  style="margin-right:0px;margin-right:0px;">
          <div style="background-color: #428bca;width:auto;">
            <a style="padding:0px; margin-bottom:5px;text-align:right;color:white;margin-right:15px;" class="btn">Total Biaya Transaksi&nbsp <span style="font-size:25px;"><?php echo format_rupiah($total); ?></span></a>
          </div>
          </div>   
    </div>
 </div> -->
 