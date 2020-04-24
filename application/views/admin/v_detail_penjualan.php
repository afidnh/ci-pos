
<html>
<head>
<title>Faktur Pembayaran</title>
<style>

#tabel
{
font-size:15px;
border-collapse:collapse;
}
#tabel  td
{
padding-left:5px;
border: 1px solid black;
}
</style>
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
    <?php
$this->load->view('admin/menu');
    ?>
<center>
    <table style='width:550px; font-size:8pt; font-family:calibri; border-collapse: collapse;' border = '0'>
        <td width='75%' align='left' style='padding-right:80px; vertical-align:top'>
            <span style='font-size:12pt'><b><img src="<?php echo base_url().'assets/img/logo-toko.png'?>"/ style=" width: 125px; "></b></span>
            </br style='font-size:20pt'>Dsn. Bangsongan Rt.01/Rw.06 -Kec. Kayen Kidul -Kab. Kediri Jawa Timur Indonesia</br>Telp : +62 812-3556-7273
        </td>
        <?php 
            $b=$data->row_array();

            $nofak=$b['jual_nofak'];
            $pelanggan_id=$b['pelanggan_id'];
        ?>
        <td style='vertical-align:top' width='30%' align='left'>
            <b><span style='font-size:12pt'>FAKTUR PENJUALAN</span></b></br>
                No Trans. : <?php echo $b['jual_nofak'];?></br>
                Tanggal : <?php echo $b['jual_tanggal'];?></br>
                Keterangan: <?php echo $b['jual_keterangan'];?>
        </td>
         <td style="text-align:left;"></td>
    </table>
    <table style='width:550px; font-family:calibri; border-collapse: collapse;' border = '0'>
        <td width='75%' align='left' style='padding-right:80px; vertical-align:top'>
        Nama Pelanggan : <?php echo $b['pelanggan_nama'];?></br>
        Alamat : <?php echo $b['pelanggan_alamat'];?>
        </td>
        <td style='vertical-align:top' width='30%' align='left'>
        No Telp : <?php echo $b['pelanggan_notelp'];?>
        </td>
    </table>
    <table cellspacing='0' style='width:550px; font-size:12px; font-family:calibri;  border-collapse: collapse;' border='1'>

        <tr align='center'>
            <td width='5%'>No</td>
            <td width='20%'>Nama Barang</td>
            <td width='5%'>Satuan</td>
            <td width='13%'>Harga</td>
            <td width='4%'>Qty</td>
            <td width='7%'>Discount</td>
            <td width='13%'>Total Harga</td>
        </tr>
        <?php 
            $no=0;
            foreach ($data->result_array() as $i) {
                $no++;

                
                $nabar=$i['d_jual_barang_nama'];
                $satuan=$i['d_jual_barang_satuan'];
                
                $harjul=$i['d_jual_barang_harjul'];
                $qty=$i['d_jual_qty'];
                $diskon=$i['d_jual_diskon'];
                $total=$i['d_jual_total'];
        ?>
        <tr>
            <td style="text-align:center;"><?php echo $no;?></td>
            <td style="text-align:left;"><?php echo $nabar;?></td>
            <td style="text-align:center;"><?php echo $satuan;?></td>
            <td style="text-align:right;"><?php echo 'Rp '.number_format($harjul);?></td>
            <td style="text-align:center;"><?php echo $qty;?></td>
            <td style="text-align:right;"><?php echo 'Rp '.number_format($diskon);?></td>
            <td style="text-align:right;"><?php echo 'Rp '.number_format($total);?></td>
        </tr>
<?php }?>
        <tr>
            <td colspan = '6'><div style='text-align:right'>Ongkir : </div></td>
            <td style='text-align:right'><?php echo 'Rp '.number_format($b['jual_ongkir']).',-';?></td>
        </tr>
        <tr>
            <td colspan = '6'><div style='text-align:right'>Total Yang Harus Di Bayar Adalah : </div></td>
            <td style='text-align:right'><?php echo 'Rp '.number_format($b['jual_total']);?></td>
        </tr>
        <tr>
            <td colspan = '6'><div style='text-align:right'>Cash : </div></td>
            <td style='text-align:right'><?php echo 'Rp '.number_format($b['jual_jml_uang']).',-';?></td>
        </tr>
        <tr>
            <td colspan = '6'><div style='text-align:right'>Kembalian : </div></td>
            <td style='text-align:right'><?php echo 'Rp '.number_format($b['jual_kembalian']).',-';?></td>
        </tr>
    </table>
    <div style='width:550px; font-family:calibri;  margin-top:10px; '>
        <div class="col-md-4"></div>
        <div class="col-md-8">
            <button onclick="goBack()" class="btn btn-default btn-sm"> Kembali</button>|<a href="<?php echo base_url().'admin/penjualan/cetak_daftar_faktur?nofak='.$nofak?>" target="_blank" class="btn btn-warning btn-sm"><span class="fa fa-print"> Cetak</span></a>|<a href="<?php echo base_url().'admin/penjualan/edit_penjualan?pelanggan_id='.$pelanggan_id.'&nofak='.$nofak?>" class="btn btn-success btn-sm"><span class="fa fa-pencil"> Edit</span></a>|<a href="<?php echo base_url().'admin/penjualan/hapus?nofak='.$nofak?>" class="btn btn-primary btn-sm" onClick="return confirm(' Data Yakin Mau dihapus ?');"><span class="fa fa-trash"> Hapus</span></a>
        </div>
    </div>
    <hr>
</center>
<script src="<?php echo base_url().'assets/js/jquery.js'?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url().'assets/dist/js/bootstrap-select.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/dataTables.bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.price_format.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/moment.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap-datetimepicker.min.js'?>"></script>
    <script>
    function goBack() {
        window.history.back();
    }
</script>

</body>
</html>