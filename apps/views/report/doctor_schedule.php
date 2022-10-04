<div class="container-fluid">
<p class="medicos_header_logo"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></p>
<h3><?php echo $content_title;?><br /> From <?php echo date('d M Y',strtotime($startdate)); ?> Until <?php echo date('d M Y',strtotime($enddate));?> </h3>
<div class="row-fluid well">
<table class="table table-striped table-bordered" >
        <thead>
                <tr>
                  <th>Doctor Code</th>
				  <th>Doctor Name</th>
				  <th>Specialist</th>
				  <th>Room</th>
				  <th>Appointment Start Time</th>
				  <th>Appointment End Time</th>
				  <th>Patient Name</th>
				  <th>Day</th>
                </tr>
              </thead>
              <tbody>
			<?php foreach($daily_schedule as $schedules) 
			  {?>
              <tr>
			  <td><?php echo $schedules->DoctorCode;?></td>
              <td><?php echo $schedules->DoctorName;?></td>
              <td><?php echo $schedules->Specialist;?></td>
              <td><?php echo $schedules->Room;?></td>
              <td><?php echo $schedules->StartTime;?></td>
			  <td><?php echo $schedules->EndTime;?></td>
			  <td><?php echo $schedules->PatientName;?></td>
			  <td><?php if($schedules->Day=='1')
											{echo 'Sunday';}
										else if($schedules->Day=='2')
											{echo 'Monday';}
										else if($schedules->Day=='3')
											{echo 'Tuesday';}
										else if($schedules->Day=='4')
											{echo 'Wednesday';}
										else if($schedules->Day=='5')
											{echo 'Thursday';}
										else if($schedules->Day=='6')
											{echo 'Friday';}
										else if($schedules->Day=='7')
											{echo 'Saturday';}
											?></td>
			<?php } ?>
			</tbody>
    </table>
</div>
<div class="row">
	    <div class="span12 back">
						<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Menu</a>
		</div>
</div>
</div>