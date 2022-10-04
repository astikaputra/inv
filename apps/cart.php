
		<div id="page-header">
			<img src="<?php echo base_url();?>public/frontend/images/page-header1.jpg" alt="" />
		</div>
		
		<!-- BEGIN .section -->
		<div class="section page-content clearfix">
	
			<h2 class="page-title">Keranjang Belanja</h2>
			
			
			
				<div class="tag-title-wrap clearfix">
					<h4 class="tag-title">Pesanan Anda</h4>
				</div>
				<?php echo $message?>
				<table width="100%" class="account-table">
				<?php if ($cart = $this->cart->contents()): ?>
					<thead>
						<tr>
							<th>Product #</th>
							<th>Product Name</th>
							<th>Product Price</th>
							<th>Qty</th>
							<th>Infak</th>
							<th>Totals</th>
							<th>Options</th>
						</tr>
					</thead>
					<?php
					echo form_open('cart/update_cart');
					$grand_total = 0; $grand_sedekah=0; $i = 1;
		
					foreach ($cart as $item):
					echo form_hidden('cart['. $item['id'] .'][id]', $item['id']);
					echo form_hidden('cart['. $item['id'] .'][rowid]', $item['rowid']);
					echo form_hidden('cart['. $item['id'] .'][name]', $item['name']);
					echo form_hidden('cart['. $item['id'] .'][price]', $item['price']);
					echo form_hidden('cart['. $item['id'] .'][qty]', $item['qty']);
					?>
					<tbody>
						<tr>
							<td data-title="Product #"><?php echo $item['id']; ?></td>
							<td data-title="Product Name"><?php echo $item['name']; ?></td>
							<td data-title="Product #">Rp <?php echo number_format($item['price'],2); ?></td>
							<td data-title="Qty" class="qty-table">	
							<div class="qty-fields">
							
								<?php 
								echo form_input('cart['. $item['id'] .'][qty]', $item['qty'], 'maxlength="3" class="qty-text" size="1" style="text-align: right"'); ?></div>
							</td>
							<?php 
							$item['subsedekah']=$item['qty']*$item['sedekah'];
							$grand_total = $grand_total + $item['subtotal']; 
							$grand_sedekah = $grand_sedekah + $item['subsedekah']; 
							?>
							<td data-title="Harga Sedekah"><?php echo $item['subsedekah']; ?></td>
							<td data-title="Totals">Rp <?php echo number_format($item['subtotal'],2) ?></td>
							<td data-title="Remove"><?php echo anchor('cart/remove/'.$item['rowid'],'Cancel'); ?></td>
						</tr>
					</tbody>
					
					<?php endforeach; ?>
					
				</table>
				
				<!-- BEGIN .clearfix -->
				<div class="cart-options clearfix">
			
					<div class="coupon-form clearfix fl">
						<input type="text" class="coupon-code" name="coupon-code" class="text_input" value="" />
						<input class="button2 fr" style="margin: 2px 0 0 10px;" type="button" value="Gunakan Kupon &raquo;" name="submit">
					</div>
			
					<div class="cart-buttons fr">
						<input class="button2 fl" style="margin: 2px 10px 0 0;" type="submit" value="Perbaharui Keranjang Belanja &raquo" name="Update Cart">
					    <input class="button2 fr" type="button" value="Hapus Keranjang Belanja &raquo" onclick="clear_cart()">
					</div>
				</form>
				<!-- END .clearfix -->
				</div>
			
			
			
			<hr>
			
			<div class="form-third">
			
				<div class="tag-title-wrap clearfix">
					<h4 class="tag-title">Total</h4>
				</div>
			
				<table width="100%" class="account-table">
					<tbody>
						<tr>
							<td><strong>Total Pesanan</strong></td>
							<td>Rp<?php echo number_format($grand_total,2); ?></td>
						</tr>
						<tr>
							<td><strong>Total Infak</strong></td>
							<td>Rp<?php echo number_format($grand_sedekah,2); ?></td>
						</tr>
					</tbody>
				</table>
				<?php echo form_close(); ?>
				<?php echo form_open('billing');?>
				<input class="button2 fr" type="submit" value="Lanjutkan ke Checkout &raquo;" id="submit" name="submit">
				<?php echo form_close(); ?>
			
			</div>
			<?php endif; ?>
		<!-- END .section -->
		</div>
