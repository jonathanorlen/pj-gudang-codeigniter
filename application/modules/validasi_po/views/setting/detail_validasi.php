<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Detail Pembelian

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
          <div class="sukses" ></div>
          <form id="data_form" action="" method="post">
            <div class="box-body">
              <label><h3><b>Detail Transaksi Pembelian</b></h3></label>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Kode Transaksi</label>
                    <?php
                    $kode = $this->uri->segment(3);
                    
                    $transaksi_po = $this->db->get_where('transaksi_po',array('kode_po'=>$kode));
                    $hasil_transaksi_po = $transaksi_po->row();
                    ?>
                    
                    <input readonly="true" type="text" value="<?php echo @$hasil_transaksi_po->kode_po; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_po" id="kode_po" />
                  </div>
                  <div class="form-group">
                    <label class="gedhi">Kode PO</label>
                      <?php 
                      $get_po=$this->db->get_where('transaksi_po',array('kode_po'=>$hasil_transaksi_po->kode_po));
                      $hasil_get=$get_po->row();
                    ?>
                    <input type="text" value="<?php echo $hasil_get->kode_transaksi; ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="kode_po" id="kode_po"/>
                    <input type="hidden" value="<?php echo $hasil_transaksi_po->kode_po; ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="kode_po" id="kode_po"/>
                  </div>
                  

                </div>

                <div class="col-md-6">
                  <div class="form-group" hidden>
                    <label>Nota Referensi</label>
                    <input readonly="true" type="text" value="<?php echo @$hasil_transaksi_po->nomor_nota ?>" class="form-control" placeholder="Nota Referensi" name="nomor_nota" id="nomor_nota" />
                  </div>
                  <div class="form-group">
                    <label>Supplier</label>
                    <?php
                    $supplier = $this->db->get('master_supplier');
                    $supplier = $supplier->result();
                    ?>
                    <select disabled="true" class="form-control select2" name="kode_supplier" id="kode_supplier">
                     <option selected="true" value="">--Pilih Supplier--</option>
                     <?php foreach($supplier as $daftar){ ?>
                     <option <?php if($hasil_transaksi_po->kode_supplier==$daftar->kode_supplier){ echo "selected='true'"; } ?> value="<?php echo $daftar->kode_supplier ?>"><?php echo $daftar->nama_supplier ?></option>
                     <?php } ?>
                   </select> 
                 </div>
                 <div class="form-group">
                    <label class="gedhi">Tanggal Transaksi</label>
                    <input type="text" value="<?php echo TanggalIndo($hasil_transaksi_po->tanggal_input); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_pembelian" id="tanggal_pembelian"/>
                  </div>
               </div>
               <!-- <div class="col-md-6">
                <label>Pembayaran</label>
                <div class="form-group">
                  <select disabled="true" class="form-control" name="proses_pembayaran" id="proses_pembayaran">
                    <option <?php if($hasil_transaksi_po->proses_pembayaran=='cash') { echo "selected='true'"; } ?> value="cash">Cash</option>
                    <option <?php if($hasil_transaksi_po->proses_pembayaran=='credit') { echo "selected='true'"; } ?>  value="credit">Credit</option>
                    <option <?php if($hasil_transaksi_po->proses_pembayaran=='konsinyasi') { echo "selected='true'"; } ?> value="konsinyasi">Konsinyasi</option>
                  </select>
                </div> -->
              </div>
            </div>
          </div> 

          <div id="list_transaksi_pembelian">
            <div class="box-body">
              <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">
                <thead>
                  <tr>
                    <th>No</th>
                   
                    <th>Nama bahan</th>
                    <th>QTY</th>
                    <th style="display: none">Harga Satuan</th>
                    <th style="display: none">Sub Total</th>
                    <th>QTY Retur</th>
                    <th style="display: none">Sub Total Retur</th>
                  </tr>
                </thead>
                <tbody id="tabel_temp_data_transaksi">

                  <?php
                  $kode = $this->uri->segment(3);
                  $po = $this->db->get_where('opsi_transaksi_po',array('kode_po'=>$kode));
                  $list_po = $po->result();
                  $nomor = 1;  $total = 0;

                  foreach($list_po as $daftar){ 
                    @$satuan_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>@$daftar->kode_bahan));
                    @$hasil_satuan_bahan = $satuan_bahan->row();
                    @$satuan_barang = $this->db->get_where('master_barang',array('kode_barang'=>@$daftar->kode_bahan));
                    @$hasil_satuan_barang = $satuan_barang->row();
                    ?> 
                    <tr>
                      <td><?php echo $nomor; ?></td>
                      
                      <td><?php echo $daftar->nama_bahan; ?></td>
                      <td><?php echo $daftar->jumlah; ?> <?php echo @$hasil_satuan_bahan->satuan_po; echo @$hasil_satuan_barang->satuan_po;?></td>
                      <td style="display: none"><?php echo format_rupiah($daftar->harga_satuan); ?></td>
                      <td style="display: none"><?php echo format_rupiah($daftar->subtotal); ?></td>
                      <td><?php if($daftar->jumlah_retur != ''){ echo @$daftar->jumlah_retur; ?> <?php echo @$hasil_satuan_bahan->satuan_po; echo @$hasil_satuan_barang->satuan_po; }?></td>
                      <td style="display: none"><?php echo format_rupiah($daftar->subtotal_retur); ?></td>
                    </tr>
                    <?php 
                    $total = $total + @$daftar->subtotal;
                    $nomor++; 
                  } 
                  ?>
                  
                  <tr style="display: none">
                    <td colspan="3"></td>
                    <td style="font-weight:bold;">Total</td>
                    <td><?php echo format_rupiah($total); ?></td>
                    <td colspan="2"></td>
                  </tr>

                  <tr style="display: none">
                    <td colspan="3"></td>
                    <td style="font-weight:bold;">Diskon (%)</td>
                    <td id="tb_diskon"><?php echo $hasil_transaksi_po->diskon_persen; ?></td></td>
                    <td colspan="2"></td>
                  </tr>
                  
                  <tr style="display: none">
                    <td colspan="3"></td>
                    <td style="font-weight:bold;">Diskon (Rp)</td>
                    <td id="tb_diskon_rupiah"><?php echo format_rupiah($hasil_transaksi_po->diskon_rupiah); ?></td>
                    <td colspan="2"></td>
                  </tr>
                  
                  <tr style="display: none">
                    <td colspan="3"></td>
                    <td style="font-weight:bold;">Grand Total</td>
                    <td id="tb_grand_total"><?php echo format_rupiah($total-$hasil_transaksi_po->diskon_rupiah); ?></td>
                    <td colspan="2"></td>
                  </tr>
                </tbody>
                <tfoot>

                </tfoot>
              </table>
              <br>
              <label style="font-size: 20px;color:#3379b5;" class="input-control"><a style="cursor:default;" class="btn btn-primary"><i class="glyphicon glyphicon-bullhorn"></i></a>&nbsp;&nbsp;<?php echo strtoupper($hasil_transaksi_po->status_validasi) ; ?>
              </label>
            </div>
          </div>
        </form>
      </div>
    </div>
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
    window.location = "<?php echo base_url().'validasi_po/daftar_validasi'; ?>";
  });
</script>

