<div class="container-fluid">

<div class="tab-pane active" id="tabs-basic">
							<h3><?php echo $item_name->CodeValue.' - '.$item_name->NameValue; ?></h3>
							<div class="tabbable">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#item-price" data-toggle="tab">Price</a></li>
									<li><a href="#item-stock" data-toggle="tab">Stock </a></li>
									<li><a href="#item-specialist" data-toggle="tab">Specialist</a></li>
									<li><a href="#item-store" data-toggle="tab">Store</a></li>
									<li><a href="#item-grn" data-toggle="tab">GRN</a></li>
									<li><a href="#item-order-price" data-toggle="tab">Order Price</a></li>
									<li><a href="#item-po" data-toggle="tab">Purchase Orders</a></li>
									<li><a href="#item-pr" data-toggle="tab">Purchase Requisition</a></li>
								
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="item-price">
			<table class="table table-striped">
              <thead><tr><th>Class</th><th>Harga/ Price</th><th>Harga/ Price With Passport</th><th>Harga/ Price With KITAS</th></tr> </thead>
              <tbody> 
			  <?php foreach($item_price as $item)
			  {?>
			  <tr><td>  <?php echo $item->price_class;?></td><td>Rp. <?php echo number_format($item->price_amount); ?></td> 
			  <td>Rp. <?php echo number_format($item->price_passport); ?></td> <td>Rp. <?php echo number_format($item->price_kitas); ?></td> </tr>
			  <?php } ?>
             
              </tbody>
            </table>
			</div>
			<div class="tab-pane" id="item-grn">
			<table class="table table-striped">
              <thead><tr><th>Nomor PO</th><th>Nomor GRN</th><th>GRN DATE</th><th>PO QTY</th> <th>GRN QTY</th> <th>Expired Date</th> <th>Batch Number</th></tr> </thead>
              <tbody> 
			<?php foreach($item_grn as $item)
			  {?>
		 	 <tr><td><?php echo $item->nomor_po;?></td><td><?php echo $item->nomor_grn;?></td>
			 <td><?php echo $item->GrnDate;?></td>
			  <td><?php echo round($item->QtyPo);?></td><td><?php echo round($item->QtyGrn);?></td>
			  <td><?php echo $item->ExpiredDate;?></td><td><?php echo $item->BatchNumberLocal;?></td>
			</tr>
	  		<?php } ?>
              </tr>
              </tbody>
            </table></div>
			<div class="tab-pane" id="item-stock">
			<table class="table table-striped">
              <thead><tr><th>Item Code</th><th>StoreName</th><th>QtyOnHand</th></tr> </thead>
              <tbody> 
			<?php foreach($item_stock as $item)
			  {?>
			  <tr><td><?php echo $item->ItemCode;?></td>
			  <td><?php echo $item->StoreName;?></td>
			  <td><?php echo $item->QtyOnHand;?></td>
			</tr>
			  <?php } ?>
              </tbody>
            </table></div>
			<div class="tab-pane" id="item-specialist">
			<table class="table  table-striped">
              <thead><tr><th>Kode Spesialist</th><th> Specialist </th><th>Group Spesialist</th></tr> </thead>
              <tbody> 
			 <?php foreach($item_specialist as $item)
			  {?>
			  <tr><td><?php echo $item->CodeValue;?></td>
			  <td><?php echo $item->NameValue;?></td>
			  <td><?php echo $item->specialist_group;?></td>
			</tr>
			  <?php } ?>
              </tr>
              </tbody>
            </table></div>
			
			<div class="tab-pane" id="item-store">
			<table class="table  table-striped">
              <thead><tr><th>Store Name</th></thead>
              <tbody> 
			 <?php foreach($item_store as $item)
			  {?>
			  <tr><td><?php echo $item->StoreName;?></td></tr>
			  <?php } ?>
            </table></div>
			
			<div class="tab-pane" id="item-po">
			<table class="table table-striped">
              <thead><tr><th>Nomor PO</th><th>Tanggal</th><th>Nama Supplier</th></tr> </thead>
              <tbody> 
			<?php foreach($item_po as $item)
			  {?>
			  <tr><td><?php echo $item->nomor_po;?></td>
			  <td><?php echo $item->tanggal;?></td>
			  <td><?php echo $item->supplier;?></td>
			</tr>
			  <?php } ?>
              </tr>
              </tbody>
            </table></div>
			
			<div class="tab-pane" id="item-order-price">
			<table class="table table-striped">
              <thead><tr><th>Supplier</th><th>Order Price</th><th>Discount</th> <th>Order Qty</th> <th>Convertion</th></tr> </thead>
              <tbody> 
			<?php foreach($item_order_price as $item)
			  {?>
			  <tr><td><?php echo $item->supplier;?></td><td><?php echo round($item->order_price);?></td>
			  <td><?php echo round($item->order_discount);?></td><td><?php echo round($item->order_qty);?></td>
			  <td><?php echo $item->convertion;?></td>
			</tr>
			  <?php } ?>
              </tr>
              </tbody>
            </table></div>
			
			<div class="tab-pane" id="item-pr">
			<table class="table table-striped">
              <thead><tr><th>Nomor PR</th><th>Release Date</th><th>Request By</th> <th>Need Time</th> <th>Store</th> <th>Is Cito</th> <th>Qty</th></tr> </thead>
              <tbody> 
			<?php foreach($item_pr as $item)
			  {?>
			  <tr><td><?php echo $item->pr_code;?></td><td><?php echo $item->released_date;?></td>
			  <td><?php echo $item->request_by;?></td><td><?php echo $item->need_date;?></td>
			  <td><?php echo $item->stores;?></td><td><?php echo $item->iscito;?></td>
			  <td><?php echo $item->qty;?></td>
			</tr>
			  <?php } ?>
              </tr>
              </tbody>
            </table></div>
								</div><!-- /.tab-content -->
							</div><!-- /.tabbable -->
</div><!-- .tabs-basic -->
		
</div>