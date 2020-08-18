<?php 
    $kode=$this->uri->segment(3);
    //echo $kode;
    $data_opname = $this->db->get_where('opsi_transaksi_opname',array('kode_opname'=>$kode));
    $hasil_data_opname = $data_opname->result();
    $opname = $this->db->get_where('transaksi_opname',array('kode_opname'=>$kode));
    $hasil_opname = $opname->row();
    ?>
<body style="font-size:6px;" onload="window.print()"; onfocus="window.close()">
  <table align="left" >
    <tr>
      <td style="font-style:bold;font-size: 22px">  TRANSAKSI OPNAME</td>
    </tr>
    <tr>
      <td style="font-style:bold;font-size: 15px"> Kode Opname</td>
      <td style="font-style:bold;font-size: 15px">:</td>
      <td style="font-style:bold;font-size: 15px"><?php echo $kode;?></td>
    </tr>
    <tr>
      <td style="font-style:bold;font-size: 15px"> Tanggal  Opname</td>
      <td style="font-style:bold;font-size: 15px">:</td>
      <td style="font-style:bold;font-size: 15px"><?php echo TanggalIndo($hasil_opname->tanggal_opname);?></td>
      </tr>
    <tr>
      <td style="font-style:bold;font-size: 15px"> Nama  Petugas</td>
      <td style="font-style:bold;font-size: 15px">:</td>
      <td style="font-style:bold;font-size: 15px"><?php echo $hasil_opname->petugas;?></td>
    </tr>
    
  </table><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <table width="100%" class="table"  border="1" style="border-collapse: collapse;">
    <tr  style="font-size: 15px">
      <th>No</th>
      <th>Nama Produk</th>
      <th>Nama Unit</th>
      <th>Nama Blok</th>
      <th>Qty Opname</th>
      <th>Qty Fisik</th>
      <!-- <th>Selisih</th> -->
      <th>Status</th>
      </tr>
      <?php 
      $no=1;
      foreach ($hasil_data_opname as  $value) {
      ?>
      <tr style="font-size: 15px">
        <td><?php echo $no++;?></td>
        
        <td><?php echo $value->nama_bahan;?></td>
        <td><?php echo $value->nama_unit;?></td>
        <td><?php echo $value->nama_rak;?></td>
        <td align="right"><?php echo $value->stok_awal;?></td>
         <td align="right"><?php echo $value->stok_akhir;?></td>
        <!-- <td align="right"><?php #echo $value->selisih;?></td> -->
        <td><?php echo $value->status;?></td>
      </tr>

      <?php  
      }
      ?>
      

    </table>

  <!--   <P style="font-size: 15px;margin-left: 25px">* Coret yang tidak perlu</P>
    <p style="margin-left: 500px">________________________________________________________</p>
    <p style="font-size: 15px;margin-left: 500px">Konsultan Pendamping</p><br><br><br><br><br><br>
    <p style="font-size: 15px;margin-left: 500px">(...........................................)</p> -->
  </body>
  </html>
