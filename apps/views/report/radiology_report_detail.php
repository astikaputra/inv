<div class="well">

			<table class="table table-striped table-bordered" id="reporttattable" style="width:100%" >
											<thead>
												<tr>
												  <th>Date</th>	
												  <?php foreach($service_group as $service)
													{
												  ?>
												  <th><?php echo $service->ServiceGroup?></th>	
												<?php 
													}
												?>
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
							{ "mData": "OrderDate" },							
						 <?php foreach($service_group as $service)
						{?>
												 { "mData": "<?php echo $service->ServiceGroup?>" },
												<?php 
													}
												?>
						]
					} );
			
				};
				





</script>