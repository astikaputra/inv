<div class="container-fluid">

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
              <thead><tr><th>Class</th><th>Harga/ Price</th> <th> Passport </th> <th> Kitas </th></tr> </thead>
              <tbody> 
			  <?php foreach($item_service_price as $item)
			  {?>
			  <tr><td>  <?php echo $item->PriceClass;?></td><td>Rp. <?php echo number_format($item->PriceAmount); ?></td> 
			  <td>Rp. <?php echo number_format($item->PricePassport); ?></td><td>Rp. <?php echo number_format($item->PriceKitas); ?></td>
			  </tr>
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
