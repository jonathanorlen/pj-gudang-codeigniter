<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
        Data Supplier
        </div>
        <div class="tools">
          <a href="javascript:;" class="collapse">
          </a>
          <a href="javascript:;" class="reload">
          </a>

        </div>
      </div>
      <div class="portlet-body">
      
        <div class="box-body">                   
          <div class="sukses" ></div>
           <form id="data_form"  method="post">
                        <div class="box-body">            
                          <div class="row">
                            <?php
                                $uri = $this->uri->segment(4);
                                if(!empty($uri)){
                                    $data = $this->db->get_where('master_supplier',array('id'=>$uri));
                                    $hasil_data = $data->row();
                                }
                            ?>
                            <!--<div class="form-group  col-xs-5">
                              <label>Id Supplier</label>
                              <input type="text" class="form-control" name="id_supplier" id="id_supplier" />
                            </div>-->

                            <div class="form-group  col-xs-5">
                              <label>Kode Supplier</label>
                              <input type="hidden" name="id" value="<?php echo @$hasil_data->id ?>" />
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->kode_supplier; ?>"  name="kode_supplier" id="kode_supplier" readonly />
                            </div>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Kategori Supplier</label>
                               <select class="form-control"  name="kategori_supplier" id="kategori_supplier" readonly disabled>
                                  <option selected="" value="">--Pilih Kategori Supplier--</option>
                                  <option <?php echo "1" == @$hasil_data->kategori_supplier ? 'selected' : '' ?> value="1" >UD</option>
                                  <option <?php echo "2" == @$hasil_data->kategori_supplier ? 'selected' : '' ?> value="2" >CV</option>
                                  <option <?php echo "3" == @$hasil_data->kategori_supplier ? 'selected' : '' ?> value="3" >Perseorangan</option>
                              </select> 
                            </div>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Nama Supplier</label>
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->nama_supplier; ?>" name="nama_supplier" readonly/>
                            </div>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Alamat Supplier</label>
                              <textarea readonly="true" class="form-control" name="alamat_supplier"><?php echo @$hasil_data->alamat_supplier; ?></textarea>
                            </div>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">No.Telp</label>
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->telp_supplier; ?>" name="telp_supplier" readonly/>
                            </div>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Nama Bank</label>
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->nama_bank; ?>" name="nama_bank" readonly/>
                            </div>

                            <div class="form-group  col-xs-3">
                              <label class="gedhi">No.Rekening</label>
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->no_rek; ?>" name="no_rek" readonly/>
                            </div>

                            <div class="form-group  col-xs-4">
                              <label class="gedhi">Nama PIC</label>
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->nama_pic; ?>" name="nama_pic" readonly/>
                            </div>

                            <div class="form-group  col-xs-3">
                              <label class="gedhi">Jabatan PIC</label>
                              <input type="text" class="form-control" value="<?php echo @$hasil_data->jabatan_pic; ?>" name="jabatan_pic" readonly/>
                            </div>

                            <div class="form-group  col-xs-3">
                              <label class="gedhi">No.HP PIC</label>
                              <input type=
                              "text" class="form-control" value="<?php echo @$hasil_data->telp_pic; ?>" name="telp_pic" readonly/>
                            </div>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Status</label>
                               <select class="form-control" name="status_supplier" readonly disabled="">
                                  <option selected="" value="">--Pilih Status--</option>
                                  <option <?php echo "1" == @$hasil_data->status_supplier ? 'selected' : '' ?> value="1" >Aktif</option>
                                  <option <?php echo "0" == @$hasil_data->status_supplier ? 'selected' : '' ?> value="0" >Tidak Aktif</option>
                              </select> 
                            </div>
                          </div>

      
                        </div>
                    </form>
        </div>
      </div>
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
            window.location = "<?php echo base_url().'master/supplier/'; ?>";
          });
        </script>

