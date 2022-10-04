<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap -->
<link href="<?php echo $this->config->item('template').'bootstrap/';?>css/bootstrap.min.css" rel="stylesheet" media="screen">
<script src="<?php echo $this->config->item('template').'bootstrap/';?>js/bootstrap-transition.js"></script>
<meta http-Equiv="Cache-Control" Content="no-cache">
    <meta http-Equiv="Pragma" Content="no-cache">
    <meta http-Equiv="Expires" Content="0">
	
</head>
<body>
<div class="container">

<div class="tab-pane active" id="tabs-basic">
							<h3><?php echo $item_name->CodeValue.' - '.$item_name->NameValue; ?></h3>
							
							
							
							<div class="tabbable">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#item-price" data-toggle="tab">Price</a></li>
									<li><a href="#item-grn" data-toggle="tab">(GRN) Goods Receive Notes </a></li>
									<li><a href="#item-stock" data-toggle="tab">Stock </a></li>
									<li><a href="#item-specialist" data-toggle="tab">Specialist</a></li>
									<li><a href="#item-store" data-toggle="tab">Store</a></li>
								
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="item-price">
			<table class="table table-striped">
              <thead><tr><th>Class</th><th>Harga/ Price</th></tr> </thead>
              <tbody> 
			  <?php foreach($item_price as $item)
			  {?>
			  <tr><td>  <?php echo $item->PriceClass;?></td><td>Rp. <?php echo number_format($item->PriceAmount); ?></td> </tr>
			  <?php } ?>
             
              </tbody>
            </table>
									</div>
									<div class="tab-pane" id="item-grn">
			<table class="table table-striped">
              <thead><tr><th>Nomor PO</th><th>Nomor GRN</th><th>PO QTY</th> <th>GRN QTY</th> <th>Expired Date</th> <th>Batch Number</th></tr> </thead>
              <tbody> 
			<?php foreach($item_grn as $item)
			  {?>
			  <tr><td><?php echo $item->nomor_po;?></td><td><?php echo $item->nomor_grn;?></td>
			  <td><?php echo round($item->QtyPo);?></td><td><?php echo round($item->QtyGrn);?></td>
			  <td><?php echo $item->ExpiredDate;?></td><td><?php echo $item->BatchNumberLocal;?></td>
			</tr>
			  <?php } ?>
              </tr>
              </tbody>
            </table></div>
			<div class="tab-pane" id="item-stock">
			<table class="table table-striped">
              <thead><tr><th>BarCode</th><th>StoreName</th><th>QtyOnHand</th></tr> </thead>
              <tbody> 
			<?php foreach($item_stock as $item)
			  {?>
			  <tr><td><?php echo $item->BarCode;?></td>
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
								</div><!-- /.tab-content -->
							</div><!-- /.tabbable -->
						</div><!-- .tabs-basic -->
		</div>

	<script src="<?php echo $this->config->item('template').'js/';?>jquery.min.js"></script>
    <script src="<?php echo $this->config->item('template').'bootstrap/';?>js/bootstrap.min.js"></script>
</body>
</html>	