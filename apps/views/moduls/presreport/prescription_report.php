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
			 <a href="<?php $button_action; ?>" class="btn btn-primary" style="display:none;z-index:2; align:right; position: fixed; top: 7em; right: 45px;" id="searchdataagain">Change Report</a>

			<?php if ($prescription_page == "prescription_page_rep") { ?>								
            <table class="table table-bordered" id="finance_docgrid"  >
											<thead>
												<tr>
												  <th>Bill Date</th>	
												  <th>Patient Name</th>
												  <th>Doctor Name</th>
												  <th>Prescription</th>
												  <th>Item Code</th>
												  <th>Item Name</th>
												  <th>Qty Prescribed</th>
												  <th>Qty</th>
												  <th>Purchase Price</th>
												  <th>Total Purchase Order</th>
												  <th>Selling Price</th>
												  <th>Total Selling Price</th>
												  <th>Margin Class</th>
												  <th>Identity Card Types</th>
												  <th>Is Retail</th>
												  <th>Site</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
    foreach ($prescription_page_data as $prescription_pag) {
        $i++; ?>
										<tr>						
										<td><?php echo date('d-m-Y', strtotime($prescription_pag->billdate)); ?></td>
										<td><?php echo $prescription_pag->patientName; ?></td>
										<td><?php echo $prescription_pag->DoctorName; ?></td>
										<td><?php echo $prescription_pag->prescription; ?></td>
										<td><?php echo $prescription_pag->itemcode; ?></td>
										<td><?php echo $prescription_pag->ItemName; ?></td>										
										<td><?php echo $prescription_pag->QtyofDrugsPrescribed; ?></td>
										<td><?php echo $prescription_pag->QtyofDrugsFulfilled; ?></td>
										<td><?php echo $prescription_pag->PurchasePrice; ?></td>
										<td><?php echo $prescription_pag->TotalPurchaseOrder; ?></td>
										<td><?php echo $prescription_pag->SellingPrice; ?></td>
										<td><?php echo $prescription_pag->TotalSellingPrice; ?></td>
										<td><?php echo $prescription_pag->MarginClass; ?></td>
										<td><?php echo $prescription_pag->IdentityCardTypes; ?></td>
										<td><?php echo $prescription_pag->isretail; ?></td>
										<td><?php echo $prescription_pag->site; ?></td>
										</tr>
										<?php } ?>
										</tbody>
								</table>				
<?php } ?>				
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