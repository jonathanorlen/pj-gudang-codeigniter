<?php
$jvalidasi = $this->uri->segment(3);
$kode = $this->uri->segment(4);

$transaksi_po = $this->db->get_where('transaksi_po',array('kode_po'=>$kode));
$hasil_transaksi_po = $transaksi_po->row();

$this->db->where('kode_po', $kode);
if($jvalidasi=='validasi'){
  $this->db->where('status !=', 'Belum Datang');
} else if($jvalidasi=='validasi2'){
  $this->db->where('status', 'Belum Datang');
} 
$po = $this->db->get('opsi_transaksi_po');
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
    <td><?php echo $daftar->jumlah - $daftar->jumlah_retur; ?> <?php echo @$hasil_satuan_bahan->satuan_pembelian; echo @$hasil_satuan_barang->satuan_pembelian;?></td>
    <td style="display: none" align="right"><?php echo format_rupiah($daftar->harga_satuan); ?></td>
    <td style="display: none" align="right"><?php echo format_rupiah($subtotal = $daftar->subtotal - $daftar->subtotal_retur); ?></td>
    <td>
      <?php if($daftar->status_sesuai==''){ ?>
        <button style="width: 120px" type="button" class="btn btn-success sesuai" key="<?php echo $daftar->id ?>" id="sesuai_<?php echo $daftar->id ?>"><i class="fa fa-check"></i> Sesuai</button>
        <button style="width: 120px" type="button" class="btn btn-danger tidak_sesuai" key="<?php echo $daftar->id ?>" id="tidak_sesuai_<?php echo $daftar->id ?>"><i class="fa fa-remove"></i> Tidak Sesuai</button>
        <?php
        if($jvalidasi=='validasi'){
          ?>
          <button style="width: 150px" type="button" class="btn btn-info belum_datang" key="<?php echo $daftar->id ?>" id="belum_datang_<?php echo $daftar->id ?>"><i class="fa fa-remove"></i> Belum Datang</button>
          <?php
        }
        ?>
        <?php 
      } else { ?> 
        <button style="width: 120px" type="button" class="btn btn-danger batal" key="<?php echo $daftar->id ?>" id="batal_<?php echo $daftar->id ?>"><i class="fa fa-close"></i> Batal</button>
        <?php 
      } ?>
    </td>
  </tr>
  <tr style="display: none;" id="form_ts_<?php echo $daftar->id ?>">
    <td colspan="">
      <input type="hidden" value="<?php echo $daftar->jumlah ?>" name="jumlah_sesuai" id="jumlah_awal_<?php echo $daftar->id ?>" />
    </td>
    <td>
      <label>Jumlah Sesuai</label>
      <input type="text" value="" class="form-control jumlah_sesuai" placeholder="" name="jumlah_sesuai" key="<?php echo $daftar->id ?>" id="jumlah_sesuai_<?php echo $daftar->id ?>" />
    </td>
    <td>
      <label>Qty Retur</label>
      <input type="text" readonly="readonly" value="" class="form-control" placeholder="" name="qty_retur" key="<?php echo $daftar->id ?>" id="qty_retur_<?php echo $daftar->id ?>" />
    </td>
    <td>
      <br>
      <button type="button" value="" class="btn btn-info simpan_perubahan" name="simpan" key="<?php echo $daftar->id ?>" id="" >Simpan</button>
      <button type="button" value="" class="btn btn-danger batal_perubahan" name="simpan" key="<?php echo $daftar->id ?>" id="" >Batal</button>
    </td>
  </tr>
  <tr style="display: none;" id="form_bd_<?php echo $daftar->id ?>">
    <td colspan="">
      <input type="hidden" value="<?php echo $daftar->jumlah ?>" name="jumlah_bawal" id="jumlah_bawal_<?php echo $daftar->id ?>" />
    </td>
    <td>
      <label>Jumlah Datang</label>
      <input type="text" value="" class="form-control jumlah_bdatang" placeholder="" name="jumlah_bdatang" key="<?php echo $daftar->id ?>" id="jumlah_bdatang_<?php echo $daftar->id ?>" />
    </td>
    <td>
      <label>Jumlah Belum Datang</label>
      <input type="text" readonly="readonly" value="" class="form-control" placeholder="" name="jumlah_bbelum" key="<?php echo $daftar->id ?>" id="jumlah_bbelum_<?php echo $daftar->id ?>" />
    </td>
    <td>
      <br>
      <button type="button" value="" class="btn btn-info simpan_bd" key="<?php echo $daftar->id ?>" id="" >Simpan</button>
      <button type="button" value="" class="btn btn-danger batal_bd" key="<?php echo $daftar->id ?>" id="" >Batal</button>
    </td>
  </tr>
  <?php 
  $total = $total + $subtotal;
  $nomor++; 
} 
?>

<tr style="display: none">
  <td colspan="3"></td>
  <td style="font-weight:bold;">Total</td>
  <td align="right"><?php echo format_rupiah($total); ?></td>
  <td></td>
</tr>

<tr style="display: none">
  <td colspan="3"></td>
  <td style="font-weight:bold;">Diskon (%)</td>
  <td align="right" id="tb_diskon"><?php echo $hasil_transaksi_pembelian->diskon_persen; ?></td></td>
  <td></td></td>

</tr>

<tr style="display: none">
  <td colspan="3"></td>
  <td style="font-weight:bold;">Diskon (Rp)</td>
  <td align="right" id="tb_diskon_rupiah"><?php echo format_rupiah($hasil_transaksi_pembelian->diskon_rupiah); ?></td>
  <td></td>
</tr>

<tr style="display: none">
  <td colspan="3"></td>
  <td style="font-weight:bold;">Grand Total</td>
  <td align="right" id="tb_grand_total"><?php echo format_rupiah($total-$hasil_transaksi_pembelian->diskon_rupiah); ?></td>
  <td></td>

</tr>
<script>
  function reload_table(){
    $('#tabel_temp_data_transaksi').load('<?php echo base_url().'validasi_po/tabel_validasi/'.$jvalidasi.'/'.$kode; ?>')
  }
  $('.tidak_sesuai').click(function(){
    key = $(this).attr('key');
    $("#form_ts_"+key).css('display', '');
    $("#form_bd_"+key).css('display', 'none');

  });
  $('.batal_perubahan').click(function(){
    key = $(this).attr('key');
    $("#form_ts_"+key).css('display', 'none');

  });
  $('.belum_datang').click(function(){
    key = $(this).attr('key');
    $("#form_bd_"+key).css('display', '');
    $("#form_ts_"+key).css('display', 'none');
  });
  $('.batal_bd').click(function(){
    key = $(this).attr('key');
    $("#form_bd_"+key).css('display', 'none');
  });
  $('.simpan_perubahan').click(function(){
    id = $(this).attr('key');
    sesuai = $("#jumlah_sesuai_"+id).val();
    retur = $("#qty_retur_"+id).val();
    if(sesuai != '' && retur != ''){
      $.ajax( {  
        type :"post",  
        url : "<?php echo base_url() . 'validasi_po/ubah_pembelian' ?>",  
        cache :false,
        beforeSend:function(){
          $(".tunggu").show();  
        },
        data :({id:id, sesuai:sesuai, retur:retur}),
        success : function(data) {
          $(".tunggu").hide();  
          $("#form_ts_"+id).css('display', 'none');
          $("#sesuai_"+id).css('display', 'none');
          $("#tidak_sesuai_"+id).css('display', 'none');
          $("#batal_"+id).css('display', '');
          reload_table();         
        },  
        error : function() {  
          $(".tunggu").hide();
          alert("Data gagal dimasukkan.");
          $("#form_ts_"+id).css('display', 'none');
        }  
      });
    } else {
      alert('Anda belum menginputkan jumlah sesuai !!!');
    }
  });
  $('.simpan_bd').click(function(){
    id = $(this).attr('key');
    datang = $("#jumlah_bdatang_"+id).val();
    belum_datang = $("#jumlah_bbelum_"+id).val();
    if(datang != '' && belum_datang != ''){
      $.ajax( {  
        type :"post",  
        url : "<?php echo base_url() . 'validasi_po/ubah_barang_datang' ?>",  
        cache :false,
        beforeSend:function(){
          $(".tunggu").show();  
        },
        data :({id:id, datang:datang, belum_datang:belum_datang}),
        success : function(data) {
          $(".tunggu").hide();  
          $("#form_bd_"+id).css('display', 'none');
          $("#sesuai_"+id).css('display', 'none');
          $("#tidak_sesuai_"+id).css('display', 'none');
          $("#batal_"+id).css('display', '');
          reload_table();         
        },  
        error : function() {  
          $(".tunggu").hide();
          alert("Data gagal dimasukkan.");
          $("#form_ts_"+id).css('display', 'none');
        }  
      });
    } else {
      alert('Anda belum menginputkan jumlah datang !!!');
    }
  });
  $('.batal').click(function(){
    id = $(this).attr('key');
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url() . 'validasi_po/batal_pembelian' ?>",  
      cache :false,
      beforeSend:function(){
        $(".tunggu").show();  
      },
      data :({id:id}),
      success : function(data) {
        $(".tunggu").hide();  
        $("#form_ts_"+id).css('display', 'none');
        $("#sesuai_"+id).css('display', 'none');
        $("#tidak_sesuai_"+id).css('display', 'none');
        $("#batal_"+id).css('display', '');
        reload_table();         
      },  
      error : function() {  
        $(".tunggu").hide();
        alert("Data gagal dimasukkan.");
        $("#form_ts_"+id).css('display', 'none');
      }  
    });
  });
  $('.sesuai').click(function(){
    id = $(this).attr('key');
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url() . 'validasi_po/pembelian_sesuai' ?>",  
      cache :false,
      beforeSend:function(){
        $(".tunggu").show();  
      },
      data :({id:id}),
      success : function(data) {
        $(".tunggu").hide();  
        $("#form_ts_"+id).css('display', 'none');
        $("#sesuai_"+id).css('display', 'none');
        $("#tidak_sesuai_"+id).css('display', 'none');
        $("#batal_"+id).css('display', '');
        reload_table();         
      },  
      error : function() {  
        $(".tunggu").hide();
        alert("Data gagal dimasukkan.");
        $("#form_ts_"+id).css('display', 'none');
      }  
    });
  });

  $('.jumlah_sesuai').keyup(function(){
    id = $(this).attr('key');
    sesuai = parseInt($(this).val());
    awal = parseInt($("#jumlah_awal_"+id).val());
    if(awal >= sesuai){
      $("#qty_retur_"+id).val(Math.round(awal - sesuai));
    } else{
      alert("Inputan Anda Lebih Dari Jumlah Pembelian Awal!!!");
      $(this).val('');
      $("#qty_retur_"+id).val('');
    }
    
  });
  $('.jumlah_bdatang').keyup(function(){
    id = $(this).attr('key');
    datang = parseInt($(this).val());
    awal = parseInt($("#jumlah_bawal_"+id).val());
    if(awal >= datang){
      $("#jumlah_bbelum_"+id).val(Math.round(awal - datang));
    } else{
      alert("Inputan Anda Lebih Dari Jumlah Pembelian Awal!!!");
      $(this).val('');
      $("#jumlah_bbelum_"+id).val('');
    }
  });

</script>