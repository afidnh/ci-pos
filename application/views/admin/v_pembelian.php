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
                <h1 class="page-header">Daftar
                    <small>Pembelian</small>
                    <a href="<?php echo base_url().'admin/pembelian/tambah_data'?>" class="pull-right"><small>Tambah Pembelian!</small></a>
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
                        <th style="text-align:center;">Nama Suplier</th>
                        <th style="text-align:center;">Total Pembelian(Rp)</th>
                        <th style="width:100px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                     <?php 
                         $no=0;
                        foreach ($data->result_array() as $i):
                            $beli_kode=$i['beli_kode'];
                    ?>
                    <tr>
                         <td><?php echo $i['beli_nofak'];?></td>
                         <td><?php echo $i['beli_tanggal'];?></td>
                         <td style="text-align:center;"><?php echo $i['suplier_nama'];?></td>
                         <?php
                        $sql_pembelian  = "SELECT sum(tbl_detail_beli.d_beli_total) AS jum FROM tbl_detail_beli WHERE d_beli_kode='$beli_kode'";
                                $omset = $conn->query($sql_pembelian);
                                $row=mysqli_fetch_array($omset,MYSQLI_ASSOC);
                                $total=$row['jum'];
                         ?>
                         <td style="text-align:center;"><?php echo 'Rp. '.$total;?></td>
                        <td style="text-align:center;">
                            <a href="<?php echo base_url().'admin/pembelian/tampil_pembelian_detail?beli_kode='.$beli_kode?>" class="btn btn-default btn-sm"><span class="fa fa-eye"></span></a>|<a href="<?php echo base_url().'admin/pembelian/hapus?beli_kode='.$beli_kode?>" class="btn btn-primary btn-sm"><span class="fa fa-trash"></span></a>
                        </td>
                       
                         
                    </tr>
         
                    <?php endforeach;?>
                </tbody>
            </table>
            <hr/>
        </div>
        <!-- /.row -->
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
