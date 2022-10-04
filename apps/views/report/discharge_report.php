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
<h3>Monthly Patient Discharge Report From <?php echo date('M Y',strtotime($repmoyr)); ?> </h3>
<br /><br />
<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#daily1" data-toggle="tab">Monthly Patient Discharge</a></li>
	<li><a href="#daily2" data-toggle="tab">Monthly Patient Discharge at < 10:00</a></li>
  </ul>

 <div class="tab-content">
    <div id="daily1" class="tab-pane active">
<table class="table table-striped table-bordered">
        <thead>
                 <tr>
                  <th>Registration Code</th>
				  <th>MR Number</th>
				  <th>Patient Name</th>
				  <th>Doctor Name</th>
				  <th>Registration Time</th>
				  <th>Discharge Date</th>
				  <th>Length Of Stay</th>
				  <th>Discharge Status</th>
				  <th>Discharge Type</th>
				  <th>Discharge Reasons</th>				  
				 </tr>
              </thead>
              <tbody>
			  
			    <?php 
					foreach ($discharge_data->result() as $data_discharge) { 
					 echo '<tr>';
					 echo '<td>'. $data_discharge->RegCode.'</td>';
					 echo '<td>'. $data_discharge->MedicalRecordNumber.'</td>';		
					 echo '<td>'. $data_discharge->PatientName.'</td>';
					 echo '<td>'. $data_discharge->DoctorName.'</td>';
					 echo '<td>'. date('d-m-Y H:i:s',strtotime($data_discharge->RegistrationTime)).'</td>';		
					 echo '<td>'.date('d-m-Y H:i:s',strtotime($data_discharge->DischargeDate)).'</td>';
					 echo '<td>'. $data_discharge->DayOfService.'</td>';		
					 echo '<td>'. $data_discharge->DischargeStatus.'</td>';
					 echo '<td>'. $data_discharge->DischargeType.'</td>';		
					 echo '<td>'. $data_discharge->DischargeReasons.'</td>';
					 echo '</tr>';                    
				 }; ?>
				 
			</tbody>
    </table>
</div>

 <div id="daily2" class="tab-pane">
 <table class="table table-striped table-bordered">
        <thead>
                 <tr>
                  <th>Registration Code</th>
				  <th>MR Number</th>
				  <th>Patient Name</th>
				  <th>Doctor Name</th>
				  <th>Registration Time</th>
				  <th>Discharge Date</th>
				  <th>Discharge Hour</th>
				  <th>Day Of Service</th>
				  <th>Discharge Status</th>
				  <th>Discharge Type</th>
				  <th>Discharge Reasons</th>				  
				 </tr>
              </thead>
              <tbody>
			  
			    <?php 
					foreach ($discharge_data_10->result() as $data_discharge_10) { 
					 echo '<tr>';
					 echo '<td>'. $data_discharge_10->RegCode.'</td>';
					 echo '<td>'. $data_discharge_10->MedicalRecordNumber.'</td>';		
					 echo '<td>'. $data_discharge_10->PatientName.'</td>';
					 echo '<td>'. $data_discharge_10->DoctorName.'</td>';
					 echo '<td>'. date('d-m-Y H:i:s',strtotime($data_discharge_10->RegistrationTime)).'</td>';		
					 echo '<td>'. date('d-m-Y H:i:s',strtotime($data_discharge_10->DischargeDate)).'</td>';
					 echo '<td>'. $data_discharge_10->DischargeHour.'</td>';
					 echo '<td>'. $data_discharge_10->DayOfService.'</td>';		
					 echo '<td>'. $data_discharge_10->DischargeStatus.'</td>';
					 echo '<td>'. $data_discharge_10->DischargeType.'</td>';		
					 echo '<td>'. $data_discharge_10->DischargeReasons.'</td>';
					 echo '</tr>';                    
				 }; ?>
			
			</tbody>
    </table>
 </div>
 
</div>
<div class="row">
	    <div class="span12 back">
						<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Menu</a>
		</div>
</div>
</div>
