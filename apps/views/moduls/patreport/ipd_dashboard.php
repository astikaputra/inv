<div class="container-fluid">
<div class="row-fluid">
			<div class="well">
			 <div class="col-md-4"><img class="medicos_header_logo" src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution"></div>
			 <div class="col-md-4"></div>
			 <div class="col-md-4"><p class="hospital_logo"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></p></div>

<h3 class="text-center">Nutrition Dashboard</h3>

<table class="table table-striped table-bordered">
        <thead>
                <tr>
                  <th>Patient Name</th><th>Medical Record</th><th>Doctor Name</th><th>Diagnose</th><th>Room</th><th>Bed Name</th><th>Bed Status</th><th>Class</th><th>Ward/Floor</th><th>Admit Date</th>
                </tr>
        </thead>
            <tbody>
			<?php foreach($listbedstatus as $items) 
			  {?>
                <tr>
                  <td><b><?php echo $items->PatientName;?></b></td>
				  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo $items->DoctorName;?></td>
				  <td><a class='btn btn-danger disabled'><?php echo $items->Diagnosis;?></a></td>
				  <td><?php echo $items->RoomName;?></td>
				  <td><?php echo $items->BedName;?></td>
				  <td><a class=' <?php if($items->BedStatus=='Vacant')
											{echo 'btn btn-success disabled';}
										else if($items->BedStatus=='Alloted Not Occupied')
											{echo 'btn btn-warning disabled';}
										else if($items->BedStatus=='Released Not Vacated')
											{echo 'btn btn-inverse disabled';}
										else if($items->BedStatus=='Occupied')
											{echo 'btn btn-primary disabled';}
											?>'><?php echo $items->BedStatus;?></a></td>
				  <td><?php echo $items->WardName;?></td>
				  <td><?php echo $items->Floor;?></td>
				  <td><?php echo date('d-m-Y H:i:s', strtotime($items->AdmitDate)); ?></td>
				 </tr> 
			<?php }?>
			</tbody>
</table>
  
  <div class="row">
	    <div class="col-md-12 back">
						<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Menu</a>
		</div>	
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
					
					});
 </script>

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
							{ "mData": "PatientName" },
							{ "mData": "MedicalRecordNumber" },
							{ "mData": "Diagnosis" },
							{ "mData": "RoomName" },
							{ "mData": "BedName" },
							{ "mData": "BedStatus" },
							{ "mData": "WardName" },
							{ "mData": "Floor" },
							{ "mData": "AdmitDate" }
						]
					} );
				$("#reporttattable").css("width","100%");	
				};

var auto_refresh = setInterval(tbl_data,120000);



</script>		
