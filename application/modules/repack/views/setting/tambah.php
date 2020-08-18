<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">

<div class="page-content">

	<div class="row">   
		<div class="col-xs-12">
			<!-- /.box -->
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						Tambah Pengiriman
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
						<form id="data_form">
							<div class="row">
								<div class="col-md-12">
									<label>Kode Pengiriman</label>
									<input readonly="" type="text" name="kode" id="kode" class="form-control tgl_selesai" value="<?php echo'DO_'.date('Ymdhis') ?>" required/>
									
								</div>
								<div class="col-md-4">
									<label>Tangki</label>
									<select name="tangki" id="tangki" class="form-control" required="">
										<option value=''>-- Pilih Nomor Polisi Tangki --</option>
										<?php
										$get_tangki = $this->db->get('master_tangky');
										$hasil_tangki = $get_tangki->result();
										foreach ($hasil_tangki as $key) {
											echo '<option value="'.$key->nomor_polisi.'">'.$key->nomor_polisi.'</option>';
										}
										?>
									</select>
								</div>
								<div class="col-md-4">
									<label>Supir</label>
									<input readonly="" type="text" name="supir" id="supir" class="form-control" required/>
								</div>
								<div class="col-md-4">
									<label>Status Supir</label>
									<select name="diwakilkan" id="diwakilkan" class="form-control" required="">
										<option value='Tidak'>Sendiri</option>
										<option value='Ya'>Diwakilkan</option>
									</select>
								</div>
								<div class="col-md-4" id="form_supir_pengganti">
									<label>Supir Pengganti</label>
									<input type="text" name="supir_pengganti" id="supir_pengganti" class="form-control"/>
								</div>
								<div class="col-md-4">
									<label>Tanggal</label>
									<input class="form-control form-control-inline date-picker" type="text" placeholder="Tanggal Pengiriman" data-date-format="yyyy-mm-dd" value="" name="tanggal" id="tanggal" required="">
								</div>
								<div class="col-md-4">
									<label>Waktu</label>
									<select name="waktu" id="waktu" class="form-control" required="">
										<option value="Pagi">Pagi</option>
										<option value="Sore">Sore</option>
									</select>
									<br>
									<br>
								</div>
							</div>

							<div class="portlet box blue">
								<div class="portlet-title">
									<div class="caption">
										Detail Opsi Pengiriman
									</div>

								</div>
								<div class="portlet-body">
									<div class="box-body">            
										<div class="row">
											<div class="col-md-6">
												<label>Coling Unit</label>
												<select name="cooling_unit" id="cooling_unit" class="form-control">
													<option value=''>-- Pilih Cooling Unit --</option>
													<?php
													$this->db->where('status', '1');
													$get_cu = $this->db->get('cooling_unit');
													$hasil_cu = $get_cu->result();
													foreach ($hasil_cu as $key) {
														echo '<option value="'.$key->kode_cooling_unit.'">'.$key->nama_cooling_unit.'</option>';
													}
													?>
												</select>
											</div>
											<div class="col-md-2">
												<label>Jumlah Susu (Liter)</label>
												<input type="text" name="jml_susu" id="jml_susu" value="" class="form-control" placeholder="Jumlah Susu" />

											</div>
											<div class="col-md-2">
												<br>
												<br>
												<button type="button" id="tambah_temp" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</button>
											</div>
											<div class="col-md-12">
												<br>
												<br>
												<table class="table table-bordered">
													<thead>
														<tr>
															<th>No</th>
															<th>Colling Unit</th>
															<th>Jumlah</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody id='temp_pengiriman'>
														<tr>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
														</tr>
														<tr>
															<td colspan="2">Total Susu</td>
															<td></td>
															<td></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>


							<div class="row">
								<div class="col-md-12">
									<input type="submit" name="Simpan" class="btn btn-primary pull-right" value="Simpan">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<script>
	$(document).ready(function() {

		$('.date-picker').datepicker();
		$('.tgl_pengambilan').datepicker();
		$('#form_supir_pengganti').css('display','none');
	});
	$('#diwakilkan').change(function(){
		if($('#diwakilkan').val()!="Ya"){
			$('#form_supir_pengganti').css('display','none');
		} else if($('#diwakilkan').val()!="Tidak"){
			$('#form_supir_pengganti').css('display','');
		}
	});
	$('#tangki').change(function(){
		if($('#tangki').val()!=""){
			tangki = $('#tangki').val()
			$.ajax( {  
				type :"post",  
				url : "<?php echo base_url() . 'operasional/pengiriman/get_supir' ?>",  
				cache :false,  
				data :({key:tangki}), 
				success : function(data) {  
					$("#supir").val(data);            
				},  
				error : function() {  
					alert("Data gagal dimasukkan.");  
				}  
			});
			return false;

		}
	});
	$('#tambah_temp').click(function(){
		if($('#cooling_unit').val()!="" && $('#jml_susu').val()!=""){
			kode_do = $('#kode').val()
			cooling_unit = $('#cooling_unit').val()
			jml_susu = $('#jml_susu').val()
			$.ajax( {  
				type :"post",  
				url : "<?php echo base_url() . 'operasional/pengiriman/add_temp_pengiriman' ?>",  
				cache :false,  
				data :({kode_do:kode_do, cooling_unit:cooling_unit, jml_susu:jml_susu}), 
				success : function(data) {  
					$("#temp_pengiriman").html(data);            
					$("#jml_susu").val('');            
				},  
				error : function() {  
					alert("Data gagal dimasukkan.");  
				}  
			});
			return false;
		}
	});
	$('#data_form').submit(function(){

		$.ajax( {  
			type :"post",  
			url : "<?php echo base_url() . 'operasional/pengiriman/simpan_pengiriman' ?>",  
			cache :false,  
			data :$(this).serialize(), 
			success : function(data) {  
				$(".sukses").html(data);   
				setTimeout(function(){$('.sukses').html('');
					window.location = "<?php echo base_url() . 'operasional/pengiriman/daftar'; ?>";
				},1500);        
			},  
			error : function() {  
				alert("Data gagal dimasukkan.");  
			}  
		});
		return false;
	});

	function hapus_opsi_do(key) {    
		var r =confirm("Anda yakin ingin menghapus data ini ?");
		if (r==true)  
		{	
			kode_do = $('#kode').val()
			$.ajax( {  
				type :"post",  
				url :"<?php echo base_url() . 'operasional/pengiriman/hapus_temp_do' ?>",  
				cache :false,  
				data :({kode_do:kode_do, key:key}),
				success : function(data) { 
					$("#temp_pengiriman").html(data);            
				},  
				error : function() {  
					alert("Data gagal dimasukkan.");  
				}  
			});
			return false;
		}
		else {}        
	}
</script>