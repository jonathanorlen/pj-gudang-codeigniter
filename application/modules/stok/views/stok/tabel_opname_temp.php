
                                <?php
                                  $opname = $this->db->get('opsi_transaksi_opname_temp');
                                  $list_opname = $opname->result();
                                  $nomor = 1;  

                                  foreach($list_opname as $daftar){ 
                                ?> 
                                    <tr>
                                      <td><?php echo $nomor; ?></td>
                                      <td><?php echo $daftar->jenis_bahan; ?></td>
                                      <td><?php echo $daftar->nama_unit; ?></td>
                                      <td><?php echo $daftar->nama_rak; ?></td>
                                      <td><?php echo $daftar->nama_bahan; ?></td>
                                      <td><?php echo $daftar->stok_awal; ?></td>
                                      <td><?php echo $daftar->stok_akhir; ?></td>
                                      <td><?php echo $daftar->selisih; ?></td>
                                      <td><?php echo $daftar->status; ?></td>
                                      <td><?php echo $daftar->keterangan; ?></td>
                                      <td align="center"><?php echo get_edit_del_id($daftar->id); ?></td>
                                    </tr>
                                <?php 
                                    $nomor++; 
                                  } 
                                ?>