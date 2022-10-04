<style>
.container-fluid
{
background-color:#fff;
}
</style>
<div class="container-fluid">
<div class="row-fluid">
<br />
<img class="medicos_header_logo" src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution">
<p class="hospital_logo"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></p>
<h3>Patient Data Sheet Report From <?php echo date('d M Y',strtotime($startdate)); ?> Until <?php echo date('d M Y',strtotime($enddate));?> </h3>
<br /><br />

<table class="table table-striped table-bordered">
        <thead>
                 <tr>
                  <th>Patient Name</th>
				  <th>MR. Number</th>
				  <th>DOB / Age</th>
				  <th>Gender</th>
				  <th>Admit Date</th>
				  <th>Room Name / Bed</th>
				  <th>Payer</th>
				  <th>Primary Doctor</th>
				 </tr>
              </thead>
              <tbody>
			  
			    <?php 
					foreach ($patient_sheet_data as $sheet_data) { ?>
					 <tr>
					 <td><b><?php echo $sheet_data->PatientName;?></b></td>
					 <td><?php echo $sheet_data->MedicalRecordNumber;?></td>
					 <td><?php echo date('d-m-Y',strtotime($sheet_data->Birthdate)) ?><br/><b> 
					 <?php if($sheet_data->Age == 0) { echo $sheet_data->AgeDetail;} else { echo $sheet_data->Age;}?></b></td>
					 <td><?php echo $sheet_data->Gender;?></td>
					 <td><?php echo date('d-m-Y H:i:s',strtotime($sheet_data->AdmitDate)); ?></td>					 
					 <td><?php echo $sheet_data->RoomName; ?><br/><?php echo $sheet_data->BedName;?></td>			
					 <td><?php echo $sheet_data->Payer;?></td>
					 <td><?php echo $sheet_data->DoctorName;?></td>
					 </tr>                    
				 <?php }; ?>
				 
			</tbody>
    </table>
</div>

<div class="row">
	    <div class="span12 back">
						<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Menu</a>
		</div>
</div>
</div>