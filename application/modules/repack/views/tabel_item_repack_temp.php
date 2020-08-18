    <?php
    if($kode){
      $kode_default = $this->db->get('setting_gudang');
      $hasil_unit =$kode_default->row();
      $param =$hasil_unit->kode_unit;
      $pembelian = $this->db->get_where('opsi_transaksi_repack_temp',array('kode_repack'=>$kode));
      $list_pembelian = $pembelian->result();
      $nomor = 1;  $total = 0;
      foreach($list_pembelian as $daftar){ 

        @$satuan_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>@$daftar->kode_bahan));
        @$hasil_satuan_bahan = $satuan_bahan->row();
        @$satuan_barang = $this->db->get_where('master_barang',array('kode_barang'=>@$daftar->kode_bahan));
        @$hasil_satuan_barang = $satuan_barang->row();
        ?>
        <tr>
          <td><?php echo $nomor; ?></td>
          <td><?php echo $daftar->nama_bahan; ?></td>
          <td><?php echo $daftar->jumlah; ?></td>
          <td><?php echo $daftar->nama_produk_repack; ?></td>
          <td><?php echo $daftar->jumlah_in; ?></td>
          <td align="center"><?php echo get_edit_del_id($daftar->id); ?></td>
        </tr>
        <?php 
        $nomor++; 
      } 
    }
    else{
      ?>
      <tr>
        <td><?php echo @$nomor; ?></td>
        <td><?php echo @$daftar->kategori_bahan; ?></td>
        <td><?php echo @$daftar->nama_bahan; ?></td>
        <td><?php echo @$daftar->jumlah; ?> <?php echo @$hasil_satuan_bahan->satuan_stok; echo @$hasil_satuan_barang->satuan_stok;?></td>
        <td align="center"><?php echo get_edit_del_id(@$daftar->id); ?></td>
      </tr>
      <?php
    }
    ?>