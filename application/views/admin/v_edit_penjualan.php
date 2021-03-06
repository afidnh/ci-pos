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
   ?>

<!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
            <center><?php echo $this->session->flashdata('msg');?></center>
                <h1 class="page-header">Transaksi
                    <small>Penjualan (Ready)</small>
                </h1> 
            </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->
        <div class="row">
             <?php
             error_reporting(0);
             $pelanggan_id = $_GET['pelanggan_id'];
             $nofak = $_GET['nofak'];

            $sql = "SELECT * FROM tbl_pelanggan where pelanggan_id='$pelanggan_id'";
            $result = $conn->query($sql);
            $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
            $kategori=$row['pelanggan_kategori'];         

             ?>
             <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">

                     <form>
                        <div class="form-group">
                          <label for="nama">Nama Lengkap</label>
                          <input type="text" class="form-control" name="nama" value="<?php echo($row[pelanggan_nama])?>" readonly>
                        </div>
                        <div class="form-group">
                          <label for="alamat">Alamat</label>
                          <textarea type="text" class="form-control" name="alamat" value="<?php echo($row[pelanggan_alamat])?>" readonly><?php echo($row[pelanggan_alamat])?> </textarea>
                        </div>
                         <div class="form-group">
                          <label for="notelp">Nomer Telp</label>
                          <input type="text" class="form-control" name="notelp" value="<?php echo($row[pelanggan_notelp])?>" readonly>
                        </div>
                         <div class="form-group">
                          <label for="kategori">Kategori</label>
                          <input type="text" class="form-control" name="kategori" value="<?php echo($row[pelanggan_kategori])?>" readonly>
                        </div>
                      </form>
                </div>
                <div class="col-lg-3"></div>
             </div>
              <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Detail
                    <small>Barang</small>
                    <a href="#" data-toggle="modal" data-target="#largeModal" class="pull-right"><small>Cari Produk!</small></a>
                </h1> 
            </div>
        </div>

            <table class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;">
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th style="text-align:center;">Satuan</th>
                        <th style="text-align:center;">Harga(Rp)</th>
                        <th style="text-align:center;">Diskon(Rp)</th>
                        <th style="text-align:center;">Qty</th>
                        <th style="text-align:center;">Sub Total</th>
                        <th style="width:100px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;?>
                    <?php foreach ($detail_barang->result_array() as $items) { ?>
                    <tr>
                         <td><?=$items['d_jual_barang_id'];?></td>
                         <td><?=$items['d_jual_barang_nama'];?></td>
                         <td style="text-align:center;"><?=$items['d_jual_barang_satuan'];?></td>
                         <td style="text-align:right;"><?php echo number_format($items['d_jual_barang_harjul']);?></td>
                         <td style="text-align:right;"><?php echo number_format($items['d_jual_diskon']);?></td>
                         <td style="text-align:center;"><?php echo number_format($items['d_jual_qty']);?></td>
                         <td style="text-align:right;"><?php echo number_format($items['d_jual_total']);?></td>
                        
                         <td style="text-align:center;"><a href="<?php echo base_url().'admin/penjualan/hapus_barang?id_barang='.$items['d_jual_id'];?>" class="btn btn-warning btn-xs"><span class="fa fa-close"></span> Batal</a></td>
                    </tr>
                    
                    <?php $i++; ?>
                    <?php }?>
                </tbody>
            </table>
            <center><a href="https://rajaongkir.com/widget/buat" target="_blank"><button class="btn btn-success btn-xd">cek ongkir</button></a></center>
            <form action="<?php echo base_url().'admin/penjualan/proses_edit_penjualan'?>" method="post">
            <table>
                 <?php foreach ($detail_barang->result_array() as $items) 
                 $sql_total  = "SELECT sum(tbl_detail_jual.d_jual_total) AS jum FROM tbl_detail_jual WHERE d_jual_nofak='$nofak'";
                    $total = $conn->query($sql_total);
                    $row=mysqli_fetch_array($total,MYSQLI_ASSOC);
                    $total=$row['jum'];
                    $harga=$total+$items['jual_ongkir'];?>
                <tr>
                    <td style="width:760px;" rowspan="4"></td>
                    <th style="width:140px;">Total Belanja(Rp)</th>
                    <th style="text-align:right;width:140px;"><input type="text" name="total2" value="<?php echo $total;?>" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly></th>
                    
                    <input type="hidden" id="total" name="total" value="<?php echo $harga;?>" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly>
                    <input type="hidden" name="pelanggan_id" value="<?php echo($pelanggan_id)?>">
                </tr>
                <tr>

                    <th>ongkir(Rp)</th>
                    <th style="text-align:right;"><input type="text" id="ongkir" name="ongkir" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" value="<?php echo $items['jual_ongkir'];?>" required></th>
                    <input type="hidden" id="ongkir2" name="ongkir2" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" required>
                </tr>
                <tr>
                    <th>Total (Rp)</th>
                    <th style="text-align:right;"><input type="text" id="totalbel" name="totalbel" class=" form-control input-sm" style="text-align:right;margin-bottom:5px;" value="<?php echo $harga;?>" readonly></th>
                </tr>
                <tr>
                    <th>Pembayaran (Rp)</th>
                    <th style="text-align:right;"><input type="text" id="jml_uang" name="jml_uang" class="jml_uang form-control input-sm" style="text-align:right;margin-bottom:5px;" value="<?php echo $items['jual_jml_uang'];?>" required></input></th>
                    <input type="hidden" id="jml_uang2" name="jml_uang2" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" required>
                </tr>
                <tr>
                    <td></td>
                    <th>Kembalian(Rp)</th>
                    <?php if ( $items['jual_keterangan'] == 'Lunas') { ?>
                        <th style="text-align:right;"><input type="text" id="kembalian" name="kembalian" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" value="<?php echo $items['jual_kembalian'];?>" readonly ></th>

                   <?php }else{ ?>
                        <th style="text-align:right;"><input type="text" id="kembalian" name="kembalian" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" value="<?php echo $items['jual_piutang'];?>" readonly ></th>

                   <?php } ?>
                    
                    <input type="hidden" id="keterangan" name="keterangan" class="form-control input-sm" value="<?php echo $items['jual_keterangan'];?>" readonly>
                    <input type="hidden" id="nofak" name="nofak" class="form-control input-sm" value="<?php echo $nofak;?>" readonly>
                </tr>
                <tr>
                    <td></td>
                    <th><button type="submit" class="btn btn-info btn-lg"> Simpan</button></th>
                    <th style="text-align:right;"></th>
                </tr>
            </table>
            </form>
            <hr/>
        </div>
        <!-- /.row -->

        <!-- ============ MODAL ADD =============== -->
        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Data Barang</h3>
            </div>
                <div class="modal-body" style="overflow:scroll;height:500px;">

                  <table class="table table-bordered table-condensed" style="font-size:11px;" id="mydata">
                    <thead>
                        <tr>
                            <th style="text-align:center;width:40px;">No</th>
                            <th style="width:120px;">Kode Barang</th>
                            <th style="width:240px;">Nama Barang</th>
                            <th>Satuan</th>
                            <th style="width:100px;">Harga</th>
                            <th>Stok</th>
                            <th>Diskon</th>
                            <th>Qty</th>
                            <th style="width:100px;text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $no=0;
                        foreach ($data->result_array() as $a):
                            $no++;
                            $id=$a['barang_id'];
                            $nm=$a['barang_nama'];
                            $satuan=$a['barang_satuan'];
                            $harpok=$a['barang_harpok'];
                            $harjul=$a['barang_harjul'];
                            $harjul_grosir=$a['barang_harjul_grosir'];
                            $harjul_agen=$a['barang_harjul_agen'];
                            $stok=$a['barang_stok'];
                            $min_stok=$a['barang_min_stok'];
                            $kat_id=$a['barang_kategori_id'];
                            $kat_nama=$a['kategori_nama'];
                            if ($stok <+ $min_stok) {
                        echo "<tr style='background-color: red;'>";
                        }else{
                            echo "<tr>";
                        }
                    ?>

                            <form action="<?php echo base_url().'admin/penjualan/update_barang_edit'?>" method="post">
                            <td style="text-align:center;"><?php echo $no;?></td>
                            <td><?php echo $id;?></td>
                            <td><?php echo $nm;?></td>
                            <td style="text-align:center;"><?php echo $satuan;?></td>
                           <td style="text-align:right;">
                                <?php 
                                if ($kategori == 'Pelanggan') {
                                    echo 'Rp '.number_format($harjul);
                                }elseif ($kategori == 'Reseller') {
                                    echo 'Rp '.number_format($harjul_grosir);
                                }elseif ($kategori == 'Sub Agen') {
                                    echo 'Rp '.number_format($harjul_agen);
                                }
                                
                                ?>
                            </td>
                            <td style="text-align:center;"><?php echo $stok;?></td>
                            <td style="text-align:center;">
                            
                            <input type="hidden" name="kode_brg" value="<?php echo $id?>">
                            <input type="hidden" name="nofak" value="<?php echo $nofak?>">
                            <input type="hidden" name="harpok" value="<?php echo $harpok?>">
                            <input type="hidden" name="nabar" value="<?php echo $nm;?>">
                            <input type="hidden" name="satuan" value="<?php echo $satuan;?>">
                            <input type="hidden" name="stok" value="<?php echo $stok;?>">
                              <?php 
                                if ($kategori == 'Pelanggan') {?>
                                   <input type="hidden" name="harjul" value="<?php echo$harjul;?>">
                                   <input type="number" name="diskon" value="0" max="<?php echo $harjul;?>">
                               <?php }elseif ($kategori == 'Reseller') {?>
                                <input type="hidden" name="harjul" value="<?php echo $harjul_grosir;?>">
                                <input type="number" name="diskon" value="0" max="<?php echo $harjul_grosir;?>">
                                <?php }elseif ($kategori == 'Sub Agen') {?>
                                    <input type="hidden" name="harjul" value="<?php echo $harjul_agen;?>">
                                     <input type="number" name="diskon" value="0" max="<?php echo $harjul_agen;?>">
                                <?php } ?>
                        </td>
                            <td><input type="number" name="qty" value="1" min="1" max="<?php echo $stok;?>" required></td>
                                <td><a href="<?php echo base_url().'admin/penjualan/update_barang_edit'?>"></a><button type="submit" class="btn btn-xs btn-info" title="Pilih"><span class="fa fa-edit"></span> Pilih</button>
                            </td>
                            </form>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>          

                </div>

                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    
                </div>
            </div>
            </div>
        </div>      
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
        $(function(){
            $('#jml_uang').on("input",function(){
                var total=$('#totalbel').val();
                var jumuang=$('#jml_uang').val();
                var hsl=jumuang.replace(/[^\d]/g,"");
                $('#jml_uang2').val(hsl);
                $('#kembalian').val(hsl-total);
            })
            
        });
    </script>
    <script type="text/javascript">
        $(function(){
            $('#ongkir').on("input",function(){
                var total=$('#total').val();
                var jumuang=$('#ongkir').val();
                var hsl=jumuang.replace(/[^\d]/g,"");
                $('#ongkir2').val(hsl);
                var jumlah =parseInt(hsl) + parseInt(total);
                // var jumlah = hsl+total;
                $('#totalbel').val(jumlah);
            })
            
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mydata').DataTable();
        } );
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mydata1').DataTable();
        } );
    </script>
    <script type="text/javascript">
        $(function(){
            $('.jml_uang').priceFormat({
                    prefix: '',
                    //centsSeparator: '',
                    centsLimit: 0,
                    thousandsSeparator: ','
            });
            $('#jml_uang2').priceFormat({
                    prefix: '',
                    //centsSeparator: '',
                    centsLimit: 0,
                    thousandsSeparator: ''
            });
            $('#ongkir').priceFormat({
                    prefix: '',
                    //centsSeparator: '',
                    centsLimit: 0,
                    thousandsSeparator: ''
            });
            $('#kembalian').priceFormat({
                    prefix: '',
                    //centsSeparator: '',
                    centsLimit: 0,
                    thousandsSeparator: ','
            });
            $('.harjul').priceFormat({
                    prefix: '',
                    //centsSeparator: '',
                    centsLimit: 0,
                    thousandsSeparator: ','
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            //Ajax kabupaten/kota insert
            $("#kode_brg").focus();
            $("#kode_brg").on("input",function(){
                var kobar = {kode_brg:$(this).val()};
                   $.ajax({
               type: "POST",
               url : "<?php echo base_url().'admin/penjualan/get_barang';?>",
               data: kobar,
               success: function(msg){
               $('#detail_barang').html(msg);
               }
            });
            }); 

            $("#kode_brg").keypress(function(e){
                if(e.which==13){
                    $("#jumlah").focus();
                }
            });
        });
    </script>  
</body>

</html>