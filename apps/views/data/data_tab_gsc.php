<div class="container-fluid">

<div class="tab-pane active" id="tabs-basic">
							<h3><?php echo $patient->MedicalRecordNumber.' - '.$patient->PatientName; ?></h3>
							<div class="tabbable">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#opd" data-toggle="tab">OPD</a></li>
									<li><a href="#ipd" data-toggle="tab">IPD</a></li>
									<li><a href="#etc" data-toggle="tab">ETC</a></li>
									<li><a href="#mcu" data-toggle="tab">MCU</a></li>
									<li><a href="#other" data-toggle="tab">All</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="opd">
			<table class="table table-striped">
              <thead><tr><th>Item/Service Name</th><th>Category</th><th>Quantity</th><th>Cost</th><th>Create Date</th></tr> </thead>
              <tbody> 
			  <?php foreach($gsc_opd as $item)
			  {?>
			  <tr><td>  <?php echo $item->NameValue;?></td><td>  <?php echo $item->Category;?></td><td>  <?php echo $item->Qty;?></td><td>Rp. <?php echo number_format($item->Cost); ?></td> </tr>
			  <?php } ?>
             
              </tbody>
            </table>
			</div>
			
			<div class="tab-pane" id="ipd">
			<table class="table table-striped">
              <thead><tr><th>Item/Service Name</th><th>Category</th><th>Quantity</th><th>Cost</th><th>Create Date</th></tr> </thead>
              <tbody> 
			  <?php foreach($gsc_ipd as $item)
			  {?>
			  <tr><td>  <?php echo $item->NameValue;?></td><td>  <?php echo $item->Category;?></td><td>  <?php echo $item->Qty;?></td><td>Rp. <?php echo number_format($item->Cost); ?></td><td>  <?php echo $item->CreatedDate;?></td> </tr>
			  <?php } ?>
             </tbody>
            </table></div>
			
			<div class="tab-pane" id="etc">
			<table class="table table-striped">
              <thead><tr><th>Item/Service Name</th><th>Category</th><th>Quantity</th><th>Cost</th><th>Create Date</th></tr> </thead>
              <tbody> 
			  <?php foreach($gsc_etc as $item)
			  {?>
			  <tr><td>  <?php echo $item->NameValue;?></td><td>  <?php echo $item->Category;?></td><td>  <?php echo $item->Qty;?></td><td>Rp. <?php echo number_format($item->Cost); ?></td> <td>  <?php echo $item->CreatedDate;?></td></tr>
			  <?php } ?>
             </tbody>
            </table></div>
			
			<div class="tab-pane" id="mcu">
			<table class="table table-striped">
              <thead><tr><th>Item/Service Name</th><th>Category</th><th>Quantity</th><th>Cost</th><th>Create Date</th></tr> </thead>
              <tbody> 
			  <?php foreach($gsc_mcu as $item)
			  {?>
			  <tr><td>  <?php echo $item->NameValue;?></td><td>  <?php echo $item->Category;?></td><td>  <?php echo $item->Qty;?></td><td>Rp. <?php echo number_format($item->Cost); ?></td><td>  <?php echo $item->CreatedDate;?></td> </tr>
			  <?php } ?>
             </tbody>
            </table></div>
			
			<div class="tab-pane" id="other">
			<table class="table table-striped">
              <thead><tr><th>Item/Service Name</th><th>Category</th><th>Quantity</th><th>Cost</th><th>Create Date</th></tr> </thead>
              <tbody> 
			  <?php foreach($gsc_other as $item)
			  {?>
			  <tr><td>  <?php echo $item->NameValue;?></td><td>  <?php echo $item->Category;?></td><td>  <?php echo $item->Qty;?></td><td>Rp. <?php echo number_format($item->Cost); ?></td><td>  <?php echo $item->CreatedDate;?></td> </tr>
			  <?php } ?>
             </tbody>
            </table></div>

								</div><!-- /.tab-content -->
							</div><!-- /.tabbable -->
						</div><!-- .tabs-basic -->
		</div>