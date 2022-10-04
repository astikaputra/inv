<div class="well">
			<table class="table table-striped table-bordered" id="reporttattable"  >
											<thead>
												<tr>
												  <th>PO Date</th>	
												  <th>PO Number</th>	
												  <th>GRN Number</th>
												  <th>Item Code</th>
												  <th>Item Name</th>
												  <th>Item Category</th>
												  <th>Manufacturer</th>
												  <th>Vendor</th>
												  <th>Qty</th>
												  <th>UOM Buy</th>												
												  <th>Discount</th>
												  <th>VAT</th>
												  <th>HNA</th>
												  <th>Purchase Price</th>
												  <th>Total Purchase</th>
												  <th>Qty GRN</th>
												  <th>Total GRN</th>													  
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
						"bProcessing":true
						"sPaginationType": "full_numbers",
						"aoColumns": [
							{ "mData": "RegCode" },
							{ "mData": "BillCode" },
							{ "mData": "pasien" },
							{ "mData": "payer" },			
							{ "mData": "BillDate" },
							{ "mData": "TotalAmount" },
							{ "mData": "deposit" },
							{ "mData": "totalDiscount" },
							{ "mData": "Balances" }
						]
					} );
				$("#reporttattable").css("width","100%");	
				};

var auto_refresh = setInterval(tbl_data,120000);



</script>