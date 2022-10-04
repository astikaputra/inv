<div class="well">			
 			<table class="table table-striped table-bordered" id="reporttattable"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Bill Date</th>	
												  <th>Bill Create Date</th>
												  <th>Bill No.</th>
												  <th>Reg. No.</th>
												  <th>Reg.Time</th>
												  <th>Patient Name</th>
												  <th>Sex</th>
												  <th>Birthdate</th>
												  <th>Age</th>
												  <th>Address</th>
												  <th>ID Types</th>
												  <th>Nationality</th>
												  <th>LOB</th>
												  <th>Doctor Code</th>
												  <th>Doctor Name</th>
												  <th>Ref. Doctor</th>
												  <th>Sub. Specialist</th>
												  <th>Specialist</th>
												  <th>Group Specialist</th>
												  <th>Room</th>
												  <th>Class</th>
												  <th>Item Code</th>
												  <th>Service Code</th>
												  <th>Service Name</th>
												  <th>Service LOS</th>
												  <th>Qty</th>
												  <th>Item Price</th>
												  <th>Bill Amount</th>
												  <th>Payer Amount</th>
												  <th>Doctor Fee</th>
												  <th>Discount</th>
												  <th>Payer Name</th>
												  <th>PayerType</th>
												  <th>Payment Method</th>
												  <th>Status</th>
												  <th>Is Retail</th>
												  <th>Triage</th>
												  <th>Admit Date</th>
												  <th>PaymentStatus</th>
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
							{ "mData": "billdate" },
							{ "mData": "Billcreateddate" },
							{ "mData": "BillNo" },
							{ "mData": "RegistCode" },			
							{ "mData": "RegistrationTime" },
							{ "mData": "patientName" },
							{ "mData": "gender" },
							{ "mData": "birthdate" },
							{ "mData": "age" },
							{ "mData": "Address" },
							{ "mData": "IdentityCardTypes" },
							{ "mData": "Nationality" },
							{ "mData": "LOB" }
							{ "mData": "AxdoctorCode" },
							{ "mData": "DoctorName" },
							{ "mData": "ReferingDoctor" },
							{ "mData": "SubSpecialistName" },			
							{ "mData": "specialistName" },
							{ "mData": "GroupSpecialistName" },
							{ "mData": "ROOM" },
							{ "mData": "MarginClass" },
							{ "mData": "Itemcode" },
							{ "mData": "ServiceCode" },
							{ "mData": "DescName" },
							{ "mData": "LOSName" },
							{ "mData": "Qty" }
							{ "mData": "ItemPrice" },
							{ "mData": "BillAmount" },
							{ "mData": "PayerAmount" },
							{ "mData": "DoctorFee" },			
							{ "mData": "Discount" },
							{ "mData": "PayerName" },
							{ "mData": "payertype" },
							{ "mData": "PaymentMethod" },
							{ "mData": "Status" },
							{ "mData": "isretail" },
							{ "mData": "triage" },
							{ "mData": "Admitdate" },
							{ "mData": "PaymentStatus" }
						]
					} );
				$("#reporttattable").css("width","100%");	
				};

var auto_refresh = setInterval(tbl_data,120000);



</script>						