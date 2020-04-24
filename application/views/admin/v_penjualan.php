<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transaksi Penjualan</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url().'assets/css/bootstrap.min.css'?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/style.css'?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/font-awesome.css'?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url().'assets/css/4-col-portfolio.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/dataTables.bootstrap.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/jquery.dataTables.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/dist/css/bootstrap-select.css'?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/bootstrap-datetimepicker.min.css'?>">
</head>

<body>  
    <div class="container">
        <div class="alert alert-info alert-dismissable">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          1. Icon <i class="fa fa-print"></i> berfunsi sebagai mencetak data<br>
          2. Icon <i class="fa fa-dollar"></i> berfunsi untuk membayar Hutang atau barang PO sudah datang<br>
          3. Icon <i class="fa fa-eye"></i> berfunsi untuk menampilkan detail yang dipilih<br>
          4. Icon <i class="fa fa-truck"></i> simbol barang sudah di kirim<br>
          5. Icon <i class="fa fa-cubes"></i> simbol barang belum di kirim<br>
        </div>  
        
    </div>

    <!-- Navigation -->
   <?php 
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "db_penjualan";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }
        $this->load->view('admin/menu');
         error_reporting(0);


switch ($_GET['act']) {
    default:
    ?>
      <!-- Page Content -->
    <div class="container">
        <ul class="nav nav-tabs" style=" background-color: bisque; ">
            <li class="active"><a href="#">All</a></li>
            <li ><a href="?act=now">Hari Ini</a></li>
          <li><a href="?act=hutang">Hutang</a></li>
          <li><a href="?act=po">Pre Order</a></li>
        </ul>
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
            <center><?php echo $this->session->flashdata('msg');?></center>
                <h1 class="page-header">Daftar
                    <small>Penjualan</small>
                    <a href="<?php echo base_url().'admin/penjualan/tambah_data'?>" class="pull-right"><small>Tambah Order!</small></a>
                </h1> 
            </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->

            <table class="table table-bordered table-condensed" id="mydata" style="font-size:11px;margin-top:10px;">
                <thead>
                    <tr>
                        <th>No Faktur</th>
                        <th>Tanggal Order</th>
                        <th style="text-align:center;">Nama Pelanggan</th>
                        <th style="text-align:center;">Total Pembelian(Rp)</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:center;">Pengiriman</th>
                        <th style="text-align:center;">Kembalian / Piutang (Rp)</th>
                        <th style="width:100px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                     <?php 
                         $no=0;
                        $sql = "SELECT
                                tbl_jual.jual_nofak,
                                DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,
                                tbl_jual.jual_total,
                                tbl_jual.jual_jml_uang,
                                tbl_jual.jual_kembalian,
                                tbl_jual.jual_keterangan,
                                tbl_jual.jual_pelanggan_id,
                                tbl_pelanggan.pelanggan_id,
                                tbl_pelanggan.pelanggan_nama,
                                tbl_pelanggan.pelanggan_alamat,
                                tbl_pelanggan.pelanggan_notelp,
                                tbl_pelanggan.pelanggan_kategori,
                                tbl_jual.jual_piutang,
                                tbl_jual.jual_pengiriman
                                FROM
                                tbl_jual
                                INNER JOIN tbl_pelanggan ON tbl_jual.jual_pelanggan_id = tbl_pelanggan.pelanggan_id
                                ";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                             // output data of each row
                            while($i = $result->fetch_assoc()) {
                            $no++;
                            
                            $nofak=$i['jual_nofak'];
                            $tanggal=$i['jual_tanggal'];
                            $napel=$i['pelanggan_nama'];
                            $total=$i['jual_total'];
                            $kembalian=$i['jual_kembalian'];
                            $status=$i['jual_keterangan'];
                            $hutang=$i['jual_piutang'];
                            $pengiriman=$i['jual_pengiriman'];
                    ?>
                    <tr>
                         <td><?php echo $nofak;?></td>
                         <td><?php echo $tanggal;?></td>
                         <td style="text-align:center;"><?php echo $napel;?></td>
                         <td style="text-align:right;"><?php echo number_format($total);?></td>
                         <td style="text-align:center;"><?php echo $status;?></td>
                         <?php if ($pengiriman == 0) {?>
                             <td style="text-align:center;">
                                <a href="<?php echo base_url().'admin/penjualan/kirim?nofak='.$nofak?>" class="btn btn-default btn-sm"><span class="fa fa-cubes"></span></a></td>
                        <?php }else{?>
                            <td style="text-align:center;"><a href="#" class="btn btn-default btn-sm"><span class="fa fa-truck"></span></a></td>
                         
                         <?php }
                         if ($status=='Lunas') {?>
                            <td style="text-align:right;"><?php echo number_format($kembalian);?></td>
                            <td style="text-align:center;">
                                <a href="<?php echo base_url().'admin/penjualan/detail_penjualan?nofak='.$nofak?>" class="btn btn-default btn-sm"><span class="fa fa-eye"></span></a>|<a href="<?php echo base_url().'admin/penjualan/cetak_daftar_faktur?nofak='.$nofak?>" target="_blank" class="btn btn-warning btn-sm"><span class="fa fa-print"></span></a>
                            </td>
                        <?php }else{?>
                            <td style="text-align:right;"><?php echo number_format($hutang);?></td>
                            <td style="text-align:center;">
                                <a href="<?php echo base_url().'admin/penjualan/detail_penjualan?nofak='.$nofak?>" class="btn btn-default btn-sm"><span class="fa fa-eye"></span></a>|<a href="<?php echo base_url().'admin/penjualan/bayar_piutang?nofak='.$nofak?>" class="btn btn-primary btn-sm"><span class="fa fa-dollar"></span></a>|<a href="<?php echo base_url().'admin/penjualan/cetak_daftar_faktur?nofak='.$nofak?>" target="_blank" class="btn btn-warning btn-sm"><span class="fa fa-print"></span></a>
                            </td>
                       <?php }?>
                         
                    </tr>
         
                    <?php }}?>
                </tbody>
            </table>
            <hr/>
        </div>
        <!-- /.row -->

<?php    
  break;
case 'hutang':?>
      <!-- Page Content -->
    <div class="container">
        <ul class="nav nav-tabs" style=" background-color: bisque; ">
            <li><a href="?">All</a></li>
           <li ><a href="?act=now">Hari Ini</a></li>
          <li class="active"><a href="?act=hutang">Hutang</a></li>
          <li><a href="?act=po">Pre Order</a></li>
        </ul>

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
            <center><?php echo $this->session->flashdata('msg');?></center>
                <h1 class="page-header">Daftar
                    <small>Hutang</small>
                    <a href="<?php echo base_url().'admin/penjualan/tambah_data'?>" class="pull-right"><small>Tambah Order!</small></a>
                </h1> 
            </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->

            <table class="table table-bordered table-condensed" id="mydata" style="font-size:11px;margin-top:10px;">
                <thead>
                    <tr>
                        <th>No Faktur</th>
                        <th>Tanggal Order</th>
                        <th style="text-align:center;">Nama Pelanggan</th>
                        <th style="text-align:center;">Total Pembelian(Rp)</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align: center;">Pengiriman</th>
                        <th style="text-align:center;">Piutang (Rp)</th>
                        <th style="width:100px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                     <?php 
                         $no=0;
                        $sql = "SELECT
                                tbl_jual.jual_nofak,
                                DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,
                                tbl_jual.jual_total,
                                tbl_jual.jual_jml_uang,
                                tbl_jual.jual_kembalian,
                                tbl_jual.jual_keterangan,
                                tbl_jual.jual_pelanggan_id,
                                tbl_pelanggan.pelanggan_id,
                                tbl_pelanggan.pelanggan_nama,
                                tbl_pelanggan.pelanggan_alamat,
                                tbl_pelanggan.pelanggan_notelp,
                                tbl_pelanggan.pelanggan_kategori,
                                tbl_jual.jual_piutang,
                                tbl_jual.jual_pengiriman
                                FROM
                                tbl_jual
                                INNER JOIN tbl_pelanggan ON tbl_jual.jual_pelanggan_id = tbl_pelanggan.pelanggan_id
                                WHERE tbl_jual.jual_keterangan = 'hutang'
                                ";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                             // output data of each row
                            while($i = $result->fetch_assoc()) {
                            $no++;
                            
                            $nofak=$i['jual_nofak'];
                            $tanggal=$i['jual_tanggal'];
                            $napel=$i['pelanggan_nama'];
                            $total=$i['jual_total'];
                            $kembalian=$i['jual_kembalian'];
                            $status=$i['jual_keterangan'];
                            $hutang=$i['jual_piutang'];
                            $pengiriman=$i['jual_pengiriman'];
                    ?>
                    <tr>
                         <td><?php echo $nofak;?></td>
                         <td><?php echo $tanggal;?></td>
                         <td style="text-align:center;"><?php echo $napel;?></td>
                         <td style="text-align:right;"><?php echo number_format($total);?></td>
                         <td style="text-align:center;"><?php echo $status;?></td>
                         <?php if ($pengiriman == 0) {?>
                             <td style="text-align:center;"><a href="<?php echo base_url().'admin/penjualan/kirim?nofak='.$nofak?>" class="btn btn-default btn-sm"><span class="fa fa-cubes"></span></a></td>
                        <?php }else{?>
                            <td style="text-align:center;"><a href="#" class="btn btn-default btn-sm"><span class="fa fa-truck"></span></a></td>
                         
                         <?php }
                         if ($status=='Lunas') {?>
                            <td style="text-align:right;"><?php echo number_format($kembalian);?></td>
                            <td style="text-align:center;">
                                <a href="<?php echo base_url().'admin/penjualan/detail_penjualan?nofak='.$nofak?>" class="btn btn-default btn-sm"><span class="fa fa-eye"></span></a>|<a href="<?php echo base_url().'admin/penjualan/cetak_daftar_faktur?nofak='.$nofak?>" target="_blank" class="btn btn-warning btn-sm"><span class="fa fa-print"></span></a>
                            </td>
                        <?php }else{?>
                            <td style="text-align:right;"><?php echo number_format($hutang);?></td>
                            <td style="text-align:center;">
                                <a href="<?php echo base_url().'admin/penjualan/detail_penjualan?nofak='.$nofak?>" class="btn btn-default btn-sm"><span class="fa fa-eye"></span></a>|<a href="<?php echo base_url().'admin/penjualan/bayar_piutang?nofak='.$nofak?>" class="btn btn-primary btn-sm"><span class="fa fa-dollar"></span></a>|<a href="<?php echo base_url().'admin/penjualan/cetak_daftar_faktur?nofak='.$nofak?>" target="_blank" class="btn btn-warning btn-sm"><span class="fa fa-print"></span></a>
                            </td>
                       <?php }?>
                         
                    </tr>
         
                    <?php }}?>
                </tbody>
            </table>
            <hr/>
        </div>
        <!-- /.row -->
        <?php    
  break;
case 'po':?>
      <!-- Page Content -->
    <div class="container">
        <ul class="nav nav-tabs" style=" background-color: bisque; ">
            <li><a href="?">All</a></li>
          <li ><a href="?act=now">Hari Ini</a></li>
          <li ><a href="?act=hutang">Hutang</a></li>
          <li class="active"><a href="?act=po">Pre Order</a></li>
        </ul>

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
            <center><?php echo $this->session->flashdata('msg');?></center>
                <h1 class="page-header">Daftar
                    <small>Pre Order</small>
                    <a href="<?php echo base_url().'admin/penjualan/tambah_data'?>" class="pull-right"><small>Tambah Order!</small></a>
                </h1> 
            </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->

            <table class="table table-bordered table-condensed" id="mydata" style="font-size:11px;margin-top:10px;">
                <thead>
                    <tr>
                        <th>No Faktur</th>
                        <th>Tanggal Order</th>
                        <th style="text-align:center;">Nama Pelanggan</th>
                        <th style="text-align:center;">Total Pembelian(Rp)</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align: center;">Pengiriman</th>
                        <th style="text-align:center;">Kembalian / Piutang (Rp)</th>
                        <th style="width:100px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                     <?php 
                         $no=0;
                        $sql = "SELECT
                                tbl_jual.jual_nofak,
                                DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,
                                tbl_jual.jual_total,
                                tbl_jual.jual_jml_uang,
                                tbl_jual.jual_kembalian,
                                tbl_jual.jual_keterangan,
                                tbl_jual.jual_pelanggan_id,
                                tbl_pelanggan.pelanggan_id,
                                tbl_pelanggan.pelanggan_nama,
                                tbl_pelanggan.pelanggan_alamat,
                                tbl_pelanggan.pelanggan_notelp,
                                tbl_pelanggan.pelanggan_kategori,
                                tbl_jual.jual_piutang,
                                tbl_jual.jual_pengiriman
                                FROM
                                tbl_jual
                                INNER JOIN tbl_pelanggan ON tbl_jual.jual_pelanggan_id = tbl_pelanggan.pelanggan_id
                                WHERE tbl_jual.jual_keterangan = 'po'
                                ";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                             // output data of each row
                            while($i = $result->fetch_assoc()) {
                            $no++;
                            
                            $nofak=$i['jual_nofak'];
                            $tanggal=$i['jual_tanggal'];
                            $napel=$i['pelanggan_nama'];
                            $total=$i['jual_total'];
                            $kembalian=$i['jual_kembalian'];
                            $status=$i['jual_keterangan'];
                            $hutang=$i['jual_piutang'];
                            $pengiriman=$i['jual_pengiriman'];
                    ?>
                    <tr>
                         <td><?php echo $nofak;?></td>
                         <td><?php echo $tanggal;?></td>
                         <td style="text-align:center;"><?php echo $napel;?></td>
                         <td style="text-align:right;"><?php echo number_format($total);?></td>
                         <td style="text-align:center;"><?php echo $status;?></td>
                         <?php if ($pengiriman == 0) {?>
                             <td style="text-align:center;"><a href="<?php echo base_url().'admin/penjualan/kirim?nofak='.$nofak?>" class="btn btn-default btn-sm"><span class="fa fa-cubes"></span></a></td>
                        <?php }else{?>
                            <td style="text-align:center;"><a href="#" class="btn btn-default btn-sm"><span class="fa fa-truck"></span></a></td>
                         
                         <?php }
                         if ($status=='Lunas') {?>
                            <td style="text-align:right;"><?php echo number_format($kembalian);?></td>
                            <td style="text-align:center;">
                                <a href="<?php echo base_url().'admin/penjualan/detail_penjualan?nofak='.$nofak?>" class="btn btn-default btn-sm"><span class="fa fa-eye"></span></a>|<a href="<?php echo base_url().'admin/penjualan/detail_penjualan?nofak='.$nofak?>" target="_blank" class="btn btn-warning btn-sm"><span class="fa fa-eye"></span></a>|<a href="<?php echo base_url().'admin/penjualan/cetak_daftar_faktur?nofak='.$nofak?>" target="_blank" class="btn btn-warning btn-sm"><span class="fa fa-dollar"></span></a>
                            </td>
                        <?php }else{?>
                            <td style="text-align:right;"><?php echo number_format($hutang);?></td>
                            <center>
                                <td style="text-align:center;"><a href="<?php echo base_url().'admin/penjualan/detail_penjualan?nofak='.$nofak?>" class="btn btn-default btn-sm"><span class="fa fa-eye"></span></a>|<a href="<?php echo base_url().'admin/penjualan/bayar_piutang?nofak='.$nofak?>" class="btn btn-primary btn-sm"><span class="fa fa-dollar"></span></a>|<a href="<?php echo base_url().'admin/penjualan/cetak_daftar_faktur?nofak='.$nofak?>" target="_blank" class="btn btn-warning btn-sm"><span class="fa fa-print"></span></a></td>
                            </center>
                            
                       <?php }?>
                         
                    </tr>
         
                    <?php }}?>
                </tbody>
            </table>
            <hr/>
        </div>
        <!-- /.row -->

<?php
    break;
case 'now':?>
      <!-- Page Content -->
    <div class="container">
        <ul class="nav nav-tabs" style=" background-color: bisque; ">
            <li><a href="?">All</a></li>
          <li class="active"><a href="?act=now">Hari ini</a></li>
          <li ><a href="?act=hutang">Hutang</a></li>
          <li ><a href="?act=po">Pre Order</a></li>
        </ul>

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
            <center><?php echo $this->session->flashdata('msg');?></center>
                <h1 class="page-header">Daftar
                    <small>Order Hari Ini</small>
                    <a href="<?php echo base_url().'admin/penjualan/tambah_data'?>" class="pull-right"><small>Tambah Order!</small></a>
                </h1> 
            </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->

            <table class="table table-bordered table-condensed" id="mydata" style="font-size:11px;margin-top:10px;">
                <thead>
                    <tr>
                        <th>No Faktur</th>
                        <th>Tanggal Order</th>
                        <th style="text-align:center;">Nama Pelanggan</th>
                        <th style="text-align:center;">Total Pembelian(Rp)</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align: center;">Pengiriman</th>
                        <th style="text-align:center;">Kembalian / Piutang (Rp)</th>
                        <th style="width:100px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                     <?php 
                         $no=0;
                        $sql = "SELECT
                                tbl_jual.jual_nofak,
                                DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,
                                tbl_jual.jual_total,
                                tbl_jual.jual_jml_uang,
                                tbl_jual.jual_kembalian,
                                tbl_jual.jual_keterangan,
                                tbl_jual.jual_pelanggan_id,
                                tbl_pelanggan.pelanggan_id,
                                tbl_pelanggan.pelanggan_nama,
                                tbl_pelanggan.pelanggan_alamat,
                                tbl_pelanggan.pelanggan_notelp,
                                tbl_pelanggan.pelanggan_kategori,
                                tbl_jual.jual_piutang,
                                tbl_jual.jual_pengiriman
                                FROM
                                tbl_jual
                                INNER JOIN tbl_pelanggan ON tbl_jual.jual_pelanggan_id = tbl_pelanggan.pelanggan_id
                                WHERE DATE_FORMAT(jual_tanggal,'%Y-%m-%d') = curdate()
                                ";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                             // output data of each row
                            while($i = $result->fetch_assoc()) {
                            $no++;
                            
                            $nofak=$i['jual_nofak'];
                            $tanggal=$i['jual_tanggal'];
                            $napel=$i['pelanggan_nama'];
                            $total=$i['jual_total'];
                            $kembalian=$i['jual_kembalian'];
                            $status=$i['jual_keterangan'];
                            $hutang=$i['jual_piutang'];
                            $pengiriman=$i['jual_pengiriman'];
                    ?>
                    <tr>
                         <td><?php echo $nofak;?></td>
                         <td><?php echo $tanggal;?></td>
                         <td style="text-align:center;"><?php echo $napel;?></td>
                         <td style="text-align:right;"><?php echo number_format($total);?></td>
                         <td style="text-align:center;"><?php echo $status;?></td>
                         <?php if ($pengiriman == 0) {?>
                             <td style="text-align:center;"><a href="<?php echo base_url().'admin/penjualan/kirim?nofak='.$nofak?>" class="btn btn-default btn-sm"><span class="fa fa-cubes"></span></a></td>
                        <?php }else{?>
                            <td style="text-align:center;"><a href="#" class="btn btn-default btn-sm"><span class="fa fa-truck"></span></a></td>
                         
                         <?php }
                         if ($status=='Lunas') {?>
                            <td style="text-align:right;"><?php echo number_format($kembalian);?></td>
                            <td style="text-align:center;"><a href="<?php echo base_url().'admin/penjualan/detail_penjualan?nofak='.$nofak?>" class="btn btn-default btn-sm"><span class="fa fa-eye"></span></a>|<a href="<?php echo base_url().'admin/penjualan/cetak_daftar_faktur?nofak='.$nofak?>" target="_blank" class="btn btn-warning btn-sm"><span class="fa fa-print"></span></a></td>
                        <?php }else{?>
                            <td style="text-align:right;"><?php echo number_format($hutang);?></td>
                            <td style="text-align:center;"><a href="<?php echo base_url().'admin/penjualan/detail_penjualan?nofak='.$nofak?>" class="btn btn-default btn-sm"><span class="fa fa-eye"></span></a>|<a href="<?php echo base_url().'admin/penjualan/bayar_piutang?nofak='.$nofak?>" class="btn btn-primary btn-sm"><span class="fa fa-close"></span></a><a href="<?php echo base_url().'admin/penjualan/cetak_daftar_faktur?nofak='.$nofak?>" target="_blank" class="btn btn-warning btn-sm"><span class="fa fa-print"></span></a></td>
                       <?php }?>
                    </tr>
                    <?php }}?>
                </tbody>
            </table>
            <hr/>
        </div>
        <!-- /.row -->
<?php
    break;}

   ?>
        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <!-- <div class="col-lg-12">
                    <p style="text-align:center;">Copyright &copy; <?php echo '2017';?> by M Fikri Setiadi</p>
                </div> -->
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="<?php echo base_url().'assets/js/jquery.js'?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url().'assets/dist/js/bootstrap-select.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/dataTables.bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.price_format.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/moment.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap-datetimepicker.min.js'?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mydata').DataTable();
        } );
    </script>
    
</body>

</html>
