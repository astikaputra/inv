 <div class="container-fluid">

      <div class="row-fluid">

      <div class="progress progress-striped active" style="display:none;" id="progressbar">
        <div class="bar" style="width: 0%;"></div>
		</div>	
			<div class="well"  id="date_range">
			 <div class="span4"><img class="medicos_header_logo" src="<?php echo base_url() .
'assets/template/images/medicos.png'; ?>" alt="Medical Information Solution"></div>
			 <div class="span4"></div>
			 <div class="span4"><p class="hospital_logo"><img src="<?php echo base_url() .
'assets/template/icon/logo.png'; ?>" alt="Siloam Hospitals"></p></div>
			
			<legend id="toplegend"><?php echo $content_title; ?> </legend>

			<br />
            
			 <div class="control-group">
			 <a href="<?php $button_action; ?>" class="btn btn-primary" style="display:none;z-index:2; align:right; position: fixed; top: 7em; right: 45px;" id="searchdataagain">Change Report</a>
			
			<?php if ($stock_page == "all_stores") { ?>								
            <table class="table table-bordered" id="stock_grid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Item Code</th>
												  <th>Item Name</th>	
												  <th>Stock Qty</th>
												  <th>Store Name</th>
												  <th>Cost Value</th>
												  <th>Total Cost</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
        foreach ($list_all_store_stock as $stocks) {
            $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $stocks->ItemCode; ?></td>
										<td><?php echo $stocks->ItemName; ?></td>
                                        <td><?php echo $stocks->StockOnHand; ?></td>
										<td><?php echo $stocks->StoreName; ?></td>
										<td><?php echo number_format($stocks->CostValue, 0, ',', '.'); ?></td>
										<td><?php echo number_format($stocks->TotalCost, 0, ',', '.'); ?></td>						
										<?php } ?>
										</tbody>
										
								</table>	
										
								</table>	
			<?php } elseif ($stock_page == "spes_store") { ?>	
		 								<table class="table table-bordered" id="stock_grid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Item Code</th>
												  <th>Item Name</th>	
												  <th>Stock Qty</th>
												  <th>Store Name</th>
												  <th>Cost Value</th>
												  <th>Total Cost</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
        foreach ($list_spec_store_stock as $stocks) {
            $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $stocks->ItemCode; ?></td>
										<td><?php echo $stocks->ItemName; ?></td>
                                        <td><?php echo $stocks->StockOnHand; ?></td>
										<td><?php echo $stocks->StoreName; ?></td>
										<td><?php echo number_format($stocks->CostValue, 0, ',', '.'); ?></td>
										<td><?php echo number_format($stocks->TotalCost, 0, ',', '.'); ?></td>						
										<?php } ?>
										</tbody>
										
								</table>	
	
			<?php } ?>
			 </div>
	   
	    </div>
		  	<div class="row" align="right">
	  		<a href="<?php echo base_url() . 'tools'; ?>" class="btn btn-success">Back To Main Menu</a>
			</div>
	  </div>
			
</div>

<script>
 $(document).ready(function() {
 
 	TableTools.DEFAULTS.aButtons = [
							"copy",
							"print",
							{
								"sExtends":    "collection",
								"sButtonText": 'Save <span class="caret" />',
								"aButtons":    [ "csv", "xls",
								{
								"sExtends": "pdf",
								"sPdfOrientation": "landscape"
								}
								]
							}
						];
						
    TableTools.DEFAULTS.sSwfPath = "<?php echo $this->config->item('template') .
'TableTools'; ?>/media/swf/copy_csv_xls_pdf.swf";

	var stockrep = $('#stock_grid').dataTable({
							"aLengthMenu": [[10, 35, 35, 55, 80,10, 35, 10, 100, -1], [10, 35, 35, 55, 80,10, 35, 10, 100,"All"]],
							"iDisplayLength": 10,
							"sPaginationType": "full_numbers",
							"bAutoWidth": false,
							"sDom": '<"top"i>rt<"bottom"flp><"clear">',
							"sDom": "<T<'span2'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
							"oTableTools": {
							"aButtons": [ "copy","print",
							{
							"sExtends":    "collection",
							"sButtonText": "Save",
							"aButtons":    [ "pdf" ]
							}							
							]
							}
							} );
							
	var stock_allrep = $('#all_stock_grid').dataTable({
							"aLengthMenu": [[-1,25, 50], ["All",25, 50]],							
							"iDisplayLength": 10,
							"sPaginationType": "full_numbers",
							"sScrollY": "400px",
							"sScrollX": "96%",
							"bScrollCollapse": true,
							"bAutoWidth": false,
							"sDom": '<"top"i>rt<"bottom"flp><"clear">',
							"sDom": "<T<'span2'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
							"oTableTools": {
							"aButtons": [ "copy","print",
							{
							"sExtends":    "collection",
							"sButtonText": "Save",
							"aButtons":    [ "pdf" ]
							}							
							]
							}
							} );
	
	});
	
	$("#searchdataagain").show("slow");
	
</script>