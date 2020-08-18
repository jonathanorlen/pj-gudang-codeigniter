<table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
           <thead>
            <tr>
              <th>Kode Produk</th>
              <th>Nama Produk</th>
              <th>Nama Blok</th>
              <th align="right">Qty Stok</th>
              <!-- <th align="right">Stok Terkecil</th> -->
              <th align="right">Stok Min</th>
              <!--<th>HPP</th>
              <th>Aset</th>-->
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="daftar_list_stock">

            <?php

            $kode_default = $this->db->get('setting_gudang');
            $hasil_unit =$kode_default->row();
            $param=$hasil_unit->kode_unit;
            
            $jenis_filter=$this->input->post('jenis_filter');
            $kategori_filter=$this->input->post('kategori_filter');
            $nama_produk=$this->input->post('nama_produk');
            if($kategori_filter=='kategori' and !empty($jenis_filter) and empty($nama_produk)){
              
              $this->db->where('kode_kategori_produk',$jenis_filter);
              //$this->db->where('nama_bahan_baku',$nama_produk);

            }elseif ($kategori_filter=='blok' and !empty($jenis_filter) and empty($nama_produk)) {
              
              $this->db->where('kode_rak',$jenis_filter);
              //$this->db->where('nama_bahan_baku',$nama_produk);
            }
            if(!empty($nama_produk)){
               $this->db->like('nama_bahan_baku',$nama_produk,'both');
            }

            $this->db->where('kode_unit',$param);
            $get_stok = $this->db->get('master_bahan_baku');
            $hasil_stok = $get_stok->result_array();
            foreach ($hasil_stok as $item) {

              $kode_bahan = $item['kode_bahan_baku']; 
              $this->db->select_max('id');                       
              $get_kode_bahan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan,'jenis_transaksi'=>'pembelian'));
              $hasil_hpp_bahan = $get_kode_bahan->row();
              #echo $this->db->last_query();

              $get_hpp = $this->db->get_where('transaksi_stok',array('id'=>$hasil_hpp_bahan->id));
              $hasil_get_hpp = $get_hpp->row();

              $get_stok_min = $this->db->get_where('master_bahan_baku',array('id'=>$item['id']));
              $hasil_stok_min = $get_stok_min->row();
                                  //echo count($hasil_stok_min);
              ?>   
              <tr <?php if($item['real_stock']<=$hasil_stok_min->stok_minimal){echo'class="danger"';}?>>
                <td><?php echo $item['kode_bahan_baku'];?></td>
                <td><?php echo $item['nama_bahan_baku'];?></td>
                <td><?php echo $item['nama_rak'];?></td>
                <td align="right"><?php

                 $jumlah_stok =  round($item['real_stock'] / $item['jumlah_dalam_satuan_pembelian'],2);

                 $pecah_stok = explode(".", $jumlah_stok);
                 echo $pecah_stok[0];

                 ?> <?php echo $item['satuan_pembelian'];
                 
                 ?>
                   
                 </td>
                <!-- <td align="right"><?php //if(@$pecah_stok[1]){ echo  @$pecah_stok[1]." ". $item['satuan_stok']; } else{ echo "-"; }    ;?></td> -->
                <td align="right"><?php echo $item['stok_minimal'];?> <?php echo $item['satuan_stok'];?></td>


                <!--<td><?php echo format_rupiah(@$hasil_get_hpp->hpp);?></td>
                <td><?php echo format_rupiah(($item['real_stock'] <= 0) ? (@$hasil_get_hpp->hpp * 0) : (@$hasil_get_hpp->hpp * $item['real_stock']));?></td>-->
                <td align="center"><?php echo get_detail($item['id']); ?></td>
              </tr>

              <?php } ?>

            </tbody>
            <tfoot>
              <tr>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Nama Blok</th>
                <th align="right">Qty Stok </th>
                <!-- <th align="right">Stok Terkecil</th> -->
                <th align="right">Stok Min</th>
                <!--<th>HPP</th>
                <th>Aset</th>-->
                <th>Action</th>
              </tr>
            </tfoot>
            <tbody>

            </tbody>                
          </table>
