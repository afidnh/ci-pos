
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
</head>
<body onload="window.print()">
<center>
    <table style='width:550px; font-size:8pt; font-family:calibri; border-collapse: collapse;' border = '0'>
        <td width='75%' align='left' style='padding-right:80px; vertical-align:top'>
            <span style='font-size:12pt'><b><img src="<?php echo base_url().'assets/img/logo-toko.png'?>"/ style=" width: 125px; "></b></span>
            </br style='font-size:20pt'>Dsn. Bangsongan Rt.01/Rw.06 -Kec. Kayen Kidul -Kab. Kediri Jawa Timur Indonesia</br>Telp : +62 812-3556-7273
        </td>
        <?php 
            $b=$data->row_array();
        ?>
        <td style='vertical-align:top' width='30%' align='left'>
            <b><span style='font-size:12pt'>FAKTUR PENJUALAN</span></b></br>
                No Trans. : <?php echo $b['jual_nofak'];?></br>
                Tanggal : <?php echo $b['jual_tanggal'];?></br>
                Keterangan: <?php echo $b['jual_keterangan'];?>
        </td>
         <td style="text-align:left;"></td>
    </table>
    <table style='width:550px; font-size:8pt; font-family:calibri; border-collapse: collapse;' border = '0'>
        <td width='75%' align='left' style='padding-right:80px; vertical-align:top'>
        Nama Pelanggan : <?php echo $b['pelanggan_nama'];?></br>
        Alamat : <?php echo $b['pelanggan_alamat'];?>
        </td>
        <td style='vertical-align:top' width='30%' align='left'>
        No Telp : <?php echo $b['pelanggan_notelp'];?>
        </td>
    </table>
    <table cellspacing='0' style='width:550px; font-size:8pt; font-family:calibri;  border-collapse: collapse;' border='1'>

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
    <table align="center" style="width:550px; border:none;margin-top:5px;margin-bottom:20px;">
        <tr>
            <td align="right">Kediri, <?php echo date('d-M-Y')?></td>
        </tr>
        <tr>
            <td align="right"></td>
        </tr>
       
        <tr>
        <td><br/><br/><br/><br/></td>
        </tr>    
        <tr>
            <td align="right">( <?php echo $this->session->userdata('nama');?> )</td>
        </tr>
        <tr>
            <td align="center"></td>
        </tr>
    </table>
    <table align="center" style="width:550px; border:none;margin-top:5px;margin-bottom:20px;">
        <tr>
            <th><br/><br/></th>
        </tr>
        <tr>
            <th align="left"></th>
        </tr>
    </table>
    <hr>
    <h3>Shipping Label</h3>
    <table style='width:550px; font-size:8pt; font-family:calibri; border-collapse: collapse;' border = '0'>
        <td width='30%' align='left' style='padding-right:80px; vertical-align:top'>
            <b><span style='font-size:12pt'>Pengirim</span></b></br>
            <span style='font-size:12pt'><b><img src="<?php echo base_url().'assets/img/logo-toko.png'?>"/ style=" width: 125px; "></b></span>
            </br style='font-size:20pt'>Dsn. Bangsongan Rt.01/Rw.06 -Kec. Kayen Kidul -Kab. Kediri Jawa Timur Indonesia</br>Telp : +62 812-3556-7273
        </td>
        <?php 
            $b=$data->row_array();
        ?>
        <td style='vertical-align:top; font-size:13pt;' width='70%' align='left'>
            <b><span style='font-size:15pt'>Kepada</span></b></br>
                Nama Pelanggan : <?php echo $b['pelanggan_nama'];?></br>
                Alamat : <?php echo $b['pelanggan_alamat'];?><br>
                 No Telp : <?php echo $b['pelanggan_notelp'];?>
        </td>
         <td style="text-align:left;"></td>
    </table>
    <hr>
</center>
</body>
</html>