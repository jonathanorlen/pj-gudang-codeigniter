<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Detail Produk
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

        <?php
        $param = $this->uri->segment(4);
        if(!empty($param)){
          $bahan_baku = $this->db->get_where('master_bahan_baku',array('id'=>$param));
          $hasil_bahan_baku = $bahan_baku->row();
        }    

        ?>
        <div class="box-body">
          <div class="box-body">                   
            <div class="sukses" ></div>
            <form id="data_form" method="post">
              <div class="box-body">            
                <div class="row">
                  <div class="form-group  col-xs-6">
                    <label><b>Kode Produk</label>

                    <?php
                    $this->db->select('kode_bahan_baku');
                    $bb = $this->db->get('master_setting');
                    $hasil_bb = $bb->row();
                    ?>

                    <input type="hidden" id="kode_setting" value="<?php echo @$hasil_bb->kode_bahan_baku ?>"></input>
                    <input  name="kode_bahan_baku" value="<?php echo @$hasil_bahan_baku->kode_bahan_baku ?>"  <?php if(!empty($param)){ echo "readonly='true'"; } ?> type="text" class="form-control" id="kode_bahan_baku" />

                  </div>
                  <div class="form-group  col-xs-6">
                    <label class="gedhi"><b>Nama Produk</label>
                    <input readonly="true" id="nama_bahan_baku"  value="<?php echo @$hasil_bahan_baku->nama_bahan_baku; ?>" type="text" class="form-control" name="nama_bahan_baku" />
                  </div>
                  <div class="form-group  col-xs-6">
                    <label class="gedhi"><b>Kategori Produk</label>
                    <select disabled="true"  class="form-control stok select2" name="kode_kategori_produk">
                      <option>-- Pilih Kategori Produk --</option>
                      <?php
                      $kategori_produk = $this->db->get('master_kategori_menu');
                      $hasil_kategori =$kategori_produk->result();
                      foreach ($hasil_kategori as $value) {
                       ?>
                       <option value="<?php echo $value->kode_kategori_menu; ?>" <?php if($value->kode_kategori_menu==@$hasil_bahan_baku->kode_kategori_produk){ echo "selected";}?>><?php echo $value->nama_kategori_menu; ?></option>
                       <?php
                     }
                     ?>
                   </select>

                 </div>
                 <div class="form-group  col-xs-6">
                  <label class="gedhi"><b>Satuan Pembelian</label>
                  <?php
                  $pembelian = $this->db->get('master_satuan');
                  $hasil_pembelian = $pembelian->result();
                  ?>
                  <select disabled="true"  class="form-control select2 pembelian" name="id_satuan_pembelian" id="id_satuan_pembelian">
                    <option selected="true" value="">--Pilih satuan pembelian--</option>
                    <?php foreach($hasil_pembelian as $daftar){ ?>
                    <option <?php if(@$hasil_bahan_baku->id_satuan_pembelian==$daftar->kode){ echo "selected"; } ?> value="<?php echo $daftar->kode; ?>" ><?php echo $daftar->nama; ?></option>
                    <?php } ?>
                  </select> 
                </div>
                <div class="form-group  col-xs-6">
                  <label class="gedhi"><b>Unit</label>
                  <?php
                  $kode_default = $this->db->get('setting_gudang');
                  $hasil_unit =$kode_default->row();
                  $kode_unit=$hasil_unit->kode_unit;

                  $unit = $this->db->get_where('master_unit',array('kode_unit' => $kode_unit));
                  $hasil_unit = $unit->row();
                  ?>
                  <input  value="stok" name="jenis_bahan"  id="jenis_bahan"type="hidden" class="form-control"  />
                  <input readonly="true" required value="<?php echo @$hasil_unit->nama_unit; ?>" type="text" class="form-control"  />
                  <input value="<?php echo @$hasil_unit->kode_unit; ?>" type="hidden" class="form-control" name="kode_unit" />
                </div>

                <div class="form-group  col-xs-6">
                  <label class="gedhi"><b>Nama Blok</label>
                  <?php
                  $kode_default = $this->db->get('setting_gudang');
                  $hasil_unit =$kode_default->row();
                  $kode_unit=$hasil_unit->kode_unit;

                  $unit = $this->db->get_where('master_rak',array('kode_unit' => $kode_unit));
                  $hasil_rak = $unit->result();
                  ?>
                  <select disabled="true" name="kode_rak" id="kode_rak" class="form-control select2">
                    <option value="" selected="true">--Pilih Rak--</option>
                    <?php foreach($hasil_rak as $daftar){  ?>
                    <option <?php if(@$hasil_bahan_baku->kode_rak==$daftar->kode_rak){ echo "selected='true'"; } ?> value="<?php echo $daftar->kode_rak; ?>"><?php echo $daftar->nama_rak; ?></option>
                    <?php } ?>
                  </select>
                  
                  
                </div>
                <div class="form-group  col-xs-6">
                  <label class="gedhi"><b>Isi Dalam 1 (Satuan Pembelian)</label>
                  <input readonly="true"  value="<?php echo @$hasil_bahan_baku->jumlah_dalam_satuan_pembelian; ?>" type="text" class="form-control" name="jumlah_dalam_satuan_pembelian" />
                </div>
                <div class="form-group  col-xs-6">
                  <?php
                  $dft_satuan = $this->db->get_where('master_satuan');
                  $hasil_dft_satuan = $dft_satuan->result();

                  ?>
                  <label class="gedhi"><b>Satuan Stok</label>
                  <select disabled="true" id="id_satuan_stok"  class="form-control stok select2" name="id_satuan_stok">
                    <option selected="true" value="">--Pilih satuan stok--</option>
                    <?php 
                    foreach($hasil_dft_satuan as $daftar){    
                      ?>
                      <option <?php if(@$hasil_bahan_baku->id_satuan_stok==$daftar->kode){ echo "selected"; } ?> value="<?php echo $daftar->kode; ?>"><?php echo $daftar->nama; ?></option>
                      <?php } ?>
                    </select> 
                  </div>


                  <div class="form-group  col-xs-6">
                    <label class="gedhi"><b>Stok Minimal</label>
                    <input readonly="true"  type="text" class="form-control" name="stok_minimal" value="<?php echo @$hasil_bahan_baku->stok_minimal ?>" />
                  </div>
                  <div class="form-group  col-xs-6">
                    <label class="gedhi"><b>HPP</label>
                    <input readonly="true"  type="text" class="form-control" name="hpp" value="<?php echo @$hasil_bahan_baku->hpp ?>" />
                  </div>
                  <div class="form-group  col-xs-6">
                    <label class="gedhi"><b>QTY Grosir</label>
                    <input  disabled type="text" class="form-control" name="qty_grosir" value="<?php echo @$hasil_bahan_baku->qty_grosir ?>" />

                  </div>
                  <div class="form-group  col-xs-2">
                    <label class="gedhi"><b>Harga 1</label>
                    <input disabled  type="text" class="form-control" name="harga_jual_1" value="<?php echo @$hasil_bahan_baku->harga_jual_1 ?>" />
                  </div>

                  <div class="form-group  col-xs-2">
                    <label class="gedhi"><b>Harga 2</label>
                    <input disabled  type="text" class="form-control" name="harga_jual_2" value="<?php echo @$hasil_bahan_baku->harga_jual_2 ?>" />
                  </div>

                  <div class="form-group  col-xs-2">
                    <label class="gedhi"><b>Harga 3</label>
                    <input disabled  type="text" class="form-control" name="harga_jual_3" value="<?php echo @$hasil_bahan_baku->harga_jual_3 ?>" />
                  </div>

                  <div class="form-group  col-xs-6">
                    <label class="gedhi"><b>Status Opname</label>
                    <select disabled class="form-control" name="status_opname">
                     <option>--Pilih--</option>
                     <option value="Nominal" <?php if(@$hasil_bahan_baku->status_opname=="Nominal"){ echo "selected";}?>>Nominal</option>
                     <option value="View" <?php if(@$hasil_bahan_baku->status_opname=="View"){ echo "selected";}?>>View</option>
                   </select>
                 </div>

                 <div class="form-group  col-xs-6">
                  <label class="gedhi"><b>Status</label>
                  <select disabled="true"  class="form-control stok select2" name="status">
                    <option value="Aktif" <?php if(@$hasil_bahan_baku->kode_kategori_produk=="Aktif"){ echo "selected";}?>>Aktif</option>
                    <option value="Tidak Aktif" <?php if(@$hasil_bahan_baku->status=="Tidak Aktif"){ echo "selected";}?>>Tidak Aktif</option>
                  </select>
                </div>


              </div>

            </div>


          </div>



          

        </div>
        <div class="row">


        </div>
        <!--<div class="row">
          <div class="col-md-12">
           <h3>Setting Harga</h3>
           <table  class="table table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">



            <thead>
              <tr width="100%">
                <th>No</th>
                <th>Satuan</th>
                <th>Jumlah</th>
                <th>Harga</th>
              </tr>
            </thead>
            <tbody id="tabel_ecer">
              <?php
              $no = 1; 
              $opsi_bb = $this->db->get_where('opsi_bahan_baku',array('kode_bahan_baku'=>@$hasil_bahan_baku->kode_bahan_baku));
              $hasil_opsi = $opsi_bb->result();
              foreach($hasil_opsi as $daftar){
                ?>
                <tr>
                  <td><?php echo $no; ?></td>
                  <td><?php echo "1 ".@$daftar->nama_satuan; ?></td>
                  <td><?php echo @$daftar->jumlah." ".@$daftar->nama_satuan_stok; ?></td>
                  <td><?php echo format_rupiah(@$daftar->harga); ?></td>
                </tr>
                <?php $no++; } ?>
              </tbody>
              
            </table>
          </div>
        </div>-->

      </form>     

    </div>
  </div>
</div>


<!------------------------------------------------------------------------------------------------------>
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
    window.location = "<?php echo base_url().'master/bahan_baku/'; ?>";
  });
</script>
