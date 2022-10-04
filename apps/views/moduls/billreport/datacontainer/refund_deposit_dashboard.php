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
						"bProcessing":true,
						"sScrollY": "400px",
						"sScrollX": "96%",
						"bScrollCollapse": true,
						"sPaginationType": "full_numbers",
						"aoColumns": [
							{ "mData": "PoDate" },
							{ "mData": "PONumber" },
							{ "mData": "GRNNumber" },
							{ "mData": "itemcode" },			
							{ "mData": "ItemName" },
							{ "mData": "ItemCategory" },
							{ "mData": "Manufacturer" },
							{ "mData": "Vendor" },
							{ "mData": "Qty_Order" },
							{ "mData": "UOMBuy" },
							{ "mData": "Discount" },
							{ "mData": "VAT" },
							{ "mData": "SalesPrice" },
							{ "mData": "PurchasePrice" },
							{ "mData": "TotalPurchase" },
							{ "mData": "QTYGrn" },
							{ "mData": "TotalGRN" }
						]
					} );
				$("#reporttattable").css("width","100%");	
				};

var auto_refresh = setInterval(tbl_data,120000);



</script>