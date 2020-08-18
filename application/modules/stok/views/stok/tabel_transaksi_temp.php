
                                <?php
                                  $spoil = $this->db->get('opsi_transaksi_spoil_temp');
                                  $list_spoil = $spoil->result();
                                  $nomor = 1;  

                                  foreach($list_spoil as $daftar){ 
                                ?> 
                                    <tr>
                                      <td><?php echo $nomor; ?></td>
                                      <td><?php echo $daftar->jenis_bahan; ?></td>
                                      <td><?php echo $daftar->nama_unit; ?></td>
                                      <td><?php echo $daftar->nama_rak; ?></td>
                                      <td><?php echo $daftar->nama_bahan; ?></td>
                                      <td><?php echo $daftar->jumlah; ?></td>
                                      <td><?php echo $daftar->keterangan; ?></td>
                                      <td align="center"><?php echo get_edit_del_id($daftar->id); ?></td>
                                    </tr>
                                <?php 
                                    $nomor++; 
                                  } 
                                ?>