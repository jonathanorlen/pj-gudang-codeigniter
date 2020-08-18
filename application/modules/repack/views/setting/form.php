<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Validasi Bakal Calon Anggota Anggota

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
        $parameter = $this->uri->segment(3);
        $ambil_data = $this->db->query(" SELECT * FROM anggota where nomor_anggota='$parameter' ");
        $hasil_ambil_data = $ambil_data->row();        
        ?>
        <div class="box-body">                   
          <div class="sukses" ></div>
          <form method="post" id="data_form" name="data_form">  
            <div class="form-group">

              <div class="form-group">

                <div class="col-md-6">
                  <label >Nama Anggota</label>
                  <input type="text" name="nama_anggota" class="form-control" placeholder="Nama Anggota" value="<?php if(!empty($hasil_ambil_data->nama)){echo $hasil_ambil_data->nama;} ?>" required />
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6">   

                <input type="hidden" name="nomor_anggota" class="form-control" value="<?php  if(!empty($hasil_ambil_data->nomor_anggota)){echo $hasil_ambil_data->nomor_anggota;} else{echo 'PEN_'.date("Ymdhis");}?> " >
              </div>

            </div> 


            <div class="form-group">
              <div class="col-md-6">
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" value="<?php if(!empty($hasil_ambil_data->tempat_lahir)){echo $hasil_ambil_data->tempat_lahir;} ?>" required>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6">
                <label>Tanggal Lahir</label>
                <div class="input-group date date-picker" data-date-format="dd-mm-yyyy">
                  <input type="text" class="form-control" name="tanggal_lahir" readonly="" value="<?php if(!empty($hasil_ambil_data->tanggal_lahir)){echo $hasil_ambil_data->tanggal_lahir;} ?>">
                  <span class="input-group-btn">
                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                  </span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6">
                <label>No KTP Anggota</label>
                <input type="text" name="no_ktp" class="form-control" placeholder="No KTP Anggota" value="<?php if(!empty($hasil_ambil_data->no_ktp)){echo $hasil_ambil_data->no_ktp;} ?>" required>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <label>Alamat</label>
                <textarea class="form-control" name="alamat" rows="3" placeholder="Alamat"  required=""><?php if(!empty($hasil_ambil_data->alamat)){echo $hasil_ambil_data->alamat;} ?></textarea>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-12">
                <br>
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1"  style="font-size:1.5em;">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th width="10%">Tipe Sapi</th>
                      <th>Milik Sendiri</th>
                      <th>Rumatan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $tipe_sapi = $this->db->get('tipe_sapi');
                    $hasil_tipe_sapi = $tipe_sapi->result_array();
                    $no = 0;
                    $tipe = 0;

                    foreach ($hasil_tipe_sapi as $item) {                
                      $no++;
                      ?>
                      <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $item['tipe'];?></td>
                        <?php
                        $jumlah_sapi = $this->db->query(" SELECT * FROM opsi_sapi_anggota where no_anggota='$parameter' ");
                        $hasil_jumlah_sapi = $jumlah_sapi->row();
                        ?>
                        <td>
                          <table class="table table-striped table-hover table-bordered" id="sample_editable_1"  style="font-size:1.0em;">
                            <thead>
                              <tr>
                                <th width="20%">Status</th>
                                <th width="60%">No Ear Tag</th>
                                <th width="20%">keterangan</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $fill_milik_sendiri = $item['tipe'].'_milik_sendiri';
                              $hasil = $hasil_jumlah_sapi->$fill_milik_sendiri;
                              for($ulang=1;$ulang<=$hasil;$ulang++){
                                ?>
                                <tr>
                                  <td width="3">
                                    <select class="form-control" style="padding: 0px;" name="status" required>              
                                      <option value="1">
                                        Ada
                                      </option>
                                      <option value="0" >
                                        Tidak Ada
                                      </option>
                                    </select>
                                  </td>
                                  <td><input type="text" name="cari_balon_anggota" id="cari_balon_anggota" class="form-control" placeholder="Ear Tag" style="display: table-column; width: 70%;" required /><a class="pull-middle btn btn-warning" id="proses">Cek<i class="fa fa-arrow-circle-right"></i></a></td>
                                  <td>keterangan</td>
                                </tr>
                                <?php
                              }
                              ?>
                            </tbody>
                          </table>
                        </td>

                        <td>
                          <table class="table table-striped table-hover table-bordered" id="sample_editable_1"  style="font-size:1.0em;">
                            <thead>
                              <tr>
                                <th width="20%">Status</th>
                                <th width="60%">No Ear Tag</th>
                                <th width="20%">keterangan</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $fill_rumatan = $item['tipe'].'_rumatan';
                              $hasil = $hasil_jumlah_sapi->$fill_rumatan;
                              for($ulang=1;$ulang<=$hasil;$ulang++){
                                ?>
                                <tr>
                                  <td width="3">
                                    <select class="form-control" style="padding: 0px;" name="status" required>              
                                      <option value="1">
                                        Ada
                                      </option>
                                      <option value="0" >
                                        Tidak Ada
                                      </option>
                                    </select>
                                  </td>
                                  <td><input type="text" name="cari_balon_anggota" id="cari_balon_anggota" class="form-control" placeholder="Ear Tag" style="display: table-column; width: 70%;" required /><a class="pull-middle btn btn-warning" id="proses">Cek<i class="fa fa-arrow-circle-right"></i></a></td>
                                  <td>keterangan</td>
                                </tr>
                                <?php
                              }
                              ?>
                            </tbody>
                          </table>
                        </td>


                      </tr>
                      <?php
                    } ?>

                  </tbody>            
                </table>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12" hidden>
                <label>Kondisi Kandang</label>
                <select disabled="" class="form-control" name="kondisi_kandang" required>              
                  <option <?php if(@$hasil_ambil_data->status_kepemilikan=='tidak_ada') {echo 'selected';} ?>
                    value="tidak_ada"    
                    >
                    Tidak ada sekat pemisah
                  </option>
                  <option <?php if(@$hasil_ambil_data->status_kepemilikan=='tidak_ada') {echo 'selected';} ?>
                    value="ada_sekat"    
                    >
                    ada sekat pemisah
                  </option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6" style="width: 100%;">
                <button style="margin-top:30px" type="submit" class="pull-right btn btn-warning" id="data_form"><?php if(empty($parameter)){echo 'Save';}else{echo 'Update';} ?><i class="fa fa-arrow-circle-right"></i></button>
              </div>
            </div>
            <div class="box-footer clearfix"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!------------------------------------------------------------------------------------------------------>



<script type="text/javascript">
  $(document).ready(function(){  

    $("#data_form").submit( function() {    
      $.ajax( {  
        type :"post",  
        <?php
    //if(empty($hasil_ambil_data)){
        ?>
        url : "<?php echo base_url() . 'anggota/simpan_tambah' ?>",  
        <?php
    //}else{
        ?>
      //url : "<?php echo base_url() . 'anggota/simpan_edit' ?>",  
      <?php
    //}
      ?>
      cache :false,  
      data :$(this).serialize(),
      success : function(data) {  
        $(".sukses").html(data);   
        setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'anggota/pendaftaran' ?>";},1500);              
      }  

    });
      return false;                          
    });
    <?php
    foreach ($hasil_tipe_sapi as $item) {
      ?>
      $("#milik_sendiri<?php echo $item['tipe'];?>").keyup( function() { 
        if(document.getElementById("rumatan<?php echo $item['tipe'];?>").value == ""){
          rumatan<?php echo $item['tipe'];?> =  parseInt(document.getElementById("rumatan<?php echo $item['tipe'];?>").placeholder);
        } else {
          rumatan<?php echo $item['tipe'];?> =  parseInt(document.getElementById("rumatan<?php echo $item['tipe'];?>").value);
        }
        milik_sendiri<?php echo $item['tipe'];?> = parseInt(document.getElementById("milik_sendiri<?php echo $item['tipe'];?>").value);

        if(document.getElementById("milik_sendiri<?php echo $item['tipe'];?>").value != ""){
          $("#jumlah<?php echo $item['tipe'];?>").val(milik_sendiri<?php echo $item['tipe'];?> + rumatan<?php echo $item['tipe'];?>);
        }

        var nol = 0;
        $("#total_semua").val(nol);
        <?php
        foreach ($hasil_tipe_sapi as $item2) {
          ?>
          if(document.getElementById("milik_sendiri<?php echo $item2['tipe'];?>").value != ""){
            var total = parseInt($("#jumlah<?php echo $item2['tipe'];?>").val()) + parseInt($("#total_semua").val());
            $("#total_semua").val(total);
          }
          <?php
        }
        ?>

      });

      $("#rumatan<?php echo $item['tipe'];?>").keyup( function() {   
        if(document.getElementById("milik_sendiri<?php echo $item['tipe'];?>").value == ""){
          milik_sendiri<?php echo $item['tipe'];?> = parseInt(document.getElementById("milik_sendiri<?php echo $item['tipe'];?>").placeholder);
        } else {
          milik_sendiri<?php echo $item['tipe'];?> = parseInt(document.getElementById("milik_sendiri<?php echo $item['tipe'];?>").value);
        }

        rumatan<?php echo $item['tipe'];?> =  parseInt(document.getElementById("rumatan<?php echo $item['tipe'];?>").value);

        if(document.getElementById("rumatan<?php echo $item['tipe'];?>").value != ""){
          $("#jumlah<?php echo $item['tipe'];?>").val(milik_sendiri<?php echo $item['tipe'];?> + rumatan<?php echo $item['tipe'];?>);
        }

        var nol = 0;
        $("#total_semua").val(nol);
        <?php
        foreach ($hasil_tipe_sapi as $item3) {
          ?>
          if(document.getElementById("rumatan<?php echo $item3['tipe'];?>").value != ""){
            var total = parseInt($("#jumlah<?php echo $item3['tipe'];?>").val()) + parseInt($("#total_semua").val());
            $("#total_semua").val(total);
          }
          <?php
        }
        ?>

      });
      <?php
    }
    ?>
  });
  function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))

      return false;
    return true;
  }
</script>

