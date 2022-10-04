<div class="well">
			<table class="table table-striped table-bordered" id="reporttattable"  >
											<thead>
												<tr>
												  <th>Item Code</th>	
												  <th>Item Name</th>	
												  <th>Item Category</th>
												  <th>Manufacturer</th>
												  <th>Supplier Name</th>
												  <th>Qty</th>
												  <th>Total Avg Cost</th>
												  <th>Total Sales</th>											  
												</tr>
											 </thead>
										<tbody></tbody>
								</table>
</div>

<script>
tbl_data();
function tbl_data(){			
						var oTable = $('#reporttattable').dataTable( {
						"bProcessing": true,
						"sAjaxSource": "<?php echo $datasource; ?>",
						"bDestroy": true,
						"bProcessing":true,
						"sPaginationType": "full_numbers",
						"aoColumns": [
							{ "mData": "Itemcode" },
							{ "mData": "ItemName" },
							{ "mData": "ItemCategory" },
							{ "mData": "Manufacturer" },			
							{ "mData": "SupplierName" },
							{ "mData": "Qty" },
							{ "mData": "Total_AvgCost" },
							{ "mData": "TotalSales" }
						]
					} );
				$("#reporttattable").css("width","100%");	
				};

var auto_refresh = setInterval(tbl_data,120000);



</script>