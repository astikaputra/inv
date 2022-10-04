<div class="container-fluid">

<div class="tab-pane active" id="tabs-basic">
							<h3><?php echo $item_name->CodeValue.' - '.$item_name->NameValue; ?></h3>
							<div class="tabbable">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#item-store" data-toggle="tab">Store</a></li>
								</ul>
								<div class="tab-content">
			
			<div class="tab-pane active" id="item-store">
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