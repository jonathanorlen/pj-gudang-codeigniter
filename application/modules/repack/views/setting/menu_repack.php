
<div class="row">      

  <div class="col-xs-12">
    <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
      <a class="dashboard-stat dashboard-stat-light blue-soft" href="javascript:;" id="tambah">
        <div class="visual">
          <i class="fa fa-comments"></i>
        </div>
        <div class="details">
          <div class="number">

          </div>
          <div class="desc">
            Input Repack
          </div>
        </div>
      </a>
    </div>

    <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
      <a class="dashboard-stat dashboard-stat-light blue-soft" href="javascript:;" id="daftar">
        <div class="visual">
          <i class="fa fa-comments"></i>
        </div>
        <div class="details">
          <div class="number">

          </div>
          <div class="desc">
           Daftar Repack
         </div>
       </div>
     </a>
   </div>

</div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#tambah').click(function(){
      window.location = "<?php echo base_url().'repack/tambah' ?>"
    })

    $('#daftar').click(function(){
      window.location = "<?php echo base_url().'repack/daftar' ?>"
    })
  })
</script>


