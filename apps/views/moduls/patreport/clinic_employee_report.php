<div class="container-fluid">
<div class="row-fluid">
<div class="well">
			 <div class="col-md-4"><img class="medicos_header_logo" src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution"></div>
			 <div class="col-md-4"></div>
			 <div class="col-md-4"><p class="hospital_logo"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></p></div>

<h3 class="text-center">Employee Clinic Daily Report Dashboard</h3>

<table class="table table-bordered" id="employee_mcu">
        <thead>
                <tr>
					<th>Reg. No.</th>
					<th>Reg.Time</th>
					<th>Patient Name</th>
					<th>Sex</th>
					<th>Birthdate</th>
					<th>Age</th>
					<th>Address</th>
					<th>Identity Type</th>
					<th>Identity Number</th>
					<th>PhoneNumber</th>
					<th>Doctor Code</th>
					<th>Doctor Name</th>
					<th>Sub. Specialist</th>
					<th>Specialist</th>
					<th>Group Specialist</th>
                </tr>
        </thead>
            <tbody>
			<?php foreach($clinic_employee_report as $items) 
			  {?>
                <tr>
                  <td><?php echo $items->RegistrationCode;?></td>
                  <td><?php echo date('d-m-Y H:i:s', strtotime($items->RegistrationTime));?></td>
				  <td><b><?php echo $items->PatientName;?></b></td>
				  <td><?php echo $items->Gender;?></td>
				  <td><?php echo $items->Birthdate;?></td>
				  <td><?php echo $items->Age;?></td>
				  <td><?php echo $items->Address;?></td>
				  <td><?php echo $items->IdentityType;?></td>
				  <td><?php echo $items->IdentityCardbNumber;?></td>
				  <td><?php echo $items->PhoneNumber;?></td>
				  <td><?php echo $items->DoctorsCode;?></td>
				  <td><?php echo $items->DoctorName;?></td>
				  <td><?php echo $items->SubSpecialist;?></td>
				  <td><?php echo $items->Specialist;?></td>
				  <td><?php echo $items->SpecialistGroup;?></td>
				 </tr> 
			<?php }; ?>
			</tbody>
</table>
  
  <div class="row">
	    <div class="col-md-12 back">
						<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Menu</a>
		</div>	
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


	var employee_mcu_rep = $('#employee_mcu').dataTable({
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