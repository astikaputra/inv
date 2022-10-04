<style>
.container-fluid {
  padding-right: 20px;
  padding-left: 20px;
  background-color:#fff;
  *zoom: 1;
}
</style>
<div class="container-fluid">
<br />
<img class="medicos_header_logo" src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution">
<p class="hospital_logo"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></p>
<h3><?php echo $content_title;?><br /> From <?php echo date('d M Y',strtotime($startdate)); ?> Until <?php echo date('d M Y',strtotime($enddate));?> </h3>
<div class="row-fluid">
<table class="table table-striped table-bordered" >
        <thead>
                <tr>
                  <th>Doctor Code</th>
				  <th>Doctor Name</th>
				  <th>Specialist</th>
				  <th>Room</th>
                  <th>Day</th>
				  <th>Medical Record Number</th>
                  <th>Patient Name / Phone Number</th>
				  <th>Appointment Start Time</th>
				  <th>Appointment End Time</th>
                </tr>
              </thead>
              <tbody>
			<?php foreach($daily_appointment as $appointment) 
			  {?>
              <tr>
			  <td><?php echo $appointment->DoctorCode;?></td>
              <td><?php echo $appointment->DoctorName;?></td>
              <td><?php echo $appointment->Specialist;?></td>
              <td><?php echo $appointment->Room;?></td>
              <td><?php echo $appointment->Day;?></td>
			  <td><?php echo $appointment->MedicalRecordNumber;?></td>
              <td><b><?php echo $appointment->PatientName;?></b><br /><?php echo $appointment->PhoneNumber;?></td>
              <td><?php echo date('d-m-Y H:i:s',strtotime($appointment->StartTime));?></td>
              <td><?php echo date('d-m-Y H:i:s',strtotime($appointment->EndTime));?></td>
			<?php } ?>
			</tbody>
    </table>
		<div class="row" align="right">
	   	<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Main Menu</a>
		</div>
</div>
</div>