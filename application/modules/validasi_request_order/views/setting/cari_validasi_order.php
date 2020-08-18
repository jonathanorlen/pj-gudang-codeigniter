      
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
            $this->db->where('jenis_bahan =', 'stok');
            //$this->db->where('position =', $kode_unit);
            
            }
            $this->db->select('*');
            $this->db->from('opsi_transaksi_ro');
            $this->db->group_by('kode_ro');
            $transaksi = $this->db->get();
            $hasil_transaksi = $transaksi->result();

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
                <th>Tanggal</th>
                <th>Kode Request Order</th>
                <th>Petugas</th>
                <th>Unit</th>
                <th width="133px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $no=0;
                foreach ($hasil_transaksi as $list) {
                $no++;
               
              ?>

              <tr>
                <td><?php echo $no; ?></td>
               <?php
                $get_transaksi = $this->db->get_where('transaksi_ro',array('kode_ro'=>$list->kode_ro));
                $hasil_get = $get_transaksi->row();
               ?>
                <td><?php echo TanggalIndo($hasil_get->tanggal_input);?></td>
                 <td><?php echo $list->kode_ro; ?></td>
              <?php 
                $kode_unit=$hasil_get->position;
                $unit = $this->db->query("SELECT nama_unit from master_unit where kode_unit='$kode_unit'");
                $nama = $unit->row();
              ?>
                <td><?php echo $hasil_get->petugas; ?></td>
                <td><?php echo $nama->nama_unit; ?></td>
                <?php
                    $get_ro = $this->db->query("SELECT * FROM (`opsi_transaksi_ro`) WHERE `jenis_bahan` = 'stok' 
                    AND `status_validasi` = '' AND `kode_ro` = '$list->kode_ro' 
                    OR `status_validasi` = 'proses' AND `jenis_bahan` = 'stok' AND `kode_ro` = '$list->kode_ro'");
                    #echo $this->db->last_query(); 
                    $hasil_ro = $get_ro->result();
                    $jml_ro = count($hasil_ro);

                ?>  
                  
                <td><?php if($jml_ro<1){ echo detail_tervalidasi($list->kode_ro); }else{
                  echo get_detail_validasi($list->kode_ro);
                }  ?></td>
              </tr>
              <?php  } ?>
            </tbody>                
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
 <script type="text/javascript">
   $("#tabel_daftar").dataTable({
      "paging":   false,
      "ordering": false,
      "info":     false
    });
 </script>