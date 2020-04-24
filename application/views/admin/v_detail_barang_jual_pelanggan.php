					<?php 
						error_reporting(0);
						// $b=$pel->row_array();
						foreach ($pel->result_array() as $b):
					?>
					<div class="form-group">
                          <label for="alamat">Alamat</label>
                          <textarea type="text" class="form-control" name="alamat" value="<?php echo $b['pelanggan_alamat'];?>" readonly><?php echo $b['pelanggan_alamat'];?></textarea>
                        </div>
                         <div class="form-group">
                          <label for="notelp">Nomer Telp</label>
                          <input type="text" class="form-control" name="notelp" value="<?php echo $b['pelanggan_notelp'];?>" readonly>
                        </div>
                         <div class="form-group">
                          <label for="kategori">Kategori</label>
                          <input type="text" class="form-control" name="kategori" value="<?php echo $b['pelanggan_kategori'];?>" readonly>
                        </div>
					<!-- <table>
						<tr>
		                    <th style="width:200px;"></th>
		                    <th>Nama Pelanggan</th>
		                    <th>Alamat</th>
		                    <th>Nomer Telp</th>
		                    <th>Kategori</th>
		                </tr>
						<tr>
							<td style="width:200px;"></th>
							<td><input type="text" name="nabar" value="<?php echo $b['pelanggan_nama'];?>" style="width:180px;margin-right:5px;" class="form-control input-sm" readonly></td>
		                    <td><input type="text" name="satuan" value="<?php echo $b['pelanggan_alamat'];?>" style="width:380px;margin-right:5px;" class="form-control input-sm" readonly></td>
		                    <td><input type="text" name="stok" value="<?php echo $b['pelanggan_notelp'];?>" style="width:140px;margin-right:5px;" class="form-control input-sm" readonly></td>
		                   <td><input type="text" name="stok" value="<?php echo $b['pelanggan_kategori'];?>" style="width:140px;margin-right:5px;" class="form-control input-sm" readonly></td>
		                   <td>
		                   <button type="submit" class="btn btn-sm btn-primary">Ok</button></td>
						</tr>
					</table> -->
					<?php endforeach;?>
					