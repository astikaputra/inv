<div class="well">
			<table class="table table-striped table-bordered" id="reporttattable"  >
											<thead>
												<tr>
												  <th>Registration Time </th>	
												  <th>Registration Number</th>	
												  <th>Medical Record Number</th>
												  <th>Patient Name</th>
												  <th>Bill No</th>
												  <th>Total GSC</th>
												  <th>First Input GSC</th>
												  <th>Last Input GSC</th>
												  <th>Reg To First GSC</th>
												  <th>GSC Input Time</th>												
												  <th>Last GSC to BILL</th>
												  <th>TAT to Bill</th>
												  <th>TAT to Payment</th>												  
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
							{ "mData": "RegistrationTime" },
							{ "mData": "RegNo" },
							{ "mData": "MedicalRecordNumber" },
							{ "mData": "lastName" },			
							{ "mData": "BillNo" },
							{ "mData": "gsctotal" },
							{ "mData": "FirstGSCInput" },
							{ "mData": "LastGSCInput" },
							{ "mData": "RegtoFirstGSC" },
							{ "mData": "GSCInputTime" },
							{ "mData": "LastGsctoBILL" },
							{ "mData": "TAT_BILL" },
							{ "mData": "TAT_PAYMENT" }
						]
					} );
				$("#reporttattable").css("width","100%");	
				};

var auto_refresh = setInterval(tbl_data,120000);



</script>