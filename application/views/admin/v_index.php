<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome To Point of Sale Apps</title>

    <!-- Bootstrap Core CSS -->
      <link href="<?php echo base_url().'assets/css/bootstrap.min.css'?>" rel="stylesheet">
        <link href="<?php echo base_url().'assets/css/style.css'?>" rel="stylesheet">
        <link href="<?php echo base_url().'assets/css/font-awesome.css'?>" rel="stylesheet">
    <!-- Custom CSS -->
      <link href="<?php echo base_url().'assets/css/4-col-portfolio.css'?>" rel="stylesheet">

      <style type="text/css">
      .bg {
           width: 100%;
           height: 100%;
           position: fixed;
           z-index: -1;
           float: left;
           left: 0;
           margin-top: -20px;
      }
      </style>
</head>

<body>
<img src="<?php echo base_url().'assets/img/bg2.jpg'?>" alt="gambar" class="bg" />
    <!-- Navigation -->
   <?php 
        $this->load->view('admin/menu');
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "db_penjualan";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }
        $sql_order  = "SELECT count(*) as jum FROM tbl_jual where DATE_FORMAT(jual_tanggal,'%Y-%m-%d') = curdate()";
        $order = $conn->query($sql_order);
        $row=mysqli_fetch_array($order,MYSQLI_ASSOC);
        $order=$row['jum'];
        $sql_barang  = "SELECT sum(tbl_detail_jual.d_jual_qty) AS jum FROM tbl_detail_jual INNER JOIN tbl_jual ON tbl_detail_jual.d_jual_nofak = tbl_jual.jual_nofak WHERE DATE_FORMAT(tbl_jual.jual_tanggal,'%Y-%m-%d') = curdate()";
        $barang = $conn->query($sql_barang);
        $row=mysqli_fetch_array($barang,MYSQLI_ASSOC);
        $barang=$row['jum'];

        $sql_omset  = "SELECT sum(tbl_jual.jual_total) AS jum FROM tbl_jual WHERE DATE_FORMAT(tbl_jual.jual_tanggal,'%Y-%m-%d') = curdate()";
        $omset = $conn->query($sql_omset);
        $row=mysqli_fetch_array($omset,MYSQLI_ASSOC);
        $omset=$row['jum'];
        $sql_hutang = "SELECT count(*) as jum FROM tbl_jual where jual_keterangan = 'hutang'";
        $hutang = $conn->query($sql_hutang);
        $row=mysqli_fetch_array($hutang,MYSQLI_ASSOC);
        $hutang=$row['jum'];
        $bul=date("F Y");
        $sql_best_barang = "SELECT tbl_detail_jual.d_jual_barang_nama, Sum(tbl_detail_jual.d_jual_qty) AS qty, tbl_jual.jual_tanggal FROM tbl_detail_jual INNER JOIN tbl_jual ON tbl_detail_jual.d_jual_nofak = tbl_jual.jual_nofak WHERE DATE_FORMAT(tbl_jual.jual_tanggal,'%M %Y')= '$bul' GROUP BY tbl_detail_jual.d_jual_barang_nama ORDER BY qty DESC LIMIT 7";
        $sql_best_custemor="SELECT COUNT(tbl_jual.jual_pelanggan_id) as jum, tbl_pelanggan.pelanggan_nama FROM tbl_jual INNER JOIN tbl_pelanggan ON tbl_jual.jual_pelanggan_id = tbl_pelanggan.pelanggan_id WHERE tbl_pelanggan.pelanggan_kategori = 'Pelanggan' AND DATE_FORMAT(tbl_jual.jual_tanggal,'%M %Y')= '$bul' GROUP BY tbl_pelanggan.pelanggan_nama ORDER BY jum DESC LIMIT 5 ";
        $sql_best_reseller="SELECT COUNT(tbl_jual.jual_pelanggan_id) as jum, tbl_pelanggan.pelanggan_nama FROM tbl_jual INNER JOIN tbl_pelanggan ON tbl_jual.jual_pelanggan_id = tbl_pelanggan.pelanggan_id WHERE tbl_pelanggan.pelanggan_kategori = 'Reseller' AND DATE_FORMAT(tbl_jual.jual_tanggal,'%M %Y')= '$bul' GROUP BY tbl_pelanggan.pelanggan_nama ORDER BY jum DESC LIMIT 5 ";
        $sql_best_agen="SELECT COUNT(tbl_jual.jual_pelanggan_id) as jum, tbl_pelanggan.pelanggan_nama FROM tbl_jual INNER JOIN tbl_pelanggan ON tbl_jual.jual_pelanggan_id = tbl_pelanggan.pelanggan_id WHERE tbl_pelanggan.pelanggan_kategori = 'Sub Agen' AND DATE_FORMAT(tbl_jual.jual_tanggal,'%M %Y')= '$bul' GROUP BY tbl_pelanggan.pelanggan_nama ORDER BY jum DESC LIMIT 5 ";
        $grafik="SELECT DATE_FORMAT(jual_tanggal,'%d') AS tanggal,SUM(jual_total) total FROM tbl_jual WHERE DATE_FORMAT(jual_tanggal,'%M %Y')= '$bul' GROUP BY DAY(jual_tanggal)";

        ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="color:#fcc;">Welcome to
                    <small>Point of Sale Apps</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->
    <div class="mainbody-section text-center">
     <?php $h=$this->session->userdata('akses'); ?>
     <?php $u=$this->session->userdata('user'); ?>

        <!-- Projects Row -->
        <div class="row">
         <?php 

         ?> 
             <div class="col-md-3 portfolio-item">
                <div class="menu-item red" style="height:150px;">
                     <a href="<?php echo base_url().'admin/penjualan?act=now'?>">
                           <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-shopping-bag"></i>
                                </div>
                                <div class="col-xs-8">
                                    <h1 style="margin-top: 3px;"><?php echo $order ?></h1>
                                    <h3>Total Order</h3>
                                </div>
                            </div>
                      </a>
                </div> 
            </div>
            <div class="col-md-3 portfolio-item">
                <div class="menu-item purple" style="height:150px;">
                     <a href="#>" data-toggle="modal">
                           <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-cubes"></i>
                                </div>
                                <div class="col-xs-8">
                                    <h1 style="margin-top: 3px;"><?php echo $barang ?></h1>
                                    <h3>Total Barang</h3>
                                </div>
                            </div>
                      </a>
                </div> 
            </div>
            <div class="col-md-3 portfolio-item">
                <div class="menu-item light-orange" style="height:150px;">
                     <a href="#" data-toggle="modal">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-money"></i>
                                </div>
                                <div class="col-xs-8">
                                    <h2 style="margin-top: 3px;">Rp. <?php echo $omset ?></h2>
                                    <h3>Omset</h3>
                                </div>
                            </div>
                      </a>
                </div> 
            </div>
            <div class="col-md-3 portfolio-item">
                <div class="menu-item color" style="height:150px;">
                     <a href="<?php echo base_url().'admin/penjualan?act=hutang'?>" data-toggle="modal">
                          <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-user-times"></i>
                                </div>
                                <div class="col-xs-8">
                                    <h2 style="margin-top: 3px;"><?php echo $hutang ?></h2>
                                    <h3>Hutang</h3>
                                </div>
                            </div>
                      </a>
                </div> 
            </div>
        <!-- /.row -->
        <?php
          $hasil = $conn->query($grafik);
               if ($hasil->num_rows > 0) {
          /* Mengambil query report*/
          foreach($report as $result){
              $bulan[] = $result->tanggal; //ambil bulan
              $value[] = (float) $result->total; //ambil nilai
          } 
      }
          /* end mengambil query*/
         
           
      ?>

        <!-- Projects Row -->
        <div class="row">
            <div class="col-md-9 col-sm-12 col-xs-12 portfolio-item">
                    <div id="report"></div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #ff0000; color: #fff;">
                                Best Seller Barang
                            </div> 
                            <div class="panel-body" style="margin-top: 10px;">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Qty</th>
                                                <th>Nama Barang</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php                          
                                            $result = $conn->query($sql_best_barang);

                                            if ($result->num_rows > 0) {
                                                 // output data of each row
                                                while($i = $result->fetch_assoc()) {                            
                                                $qty=$i['qty'];
                                                $nama=$i['d_jual_barang_nama'];
                                                ?>
                                                <tr>
                                                     <td><?php echo $qty;?></td>
                                                     <td><?php echo $nama;?></td>
                                                <?php }}?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
              
            </div>
        </div>
        <!-- /.row -->
         <!-- Projects Row -->
        <div class="row">
            <div class="col-md-4 col-sm-12 col-xs-12">
               <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #ffa801; color: #fff;">
                        Top 5 Customer
                    </div>
                    <div class="panel-body">
                        <div class="list-group" style="text-align: left;">
                            <?php                          
                                $result = $conn->query($sql_best_custemor);
                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while($i = $result->fetch_assoc()) {                          $order=$i['jum'];
                                            $nama=$i['pelanggan_nama'];
                                                ?>
                                                <a href="#" class="list-group-item">
                                                    <span class="badge"><?php echo $order;?></span>
                                                    <i class="fa fa-fw fa-comment"></i> <?php echo $nama;?>
                                                </a>
                                            <?php }}?>

                        </div>
                        <div class="text-right">
                            <a href="#">More Tasks <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
               <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #ff0000; color: #fff;">
                        Top 5 Reseller
                    </div>
                    <div class="panel-body">
                        <div class="list-group" style="text-align: left;">
                            <?php                          
                                $result = $conn->query($sql_best_reseller);
                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while($i = $result->fetch_assoc()) {                          $order=$i['jum'];
                                            $nama=$i['pelanggan_nama'];
                                                ?>
                                                <a href="#" class="list-group-item">
                                                    <span class="badge"><?php echo $order;?></span>
                                                    <i class="fa fa-fw fa-comment"></i> <?php echo $nama;?>
                                                </a>
                                            <?php }}?>

                        </div>
                        <div class="text-right">
                            <a href="#">More Tasks <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
               <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #00d8d6; color: #fff;">
                        Top 5 Sub Agen
                    </div>
                    <div class="panel-body">
                       <div class="list-group" style="text-align: left;">
                            <?php                          
                                $result = $conn->query($sql_best_agen);
                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while($i = $result->fetch_assoc()) {                          $order=$i['jum'];
                                            $nama=$i['pelanggan_nama'];
                                                ?>
                                                <a href="#" class="list-group-item">
                                                    <span class="badge"><?php echo $order;?></span>
                                                    <i class="fa fa-fw fa-comment"></i> <?php echo $nama;?>
                                                </a>
                                            <?php }}?>

                        </div>
                        <div class="text-right">
                            <a href="#">More Tasks <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    
    <!-- /.container -->
    <!-- jQuery -->
    <script src="<?php echo base_url().'assets/js/jquery.js'?>"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js'?>"></script>

    <script src="<?php echo base_url().'assets/js/grafik/jquery.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/grafik/highcharts.js'?>"></script>
<!-- Script untuk memanggil library Highcharts -->
<script type="text/javascript">
$(function () {
    $('#report').highcharts({
        chart: {
            type: 'line',
            margin: 75,
            options3d: {
                enabled: false,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
        title: {
            text: 'Grafik Penjualan Bulan <?php echo $bln?>',
            style: {
                    fontSize: '18px',
                    fontFamily: 'Verdana, sans-serif'
            }
        },
        subtitle: {
           text: '',
           style: {
                    fontSize: '15px',
                    fontFamily: 'Verdana, sans-serif'
            }
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories:  <?php echo json_encode($bulan);?>
        },
        exporting: { 
            enabled: false 
        },
        yAxis: {
            title: {
                text: 'Penjualan'
            },
        },
        tooltip: {
             formatter: function() {
                 return 'Total Penjualan Tanggal <b>' + this.x + '</b> Adalah Rp <b>' + Highcharts.numberFormat(this.y,0) + '</b>';
             }
          },
        series: [{
            name: 'Tanggal',
            data: <?php echo json_encode($value);?>,
            shadow : true,
            dataLabels: {
                enabled: true,
                color: '#045396',
                align: 'center',
                formatter: function() {
                     return Highcharts.numberFormat(this.y, 0);
                }, // one decimal
                y: 0, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });
});
</script>
 
</body>

</html>
