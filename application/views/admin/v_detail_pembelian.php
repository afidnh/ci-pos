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
    <link href="<?php echo base_url().'assets/css/dataTables.bootstrap.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/jquery.dataTables.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/dist/css/bootstrap-select.css'?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/bootstrap-datetimepicker.min.css'?>">
</head>

<body>

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
   ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
            <center><?php echo $this->session->flashdata('msg');?></center>
                <h1 class="page-header">Pembelian
                    <small>Barang</small>
                    
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <?php

        $b=$data->row_array();
        $beli_kode=$b['beli_kode'];

        ?>
        <!-- Projects Row -->
        <div class="row">
            <div class="col-lg-12">
           <table>
                <tr>
                    <th style="width:100px;padding-bottom:5px;">No Faktur</th>
                    <th style="width:300px;padding-bottom:5px;"><input type="text" name="nofak" value="<?php echo $b['beli_nofak'];?>" class="form-control input-sm" style="width:200px;" readonly></th>
                    <th style="width:90px;padding-bottom:5px;">Suplier</th>
                    <td style="width:350px;"><input type="text" name="nofak" value="<?php echo $b['suplier_nama'];?>" class="form-control input-sm" style="width:200px;" readonly></td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>
                        <div class='input-group date' id='datepicker' style="width:200px;">
                            <input type='text' name="tgl" class="form-control" value="<?php echo $b['beli_tanggal'];?>" placeholder="Tanggal..." readonly/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </td>
                </tr>
            </table>
            <table class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;">
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th style="text-align:center;">Satuan</th>
                        <th style="text-align:center;">Harga Pokok</th>
                        <th style="text-align:center;">Harga Jual</th>
                        <th style="text-align:center;">Jumlah Beli</th>
                        <th style="text-align:center;">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($data->result_array() as $items) { ?>
                    <tr>
                         <td><?=$items['d_beli_barang_id'];?></td>
                         <td><?=$items['barang_nama'];?></td>
                         <td style="text-align:center;"><?=$items['barang_satuan'];?></td>
                         <td style="text-align:right;"><?php echo number_format($items['barang_harpok']);?></td>
                         <td style="text-align:right;"><?php echo number_format($items['d_beli_harga']);?></td>
                         <td style="text-align:center;"><?php echo number_format($items['d_beli_jumlah']);?></td>
                         <td style="text-align:right;"><?php echo number_format($items['d_beli_total']);?></td>
                    </tr>
                    <?php $i++; ?>
                    <?php }?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" style="text-align:center;">Total</td>
                        <?php
                        $sql_pembelian  = "SELECT sum(tbl_detail_beli.d_beli_total) AS jum FROM tbl_detail_beli WHERE d_beli_kode='$beli_kode'";
                                $omset = $conn->query($sql_pembelian);
                                $row=mysqli_fetch_array($omset,MYSQLI_ASSOC);
                                $total=$row['jum'];
                         ?>
                         <td style="text-align:center;"><?php echo 'Rp. '.$total;?></td>
                    </tr>
                </tfoot>
            </table>
            <button onclick="goBack()" class="btn btn-primary"> Kembali</button>
            
            </div>
        </div>
        <!-- /.row -->
        <hr>
        <!-- Footer -->
        <footer>
            <div class="row">
               <!--  <div class="col-lg-12">
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
    <script>
    function goBack() {
        window.history.back();
    }
    </script>
</body>

</html>
