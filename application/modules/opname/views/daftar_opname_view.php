<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Opname View
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
        <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url().'opname/daftar_opname'; ?>"><i class="fa fa-list"></i> Opname Nominal </a>
        <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url().'opname/daftar_validasi_nominal'; ?>"><i class="fa fa-check"></i> Validasi Nominal </a>
        <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url().'opname/daftar_opname_view'; ?>"><i class="fa fa-list"></i> Opname View </a>
        <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url().'opname/daftar_validasi_view'; ?>"><i class="fa fa-check"></i> Validasi View </a>
        <div class="box-body">            
          <div class="sukses" ></div>
          <form id="data_form" method="post">
            <div class="box-body">            
              <div class="row">
                <div class="col-md-10 " id="">
                  <div class="col-md-5 " id="">
                    <div class="input-group">
                      <span class="input-group-addon">Filter</span>
                      <select class="form-control" id="kategori_filter">
                        <option value="">- PILIH Filter -</option>
                        <option value="kategori">Kategori Produk</option>
                        <option value="blok">Blok</option>
                      </select>
                    </div>
                    <br>
                  </div>
                </div>

                <div class="col-md-10 " id="opsi_filter">
                  <div class="col-md-5 " id="">
                    <div class="input-group">
                      <span class="input-group-addon">Filter By</span>
                      <select class="form-control" id="jenis_filter">
                        <option value="">- PILIH Filter -</option>

                      </select>
                    </div>
                    <br>
                  </div>                        
                </div>
                 <div class="col-md-10 " id="opsi_filter">
                  <div class="col-md-5" id="">
              <div class="input-group">
                <span class="input-group-addon">Nama Produk</span>
                <input type="text" class="form-control" id="nama_produk">
              </div>
              </div>
              <br>
            </div>     
                <div class="col-md-10 " id="opsi_filter">
                  <div class="col-md-5 " id="">
                    <button style="width: 100px" type="button" class="btn btn-warning " id="cari"><i class="fa fa-search"></i> Cari</button>
                  </div>
                </div>
              </div> 

            </div>
          </div>
        </form>
        <form id="data_opname">
          <a style="padding:13px; margin-bottom:10px;" id="opname" class="btn btn-app green pull-right" ><i class="fa fa-edit"></i> Opname </a>
          <div id="cari_transaksi">
            
            <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
             <thead>
              <tr>
                <th>No</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Nama Blok</th>
                <th align="right">Real Stok</th>

                <th>Action</th>
              </tr>
            </thead>
            <tbody id="daftar_list_stock">

              <?php

              $kode_default = $this->db->get('setting_gudang');
              $hasil_unit =$kode_default->row();
              $param=$hasil_unit->kode_unit;
             //$kode_unit =$this->uri->segment(3);
            // $get_rak = $this->db->get_where('master_rak',array('kode_unit' => $kode_unit));
            // $hasil_rak = $get_rak->row();
              $this->db->limit(100);
              $get_stok = $this->db->get_where("master_bahan_baku", array('kode_unit' => $param, 'status'=>'Aktif', 'status_opname'=>'View'));
              $hasil_stok = $get_stok->result_array();
              $no=1;
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
                  <td><?php echo $no++;?></td>
                  <td><?php echo $item['kode_bahan_baku'];?></td>
                  <td><?php echo $item['nama_bahan_baku'];?></td>
                  <td><?php echo $item['nama_rak'];?></td>
                  <td align="right"><?php echo $item['real_stock'];?> <?php echo $item['satuan_stok'];?></td>

                  <td align="center"><input type="checkbox" id="opsi_pilihan" name="bahan_opname[]" value="<?php echo $item['kode_bahan_baku']; ?>"></td>
                </tr>

                <?php } ?>

              </tbody>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Kode Produk</th>
                  <th>Nama Produk</th>
                  <th>Nama Blok</th>
                  <th align="right">Real Stok</th>

                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
            <br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br>
          </div>
        </form>
        <div class="row">
          <?php 

          $get_jumlah = $this->db->get_where("master_bahan_baku", array('kode_unit' => $param, 'status'=>'Aktif', 'status_opname'=>'View'));
          $jumlah = $get_jumlah->num_rows();
          $jumlah = floor($jumlah/100);
          ?>
          <input type="hidden" class="form-control rowcount" value="<?php echo $jumlah ?>">
          <input type="hidden" class="form-control pagenum" value="0">
        </div>  
      </div>

      <!------------------------------------------------------------------------------------------------------>

    </div>
  </div>
</div><!-- /.col -->
</div>
</div>    
</div>  

<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data menu tersebut ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()" class="btn red">Ya</button>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url().'component/lib/jquery.min.js'?>"></script>
<script src="<?php echo base_url().'component/lib/zebra_datepicker.js'?>"></script>
<link rel="stylesheet" href="<?php echo base_url().'component/lib/css/default.css'?>"/>
<script type="text/javascript">

  $('.tgl').Zebra_DatePicker({});


// $('#cari').click(function(){

//   var tgl_awal =$("#tgl_awal").val();
//   var tgl_akhir =$("#tgl_akhir").val();
//   var kode_unit =$("#kode_unit").val();

//     $.ajax( {  
//       type :"post",  
//       url : "<?php echo base_url().'opname/cari_opname'; ?>",  
//       cache :false,

//       data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir,kode_unit:kode_unit},
//       beforeSend:function(){
//         $(".tunggu").show();  
//       },
//       success : function(data) {
//        $(".tunggu").hide();  
//        $("#cari_transaksi").html(data);
//      },  
//      error : function(data) {  
//          // alert("das");  
//        }  
//      });
//   }

//   $('#tgl_awal').val('');
//   $('#tgl_akhir').val('');

// });
</script>
<script>
  $(window).scroll(function(){
    if (Math.round($(window).scrollTop()) == ($(document).height() - $(window).height())){
      if(parseInt($(".pagenum").val()) <= parseInt($(".rowcount").val())) {
        var pagenum = parseInt($(".pagenum").val()) + 1;
        $(".pagenum").val(pagenum);
        load_table(pagenum);
      }
    }
  });

  function load_table(page){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url() . 'opname/get_table_view' ?>",
      data: ({page:$(".pagenum").val()}),
      beforeSend: function(){
        $(".tunggu").show();  
      },
      success: function(msg)
      {
        $(".tunggu").hide();
        $("#daftar_list_stock").append(msg);

      }
    });
  }
  $(document).ready(function(){
    $("#tabel_daftar").dataTable({
      "paging":   false,
      "ordering": true,
      "info":     false,
      "searching":     false
    });
    $('#opsi_filter').hide();
  })

  function actDelete(Object) {
    $('#id-delete').val(Object);
    $('#modal-confirm').modal('show');
  }

  function delData() {
    var id = $('#id-delete').val();
    var url = '<?php echo base_url().'master/menu_resto/hapus_bahan_jadi'; ?>/delete';
    $.ajax({
      type: "POST",
      url: url,
      data: {
        id: id
      },
      beforeSend:function(){
        $(".tunggu").show();  
      },
      success: function(msg) {
        $('#modal-confirm').modal('hide');
            // alert(id);
            window.location.reload();
          }
        });
    return false;
  }

  $('#kategori_filter').on('change',function(){
    var kategori_filter = $('#kategori_filter').val();

    var url = "<?php echo base_url() . 'opname/get_jenis_filter' ?>";
    $.ajax({
      type: 'POST',
      url: url,
      data: {kategori_filter:kategori_filter},
      success: function(msg){
        $('#opsi_filter').show();
        $('#jenis_filter').html(msg);
      }
    });
  });

  $('#cari').click(function(){

    var jenis_filter =$("#jenis_filter").val();
    var kategori_filter =$("#kategori_filter").val();
    var nama_produk =$("#nama_produk").val();
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url().'opname/cari_opname_view'; ?>",  
      cache :false,

      data : {nama_produk:nama_produk,jenis_filter:jenis_filter,kategori_filter:kategori_filter},
      beforeSend:function(){
        $(".tunggu").show();  
      },
      success : function(data) {
       $(".tunggu").hide();  
       $("#cari_transaksi").html(data);
     // $('#jenis_filter').val('');
     // $('#kategori_filter').val('');
   },  
   error : function(data) {  
         // alert("das");  
       }  
     });
  });
  $('#opname').click(function(){


    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url().'opname/simpan_opname_temp_baru'; ?>",  
      cache :false,

      data :$('#data_opname').serialize(),
      beforeSend:function(){
        $(".tunggu").show();  
      },
      success : function(data) {
       $(".tunggu").hide();  
       window.location = "<?php echo base_url() . 'opname/tambah_opname_view/' ; ?>";
     // $("#cari_transaksi").html(data);
     // // $('#jenis_filter').val('');
     // // $('#kategori_filter').val('');
   },  
   error : function(data) {  
         // alert("das");  
       }  
     });
  });
</script>