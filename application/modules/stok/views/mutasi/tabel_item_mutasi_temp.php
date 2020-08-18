                                <?php
                                    if($kode){
                                      $pembelian = $this->db->get_where('opsi_transaksi_mutasi_temp',array('kode_mutasi'=>$kode));
                                      $list_pembelian = $pembelian->result();
                                      $nomor = 1;  $total = 0;
                                      foreach($list_pembelian as $daftar){ 
                                ?>
                                <tr>
                                    <td><?php echo $nomor; ?></td>
                                    <td><?php echo $daftar->kategori_bahan; ?></td>
                                    <td><?php echo $daftar->nama_bahan; ?></td>
                                    <td><?php echo $daftar->jumlah; ?></td>
                                    <td><?php echo get_edit_del_id($daftar->id); ?></td>
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
                                    <td><?php echo @$daftar->jumlah; ?></td>
                                    <td><?php echo get_edit_del_id(@$daftar->id); ?></td>
                                </tr>
                                <?php
                                  }
                                ?>