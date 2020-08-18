<div class="">
	<div class="page-content">

		<div class="box-footer clearfix">

			<div class="row">
				<div class="col-md-3">
					<a class="dashboard-stat dashboard-stat-light blue-soft" id="daftar_cooling" href="<?php echo base_url().'stok/daftar_stok'?>">
						<div class="visual">
							<i class="glyphicon glyphicon-taskss" >></i>
						</div>
						<div class="details" >
							<div class="number">

							</div>
							<div class="desc">
								Stok
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-3">
					<a class="dashboard-stat dashboard-stat-light purple-soft" href="<?php echo base_url().'retur_stok/daftar_retur_stok' ?>" id="daftar_jenis">
						<div class="visual">
							<i class="glyphicon glyphicon-user" ></i>
						</div>
						<div class="details">
							<div class="number">

							</div>
							<div class="desc">
								Retur Stok
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-3">
					<a class="dashboard-stat dashboard-stat-light red-soft" href="<?php echo base_url().'spoil/daftar_spoil'?>" id="daftar_pos">
						<div class="visual">
							<i class="glyphicon glyphicon-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number">

							</div>
							<div class="desc">
								Spoil
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-3">
					<a class="dashboard-stat dashboard-stat-light green-soft" href="<?php echo base_url().'opname/daftar_opname' ?>" id="daftar_kelompok">
						<div class="visual">
							<i class="glyphicon glyphicon-th" ></i>
						</div>
						<div class="details">
							<div class="number">

							</div>
							<div class="desc">
								Opname
							</div>
						</div>
					</a>
				</div>
				 <div class="col-md-3">
					<a class="dashboard-stat dashboard-stat-light yellow-casablanca" href="<?php echo base_url().'mutasi/daftar_mutasi' ?>" id="daftar_jenis">
						<div class="visual">
							<i class="glyphicon glyphicon-barcode" ></i>
						</div>
						<div class="details">
							<div class="number">

							</div>
							<div class="desc">
								Mutasi
							</div>
						</div>
					</a>
				</div>

			</div>

			<!-- <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" ><i class="fa fa-edit"></i> Spoil </a>
			<a style="padding:13px; margin-bottom:10px;" class="btn btn-app blue" ><i class="fa fa-edit"></i> Opname </a>
			<a style="padding:13px; margin-bottom:10px;" class="btn btn-app red" ><i class="fa fa-edit"></i> Mutasi </a> -->
		</div>


		<div id="box_load">
			<?php echo @$konten; ?>
		</div>
	</div>
</div>
