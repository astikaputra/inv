<div class="well">

					<a href="#" class="btn btn-primary" style="align:left; position: fixed; top: 10em; left: 50%;margin-left:-55px;z-index:10;" id="refreshdata" onclick="refresh_data()">Refresh Data</a>

			<table class="table table-striped table-bordered" id="reporttattable" style="width:100%" >
											<thead>
												<tr>
												  <th>Order Date </th>	
												  <th>Registration No.</th>	
												  <th>MR No.</th>
												  <th>Patient Name</th>
												  <th>Gender</th>
												  <th>DOB</th>
												  <th>Service Code</th>
												  <th>Service Name</th>
												  <th>Action</th>
												</tr>
											 </thead>
										<tbody>
										
										</tbody>
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
							{ "mData": "RegCode" },
							{ "mData": "MedicalRecordNumber" },
							{ "mData": "PatientName" },			
							{ "mData": "Gender" },
							{ "mData": "Birthdate" },
							{ "mData": "ServiceCode" },
							{ "mData": "ServiceName" },
							{ "mData": "QueueStatesId" }
						],
            "aoColumnDefs": [
                                {
                                    "fnRender": function (o) {
									var StatesId = o.aData['QueueStatesId'];
                                        return '<a class="btn btn-mini btn-warning" href=activate_order/'+StatesId+'> Confirm Order</a>';
                                    },
                                    "aTargets": [8]
                                }
                        ]
					} );
			
				};
				
function refresh_data()
				{

				var oTable = $('#reporttattable').dataTable( {
						"bProcessing": true,
						"sAjaxSource": "<?php echo $datasource; ?>",
						"bDestroy": true,
						"bProcessing":true,
						"sPaginationType": "full_numbers",
						"aoColumns": [
							{ "mData": "OrderDate" },
							{ "mData": "RegCode" },
							{ "mData": "MedicalRecordNumber" },
							{ "mData": "PatientName" },			
							{ "mData": "Gender" },
							{ "mData": "Birthdate" },
							{ "mData": "ServiceCode" },
							{ "mData": "ServiceName" },
							{ "mData": "QueueStatesId"}
						],
            "aoColumnDefs": [
                                {
                                    "fnRender": function (o) {
									var StatesId = o.aData['QueueStatesId'];
                                        return '<a class="btn btn-mini btn-warning" href=activate_order/'+StatesId+'>Confirm Order</a>';
                                    },
                                    "aTargets": [8]
                                }
                        ]
					} );
				$('#reporttattable').width('100%');
			
				
				}

</script>