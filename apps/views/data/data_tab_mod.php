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
			<div class="tab-pane" id="item-grn" data-url="<?php echo base_url().'item_tracker/detail/'.$item_name->CodeValue.'/GRN';?>">
			</div>
			<div class="tab-pane" id="item-stock" data-url="<?php echo base_url().'item_tracker/detail/'.$item_name->CodeValue.'/STOCK';?>">
			</div>
			<div class="tab-pane" id="item-specialist" data-url="<?php echo base_url().'item_tracker/detail/'.$item_name->CodeValue.'/SPECIALIST';?>">
			</div>
			<div class="tab-pane" id="item-store" data-url="<?php echo base_url().'item_tracker/detail/'.$item_name->CodeValue.'/STORE';?>">
			</div>
			<div class="tab-pane" id="item-po" data-url="<?php echo base_url().'item_tracker/detail/'.$item_name->CodeValue.'/PO';?>">
			</div>
			<div class="tab-pane" id="item-order-price" data-url="<?php echo base_url().'item_tracker/detail/'.$item_name->CodeValue.'/ORDERPRICE';?>">
			</div>
			<div class="tab-pane" id="item-pr" data-url="<?php echo base_url().'item_tracker/detail/'.$item_name->CodeValue.'/PR';?>">
			</div>
								</div><!-- /.tab-content -->
							</div><!-- /.tabbable -->
						</div><!-- .tabs-basic -->
		</div>