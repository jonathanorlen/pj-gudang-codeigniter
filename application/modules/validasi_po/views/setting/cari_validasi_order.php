      
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

              //$kode_unit = $param['kode_unit'];
           
            $this->db->where('tanggal_input >=', $tgl_awal);
            $this->db->where('tanggal_input <=', $tgl_akhir);
          
            
            }
            $this->db->select('*');
            $this->db->from('transaksi_po');
            $transaksi = $this->db->get();
            $hasil_po = $transaksi->result_array();
            
              $total=0;

?>
     <div class="row">
          <div class="col-md-4">
          
          </div>
         
      </div>         
          <div class="">
          <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
              <thead>

                <tr>
                  <th width="50px;">No</th>
                 
                  <th>Kode PO</th>
                  <th>Nama Supllier</th>
                  <th>Petugas</th>
                  <th>Status</th>
                  <th width="300px;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                
                $no=0;
                foreach ($hasil_po as $list) {
                  $no++;
                  ?>
                  <tr>
                    <td><?php echo $no; ?></td>
                    
                    <td><?php echo $list['kode_po']; ?></td>
                    <td><?php echo $list['nama_supplier'];?></td>
                    <td><?php echo $list['petugas']; ?></td>
                    <td><?php echo cek_status_barang($list['status_validasi']); ?></td>
                    <td>
                      <?php
                      if($list['status_validasi'] == "menunggu"){ 
                        ?>
                        <a href="<?php echo base_url().'validasi_po/detail/'.$list['kode_po']; ?>" style="width: 148px" class="btn btn-info pull-middle" id="detail"><i class="fa fa-search"></i> Detail</a>
                        <button type="button" style="width: 148px" class="btn btn-warning pull-middle" id="belum_validasi" key="<?php echo $list['kode_po']; ?>"><i class="fa fa-check"></i> Validasi</button>
                        <?php 
                      } else if($list['status_validasi'] == "sesuai"){ 
                        ?>
                        <a href="<?php echo base_url().'validasi_po/detail/'.$list['kode_po']; ?>" style="width: 148px" class="btn btn-info pull-middle" id="detail"><i class="fa fa-search"></i> Detail</a>
                        <?php 
                      } else if($list['status_validasi'] == "belum divalidasi"){ 
                        ?>
                        <a href="<?php echo base_url().'validasi_po/detail/'.$list['kode_po']; ?>" style="width: 148px" class="btn btn-info pull-middle" id="detail"><i class="fa fa-search"></i> Detail</a>
                        <a href="<?php echo base_url().'validasi_po/validasi/'.$list['kode_po']; ?>" style="width: 148px" class="btn btn-success pull-middle" id="belum_validasi"><i class="fa fa-check"></i> Validasi</a>
                        <?php 
                      } else if($list['status_validasi'] == "belum divalidasi 2"){ 
                        ?>
                        <a href="<?php echo base_url().'validasi_po/detail/'.$list['kode_po']; ?>" style="width: 148px" class="btn btn-info pull-middle" id="detail"><i class="fa fa-search"></i> Detail</a>
                        <a href="<?php echo base_url().'validasi_po/validasi2/'.$list['kode_po']; ?>" style="width: 148px" class="btn btn-success pull-middle" id="belum_validasi"><i class="fa fa-check"></i> Validasi</a>
                        <?php 
                      }?>
                    </td>
                  </tr>
                  <?php  } ?>
                </tbody>                
              </table>
        </div>

 <script type="text/javascript">
   $("#tabel_daftar").dataTable({
      "paging":   false,
      "ordering": false,
      "info":     false
    });
 </script>