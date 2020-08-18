
                               <?php
                               if(@$kode){
                                    $no = 1;
                                    $po = $this->db->get_where('opsi_transaksi_pembelian',array('kode_po'=>$kode));
                                    $hasil_po = $po->result();
                                    foreach($hasil_po as $daftar){
                                        
                                    
                                  ?>
                                  <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $daftar->nama_bahan ?></td>
                                    <td><?php echo $daftar->jumlah." ".$daftar->nama_satuan ; ?></td>
                                    <td><?php echo cek_kesesuaian($daftar->status); ?></td>
                                    <td>
                                    <?php if($daftar->status==""){ ?>
                                    <a key="<?php echo $daftar->kode_bahan; ?>" data-toggle="tooltip" title="Sesuai" class="sesuai btn btn-icon-only btn-circle green"><i class="fa fa-edit"></i> </a>
                                    <a key="<?php echo $daftar->kode_bahan; ?>" data-toggle="tooltip" title="Tidak Sesuai" class="tidak_sesuai btn btn-icon-only btn-circle red"><i class="fa fa-trash-o"></i> </a>
                                    <?php } elseif($daftar->status=="sesuai"){ ?>
                                    <a key="<?php echo $daftar->kode_bahan; ?>" data-toggle="tooltip" title="Tidak Sesuai" class="tidak_sesuai btn btn-icon-only btn-circle red"><i class="fa fa-trash-o"></i> </a>
                                    <?php }elseif($daftar->status=="tidak sesuai"){ ?>
                                    <a key="<?php echo $daftar->kode_bahan; ?>" data-toggle="tooltip" title="Sesuai" class="sesuai btn btn-icon-only btn-circle green"><i class="fa fa-edit"></i> </a>
                                    <?php } ?>
                                    </td>
                                  </tr>
                                  <?php $no++; } } ?>  
<script>
$(".sesuai").click(function(){
        var kode_produk = $(this).attr('key');
        $("#modal-confirm-sesuai").modal('show');
        $("#kode_produk_sesuai").val(kode_produk);
      });
      
$(".tidak_sesuai").click(function(){
        var kode_produk = $(this).attr('key');
        $("#modal-confirm-tidak-sesuai").modal('show');
        $("#kode_produk_tidak_sesuai").val(kode_produk);
      });  
</script>                                   
                                
                                