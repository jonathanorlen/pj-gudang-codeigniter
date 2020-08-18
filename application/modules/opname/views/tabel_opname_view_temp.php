<?php
$kode_default = $this->db->get('setting_gudang');
$hasil_unit =$kode_default->row();
$param =$hasil_unit->kode_unit;
$status_opname =$this->uri->segment(4);

$opname = $this->db->get_where('opsi_transaksi_opname_temp',array('kode_unit' => $param,'status_opname' => $status_opname));
$list_opname = $opname->result();
$nomor = 1;  

foreach($list_opname as $daftar){ 
  @$satuan_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>@$daftar->kode_bahan));
  @$hasil_satuan_bahan = $satuan_bahan->row();
  @$satuan_barang = $this->db->get_where('master_barang',array('kode_barang'=>@$daftar->kode_bahan));
  @$hasil_satuan_barang = $satuan_barang->row();
  ?> 
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $daftar->nama_bahan; ?></td>
    <td><?php echo $daftar->nama_unit; ?></td>
    <td><?php echo $daftar->nama_rak; ?></td>
    
    <td><?php echo $daftar->stok_awal; ?> <?php echo @$hasil_satuan_bahan->satuan_stok; echo @$hasil_satuan_barang->satuan_stok;?></td>
    <!-- <td>
      <select name="stok_akhir" id="stok_akhir" class="form-control stok_akhir_<?php echo $nomor; ?>">
      
      <option value="Cukup">Cukup</option>
      <option value="Tidak Cukup">Tidak Cukup</option>
      </select>
      </td>
      
     -->
     <td><input style="width:70px;" type="text" value="<?php echo @$daftar->stok_akhir; ?>" class="form-control stok_akhir_<?php echo $nomor; ?>" placeholder="QTY" name="stok_akhir" id="stok_akhir" /><?php echo @$hasil_satuan_bahan->satuan_stok; echo @$hasil_satuan_barang->satuan_stok;?></td>
     <td><?php echo $daftar->selisih; ?> <?php echo @$hasil_satuan_bahan->satuan_stok; echo @$hasil_satuan_barang->satuan_stok;?></td>
    <td><select name="status" id="status" class="form-control status_<?php echo $nomor; ?>" required>
      <option value="">Pilih Status</option>
      <option <?php if($daftar->status=="Cukup"){ echo "selected='true'"; } ?> value="Cukup">Cukup</option>
      <option <?php if($daftar->status=="Tidak Cukup"){ echo "selected='true'"; } ?> value="Tidak Cukup">Tidak Cukup</option>
      <!--<option <?php if($daftar->status=="Lebih"){ echo "selected='true'"; } ?> value="Lebih">Lebih</option>-->
      </select>
      </td></td> 
    <!-- <td><?php #echo $daftar->keterangan; ?></td> -->
    <td><?php echo get_del_id_temp($daftar->id); ?></td>
  </tr>
  <input type="hidden"  value="<?php echo $daftar->kode_bahan; ?>" class="kode_bahan_<?php echo $nomor; ?>" name="kode_bahan" id="kode_bahan" />
  <input type="hidden"  value="<?php echo $daftar->id; ?>" class="id_<?php echo $nomor; ?>" name="id" id="id" />
  <script>
$(".status_<?php echo $nomor; ?>").change(function() {
  var status = $('.status_<?php echo $nomor; ?>').val();
 var id = $('.id_<?php echo $nomor; ?>').val();
  var kode_bahan = $('.kode_bahan_<?php echo $nomor; ?>').val();
   var kode_opname = $('#kode_opname').val();
   var stok_akhir = $('.stok_akhir_<?php echo $nomor; ?>').val();
  var url = "<?php echo base_url() . 'opname/update_opname_temp'; ?>";
  //alert(url);
  $.ajax({
    type: 'POST',
    url: url,
    
    data: {kode_bahan:kode_bahan,status:status,id:id,kode_opname:kode_opname,stok_akhir:stok_akhir},
    success: function(msg){
    
    // $("#tabel_temp_data_opname").load("<?php echo base_url().'opname/get_opname_v'; ?>");
    
    }
  });
$('.stok_akhir_<?php echo $nomor; ?>').focus();

});
 </script>
 <script>
$(".stok_akhir_<?php echo $nomor; ?>").change(function() {
  var stok_akhir = $('.stok_akhir_<?php echo $nomor; ?>').val();
 var id = $('.id_<?php echo $nomor; ?>').val();
  var kode_bahan = $('.kode_bahan_<?php echo $nomor; ?>').val();
   var kode_opname = $('#kode_opname').val();
  var url = "<?php echo base_url() . 'opname/update_opname_temp'; ?>";
  //alert(url);
  $.ajax({
    type: 'POST',
    url: url,
    
    data: {kode_bahan:kode_bahan,stok_akhir:stok_akhir,id:id,kode_opname:kode_opname},
    success: function(msg){
    $("#tabel_temp_data_opname").load("<?php echo base_url().'opname/opname/get_opname_v/View'; ?>");
    
    }
  });
$('.stok_akhir_<?php echo $nomor; ?>').focus();

});
 </script>
  <?php 
  $nomor++; 
} 
?>
     

