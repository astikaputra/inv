 <div class="container-fluid">

      <div class="row-fluid">

      <div class="progress progress-striped active" style="display:none;" id="progressbar">
        <div class="bar" style="width: 0%;"></div>
		</div>	
			<div class="well" id="date_range">
			 <div class="span4"><img class="medicos_header_logo" src="<?php echo base_url() .
'assets/template/images/medicos.png'; ?>" alt="Medical Information Solution"></div>
			 <div class="span4"></div>
			 <div class="span4"><p class="hospital_logo"><img src="<?php echo base_url() .
'assets/template/icon/logo.png'; ?>" alt="Siloam Hospitals"></p></div>

			<legend id="toplegend"><?php echo $content_title; ?> </legend>
			<br />
			 <div class="control-group">
			 <a href="<?php echo base_url() . 'bill_report/get_bill_filter'; ?>" class="btn btn-primary" style="display:none;z-index:2; align:right; position: fixed; top: 7em; right: 45px;" id="searchdataagain">Change Report</a>

			<?php if ($billing_page == "revenue_all") { ?>								
            <table class="table table-striped table-bordered">
											<thead>
												<tr>
												  <th>Reg. No.</th>	
												  <th>Bill No.</th>
												  <th>Payer</th>
												  <th>Patient Name</th>
												  <th>Bill Amount</th>
												  <th>Received Amount</th>
												  <th>Discount</th>
												  <th>Balance</th>							  
												</tr>
											 </thead>
										<tbody>

										<?php $totalbalance = 0;
										 foreach ($outstanding_data as $bills) { ?>
										<tr>
					 					<td><?php echo $bills->RegCode;?></td>
					 					<td>
					 					<small>
					 					<?php foreach ($this->bill_model->get_outbill_detail($bills->regid) as $billrow) { ?>
					 					<?php echo $billrow->BillCode .'-> Rp. '. $billrow->TotalAmount . '<br />' ?>
					 					<?php }; ?>
										</small>
					 					</td>
										<td>
										<small>
					 					<?php foreach ($this->bill_model->get_outbill_payer($bills->regid) as $billpayer) { ?>
					 					<?php echo $billpayer->payer .'-> Rp. '. $billpayer->TotalAmount . '<br />' ?>
					 					<?php }; ?>
										</small>
										</td>
					 					<td><?php echo $bills->pasien; ?></td>
				 						<td>
					 					<?php foreach ($this->bill_model->count_total_bill($bills->regid) as $totalbill) { ?>
					 					<?php echo $totalbill->GrandTotAmount . '<br />' ?>
					 					<?php }; ?>				 							
				 						</td>
										<td>
									 	<?php foreach ($this->bill_model->count_total_deposit($bills->regid) as $totaldepo) { ?>
					 					<?php echo $totaldepo->GrandTotDeposit . '<br />' ?>
					 					<?php }; ?>	
										</td>
										<td>
										<?php foreach ($this->bill_model->count_total_discount($bills->regid) as $totaldisc) { ?>
					 					<?php echo $totaldisc->GrandTotDiscount . '<br />' ?>
					 					<?php }; ?>	
										
										</td>
					 					<td>
								<?php
										$balance=  $totalbill->GrandTotAmount  - $totaldepo->GrandTotDeposit - $totaldisc->GrandTotDiscount;
												$result_balance = number_format ($balance,2,'.','');
												echo "Rp &nbsp".$result_balance;?>
										</td>
					 					</tr>
					 					<?php }; ?>

										</tbody>
										
								</table>
	<?php } else
    if ($billing_page == "deposit_report") { ?>								
            <table class="table table-bordered" id="finance_grid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Deposit Date</th>	
												  <th>Registration No.</th>
												  <th>Patient Name</th>
												  <th>Reciept No.</th>
												  <th>Username</th>
												  <th>Card No.</th>
												  <th>Payment Name</th>
												  <th>Ammount</th>
												  <th>Availed</th>
												  <th>Balance</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
    foreach ($deposit_data as $bills) {
        $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo date('d-m-Y', strtotime($bills->billdate)); ?></td>
										<td><?php echo date('d-m-Y H:i:s', strtotime($bills->
        Billcreateddate)); ?></td>
										<td><?php echo $bills->BillNo; ?></td>
										<td><?php echo $bills->RegistCode; ?></td>
										<td><?php echo date('d-m-Y H:i:s', strtotime($bills->
        RegistrationTime)); ?></th>
										<td><?php echo $bills->patientName; ?></td>
										<td><?php echo $bills->gender; ?></td>
										<td><?php echo date('d-m-Y', strtotime($bills->birthdate)); ?></td>
										<td><?php echo $bills->age; ?></td>
										<td><?php echo $bills->Address; ?></td>
										<td><?php echo $bills->IdentityCardTypes; ?></td>										
										<?php } ?>
										</tbody>
										
								</table>
       	<?php } else
    if ($billing_page == "refund_deposit_report") { ?>								
            <table class="table table-bordered" id="finance_grid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Receipt No.</th>	
												  <th>Date</th>
												  <th>Registration No.</th>
												  <th>Patient Name</th>
												  <th>Discharge Date</th>
												  <th>Deposit</th>
												  <th>Bill Ammount</th>
												  <th>Deposit Refunds</th>
												  <th>Payment Name</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
    foreach ($refund_deposit_data as $bills) {
        $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->billdate)); ?></td>
										<td><?php echo date('d-m-Y H:i:s', strtotime($revenues->Billcreateddate)); ?></td>
										<td><?php echo $revenues->BillNo; ?></td>
										<td><?php echo $revenues->RegistCode; ?></td>
										<td><?php echo date('d-m-Y H:i:s', strtotime($revenues->RegistrationTime)); ?></th>
										<td><?php echo $revenues->patientName; ?></td>
										<td><?php echo $revenues->gender; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->birthdate)); ?></td>
										<td><?php echo $revenues->age; ?></td>					
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

	var financerep = $('#finance_grid').dataTable({
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
	
	var finance_docrep = $('#finance_docgrid').dataTable({
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
    						

	var finance_revenue = $("#finance_revenue_detail").dataTable( {
					"aLengthMenu": [[10,25, 50,100,-1], [10,25,50,100,"All"]],
					"iDisplayLength": 10,
					"sPaginationType": "full_numbers",
					"sScrollY": "400px",
					"sScrollX": "96%",
					"bScrollCollapse": true,
					"bAutoWidth": false,
					"sDom": '<"top"i>rt<"bottom"flp><"clear">',
					"sDom": 'T<"clear">pfrtli',							
					"oTableTools": {
					"aButtons": [ "copy","print",
							{
							"sExtends":    "collection",
							"sButtonText": "Save",
							"aButtons":    [ "pdf" ]
							}							
							]
							}					
					} ).columnFilter({ sPlaceHolder: "head",
					aoColumns: [ { type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },
                                 { type: "select", values: [ 'OPD', 'IPD', 'ETC', 'MCU']},
								 { type: "text" },{ type: "text" },{ type: "text" },
								 { type: "text" },{ type: "text" },{ type: "number-range" },
								 { type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },
								 { type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },
								 { type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" }

								   
						]
					
					});
    
	});
	
	$("#searchdataagain").show("slow");
	
</script>