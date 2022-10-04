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
									<li><a href="#item-specialist" data-toggle="tab">Specialist</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="item-price">
			<table class="table table-striped">
              <thead><tr><th>Class</th><th>Harga/ Price</th></tr> </thead>
              <tbody> 
			  <?php foreach($item_service_price as $item)
			  {?>
			  <tr><td>  <?php echo $item->PriceClass;?></td><td>Rp. <?php echo number_format($item->PriceAmount); ?></td> </tr>
			  <?php } ?>
             
              </tbody>
            </table>
			</div>
			
			<div class="tab-pane" id="item-specialist">
			<table class="table  table-striped">
              <thead><tr><th>Kode Spesialist</th><th> Specialist </th></tr> </thead>
              <tbody> 
			 <?php foreach($item_service_specialist as $item)
			  {?>
			  <tr><td><?php echo $item->CodeValue;?></td>
			  <td><?php echo $item->NameValue;?></td>
			</tr>
			  <?php } ?>
              </tr>
              </tbody>
            </table></div>
			
								</div><!-- /.tab-content -->
							</div><!-- /.tabbable -->
						</div><!-- .tabs-basic -->
		</div>

	<script src="<?php echo $this->config->item('template').'js/';?>jquery.min.js"></script>
    <script src="<?php echo $this->config->item('template').'bootstrap/';?>js/bootstrap.min.js"></script>
</body>
</html>	